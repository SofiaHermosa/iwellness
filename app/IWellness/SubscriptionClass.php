<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Capital;
use App\Models\Earnings;
use App\IWellness\CommissionClass;
use Storage;
use Session;
use Carbon\Carbon;


class SubscriptionClass
{
    public $data, $request, $commissionClass;

    public function __construct()
    {
       $this->request           = request(); 
       $this->commissionClass   = new CommissionClass;
    }

    public function activateAccount($request){
        $this->request = $request;
        
        $sub_data = [
            'user_id'   => auth()->user()->id,
            'start'     => Carbon::now(), 
            'end'       => Carbon::now()->addMonth(),
            'validity'  => 1, 
            'valid'     => 1,
            'status'    => 1,
            'complan'   => $this->request['complan']
        ];

        $subscription = Subscription::create($sub_data);

        $capital_data = [
            'user_id'           => auth()->user()->id,
            'subscription_id'   => $subscription->id,
            'amount'            => $this->request['amount'],
            'status'            => (int)1
        ];

        $capital = Capital::create($capital_data);

        $self = auth()->user();
        $self->activated = 1;
        $self->save();

        if(auth()->user()->hasanyrole('observer')){
            auth()->user()->roles()->detach();
            auth()->user()->assignRole('member');
        }

        return $this;
    }

    public function parentsCommision(){
        $this->commissionClass->disseminate($this->request['amount'], 1);

        return $this;
    }

    public function addCapital($amount){
        $subscription = Subscription::where('user_id', auth()->user()->id)
        ->where('status', 1)
        ->where('valid', 1)
        ->orderBy('created_at', 'DESC')
        ->first();

        $capital_data = [
            'user_id'           => auth()->user()->id,
            'subscription_id'   => $subscription->id,
            'amount'            => $amount,
            'status'            => (int)1
        ];

        Capital::create($capital_data);
    }
}

?>