<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['order_code', 'customer_name', 'customer_phone', 'customer_email', 'customer_address', 'customer_note', 'method_payment', 'order_status', 'order_total', 'qty'];
}
