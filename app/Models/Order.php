<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string|null $comment
 * @property float $amount
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $items
 * @property-read \App\Models\User|null $user
 */
class Order extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'comment',
        'status',
    ];

    public const STATUSES = [
        OrderStatus::New->value => 'Новый',
        OrderStatus::Processed->value => 'Обработан',
        OrderStatus::Paid->value => 'Оплачен',
        OrderStatus::Delivered->value => 'Доставлен',
        OrderStatus::Completed->value => 'Завершен',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    /**
     * Связь «один ко многим» таблицы `orders` с таблицей `order_items`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Связь «заказ принадлежит» таблицы `orders` с таблицей `users`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusEnum(): OrderStatus
    {
        return OrderStatus::from((int) $this->status);
    }
}
