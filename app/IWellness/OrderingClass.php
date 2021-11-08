<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\Models\Orders;
use Storage;
use Session;


class OrderingClass
{
    public $orders, $request;

    public function __construct()
    {
       $this->request = request(); 
    }

    public function get($id=null){
        $orders = new Orders;

        if(!empty($id)){
            $orders = $orders->where('id', $id);
        }

        $orders = $orders->orderBy('created_at', 'DESC')->with('user')->get();
        $this->orders = $orders;
        
        return $this;
    }
}

?>