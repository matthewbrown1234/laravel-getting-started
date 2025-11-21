<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'quantity',
    ];
    public $incrementing = false;

    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $casts = [
    ];
    // Optionally, automatically generate UUIDs on model creation
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Model $model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->id = Str::uuid();
            }
        });
    }
}
