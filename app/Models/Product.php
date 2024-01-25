<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected  $table = "product";

    protected $fillable = [
        'name',
        'quantity',
        'price',
        'categoryProduct_id',
        'status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryProduct::class,'categoryProduct_id');
    }
}
