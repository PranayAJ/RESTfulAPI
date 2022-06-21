<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public $transformer = ProductTransformer::class;

    public static function boot() {
        parent::boot();
        self::updated(function(Product $product) {
            if($product->quantity == 0 && $product->isAvailable()) {
                $product->status = Product::UNAVAILABLE_PRODUCT;
                $product->save();
            }
        });
    }

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
