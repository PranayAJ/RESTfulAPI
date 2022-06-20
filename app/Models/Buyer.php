<?php

namespace App\Models;

use App\Scopes\BuyerScope;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buyer extends Model
{
    use HasFactory;
    protected $table= 'users';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BuyerScope());
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}