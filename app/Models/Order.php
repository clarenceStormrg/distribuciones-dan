<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected  $table = "order";

    protected $fillable = [
        'client_id',
        'vendedor_id',
        'conductor_id',
        'shipping_date',
        'status',
    ];
}
