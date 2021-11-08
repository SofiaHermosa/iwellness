<?php

namespace App\IWellness;
use Illuminate\Http\Request;
use App\Models\Products;
use Storage;
use Session;


class ProductClass
{
    public $data, $request;
    public function __construct()
    {
       $this->request = request(); 
    }

    public function get($id=null){
        $products = new Products;

        if(!empty($id)){
            $products = $products->where('id', $id);
        }

        $products = $products->orderBy('created_at')->get();
        $this->data = $products;
        
        return $this;
    }

    public function updateCreate($id=null){
        if($this->request->hasFile('image')){
            $this->saveImages();
        }

        if(!empty($id)){
            $this->request['id'] = $id;
        }

        $this->request['description'] = base64_encode($this->request->description);

        $this->data = Products::updateOrCreate(
            ['id' => $this->request->id ?? null],
            $this->request->except(['_token', 'image'])
        );

        return $this;
    }

    public function saveImages(){
        $images = [];

        foreach($this->request->file('image') as $image){
            $path = $image->store('products');

            array_push($images, $path);
        }

        $this->request['images'] = $images;
    }
}