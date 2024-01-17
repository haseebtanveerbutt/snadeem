<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function fulfillments()
    {
        return $this->hasMany(Fulfillment::class,'order_id','shopify_order_id');
    }

    public function lineitems()
    {
        return $this->hasMany(LineItem::class,'shopify_order_id','shopify_order_id');
    }

    public function getPaymentStatusMutAttribute(){
        $status = PaymentStatus::where('status',$this->financial_status)->first();
        if($status != null){
            return $status;
        }
        return null;
    }
}
