<?php
namespace App\Handlers\Signature;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;

class PixPaymentSignature implements SignatureValidator{
    public function isValid(Request $request, WebhookConfig $config): bool{
        return true;
        /*$authorization = $request->header('signature');

        $payloadJson = $request->getContent();
        $payloadJson = trim($payloadJson);

        $token = Configuration::find(1);

        $signature = hash_hmac('sha256', $payloadJson, $token->token_gateway);
        //dd($payloadJson, $signature, $authorization, ($signature === $authorization));
        if($signature === $authorization){
            return true;
        }

        return false;*/
    }
}
