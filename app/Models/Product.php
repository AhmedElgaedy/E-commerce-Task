<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'stock'];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
                    ->withPivot('quantity', 'price', 'total')
                    ->withTimestamps();
    }

     public function scopeSearchByName($query, $name)
     {
         if ($name) {
             return $query->where('name', 'LIKE', '%' . $name . '%');
         }
         return $query;
     }
      public function scopeFilterByPriceRange($query, $minPrice, $maxPrice)
     {
         if ($minPrice !== null) {
             $query->where('price', '>=', $minPrice);
         }
         if ($maxPrice !== null) {
             $query->where('price', '<=', $maxPrice);
         }
         return $query;
     }
}
