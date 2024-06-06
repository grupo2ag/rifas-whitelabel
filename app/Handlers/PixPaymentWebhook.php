<?php

namespace App\Handlers;

use App\Http\Controllers\Webhook\PixPaymentController;
use ShiftOneLabs\LaravelSqsFifoQueue\Bus\SqsFifoQueueable;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;

class PixPaymentWebhook extends ProcessWebhookJob
{
    use SqsFifoQueueable;

    public function __construct(WebhookCall $webhookCall)
    {
        parent::__construct($webhookCall);
    }

    public function handle()
    {
        http_response_code(200);
        $data = json_decode($this->webhookCall, true);
        if(!empty($data)) {
            $payload = $data["payload"];

            if (!empty($payload['order_id'])) {
                if (!$this->pixPayment($payload)) {
                    setLogErros('Webhook->pixPayment', 'Error Pix', $data);
                    $this->fail('Error Pix');
                }
            }
        }else return false;

        return true;
    }

    private function pixPayment($data)
    {
        return (new PixPaymentController())->create($data);
    }
}
