<?php namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Osiset\ShopifyApp\Objects\Values\ShopDomain;
use Osiset\ShopifyApp\Storage\Models\Charge;
use stdClass;

class CustomersRedactJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Shop's myshopify domain
     *
     * @var ShopDomain|string
     */
    public $shopDomain;

    /**
     * The webhook data
     *
     * @var object
     */
    public $data;

    /**
     * Create a new job instance.
     *
     * @param string   $shopDomain The shop's myshopify domain.
     * @param stdClass $data       The webhook data (JSON decoded).
     *
     * @return void
     */
    public function __construct($shopDomain, $data)
    {
        $this->shopDomain = $shopDomain;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Convert domain
        $this->shopDomain = ShopDomain::fromNative($this->shopDomain);

        // Do what you wish with the data
        // Access domain name as $this->shopDomain->toNative()
        try {

            $shop = \App\Models\User::where('name',$this->shopDomain->toNative())->first();
            $charges = Charge::where('user_id', $shop->id)->get();
            if($charges->count()){
                foreach ($charges as $charge){
                    $charge->delete();
                }
            }

            $fulfillments = \App\Models\Fulfillment::where('user_id', $shop->id)->get();
            if($fulfillments->count()){
                foreach ($fulfillments as $fulfillment){
                    $fulfillment->delete();
                }
            }

            $lineitems = \App\Models\LineItem::where('user_id', $shop->id)->get();
            if($lineitems->count()){
                foreach ($lineitems as $lineitem){
                    $lineitem->delete();
                }
            }

            $orders = \App\Models\Order::where('user_id', $shop->id)->get();
            if($orders->count()){
                foreach ($orders as $order){
                    $order->delete();
                }
            }
            $settings = \App\Models\Setting::where('user_id', $shop->id)->get();
            if($settings->count()){
                foreach ($settings as $setting){
                    $setting->delete();
                }
            }

            return;
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
