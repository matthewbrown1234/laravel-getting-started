<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'order_date',
        'status',
    ];
    protected $table = 'order_history';
    protected $primaryKey = 'id';
    protected $casts = [
        'order_date' => 'datetime',
    ];
}
