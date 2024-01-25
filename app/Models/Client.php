<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected  $table = "client";

    protected $fillable = [
        'name',
        'street_address',
        'location_lat',
        'location_lng',
        'email',
        'status',
    ];
}
