<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'status', 'rejected', 'order_number', 'invoice_number', 
    'tracking_number', 'name', 'email', 'shipping_address', 'billling_address', 'card_number', 
    'card_full_name', 'card_expire', 'card_cvc', 'payment_type', 'stripe_payment_info', 'subtotal',
    'discount', 'total'];
}
