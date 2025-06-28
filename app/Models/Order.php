<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_time',
        'total_price',
        'total_item',
        'kasir_id',
    ];

    // Relasi ke kasir (User)
    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id', 'id'); // Foreign key adalah 'kasir_id'
    }

    // Relasi ke order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    // Relasi ke produk melalui order items (opsional jika diperlukan)
    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            OrderItem::class,
            'order_id', // Foreign key di tabel OrderItem
            'id',       // Foreign key di tabel Product
            'id',       // Local key di tabel Order
            'product_id'// Local key di tabel OrderItem
        );
    }
}
