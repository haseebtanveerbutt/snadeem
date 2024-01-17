<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fulfillment extends Model
{
    use HasFactory;

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','shopify_order_id');
    }
//    public function getStatusBgColorAttribute(){
//
//        $status = ReportStatus::where('status',$this->shipment_status)->first();
//        if($status != null){
//            return $status->background;
//        }
//        return null;
//    }
//    public function getStatusTextColorAttribute(){
//
//        $status = ReportStatus::where('status',$this->shipment_status)->first();
//        if($status != null){
//            return $status->colors;
//        }
//        return null;
//    }

    public function getStatusMutAttribute(){
        $status = FulfillmentStatus::where('status',$this->shipment_status)->first();
        if($status != null){
            return $status;
        }
        return null;
    }
//
//    public function getTrackingCompanyMappingAttribute($value)
//    {
//        $carrier_mapping = CarrierMapping::where('user_id',Auth::user()->id)->where('shopify_carrier',$this->tracking_company)->first();
//        if( $carrier_mapping != null){
//            return isset($carrier_mapping->actual_carrier)?$carrier_mapping->actual_carrier:$this->tracking_company;
//        }else{
//            return $this->tracking_company;
//        }
//
//    }

    public function getDetailsAttribute($value)
    {
        return str_replace(',',', ',$value);
    }
}
