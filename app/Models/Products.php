<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "products";

    protected $fillable = [
        'name',
        'description',
        'variants',
        'images',
        'price',
    ];

    protected $appends = [
        'cover', 
        'quantity',
        'short_desc',
        'discounted_price'
    ];

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }

    public function getImagesAttribute($value)
    {
        return json_decode($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = base64_encode($value);
    }

    public function getDescriptionAttribute($value)
    {
        return base64_decode($value);
    }

    public function getCoverAttribute()
    {
        $images = $this->images;

        return !empty($images[0]) ? "<img class='img-bordered img-bordered-default rounded cover mr-20' width='50' height='50' src='".asset('storage/'.$images[0])."'>" : '';
    }

    public function getQuantityAttribute()
    {
        return 0;
    }

    public function getDiscountedPriceAttribute(){
        $discount = null;
        $percent  = null;

        if(auth()->user()->hasanyrole('member') && auth()->user()->activated){
            $discount = number_format(($this->price * 0.3), 2, '.', ',');
            $percent  = 30;
        }

        if(auth()->user()->hasanyrole('team leader') && auth()->user()->activated){
            $discount = number_format(($this->price * 0.45), 2, '.', ',');
            $percent  = 45;
        }

        if(auth()->user()->hasanyrole('manager') && auth()->user()->activated){
            $discount = number_format(($this->price * 0.6), 2, '.', ',');
            $percent  = 60;
        }

        return array(
            'price'      => $discount,
            'percentage' => $percent
        );
    }

    public function getShortDescAttribute(){
        $description = base64_decode($this->description);
        return  strlen($description) > 50 ? substr($description,0,50)."..." : $description;
    }
}
