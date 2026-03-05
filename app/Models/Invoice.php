<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'car_type_id', 'start_at', 'end_of', 'payment', 'invoice_number', 'payment_method', 'va_number', 'payment_code', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function carType()
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }
}