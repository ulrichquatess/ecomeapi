<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
	protected $fillable = [
		'star', 'customer', 'review'
	];
    // Here Review Bwlongs To Product
    public function product()
    {
    	return $this->belongsTo(Product::class);
    }
}
