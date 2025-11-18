<?php declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    use HasFactory, HasUuids;

    protected $table = 'order_history';

    public $incrementing = false;

    protected $keyType = 'string';

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
}

enum OrderStatus: string
{
    case Pending = 'pending';
    case Shipped = 'shipped';
    case Completed = 'completed';
    case Canceled = 'canceled';
}
