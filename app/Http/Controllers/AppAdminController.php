<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AppAdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $selected_date = null;
        $total_sales = 0;
        $order_counts = 0;
        if(isset($request->date_range)) {
            $selected_date = $request->query('date_range');
            $date_range = explode('-', $request->input('date_range'));
            $start_date = $date_range[0];
            $end_date = $date_range[1];
            $start_date = Carbon::parse($start_date)->format('Y-m-d') . ' 00:00:00';
            $end_date = Carbon::parse($end_date)->format('Y-m-d') . ' 23:59:59';
            $total_sales = Order::where('user_id',Auth::user()->id)->whereBetween('shopify_created_at',[$start_date,$end_date])->sum('total_price');
            $order_counts = Order::where('user_id',Auth::user()->id)->whereBetween('shopify_created_at',[$start_date,$end_date])->count();
        }else{
            $total_sales = Order::where('user_id',Auth::user()->id)->where('shopify_created_at', '>', now()->subDays(30)->endOfDay())->sum('total_price');
            $order_counts = Order::where('user_id',Auth::user()->id)->where('shopify_created_at', '>', now()->subDays(30)->endOfDay())->count();
        }


        $data = array(
            'total_sales'=>$total_sales,
            'order_counts'=>$order_counts,
            'selected_date'=>$selected_date,
        );

        return view('app.index')->with($data);
    }

    public function help(){
        return view('app.help',compact('wizard','questions'));
    }
}
