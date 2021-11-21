<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Luigel\Paymongo\Facades\Paymongo;
use Luigel\Paymongo\PaymongoServiceProvider;
use App\IWellness\PayMongoRequests;
use App\IWellness\SubscriptionClass;
use App\IWellness\CartClass;
use Illuminate\Support\Facades\Event;
use Validator;
use Session;
use App\Models\Module;

class PayMongoController extends Controller
{

    use PayMongoRequests;

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public $subsClass, $cartClass, $url;
    public function __construct()
    {
        $this->subsClass = new SubscriptionClass();
        $this->cartClass = new cartClass();
    }

    public function payWithCard()
    {
        try {
            $details = base64_decode(request()->get('data'));
            $user    = auth()->check() ? auth()->user() : json_decode(base64_decode(Session::get('checkout_details')))->shipping_details;
            parse_str($details, $formData);
         
            $cardDetails            = $formData['details'] ?? null;
            $amount                 = $formData['amount']+$formData['service_charge']+($formData['shipping_fee'] ?? 0);
            // Payment intent
            $paymentIntentData = [
                'amount' => $amount,
                'payment_method_allowed' => [
                    'card',
                ],
                'payment_method_options' => [
                    'card' => [
                        'request_three_d_secure' => 'automatic',
                    ],
                ],
                'description' => env('APP_NAME', 'IWellness') . ' | Payment for Id #' . $this->setModuleId(uniqid()),
                'statement_descriptor' => env('APP_NAME', 'IWellness'),
                'currency' => 'PHP',
            ];


            // Create Payment Intent
            $paymentIntent = $this->createPaymentIntent($paymentIntentData);            

            // Payment Method
            $customerData = [
                'type' => 'card',
                'details' => [
                    'card_number' => str_replace("-", "", $cardDetails['card_number']),
                    'exp_month'   => (int) $cardDetails['exp_month'],
                    'exp_year'    => (int) $cardDetails['exp_year'],
                    'cvc'         => $cardDetails['cvc'],
                ],
                'billing' => [
                    'name'  => $user->name ?? 'test',
                    'email' => $user->email ?? 'test',
                    'phone' => $user->contact_no ?? 'test',
                ],
            ];

            // Create Payment Method
            $paymentMethodCreated = $this->createPaymentMethod($customerData);
            $paymentMethodId      = $paymentMethodCreated->getId();

            // Attaching Payment Method to Payment Intent
            $attachedPaymentIntent = $this->attachPaymentIntent($paymentIntent, $paymentMethodCreated->getId());
            $redirect_url          = null;
            $message               = null;
            $requiresAuth          = false;

            if ($this->checkPaymentIntent($attachedPaymentIntent)[0]) {
                $nextAction   = $attachedPaymentIntent->getNextAction();
                $this->url    = $nextAction['redirect']['url'] ?? null;
                $requiresAuth = true;
            } else {
                $message = $this->checkPaymentIntent($attachedPaymentIntent)[1];
            }

            $paymentStatus   = $attachedPaymentIntent->getStatus() ?? null;
            $paymentIntendId = $attachedPaymentIntent->getId() ?? null;
            $data            = $attachedPaymentIntent->getData() ?? null;

            if($paymentStatus == 'succeeded') {
                $this->savePayments($attachedPaymentIntent, 'card', $formData['transaction_type']);
                $this->eventPerTransacType($formData, $attachedPaymentIntent);
            }

            $parameters = [
                'paymentIntendId' => $paymentIntendId,
                'paymentMethodId' => $paymentMethodId,
                'url'             => $this->url,
                'status'          => $paymentStatus,
                'message'         => $message,
                'requiresAuth'    => $requiresAuth
            ];

            return response()->json($parameters, 200);
        } catch (\Exception $e) {
            throw $e;
            
            if(isset($paymentMethodCreated) AND isset($paymentIntent)){
                $errorData = $this->getErrorDetails($e, $paymentMethodCreated, $paymentIntent, null);
            } else {
                $errorData = $this->getErrorDetails($e, null, null, null);
            }
        
            $errorMsg = $this->customErrorMessage($e->getMessage());

            return response()->json(['message', $errorMsg], '400');
        }
    }

    public function getPaymentStatus()
    {
        try {
            $details = base64_decode(request()->get('data'));
            $user    = auth()->check() ? auth()->user() : [];
            parse_str($details, $formData);

            $paymentIntentId        = base64_decode(request()->get('paymentId'));
            $retrievedPaymentIntent = Paymongo::paymentIntent()->find($paymentIntentId);
            $paymentStatus          = $retrievedPaymentIntent->getStatus() ?? null;
            $transactionId          = base64_decode(request()->get('transactionId')) ?? null;

            if($paymentStatus == 'succeeded') {
                $this->savePayments($retrievedPaymentIntent, 'card', $formData['transaction_type']);
                $this->eventPerTransacType($formData, $retrievedPaymentIntent);
            }

            return response()->json([
                'paymentIntendId' => $paymentIntentId, 
                'status' => $paymentStatus,
                'url' => $this->url
            ], 200);
            
        } catch (\Exception $e) {
            if(isset($retrievedPaymentIntent)){
                $errorData = $this->getErrorDetails($e, null, $retrievedPaymentIntent, null);
            } else {
                $errorData = $this->getErrorDetails($e, null, null, null);
            }

            return response()->json(['message', $e->getMessage()], 400);
        }
    }

    public function payWithGcashorGrabpay()
    {
        try {
            $shipping_fee = request()->get('shipping_fee');
            $moduleId     = request()->get('moduleId');
            $module       = Module::where('id', $moduleId)->first();
            $amount       = $module->cost;
            $method       = request()->get('method');
            $user         = auth()->user();

            $gcashData    = [
                'type'     => $method,
                'amount'   => $amount,
                'currency' => 'PHP',
                'redirect' => [
                    'success' => config('app.url') . '/success',
                    'failed'  => config('app.url'). '/failed',
                ],
                'billing' => [
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'email' => $user->email,
                    'phone' => $user->mobile_no,
                ],
            ];

            $source_resource = $this->createSource($gcashData);
            $redirect_url    = $source_resource->getCheckoutUrlRedirect() ?? null;
            $sourceId        = $source_resource->getId() ?? null;

            return response()->json(['url' => $redirect_url, 'sourceId' => $sourceId, 'method' => $method], 200);
        } catch (\Exception $e) {
            if(isset($source_resource)) {
                $errorData = $this->getErrorDetails($e, null, null, $source_resource);
            } else {
                $errorData = $this->getErrorDetails($e, null, null, null);
            }

            $errorMsg = $this->customErrorMessage($e->getMessage());

            return response()->json(['message', $errorMsg ], $e->getCode());
        }
    }

    function checkWalletStatus() {
        $sourceId        = request()->get('source-id');
        $source_resource = PayMongo::source()->find($sourceId);

        $isChargeable    = false;

        if($source_resource->getStatus() === 'chargeable'){
            $isChargeable  = true;
        } else {
            
        }

        return response()->json(['sourceId'=> $sourceId, 'chargeable' => $isChargeable], 200);
    }

    function sendGcashOrGrabPayPayment(){

        $source_resource = null;
        try {
            $module          = Module::where('id', request()->get('moduleId'))->with('createdBy')->first();
            $amount          = $module->cost;
            $sourceId        = request()->get('source-id');
            $source_resource = PayMongo::source()->find($sourceId);
            $walletPayment   = $this->sendPayments($amount, $sourceId, $module);


        } catch (\Exception $e) {
            $errorData = $this->getErrorDetails($e, null, null, $source_resource);

            $errorMsg = $this->customErrorMessage($e->getMessage());
            return response()->json(['message', $errorMsg], 400);
        }
    }

    public function cancelPaymentIntent()
    {
        $paymentIntentId        = request()->get('PaymentIntentId');
        $paymentIntent          = Paymongo::paymentIntent()->find($paymentIntentId);
        $cancelledPaymentIntent = $paymentIntent->cancel();
        $status                 = $cancelledPaymentIntent->getStatus();

    }

    public function webhook()
    {
        $this->createWebhook();
    }

    public function disableOrEnableWebhook()
    {
        $webhooks = Paymongo::webhook()->all();

        $webhook = Paymongo::webhook()->find($webhooks[0]->getId());

        if ($webhook->getStatus() === 'enabled')
        {
            $webhook->disable();
            $webhook = Paymongo::webhook()->find($webhooks[0]->getId());
            $this->assertEquals('disabled', $webhook->getStatus());
        }
        else
        {
            $webhook->enable();
            $webhook = Paymongo::webhook()->find($webhooks[0]->getId());
            $this->assertEquals('enabled', $webhook->getStatus());
        }
    }

    public function eventPerTransacType($data = null, $attachedPaymentIntent){
        if($data['transaction_type'] == 1){
            if(auth()->user()->activated){
                $this->subsClass->addCapital($data['amount']);
            }else{
                $this->subsClass->activateAccount($data)->parentsCommision();
            }

            $this->url = url('res/');
        }
        if($data['transaction_type'] == 2){
            $orderDetails = $this->cartClass->placeOrders($data, $attachedPaymentIntent);
            $this->url = url('res/order/invoice/'.$orderDetails->id);
        }
    }
}