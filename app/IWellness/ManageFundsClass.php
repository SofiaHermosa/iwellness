<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\IWellness\WalletClass;
use App\Mail\FundRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\CashIn;
use App\Models\CashOut;
use App\Models\Earnings;
use Storage;
use Session;


class ManageFundsClass
{
    public $request,$funds,$wallet;

    public function __construct()
    {
        $this->request = request();
        $this->wallet = new WalletClass();
    }

    public function get($type, $user = null){

        $this->funds = $type == 'cashin' ? new CashIn() : new CashOut();

        if(!empty($user)){
            $this->funds = $this->funds->where('user_id', $user);
        }

        if(request()->has('status')){
            $this->funds = $this->funds->where('status', request()->status);
        }

        if(request()->has('mop')){
            $this->funds = $this->funds->whereJsonContains('details', ['mop' => request()->mop]);
        }

        $this->funds = $this->funds
        ->with('user')
        ->orderBy('created_at', 'DESC')
        ->orderBy('status', 'ASC')
        ->get();

        return $this;
    }

    public function store(){
        if($this->validRefno()){
            Session::flash('invalid_ref_no', 'Reference no has already been used');
            return back();
        }

        if($this->request->hasFile('attachments') || $this->request->has('current_attachment')){
            $this->saveImages();
        }

        $this->funds = $this->request->type == 1 ? new CashIn() : new CashOut();

        $this->funds->updateOrCreate(
            ['id' => $this->request->id],
            $this->request->except(['_token', 'attachments', 'type'])
        );
    }

    public function saveImages(){
        $images = [];
        if ($this->request->has('attachments')) {
            foreach($this->request->file('attachments') as $image){
                $path = $image->store('cashin/attachments');
    
                array_push($images, $path);
            }    
        }
    
        if($this->request->has('current_attachment')){
            array_push($images, $this->request->current_attachment);
        }

        $this->request['details'] = [
            'sender_name'  => $this->request->details['sender_name'],
            'reference_no' => $this->request->details['reference_no'],
            'attachments'  => $images,
            'mop'          => $this->request->details['mop']
        ];

    }

    public function approveCashIn($id, $user_id,$amount){
        $cashinRequest = CashIn::with('user')->findOrFail($id);
        if ($cashinRequest->status != 1) {
            $cashinRequest->status = 1;
            $cashinRequest->save();
    
            $data = [
                'user_id' => $user_id,
                'balance' => $amount
            ];
    
            $this->wallet->update($data); 

            Mail::to($cashinRequest->user->email)->send(new FundRequest($cashinRequest, 'cash-in'));
        }
    }

    public function approveCashOut($id, $user_id,$amount){
        $cashoutRequest = CashOut::with('user')->findOrFail($id);
        $earnings = Earnings::where('user_id', $user_id)->get();

        if ($earnings->sum('amount') >= $amount) {
            if ($cashoutRequest->status == 0) {
                $new_balance = $earnings->sum('amount') - $amount;
                foreach($earnings as $earning){
                    $earning->delete();
                }
    
                if ($new_balance > 0) {
                    Earnings::insert([
                        'user_id'      => auth()->user()->id,
                        'downline_id'  => $earnings->first()->downline_id,
                        'from'         => 4,
                        'amount'       => $new_balance
                    ]);
                }

                if ($cashoutRequest->status != 1) {
                    $cashoutRequest->status = 1;
                    $cashoutRequest->save();
                }

                Mail::to($cashoutRequest->user->email)->send(new FundRequest($cashoutRequest, 'cash-out'));
            }
        }else{
            abort(403, 'Not enough earning balance');
        }
    }

    public function declineCashOut($id, $user_id,$amount){
        $cashoutRequest = CashOut::findOrFail($id);
        if ($cashoutRequest->status != 2) {
            $cashoutRequest->status = 2;
            $cashoutRequest->save();

            Mail::to($cashoutRequest->user->email)->send(new FundRequest($cashoutRequest, 'cash-out'));
        }
    }

    public function declineCashIn($id, $user_id,$amount){
        $cashinRequest = CashIn::with('user')->findOrFail($id);
        if ($cashinRequest->status != 2) {
            $cashinRequest->status              = 2;
            $cashinRequest->declining_reason    = request()->has('reason') ? base64_encode(request()->reason) : '';
            $cashinRequest->save();
    
            $data = [
                'user_id' => $user_id,
                'balance' => $amount
            ];

            Mail::to($cashinRequest->user->email)->send(new FundRequest($cashinRequest, 'cash-in'));
        }
    }

    public function validRefno(){
        $ref_no =  preg_replace('/[^A-Za-z0-9\-]/', '', request()->details['reference_no']);
        $cashIn = CashIn::whereJsonContains('details', ['reference_no' => $ref_no])->where('id', '!=',request()->id)->first();
        
        if(!empty($cashIn)){
            return true;
        }

        return false;
    }
}

?>