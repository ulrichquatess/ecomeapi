<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = [
		'name', 'detail', 'stock', 'price', 'discount'
	];
    // here one product has many review
    public function reviews()
    {
    	return $this->hasMany(Review::class);
    }
}
