<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
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
 * @property string $currency
 * @property int $status
 * @property string $payment_method
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
        'currency',
        'status',
        'payment_method',
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

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function statusEnum(): OrderStatus
    {
        return OrderStatus::from((int) $this->status);
    }

    public function paymentMethodEnum(): PaymentMethod
    {
        return PaymentMethod::from((string) $this->payment_method);
    }
}
