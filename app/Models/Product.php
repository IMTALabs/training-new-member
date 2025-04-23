<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Nếu bạn muốn chỉ định các cột được phép gán
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
        'import_price',
    ];

    // Quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
