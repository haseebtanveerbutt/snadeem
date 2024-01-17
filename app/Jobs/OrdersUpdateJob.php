<?php namespace App\Jobs;

use App\Http\Controllers\OrderController;
use App\Models\AdminEmail;
use App\Models\EmailLog;
use App\Models\ErrorMessage;
use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Osiset\ShopifyApp\Objects\Values\ShopDomain;
use stdClass;

class OrdersUpdateJob implements ShouldQueue
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
//        $this->shopDomain = ShopDomain::fromNative($this->shopDomain);
        try {
//            usleep(3);
            $shop= User::where('name',$this->shopDomain)->first();
            if($shop != null){
                $order=$this->data;
                $ord=new OrderController();
                $ord->CreateUpdateOrder($order,$shop);
            }else{
                $msg = new ErrorMessage();
                $msg->message = 'no shop found';
                $msg->save();
            }

        }catch (\Exception $exception)
        {
            $msg = new ErrorMessage();
            $msg->message = json_encode($exception->getMessage());
            $msg->save();
        }
    }
    public function failed($exception)
    {
        $msg = new ErrorMessage();
        $msg->message = 'order update exception: '.json_encode($exception->getMessage());
        $msg->save();
        // etc...
    }
}
