<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\Models\Earnings;
use App\Models\Diamonds;
use App\Models\Capital;
use App\Models\CashIn;
use App\Models\CashOut;
use App\Models\Products;
use App\Models\Orders;
use App\Models\User;
use Storage;
use Session;
use stdClass;
use Carbon\Carbon;

class DashboardClass
{
    public $earnings,
    $commissions,
    $productOrders,
    $last, 
    $cashin, 
    $cashout, 
    $diamonds, 
    $orders,
    $users,
    $content,
    $fundChart,
    $id;

    public function __construct($id=null)
    {
        $this->id                   = $id;
        $this->commissions          = new Earnings();
        $this->earnings             = new Earnings();
        $this->cashin               = new CashIn();
        $this->cashout              = new CashOut();
        $this->diamonds             = new Diamonds();
        $this->orders               = new Orders();
        $this->productOrders        = new Orders();
        $this->capital              = new Capital();
        $this->sales                = new User();
        $this->content              = ['commissions', 'diamonds', 'orders', 'capital'];
    }

    public function commissions(){
        $this->commissions = $this->commissions
                             ->whereIn('from', [1,2]);
        if(!empty($this->id)){
            $this->commissions = $this->commissions->where('user_id', $this->id);
        }  

        $this->commissions->withTrashed()->get();
        
        return $this;                     
    }

    public function capital(){
        $this->capital = $this->capital;

        if(!empty($this->id)){
            $this->capital = $this->capital->where('user_id', $this->id);
        }  
                           
        $this->capital->get();
        
        return $this;                 
    }

    public function orders(){
        $this->orders = $this->orders;
        if(!empty($this->id)){
            $this->orders = $this->orders->where('user_id', $this->id);
        }  
                           
        $this->orders->get();    
        
        return $this;
    }

    public function diamonds(){
        $this->diamonds = $this->diamonds;

        if(!empty($this->id)){
            $this->diamonds = $this->diamonds->where('user_id', $this->id);
        }  
            
        $this->diamonds->get();      
        
        return $this;
    }

    public function earnings(){
        $this->earnings = $this->earnings;

        if(!empty($this->id)){
            $this->earnings = $this->earnings->where('user_id', $this->id);
        }  
            
        $this->earnings->get(); 

        return $this;                
    }

    public function cashin(){
        $this->cashin = $this->cashin;

        if(!empty($this->id)){
            $this->cashin = $this->cashin->where('user_id', $this->id);
        }  
            
        $this->cashin->whereIn('status', [0,1])->get(); 

        return $this;                
    }

    public function cashout(){
        $this->cashout = $this->cashout;

        if(!empty($this->id)){
            $this->cashout = $this->cashout->where('user_id', $this->id);
        }  
            
        $this->cashout->whereIn('status', [0,1])->get(); 

        return $this;                
    }

    public function sales(){
        $this->sales = $this->sales;

        if(!empty($this->id)){
            $this->sales = $this->sales->where('id', $this->id);
        }  
            
        $this->sales = $this->sales
        ->whereHas('roles', function($q){
                $q->where('name', '!=','system administrator');
        })
        ->get()
        ->sortByDesc(function($users){
            return $users->sales;
        })->take(10);
       
        return $this;
    }

    public function productOrders(){
        $orders = [];
        $products = Products::all();
        foreach($products as $product){
            $id = $product->id;
            $orders[$product->id]['details'] = $product;
            $qty = [];
            $orderPerProd = $this->productOrders
            ->whereJsonContains('cart', [['prod_id' => $product->id]])
            ->get();
            
            foreach($orderPerProd as $prod){
                $qty[] = collect($prod->cart)->where('prod_id', $id)->first()->quantity;
            }

            $orders[$product->id]['total_qty'] = array_sum($qty);
        }    

        $this->productOrders = $orders;

        return $this;
    }

    public function monthlyRecords($record){
        $records = $this->$record;

        if(!empty($this->id) && !empty($this->$record)){
            $records = $records->where('user_id', $this->id);
        }

        if($record == 'earnings' && !empty($this->$record)){
            $records = $records->where('from', 3);
        }

        if($record == 'commissions' && !empty($this->$record)){
            $records = $records->whereIn('from', [1,2])->withTrashed();
        }

        if(!empty($this->$record)){
            $records = $records->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
            ->get();
        }

        $this->last =  $records ?? collect([]);

        return $this;
    }

    public function getFundRequestChart(){
        $days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        // Cash-in

        $this->cashin = $this->cashin;

        if(!empty($this->id)){
            $this->cashin = $this->cashin->where('user_id', $this->id);
        }  
            
        $this->cashin = $this->cashin->whereMonth('created_at', Carbon::now()->month)->get()->groupBy(function($item) {
            return $item->created_at->format('D');
        });
        
        // Cash-out

        $this->cashout = $this->cashout;

        if(!empty($this->id)){
            $this->cashout = $this->cashout->where('user_id', $this->id);
        }  
            
        $this->cashout = $this->cashout->whereMonth('created_at', Carbon::now()->month)->get()->groupBy(function($item) {
            return $item->created_at->format('D');
        });

        $this->fundChart[0] = $days;
        foreach($days as $key => $day){
            $this->fundChart[1][] = !empty($this->cashin[$day]) ? $this->cashin[$day]->sum('amount') : 1000;
            $this->fundChart[2][] = !empty($this->cashout[$day]) ? $this->cashout[$day]->sum('amount') : 3000;
        }

        return $this;
    }
}

?>