<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderHistoryItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'order_history_id',
        'product_id',
        'quantity',
    ];
    protected $table = 'order_history_item';
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
