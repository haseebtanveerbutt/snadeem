<?php

namespace App\Http\Middleware;

use App\Models\BillingStatus;
use App\Models\Order;
use App\Models\OrderCharge;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Osiset\ShopifyApp\Storage\Models\Charge;
use Osiset\ShopifyApp\Storage\Models\Plan;

class OrderChargeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (isset($user) && isset($user->plan_id)) {
            $charge = Charge::where('user_id', $user->id)->where('plan_id', $user->plan_id)->where('status', 'ACTIVE')->first();
            if (isset($charge)) {
                $plan_activated_on = $charge->activated_on;
                $plan_expire_on = $charge->expires_on;

                if ($plan_expire_on == null) {
                    $plan_expire_on = date('Y-m-d H:i:s', strtotime($plan_activated_on . ' +30 days'));
//                    $plan_expire_on = date('Y-m-d H:i:s', strtotime($plan_activated_on . ' +'.date("t").' days'));
                    $get_count_order = Order::where('user_id', $user->id)->whereBetween('shopify_created_at', [$plan_activated_on, $plan_expire_on])->count();
                } else {
                    $get_count_order = Order::where('user_id', $user->id)->whereBetween('shopify_created_at', [$plan_activated_on, $plan_expire_on])->count();
                }

                $charge_price = $get_count_order * 0.09;
                $order_charge = OrderCharge::where('user_id', $user->id)->where('plan_id', $user->plan_id)->where('status',0)->first();
                if ($order_charge == null) {
                    $order_charge = new OrderCharge();
                    $order_charge->status = 0;
                }
                $order_charge->user_id = $user->id;
                $order_charge->plan_id = $user->plan_id;
                $order_charge->billing_on = $charge->activated_on;
                $order_charge->charge_price = $charge_price;
                $order_charge->order_count = $get_count_order;
                $order_charge->save();

                if (isset($charge->billing_on)) {
                    $now = time(); // or your date as well
                    $your_date = strtotime($charge->billing_on);
                    $date_diff = $now - $your_date;
                    $billing_days_diff = round($date_diff / (60 * 60 * 24));

                    #billing days is more than 30
                    if ($billing_days_diff > 30) {
//                    if (true) {
                        $response = $user->api()->rest('get', '/admin/api/2023-04/recurring_application_charges.json');
                        if ($response['errors'] == false) {

                            $all_recurring_charges = $response['body']['recurring_application_charges'];
                            foreach ($all_recurring_charges as $all_recurring_charge) {
                                $plan = Plan::where('name',$all_recurring_charge->name)->first();
                                $charge = Charge::where('user_id', $user->id)->where('charge_id', $all_recurring_charge->id)->first();
                                if ($charge == null) {
                                    $charge = new Charge();
                                }
                                $charge->user_id = $user->id;
                                $charge->charge_id = $all_recurring_charge->id;
                                $charge->plan_id = $plan->id;
                                $charge->terms = $plan->terms;
                                $charge->type = $plan->type;
                                $charge->price = $all_recurring_charge->price;
                                $charge->status = strtoupper($all_recurring_charge->status);
                                $charge->name = $all_recurring_charge->name;
                                $charge->billing_on = $all_recurring_charge->billing_on;
                                $charge->created_at = $all_recurring_charge->created_at;
                                $charge->updated_at = $all_recurring_charge->updated_at;
                                $charge->activated_on = $all_recurring_charge->activated_on;
                                $charge->cancelled_on = $all_recurring_charge->cancelled_on;
                                $charge->trial_days = $all_recurring_charge->trial_days;
                                $charge->capped_amount = $all_recurring_charge->capped_amount;
                                $charge->trial_ends_on = $all_recurring_charge->trial_ends_on;
                                $charge->test = (isset($all_recurring_charge->test) && $all_recurring_charge->test == true) ? 1 : 0;
                                $charge->save();
                            }
                            $active_charge = Charge::where('user_id',$user->id)->where('plan_id',$user->plan_id)->where('status',"ACTIVE")->first();

                            if($active_charge == null || $order_charge->status == 0){ #if plan is not active
                                $billing_status = BillingStatus::where('user_id',$user->id)->first();
                                if($billing_status == null){
                                    $billing_status = new BillingStatus();
                                }
                                $billing_status->user_id = $user->id;
                                $billing_status->billing_status = 0;
                                $billing_status->save();
                            }else{
                                $billing_status = BillingStatus::where('user_id',$user->id)->first();
                                if($billing_status == null){
                                    $billing_status = new BillingStatus();
                                }
                                $billing_status->user_id = $user->id;
                                $billing_status->billing_status = 1;
                                $billing_status->save();
                            }

                        }
//                       $resp =  $this->payout_plan_charges(Auth::user());
//                        return \redirect()->targetUrl();
//                        return Redirect::route('payout.plan.charges', [
//                            'shop' => $user->getDomain()->toNative(),
//                        ]);
                    }else{
                        $billing_status = BillingStatus::where('user_id',$user->id)->first();
                        if($billing_status == null){
                            $billing_status = new BillingStatus();
                        }
                        $billing_status->user_id = $user->id;
                        $billing_status->billing_status = 1;
                        $billing_status->save();
                    }
                }else{
                    $billing_status = BillingStatus::where('user_id',$user->id)->first();
                    if($billing_status == null){
                        $billing_status = new BillingStatus();
                    }
                    $billing_status->user_id = $user->id;
                    $billing_status->billing_status = 0;
                    $billing_status->save();
                }

            }else{
                $billing_status = BillingStatus::where('user_id',$user->id)->first();
                if($billing_status == null){
                    $billing_status = new BillingStatus();
                }
                $billing_status->user_id = $user->id;
                $billing_status->billing_status = 0;
                $billing_status->save();
            }
        }else{
            $billing_status = BillingStatus::where('user_id',$user->id)->first();
            if($billing_status == null){
                $billing_status = new BillingStatus();
            }
            $billing_status->user_id = $user->id;
            $billing_status->billing_status = 0;
            $billing_status->save();
        }

        return $next($request);
    }

    public function payout_plan_charges($user)
    {
        try{
            if(isset($user->plan_id)){

                $charge = Charge::where('user_id',$user->id)->first();

                $custom_charge = OrderCharge::where('user_id',$user->id)->where('billing_on',$charge->billing_on)->where('status',0)->first();

                if(isset($custom_charge) && $custom_charge->charge_price >= 0.50){
                    $dummy_charge_plan = Plan::where('dummy',1)->first();
                    $dummy_charge_plan->price = $custom_charge->charge_price; #chages must be atleast 0.50
                    $dummy_charge_plan->save();

                    return \redirect()->route('billing', ['plan' => $dummy_charge_plan->id, 'shop' => $user->name]);
                }
            }
//            return \redirect()->back();
        }catch (\Exception $exception){
//            dd($exception->getMessage());
        }

    }
}
