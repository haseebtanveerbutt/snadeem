<?php namespace App\Jobs;

use App\Models\ErrorMessage;
use App\Models\Fulfillment;
use App\Models\FulfillmentStatus;
use App\Models\LineItem;
use App\Models\Order;
use App\Models\OrderCharge;
use App\Models\Setting;
use App\Models\User;
use App\Models\WidgetSetting;
use App\Models\WizardQuestion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Osiset\ShopifyApp\Objects\Values\ShopDomain;
use Osiset\ShopifyApp\Storage\Models\Charge;
use stdClass;

class AppUninstalledJob implements ShouldQueue
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

        try {
            $shop = User::where('name',$this->shopDomain->toNative())->first();
            $charges = Charge::where('user_id', $shop->id)->get();
            if($charges->count()){
                foreach ($charges as $charge){
                    $charge->delete();
                }
            }

            $fulfillments = Fulfillment::where('user_id', $shop->id)->get();
            if($fulfillments->count()){
                foreach ($fulfillments as $fulfillment){
                    $fulfillment->delete();
                }
            }

            $lineitems = LineItem::where('user_id', $shop->id)->get();
            if($lineitems->count()){
                foreach ($lineitems as $lineitem){
                    $lineitem->delete();
                }
            }

            $orders = Order::where('user_id', $shop->id)->get();
            if($orders->count()){
                foreach ($orders as $order){
                    $order->delete();
                }
            }
            $settings = Setting::where('user_id', $shop->id)->get();
            if($settings->count()){
                foreach ($settings as $setting){
                    $setting->delete();
                }
            }

            $shop->forceDelete();

            return;
        } catch(\Exception $e) {
            $msg = new ErrorMessage();
            $msg->message = 'app_uninstalled_error'.json_encode($e);
            $msg->save();
        }
    }
}
