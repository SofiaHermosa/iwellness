<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\IWellness\WalletClass;
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

        $this->funds = $this->funds
        ->with('user')
        ->orderBy('created_at', 'DESC')
        ->orderBy('status', 'ASC')
        ->get();

        return $this;
    }

    public function store(){
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
        $cashinRequest = CashIn::findOrFail($id);
        if ($cashinRequest->status != 1) {
            $cashinRequest->status = 1;
            $cashinRequest->save();
    
            $data = [
                'user_id' => $user_id,
                'balance' => $amount
            ];
    
            $this->wallet->update($data); 
        }
    }

    public function approveCashOut($id, $user_id,$amount){
        $cashoutRequest = CashOut::findOrFail($id);
        $earnings = Earnings::where('user_id', $user_id)->get();

        if ($earnings->sum('amount') >= $amount) {
            if ($cashoutRequest->status != 1) {
                $cashoutRequest->status = 1;
                $cashoutRequest->save();
            }
    
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
        }
    }

    public function declineCashIn($id, $user_id,$amount){
        $cashinRequest = CashIn::findOrFail($id);
        if ($cashinRequest->status != 2) {
            $cashinRequest->status              = 2;
            $cashinRequest->declining_reason    = request()->has('reason') ? base64_encode(request()->reason) : '';
            $cashinRequest->save();
    
            $data = [
                'user_id' => $user_id,
                'balance' => $amount
            ];
        }
    }
}

?>