<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    const UNAVAILABLE_PRODUCT = "unavailable";
    const AVAILABLE_PRODUCT = "available";

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller'
    ];
    protected $hidden = [
        'pivot'
    ];

    public function isAvailable(){
        return $this->status == PRODUCT::AVAILABLE_PRODUCT;
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function seller(){
        return $this->belongsTo(Seller::class);
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
