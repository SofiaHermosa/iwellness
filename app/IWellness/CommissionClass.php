<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\IWellness\WalletClass;
use App\Models\Earnings;
use App\Models\Diamonds;
use App\Models\User;
use Storage;
use Session;


class CommissionClass
{
    public $earnings, $walletClass;

    public function __construct()
    {
        $this->walletClass = new WalletClass();
    }

    public function getParents($id=null){
        return auth()->check() ? ($id != auth()->user()->id ? User::where('id', $id)->get() : []) : [];
    }

    public function disseminate($amount, $source)
    {
        $parents = $this->getParents(auth()->check() ? auth()->user()->referer : '');
        $percentage  = $source == 2 ? ['0.03', '0.02', '0.02', '0.01'] : ['0.05', '0.02', '0.02', '0.01'];
        $commissions = [];
        $diamonds    = [];
        $level       = 0;
       
        while(!empty($parents)){
            $nextParent = [];
            foreach($parents as $key => $user){
                $percent = $level <= 3 ? $percentage[$level] : '0.01';
                $dias    = 0;

                if($source == 1){
                    $dias = $level == 0 ? 10 : 2;
                }

                if($source == 2){
                    $dias = $level == 0 ? 10 : 2;
                }
        
                $commissions[$level] = [
                    'user_id'       => $user->id,
                    'downline_id'   => auth()->user()->id,
                    'from'          => $source,
                    'amount'        => $amount * $percent,
                    'user'          => $user,
                ];

                if($source == 2 && $level == 0){
                    $diamonds[] = [
                        'user_id'       => $user->id,
                        'downline_id'   => auth()->user()->id,
                        'from'          => $source,
                        'amount'        => $dias,
                        'user'          => $user,
                    ];
                }

                if($source == 1){
                    $diamonds[] = [
                        'user_id'       => $user->id,
                        'downline_id'   => auth()->user()->id,
                        'from'          => $source,
                        'amount'        => $dias,
                        'user'          => $user,
                    ];
                }

                foreach($this->getParents($user->referer) as $parent){
                    $nextParent[] = $parent;
                }
                
                $level++;
            }
        
            $parents = $nextParent;
        }

        if(auth()->check()){
            $diamonds[] = [
                'user_id'       => auth()->user()->id,
                'downline_id'   => auth()->user()->id,
                'from'          => $source,
                'amount'        => 5,
                'user'          => auth()->user(),
            ];
        }

        if(auth()->user()->activated == 1){
            foreach($commissions as $key => $commission){      
                if($key <= 3){
                    $this->updateUserEarning($commission);
                }else if($key <= 9 && $commission['user']->hasanyrole('team leader|manager')){
                    $this->updateUserEarning($commission);
                }else if($key > 9 && $commission['user']->hasanyrole('manager')){
                    $this->updateUserEarning($commission);
                }
            }
        }

        foreach($diamonds as $diamond){
            if($key <= 3){
                unset($diamond['user']);
                Diamonds::create($diamond);
            }else if($key <= 9 && $commission['user']->hasanyrole('team leader|manager')){
                unset($diamond['user']);
                Diamonds::create($diamond);
            }else if($key > 9 && $commission['user']->hasanyrole('manager')){
                unset($diamond['user']);
                Diamonds::create($diamond);
            }
        }

        return $this;
    }


    public function updateUserEarning($commission){
        unset($commission['user']);
        Earnings::create($commission);

        $earning_data = [
            'balance' => $commission['amount'],
            'user_id' => $commission['user_id']
        ];
        
        $this->walletClass->update($earning_data); 
    }
}

?>