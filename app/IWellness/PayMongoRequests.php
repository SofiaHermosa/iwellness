<?php

namespace App\IWellness;

use Luigel\Paymongo\Facades\Paymongo;
use Luigel\Paymongo\Models\Webhook;
use Illuminate\Support\Facades\Event;
use App\Models\Payment;
use App\Events\SendPaymentMailToAdmin;
use App\Events\SendPaymentMailToUser;
use Mail;
use App\Mail\SendMail;

trait PayMongoRequests
{
    private $token;
    private $sourceResource;


    public function createPaymentMethod($data)
    {
        $paymentMethodCreated = Paymongo::paymentMethod()
            ->create($data);

        return $paymentMethodCreated;
    }

    public function createPaymentIntent($data)
    {
        $paymentIntent = Paymongo::paymentIntent()->create($data);

        return $paymentIntent;
    }

    public function attachPaymentIntent($paymentIntent, $paymentMethodId)
    {
        $attachedPaymentIntent = $paymentIntent->attach($paymentMethodId);

        return $attachedPaymentIntent;
    }

    public function createSource($data)
    {
        $source               = Paymongo::source()->create($data);
        $this->sourceResource = $source;

        return $source;
    }


    public function cancelPaymentIntent()
    {
        $cancelledPaymentIntent = $this->paymentIntent->cancel();
        $details                = $cancelledPaymentIntent->getData() ?? null;

        event(new PaymentTransactions(json_encode($details)));

    }

    public function createWebhook()
    {
        $webhook = Paymongo::webhook()->create([
            'url' => config('app.url').'/webhook',
            'events' => [
                Webhook::SOURCE_CHARGEABLE
            ]
        ]);

        return $webhook;
    }

    public function sendPayments($amount, $sourceId, $module)
    {
        $payment = Paymongo::payment()
            ->create([
                'amount' => $amount,
                'currency' => 'PHP',
                'description' => config('app.name') . ' | Payment for module Id #' . $this->setModuleId($module->id),
                'statement_descriptor' => 'iSkoolme',
                'source' => [
                    'id' => $sourceId,
                    'type' => 'source',
                ],
            ]);

            $transactionId = $payment->getData()['id'] ?? null;

            if($payment->getStatus() == 'paid') {
                $this->savePayments($payment, $module);
            } else {
                throw new \Exception('Failed to submit Payment');
            }

            return $payment;
    }

    public function checkPaymentIntent($paymentIntent)
    {
        $status   = $paymentIntent->getStatus();
        $message  = null;

        if ($status == 'succeeded') {
            $needAuth = false;
            $message = 'Payment Successfully Sent!';
        } else if ($status == 'awaiting_next_action') {
            $needAuth = true;
        } else if ($status == 'awaiting_payment_method') {
            $error    = $paymentIntent['last_payment_error'];
            throw new \Exception($error);
        }
        return [$needAuth, $message];
    }

    public function savePayments($payment, $source, $transac_type = 1)
    {
        $user           = auth()->user();
        $module_payment = new Payment();
        $data           = $payment->getData() ?? null;
        

        if ($source)
        {
            $module_payment->payment_source = $source;
            $transactionId                  = $data['payments'][0]['id'] ?? null;
        }
        else
        {
            $module_payment->payment_source = $payment->getSource()['type'];
            $transactionId                  = $payment->getData()['id'] ?? null;
        }
        $module_payment->user_id             = $user->id;
        $module_payment->amount_paid         = $payment->getAmount();
        $module_payment->pg_transaction_id   = $transactionId;
        $module_payment->transaction_type    = $transac_type;
        $module_payment->save();

        $payment_data   = $details = Payment::where('user_id', $user->id)->where('pg_transaction_id', $transactionId)->first();
        
    }

    // override error messages
    public function customErrorMessage($message)
    {
        $messageList = [
            "The value for amount cannot be greater than 100,000,000.",
            "The payment has been declined as it is suspected to be fraudulent.",
            "The payment has been declined because the card is reported lost.",
            "The payment has been declined because the card is reported stolen.",
            "The payment has been blocked as it is suspected to be fraudulent.",
            'The card has expired.',
            'The CVC number is invalid.',
            'The card has insufficient funds to complete the purchase.',
            'details.card_number format is invalid.',
            'details.exp_year must be at least this year or no later than 50 years from now.',
            'The card issuer cannot be reached, please try again later.',
            'The value for amount cannot be less than 10000.'
        ];

        $genericDeclineMsg = "The card has been declined by the issuing bank. Please contact them for more information.";

        $customMessage = [
            "Amount exceeded card/wallet's maximum transaction limit",
            $genericDeclineMsg,
            $genericDeclineMsg,
            $genericDeclineMsg,
            $genericDeclineMsg,
            'Unable to process payment, the card has expired. Please try another card.',
            'The CVC is invalid. Please correct CVC or try using another card or mode of payment',
            'The card has insufficient funds to complete the purchase. Please try another card.',
            'Credit Card number in invalid.',
            'Expiration year must be at least this year or no later than 50 years from now.',
            'Please try again later.',
            'Minimum amount is ₱ 100.00'
        ];

        $messageKey        = array_search($message, $messageList);
        $equivalentMessage = $messageKey != false ? $customMessage[$messageKey] : $message;

        return $equivalentMessage;
    }

    public function getErrorDetails($e, $method, $intent, $source) {
        $errorDetails = [
            'status'         => 'FAILED',
            'message'        => $e->getMessage() ?? null,
            'payment_method' => $method != null ? $method->getData() : null,
            'payment_intent' => $intent != null ? $intent->getData() : null,
            'source'         => $source != null ? $source->getData() : null
        ];

        return $errorDetails;
    }

    public function setModuleId($id){
        $newId = str_pad($id, 5, '0', STR_PAD_LEFT);
        return $newId;
    }
}