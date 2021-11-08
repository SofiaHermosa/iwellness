<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiamondConversionItems extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "conversion_items";

    protected $fillable = [
        'name',
        'mechanics',
        'variants',
        'images',
        'price',
    ];

    protected $appends = [
        'cover',
        'attachments'
    ];

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }

    public function getImagesAttribute($value)
    {
        return json_decode($value);
    }

    public function setMechanicsAttribute($value)
    {
        $this->attributes['mechanics'] = base64_encode($value);
    }

    public function getMechanicsAttribute($value)
    {
        return base64_decode($value);
    }

    public function getCoverAttribute()
    {
        $images = $this->images;

        return !empty($images[0]) ? "<img class='img-bordered img-bordered-default rounded cover mr-20' width='50' height='50' src='".asset('storage/'.$images[0])."'>" : '';
    }

    public function getAttachmentsAttribute(){
        return !empty($this->images[0]) ? asset('storage/'.$this->images[0]) : null;
    }
}
