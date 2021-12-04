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

    public function getParents($id=null, $level=0){
        // return auth()->check() ? ($id != auth()->user()->id ?  : []) : [];
        $user = new User;
        
        if(auth()->check()){
            if($id != auth()->user()->id){
                $user = $user->where('id', $id);
                if($level > 4 && $level <= 9){
                    $user = $user->whereHas('roles', function($q){
                        $q->where('name', 'team leader')
                        ->orWhere('name', 'manager');
                    });
                }else if($level > 9){
                    $user = $user->whereHas('roles', function($q){
                        $q->where('name', 'manager');
                    });
                }else{
                    $user = $user->whereHas('roles', function($q){
                        $q->where('name', 'team leader')
                        ->orWhere('name', 'manager')
                        ->orWhere('name', 'member')
                        ->orWhere('name', 'observer');
                    });
                }
                $user = $user->get();
            }
        }    

        return $user ?? [];
    }

    public function disseminate($amount, $source)
    {
        $level       = 0;
        $parents     = $this->getParents(auth()->check() ? auth()->user()->referer : '', $level);
        $percentage  = $source == 2 ? ['0.03', '0.02', '0.02', '0.01'] : ['0.05', '0.02', '0.02', '0.01'];
        $commissions = [];
        $diamonds    = [];

        while(!empty($parents)){
            $nextParent = [];
            foreach($parents as $key => $user){
                $percent = $level <= 3 ? $percentage[$level] : '0.01';
                $dias_percent = floor($amount/700);
                $dias    = 0;

                if($source == 1){
                    $dias = $level == 0 ? 10 * $dias_percent  : 2 * $dias_percent;
                }

                if($source == 2){
                    $dias = $level == 0 ? 3 * $dias_percent : 2 * $dias_percent;
                }
        
                $commissions[] = [
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

                $level++;
                
                foreach($this->getParents($user->referer, $level) as $parent){
                    $nextParent[] = $parent;
                }
            }
        
            $parents = $nextParent;
        }
    
        if(auth()->check()){
            $self_dias_percent = floor($amount/700);
            $diamonds[] = [
                'user_id'       => auth()->user()->id,
                'downline_id'   => auth()->user()->id,
                'from'          => $source,
                'amount'        => 5 * $self_dias_percent,
                'user'          => auth()->user(),
            ];
        }

        foreach($commissions as $key => $commission){      
            unset($commission['user']);
            Earnings::create($commission);
    
            $earning_data = [
                'balance' => $commission['amount'],
                'user_id' => $commission['user_id']
            ];
            
            $this->walletClass->update($earning_data);
        }
    

        foreach($diamonds as $key => $diamond){
            unset($diamond['user']);
            Diamonds::create($diamond);
        }

        return $this;
    }
}

?>