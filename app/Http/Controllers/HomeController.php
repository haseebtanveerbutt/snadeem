<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Shopdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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
            $total_sales = Order::whereBetween('shopify_created_at',[$start_date,$end_date])->sum('total_price');
            $order_counts = Order::whereBetween('shopify_created_at',[$start_date,$end_date])->count();
        }else{

            $total_sales = Order::where('shopify_created_at', '>', now()->subDays(30)->endOfDay())->sum('total_price');
            $order_counts = Order::where('shopify_created_at', '>', now()->subDays(30)->endOfDay())->count();
        }

        $data = array(
            'total_sales'=>$total_sales,
            'order_counts'=>$order_counts,
            'selected_date'=>$selected_date,
        );
        return view('adminpanel/dashboard_index')->with($data);
    }

    public function shop_index(Request $request)
    {
        $search = null;
        $user = User::query();
        if(isset($request->search)){
            $search = $request->search;
            $user->where('name','like','%'.$search.'%');
        }
        $users_data = $user->where('role',0)->orderBy('created_at', 'desc')->paginate(25);
        $data = [
          'users_data'=>$users_data,
          'search'=>$search
        ];
        return view('adminpanel/shops_index')->with($data);
    }


    public function shop_status_detail_save(Request $request)
    {
//        dd($request->all());
        $shop_detail = Shopdetail::where('user_id', $request->user_id)->first();
        if ($shop_detail == null) {
            $shop_detail = new Shopdetail();
        }
        $shop_detail->user_id = $request->user_id;
        $shop_detail->firstname = $request->firstname;
        $shop_detail->surname = $request->surname;
        $shop_detail->email = $request->email;
        $shop_detail->mobile_number = $request->mobile_number;
        $shop_detail->company_name = $request->company_name;
        $shop_detail->sender_name = $request->sender_name;
        $shop_detail->user_name = $request->user_name;
        $shop_detail->password = $request->password;
        $shop_detail->save();
        $user_status = \App\User::find($request->user_id);
        if ($request->user_status == null) {
            $user_status->user_status = "inactive";
        } else {
            $user_status->user_status = $request->user_status;
        }
        $user_status->save();

        return redirect('shops');

    }
}
