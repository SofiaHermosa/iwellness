<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\Models\DiamondConversionItems;
use App\Mail\DiamondConversion;
use Illuminate\Support\Facades\Mail;
use App\Models\ConversionRequest;
use App\Models\Diamonds;
use Storage;
use Session;


class DiamondConversionClass
{
    public $data, $request;
    public function __construct()
    {
       $this->request = request(); 
    }

    public function get($id=null){
        $items = new DiamondConversionItems;

        if(!empty($id)){
            $items = $items->where('id', $id);
        }

        $items = $items->orderBy('created_at')->get();
        $this->data = $items;
        
        return $this;
    }

    public function getRequest($id=null){
        $request = new ConversionRequest;

        if(!empty($id)){
            $request = $request->where('user_id', $id);
        }

        $request = $request->orderBy('created_at')->with(['user', 'item'])->get();
        $this->request = $request;

        return $this;
    }

    public function updateCreate($id=null){
        if($this->request->hasFile('image')){
            $this->saveImages();
        }

        if(!empty($id)){
            $this->request['id'] = $id;
        }

        // $this->request['description'] = base64_encode($this->request->description);

        $this->data = DiamondConversionItems::updateOrCreate(
            ['id' => $this->request->id ?? null],
            $this->request->except(['_token', 'image'])
        );

        return $this;
    }

    public function saveImages(){
        $images = [];

        foreach($this->request->file('image') as $image){
            $path = $image->store('conversion-items');

            array_push($images, $path);
        }

        $this->request['images'] = $images;
    }

    public function sendRequest($id=null){
        if(!empty($id)){
            $this->request['id'] = $id;
        }

        $this->data = ConversionRequest::updateOrCreate(
            ['id' => $this->request->id ?? null],
            $this->request->except(['_token'])
        );

        return $this;
    }

    public function approveConversion($id){
        $conversionRequest = ConversionRequest::with(['user', 'item'])->findOrFail($id);
        if ($conversionRequest->status != 1) {
            $conversionRequest->status = 1;
            $conversionRequest->save();

            Mail::to($conversionRequest->user->email)->send(new DiamondConversion($conversionRequest));
        }

    }

    public function declineConversion($id){
        $conversionRequest = ConversionRequest::with(['user', 'item'])->findOrFail($id);
        if ($conversionRequest->status != 2) {
            $conversionRequest->status              = 2;
            $conversionRequest->declining_reason    = request()->reason;
            $conversionRequest->save();

            Mail::to($conversionRequest->user->email)->send(new DiamondConversion($conversionRequest));
        }

    }

    public function updateCreateRequest(){
        $item = $this->get(request()->item_id)->data->first();
        $diamonds = Diamonds::where('user_id', auth()->user()->id)->get()->sum('amount') ?? 0;
        if ($diamonds >= $item->price || !empty($this->request->id)) {
            $new_balance = $diamonds - $item->price;
            $this->request['details'] = [
                'address'        => $this->request->shipping_details,
                'receivers_name' => $this->request->details['receivers_name'],
                'contact_no'     => $this->request->details['contact_no'],
            ];

            $this->request['user_id'] = auth()->user()->id;
            $this->data = ConversionRequest::updateOrCreate(
                ['id' => $this->request->id ?? null],
                $this->request->except(['_token', 'shipping_details'])
            );

            
            $this->updateDiamond($new_balance);

            return response()->json([
                'message' => 'Diamond conversion request has been successfully sent'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Not enough diamonds'
            ], 403);
        }
    }

    function updateDiamond($balance){
        $diamonds = Diamonds::where('user_id', auth()->user()->id)->get();

        foreach($diamonds as $diamond){
            $diamond->delete();
        }

        if($balance > 0){
            $update = Diamonds::insert([
                'user_id'       => auth()->user()->id,
                'downline_id'   => $diamonds->first()->downline_id,
                'from'          => $diamonds->first()->from,
                'amount'        => $balance
            ]);
        }
    }
}    