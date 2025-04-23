<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'price',
        'image',
        'quantity',
        'views',
        'description',
        'rating',
        'status', 
        'discount_price', 
        'import_price'
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
