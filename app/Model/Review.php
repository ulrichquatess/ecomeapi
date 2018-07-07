<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Here Review Bwlongs To Product
    public function product()
    {
    	return $this->belongsTo(Product::class);
    }
}
