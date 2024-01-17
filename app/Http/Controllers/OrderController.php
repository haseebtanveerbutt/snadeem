<?php

namespace App\Http\Controllers;


use App\Models\ErrorMessage;
use App\Models\Fulfillment;
use App\Models\LineItem;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Osiset\ShopifyApp\Storage\Models\Charge;
use PhpParser\Node\Stmt\TryCatch;

class OrderController extends Controller
{
    public function get_inventory_levels()
    {
        $shop = Auth::user();
//        $response = $shop->api()->rest('GET', '/admin/api/2023-04/inventory_levels.json');
//        $response = $shop->api()->rest('GET', '/admin/api/2023-04/fulfillment_orders/3474871386310.json');
//        $response =  $shop->api()->rest('GET', '/admin/locations.json')['body']['locations'];

//        $product_variant_id = 40336135061702
//        $get_variant = $shop->api()->rest('GET','/admin/api/2023-04/variants/40336135061702.json')['body']['variant'];
//        $inventory_item_id = $get_variant->inventory_item_id;
//        $inventory_item_id = 42431431114950;
//        $inventory_items = $shop->api()->rest('GET','/admin/api/2023-04/inventory_items/'.$inventory_item_id.'.json')['body'];
//        $inventory_items = $shop->api()->rest('GET','/admin/api/2023-04/inventory_items/42431431114950.json')['body'];
        $response = $shop->api()->rest('GET', '/admin/api/2023-04/locations.json')['body']['locations'];
        $inventory_ids = [
            "42431431114950"
        ];
        $data = [
            "inventory_item_ids" => json_encode($inventory_ids)
        ];
        $inventory_levels = $shop->api()->rest('GET', '/admin/api/2023-04/inventory_levels.json', $data);
        dd('locations:', $response, 'inventory_levels:', $inventory_levels);
    }

    public function email_order_fulfillment(Request $request)
    {
        $order = Order::where('shopify_order_id', $request->shopify_order_id)->first();
        $shop = User::find($order->user_id);

        try {
            if (isset($order)) {
                if (isset($order->fulfillment_status)) {
                    if ($order->fulfillment_status != "fufilled") {
                        $this->fulfill_order($shop, $order);
                    }
                } else {
                    $this->fulfill_order($shop, $order);
                }
            }
        } catch (\Exception $exception) {
            $msg = new ErrorMessage();
            $msg->message = "email fulfillment error: " . json_decode($exception->getMessage());
            $msg->save();
        }
        if (isset($request->status) && $request->status == "manual") {
            return Redirect::tokenRedirect('order.detail', [$order->id, 'notice' => 'Successfully mark as picked up!']);
        } else {
            return redirect('https://' . $shop->name);
        }

    }

    public function fulfillment_on_system(Request $request, $id)
    {
        $order = Order::find($id);
        $shop = Auth::user();
        $setting = Setting::where('user_id',$shop->id)->first();
        if(isset($setting) && isset($setting->api_url) && isset($setting->auth_key)){
            $customer = null;
            if (isset($order->customer)) {
                $customer = json_decode($order->customer);
            }

// If you want to handle null values gracefully, you can use an array_filter to remove null values
            $data = json_encode(array_filter([
                "first_name" => isset($customer) && isset($customer->first_name)?$customer->first_name:'',
                "last_name" => isset($customer) && isset($customer->last_name)?$customer->last_name:'',
                "address" => isset($customer) && isset($customer->default_address) ? $customer->default_address->address1 : '',
                "city" => isset($customer) && isset($customer->default_address) ? $customer->default_address->city : '',
                "province_code" => isset($customer) && isset($customer->default_address) ? $customer->default_address->province_code : '',
                "phone" => isset($customer) && isset($customer->default_address) ? $customer->default_address->phone : '',
                "cod" => isset($order) ? $order->total_price : '',
                "quantity" => isset($order) ? $order->qty : '',
                "instructions" => isset($order) ? $order->note : '',
//            "sku" => "1",
            ]));
//        dd($data);
// Note: In the above examples, optional($customer)->first_name will return null if $customer is null or if $customer->first_name is not set.
            $api_url = $setting->api_url;
            $api_auth_key = $setting->auth_key;
//            https://srb.trackify.net
//        uv5itsMjffqlzYz0/Bh+URwfE7L2yMFA9R/d967wt

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "$api_url/api/json/add_shipment_txt_addr.php",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "AUTHKEY: $api_auth_key",
                    'Content-Type: text/plain'
                ),
            ));

            $response = curl_exec($curl);
            $jsonStart = strpos($response, '{');
            $jsonResponse = substr($response, $jsonStart);

// Decode JSON response into an associative array
            $parsedResponse = json_decode($jsonResponse, true);

            $success = null;
            $trackingId = null;
            $responseText = null;

            if ($parsedResponse === null) {

            } else {
                $success = $parsedResponse['success'];
                $trackingId = $parsedResponse['tracking_id'];
                $responseText = $parsedResponse['response_txt'];
            }

            curl_close($curl);

            if (isset($success) == 1) {
                $order->fulfillment_tracking_id = isset($trackingId)?$trackingId:null;
                $order->fulfillment_tracking_status = "Shipment Added";
                $order->fulfillment_tracking_message = isset($responseText)?$responseText:null;
                $order->save();
                if(isset($trackingId) && isset($responseText)){
                    $this->fulfill_order($shop,$order);
                    return Redirect::tokenRedirect('home', ['notice' => 'Fulfillment Successfully!']);
                }else{
                    return Redirect::tokenRedirect('home', ['error' => 'Fulfillment Failed, Because of error in fulfillment system error!']);
                }

            } else {
                return Redirect::tokenRedirect('home', ['error' => 'Fulfillment Failed!']);
            }
        }else{
            return Redirect::tokenRedirect('home', ['error' => 'Error: No Shipment API Credentials Found!']);
        }

    }

    public function fulfill_order($shop, $order)
    {
        $data = [];
        if (isset($shop)) {

            $data = [
                "fulfillment" => [
                    "notify_customer" => true,
                    "tracking_info" => [
                        "number" => isset($order->fulfillment_tracking_id) ? $order->fulfillment_tracking_id : null,
                        "url" => ''
                    ],
                    "line_items_by_fulfillment_order" => [
                       [
                           "fulfillment_order_id" => $order->shopify_fulfillment_order_id,
                       ]
                    ],
                ]
            ];
            $response = $shop->api()->rest('POST', '/admin/api/2023-04/fulfillments.json', $data);

            if ($response['errors'] == false) {
                $response = $response['body']['fulfillment'];

                $order_response = $shop->api()->rest('GET', '/admin/api/2023-04/orders/' . $order->shopify_order_id . '.json');

                if ($order_response['errors'] == false) {
                    $order = $order_response['body']['order'];
                    $this->CreateUpdateOrder($order, $shop);
//                        $order = Order::where('shopify_order_id', $order->id)->first();
//                        $order->pickup_status = "Marked as Picked Up";
//                        $order->save();
                } else {
                    //                dd($order_response);
                    $order_update = Order::where('user_id', $shop->id)->where('shopify_order_id', $order->shopify_order_id)->first();
                    $order_update->fulfillment_status = 'fulfilled';
                    $order_update->save();
                }

                $this->CreateUpdateFufillment($response, $shop);

            } else {
                dd('store fulfillment error::', $response);
                $msg = new ErrorMessage();
                $msg->message = "store fulfillment error:: " . json_encode($response);
                $msg->save();
            }

            return true;
//                else{
//                    $location = Location::where('user_id',$shop->id)->first();
//                    if(isset($location)){
//                        $data = [
//                            "fulfillment" => [
//                                "location_id" => $location->location_id,
//                                "tracking_number" => null,
//                                "line_items" => [
//
//                                ]
//                            ]
//                        ];
//                    }
//
//                }
//                } //6122438719
//                else {
//                    $data = [
//                        "fulfillment" => [
//                            "location_id" => $order->location_id,
//                            "tracking_number" => $request->tracking_number,
////                    "tracking_url"=> $request->tracking_url,
//                            "tracking_company" => $request->shipping_carrier,
//                            "line_items" => [
//
//                            ]
//                        ]
//                    ];
//                }

            if (!empty($data)) {
                if (isset($order->lineitems) && !empty($order->lineitems)) {
                    if (isset($order->shopify_fulfillment_order_id)) {
                        $fulfillment_order_line_items = [];
//                        $line_item = LineItem::where('user_id', $shop->id)->where('shopify_lineitem_id', $item)->first();

//                        if (isset($line_item) && $line_item->fulfillment_status != "fulfilled" && $quantity[$index] > 0) {
//                            array_push($fulfillment_order_line_items, [
//                                "id" => $line_item->shopify_fulfillment_order_id,
//                                "quantity" => $quantity[$index],
//                            ]);
//                        }

                        foreach ($order->lineitems as $index => $line_item) {
                            if ($line_item != null && $line_item->quantity > 0) {
                                array_push($fulfillment_order_line_items, [
                                    "id" => $line_item->shopify_fulfillment_order_id,
                                    "quantity" => $line_item->quantity,
                                ]);

//                                array_push($data['fulfillment']['line_items'], [
//                                    "id" => $line_item->shopify_lineitem_id,
//                                    "quantity" => $line_item->quantity,
//                                ]);
                            }
                        }

                        if (!empty($fulfillment_order_line_items)) {
                            array_push($data['fulfillment']['line_items_by_fulfillment_order'], [
                                "fulfillment_order_id" => $order->shopify_fulfillment_order_id,
                                "fulfillment_order_line_items" => $fulfillment_order_line_items
                            ]);


//                            $response = $shop->api()->rest('POST', '/admin/orders/' . $order->shopify_order_id . '/fulfillments.json', $data);
                            $response = $shop->api()->rest('POST', '/admin/api/2023-04/fulfillments.json', $data);

                            if ($response['errors'] == false) {
                                $response = $response['body']['fulfillment'];

                                $order_response = $shop->api()->rest('GET', '/admin/api/2023-04/orders/' . $order->shopify_order_id . '.json');

                                if ($order_response['errors'] == false) {
                                    $order = $order_response['body']['order'];
                                    $this->CreateUpdateOrder($order, $shop);
                                    $order = Order::where('shopify_order_id', $order->id)->first();
                                    $order->pickup_status = "Marked as Picked Up";
                                    $order->save();
                                } else {
                                    //                dd($order_response);
                                    $order_update = Order::where('user_id', $shop->id)->where('shopify_order_id', $order->shopify_order_id)->first();
                                    $order_update->fulfillment_status = 'fulfilled';
                                    $order_update->save();
                                }

                                $this->CreateUpdateFufillment($response, $shop);

                            } else {
                                dd('store fulfillment error::', $response);
                                $msg = new ErrorMessage();
                                $msg->message = "store fulfillment error:: " . json_encode($response);
                                $msg->save();
                            }
                        }
                    }
                }
            }


        }
    }

    public function filter_orders(Request $request, $shop_id)
    {
        $orders = Order::where('user_id', $shop_id);
        $selected_filter = isset($request->filter_type) ? $request->filter_type : 'all';
        $search = $request->search;

        if (isset($request->search) && $request->search != "") {
            $orders->where('name', 'like', '%' . $request->search . '%');
        }

        if (isset($selected_filter) && $selected_filter == "all") {

        } elseif (isset($selected_filter) && $selected_filter == "paid") {
            $orders->where('financial_status', "paid");
        } elseif (isset($selected_filter) && $selected_filter == "unpaid") {
            $orders->where('financial_status', null);
        } elseif (isset($selected_filter) && $selected_filter == "partial") {
            $orders->where('fulfillment_status', "partial");
        } elseif (isset($selected_filter) && $selected_filter == "fulfilled") {
            $orders->where('fulfillment_status', "fulfilled");
        } elseif (isset($selected_filter) && $selected_filter == "unfulfilled") {
            $orders->where('fulfillment_status', null);
        } elseif (isset($selected_filter) && $selected_filter == "pickup") {
            $orders->where('deliver_method', 'Local Pickup');
        }

        $orders = $orders->orderBy('shopify_created_at', 'desc')->paginate(25);
        $user = Auth::user();
        $order_data = [
            'orders' => $orders,
            'user' => $user,
            'selected_filter' => $selected_filter,
            'search' => $search
        ];
        $filter_orders_render_view = view('app.render_views.filter_orders_render_view')->with($order_data)->render();

        $data = [
            'status' => 'success',
            'filter_orders_render_view' => $filter_orders_render_view
        ];
        return response()->json($data);
    }

    public function filter_search_orders(Request $request, $shop_id)
    {

        $orders = Order::where('user_id', $shop_id);
        $selected_filter = isset($request->filter_type) ? $request->filter_type : "all";
        $search = $request->search;
        if (isset($request->search) && $request->search != "") {
            $orders->where('name', 'like', '%' . $request->search . '%');
        }

        if (isset($selected_filter) && $selected_filter == "all") {

        } elseif (isset($selected_filter) && $selected_filter == "paid") {
            $orders->where('financial_status', "paid");
        } elseif (isset($selected_filter) && $selected_filter == "unpaid") {
            $orders->where('financial_status', null);
        } elseif (isset($selected_filter) && $selected_filter == "partial") {
            $orders->where('fulfillment_status', "partial");
        } elseif (isset($selected_filter) && $selected_filter == "fulfilled") {
            $orders->where('fulfillment_status', "fulfilled");
        } elseif (isset($selected_filter) && $selected_filter == "unfulfilled") {
            $orders->where('fulfillment_status', null);
        } elseif (isset($selected_filter) && $selected_filter == "pickup") {
            $orders->where('deliver_method', 'Local Pickup');
        }

        $orders = $orders->orderBy('shopify_created_at', 'desc')->paginate(25);
        $user = Auth::user();
        $order_data = [
            'orders' => $orders,
            'user' => $user,
            'search' => $request->search,
            'selected_filter' => $selected_filter,
        ];
        $filter_orders_render_view = view('app.render_views.filter_orders_by_search')->with($order_data)->render();

        $data = [
            'status' => 'success',
            'orders' => $orders,
            'search' => $request->search,
            'selected_filter' => $selected_filter,
            'filter_orders_render_view' => $filter_orders_render_view
        ];
        return response()->json($data);
    }

    public function filter_admin_orders(Request $request, $shop_id)
    {
        $orders = null;
        $user_id = null;
        if ($shop_id == 'admin') {
            $orders = Order::query();
        } else {
            $orders = Order::where('user_id', $shop_id);
            $user_id = $shop_id;
        }

        if (isset($request->filter_type) && $request->filter_type == "all") {

        } elseif (isset($request->filter_type) && $request->filter_type == "paid") {
            $orders->where('financial_status', "paid");
        } elseif (isset($request->filter_type) && $request->filter_type == "unpaid") {
            $orders->where('financial_status', null);
        } elseif (isset($request->filter_type) && $request->filter_type == "partial") {
            $orders->where('fulfillment_status', "partial");
        } elseif (isset($selected_filter) && $selected_filter == "fulfilled") {
            $orders->where('fulfillment_status', "fulfilled");
        } elseif (isset($request->filter_type) && $request->filter_type == "unfulfilled") {
            $orders->where('fulfillment_status', null);
        }

        $orders = $orders->orderBy('shopify_created_at', 'desc')->paginate(25);

        $order_data = [
            'orders' => $orders,
            'shop_id' => $shop_id,
            'user_id' => $user_id,
            'selected_filter' => $request->filter_type
        ];
        $filter_orders_render_view = view('adminpanel.render_views.filter_admin_orders_render_view')->with($order_data)->render();

        $data = [
            'status' => 'success',
            'filter_orders_render_view' => $filter_orders_render_view
        ];
        return response()->json($data);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
//        $orders = Order::where('user_id', $user->id)->where('deliver_method', 'Local Pickup')
//            ->orderBy('shopify_created_at', 'desc')->paginate(25);
        $selected_filter = isset($request->filter_type) ? $request->filter_type : 'all';
        $orders = Order::where('user_id', $user->id);

        if (isset($request->filter_type) && $request->filter_type == "all") {

        } elseif (isset($selected_filter) && $selected_filter == "paid") {
            $orders->where('financial_status', "paid");
        } elseif (isset($selected_filter) && $selected_filter == "unpaid") {
            $orders->where('financial_status', null);
        } elseif (isset($selected_filter) && $selected_filter == "partial") {
            $orders->where('fulfillment_status', "partial");
        } elseif (isset($selected_filter) && $selected_filter == "fulfilled") {
            $orders->where('fulfillment_status', "fulfilled");
        } elseif (isset($request->filter_type) && $request->filter_type == "unfulfilled") {
            $orders->where('fulfillment_status', null);
        } elseif (isset($selected_filter) && $selected_filter == "pickup") {
            $orders->where('deliver_method', 'Local Pickup');
        }

        $orders = $orders->orderBy('shopify_created_at', 'desc')->paginate(25);

        $data = array(
            'orders' => $orders,
            'user' => $user,
            'selected_filter' => $selected_filter
        );
        return view('app.orders')->with($data);
    }

    public function sync_orders()
    {
        $next_page = '';
        $shop = Auth::user();

        $order_count_api = $shop->api()->rest('GET', '/admin/api/2023-04/orders/count.json',['status' => 'any']);

        if($order_count_api['errors'] == false){
            $order_count_api = $order_count_api['body']['count'];
            $count = ceil($order_count_api / 250);
            if ($count > 0) {
                for ($i = 1; $i <= $count; $i++) {
                    if (isset($next_page)) {

                        if ($next_page == '') {
                            $params = ['limit' => 250, 'status' => 'any'];
//                        $params = ['limit' => 250, 'page_info' => $next_page];
                        } else {
                            $params = ['limit' => 250, 'page_info' => $next_page];
                        }

                        $order_api = $shop->api()->rest('GET', '/admin/api/2023-04/orders.json', $params);

                        if ($order_api['errors'] == false) {
                            if (isset($order_api['link']['next'])) {
                                $next_page = $order_api['link']['next'];
                            } else {
                                $next_page = null;
                            }
                            $order_api = json_decode(json_encode($order_api['body']['orders']), FALSE);

                            foreach ($order_api as $order) {
                                $this->CreateUpdateOrder($order, $shop);
//                            dd($order->fulfillments);
                            }
                        }
                    }

                }

                return Redirect::tokenRedirect('home', ['notice' => 'Orders Sync Successfully!']);
            } else {
                return Redirect::tokenRedirect('home', ['error' => 'Orders not found!']);
            }
        }else {
            return Redirect::tokenRedirect('home', ['error' => 'Orders not found!']);
        }


    }

    public function sync_shipments()
    {

        $shop = Auth::user();
        $orders = Order::where('user_id',$shop->id)->whereNotNull('fulfillment_tracking_id')->get();

        $setting = Setting::where('user_id',$shop->id)->first();
        if(isset($setting) && isset($setting->api_url) && isset($setting->auth_key)){
            if($orders->count()){
                foreach ($orders as $order){
                    $this->shipment_status_api($order,$setting);
                }
                return Redirect::tokenRedirect('home', ['notice' => 'Shipments Statuses Sync Successfully!']);
            }else{
                return Redirect::tokenRedirect('home', ['error' => 'Error: No Orders Shipment Found!']);
            }
        }else{
            return Redirect::tokenRedirect('home', ['error' => 'Error: No Shipment API Credentials Found!']);
        }
    }

    public function shipment_status_api($order,$setting){

        $api_url = $setting->api_url;
        $api_auth_key = $setting->auth_key;
//            https://srb.trackify.net
//        uv5itsMjffqlzYz0/Bh+URwfE7L2yMFA9R/d967wt
        $curl = curl_init();

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$api_url/api/json/get_current_status.php?tracking_id=$order->fulfillment_tracking_id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "AUTHKEY: $api_auth_key"
            ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);
        if(str_contains($response,'current_status_name')){
            // Find the position of each key in the string
//            $tracking_id_pos = strpos($response, '"tracking_id":"') + strlen('"tracking_id":"');
//            $current_status_id_pos = strpos($response, '"current_status_id":"') + strlen('"current_status_id":"');
            $current_status_name_pos = strpos($response, '"current_status_name":"') + strlen('"current_status_name":"');
//            $user_name_pos = strpos($response, '"user_name":"') + strlen('"user_name":"');

// Extract values using substr
//            $tracking_id = substr($response, $tracking_id_pos, strpos($response, '"', $tracking_id_pos) - $tracking_id_pos);
//            $current_status_id = substr($response, $current_status_id_pos, strpos($response, '"', $current_status_id_pos) - $current_status_id_pos);
            $current_status_name = substr($response, $current_status_name_pos, strpos($response, '"', $current_status_name_pos) - $current_status_name_pos);
//            $user_name = substr($response, $user_name_pos, strpos($response, '"', $user_name_pos) - $user_name_pos);

// Remove any escaped characters
//            $tracking_id = json_decode('"' . $tracking_id . '"');
//            $current_status_id = json_decode('"' . $current_status_id . '"');
            $current_status_name = json_decode('"' . $current_status_name . '"');
//            $user_name = json_decode('"' . $user_name . '"');
            $order->fulfillment_tracking_status = $current_status_name;
            $order->save();
        }

    }

    public function CreateUpdateOrder($order, $shop)
    {
        try {

            $order_data = Order::where('shopify_order_id', $order->id)->where('user_id', $shop->id)->first();
            if ($order_data == null) {
                $order_data = new Order();
            }
            $order_data->name = $order->name;
            $order_data->user_id = $shop->id;
            $order_data->email = isset($order->email) ? $order->email : null;
            $order_data->shopify_order_id = $order->id;
            $order_data->shopify_created_at = Carbon::createFromTimeString($order->created_at)->format('Y-m-d H:i:s');
            $order_data->shopify_updated_at = Carbon::createFromTimeString($order->updated_at)->format('Y-m-d H:i:s');
            if (isset($order->shipping_address->country)) {
                $order_data->country = $order->shipping_address->country;
            } elseif (isset($order->billing_address->country)) {
                $order_data->country = $order->billing_address->country;
            }

            $order_data->fulfillment_status = $order->fulfillment_status;
            $order_data->note = $order->note;
            $order_data->financial_status = isset($order->financial_status) ? $order->financial_status : null;
            if (isset($order->customer) && $order->customer !== null) {
                $order_data->customer = json_encode($order->customer);
            }
            $order_data->total_price = $order->total_price;
//            $matched_location_with_db_location = null;

//            if (isset($order->shipping_lines) && !empty($order->shipping_lines)) {
//                $order_data->shipping_lines = json_encode($order->shipping_lines);
//                if ($db_locations->count() > 0 && isset($order->shipping_lines[0]->code)) {
//                    $order_delivery_method = $order->shipping_lines[0]->code;
//                    foreach ($db_locations as $db_location) {
//                        if ($db_location->name == $order_delivery_method) {
//                            $db_location_status = true;
//                            $matched_location_with_db_location = $db_location;
//                        }
//                    }
//                    if ($db_location_status == true) {
//                        $order_data->deliver_method = 'Local Pickup';
//                    } else {
//                        $order_data->deliver_method = $order_delivery_method;
//                    }
//                }
//            }

            if (isset($order->location_id)) {
                $order_data->location_id = isset($order->location_id) ? $order->location_id : null;
            } elseif (isset($matched_location_with_db_location)) {
                $order_data->location_id = $matched_location_with_db_location->location_id;
            }

            $qty = 0;
            foreach ($order->line_items as $item) {
                $qty = $qty + $item->quantity;
            }
            $order_data->qty = $qty;

            $order_data->save();
//                dd($order_data);
//            if (isset($order->fulfillments) && !empty($order->fulfillments)) {
//                foreach ($order->fulfillments as $fulfillment) {
//                    $this->CreateUpdateFufillment($fulfillment, $shop);
//                }
//            }

            $this->sync_fulfillment_order_ids($order_data, $shop);


        } catch (\Exception $exception) {
            $msg = new ErrorMessage();
            $msg->message = 'error in order create update function: ' . json_encode($exception->getMessage());
            $msg->save();
        }

    }

    public function sync_fulfillment_order_ids(Order $db_order, User $shop)
    {
        try {

            $fulfillments_orders = $shop->api()->rest('get', '/admin/api/2023-04/orders/' . $db_order->shopify_order_id . '/fulfillment_orders.json');

            if ($fulfillments_orders['errors'] == false) {
                $fulfillments_orders = $fulfillments_orders['body']['fulfillment_orders'];
                $fulfillments_orders = json_decode(json_encode($fulfillments_orders), false);

                foreach ($fulfillments_orders as $fulfillments_order) {
                    $db_order->shopify_fulfillment_order_id = $fulfillments_order->id;
//                    if (!empty($fulfillments_order->line_items)) {
//                        foreach ($fulfillments_order->line_items as $line_item) {
//                            $db_line_item = LineItem::where('shopify_lineitem_id', $line_item->line_item_id)->first();
//                            if (isset($db_line_item)) {
//                                $db_line_item->shopify_fulfillment_order_id = $line_item->id;
//                                $db_line_item->save();
//                            }
//                        }
//                    }
                    $db_order->save();
                }
            }
        } catch (\Exception $exception) {
            $msg = new ErrorMessage();
            $msg->message = "webhook order create sync_fulfillment_order_ids api data: " . json_encode($exception->getMessage());
            $msg->save();
        }

    }

    public function CreateUpdateFufillment($fulfillment_api, $shop)
    {
//        dd($fulfillment_api);
        $fulfillment_api = json_decode(json_encode($fulfillment_api), false);

        $fulfillment_save = Fulfillment::where('user_id', $shop->id)->where('fulfillment_id', $fulfillment_api->id)->where('tracking_number', $fulfillment_api->tracking_number)->first();
        if ($fulfillment_save == null) {
            $fulfillment_save = new Fulfillment();
        }
        $fulfillment_save->user_id = $shop->id;
        $fulfillment_save->fulfillment_id = $fulfillment_api->id;
        $fulfillment_save->order_id = $fulfillment_api->order_id;
        $fulfillment_save->location_id = $fulfillment_api->location_id;
        $fulfillment_save->status = $fulfillment_api->status;
        $fulfillment_save->service = $fulfillment_api->service;
        $fulfillment_save->tracking_number = $fulfillment_api->tracking_number;
        $fulfillment_save->tracking_company = $fulfillment_api->tracking_company;
        $fulfillment_save->shipment_status = $fulfillment_api->shipment_status;
        $fulfillment_save->tracking_url = $fulfillment_api->tracking_url;
        $fulfillment_save->name = $fulfillment_api->name;
        $fulfillment_save->line_items = json_encode($fulfillment_api->line_items);
        $fulfillment_save->created_at = Carbon::createFromTimeString($fulfillment_api->created_at)->format('Y-m-d H:i:s');
        $fulfillment_save->updated_at = Carbon::createFromTimeString($fulfillment_api->updated_at)->format('Y-m-d H:i:s');
        $fulfillment_save->save();
    }

    public function order_create(Request $request)
    {
        $shop = User::first();
        $order = $request->all();
        $order = json_decode(json_encode($order), FALSE);
        $ord = new OrderController();
        $ord->CreateUpdateOrder($order, $shop);
//        $order_data = Order::where('shopify_order_id',$order->id)->first();
    }

    public function settings(Request $request){
        $setting = Setting::where('user_id',Auth::user()->id)->first();
        return view('app.settings')->with(['setting'=>$setting]);
    }

    public function setting_save(Request $request){
        $user = Auth::user();
        $setting = Setting::where('user_id',$user->id)->first();
        if($setting == null){
            $setting = new Setting();
        }

        $setting->user_id = $user->id;
        $setting->api_url = $request->api_url;
        $setting->auth_key = $request->auth_key;
        $setting->save();

        return Redirect::tokenRedirect('settings', ['notice' => 'Settings Saved!']);

    }

    public function privacy(){
        return view('privacy');
    }
}
