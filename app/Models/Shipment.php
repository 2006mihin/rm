<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'address',
        'city',
        'postal_code',
        'country',
        'status',
    ];

    // 🔹 Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
