<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property int $user_id
 * @property Carbon $order_date
 * @property OrderStatus $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class OrderHistory extends Model
{
    use HasFactory, HasUuids; // NOTE: these are called traits

    protected $table = 'order_history'; // Note: need this because of FW opinions on plural table names

    protected $fillable = [
        'id',
        'user_id',
        'order_date',
        'status',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'user_id' => 'integer',
        'status' => OrderStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // todo: get order status's updated and use broadcasted events to notify user of status change

    #[Scope]
    protected function ofStatus(Builder $query, OrderStatus $status): void
    {
        $query->where('status', $status);
    }
}

enum OrderStatus: string
{
    case Pending = 'pending';
    case Shipped = 'shipped';
    case Completed = 'completed';
    case Canceled = 'canceled';
}
