<?php

namespace App\Library;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Log;
use Throwable;

class Sms
{
    public static function send(string $to, string $message)
    {
        if (settings('sms_enabled', true)) {
            $message = $message.' '.env('SMS_TEMPLATE_COMPANY_NAME');

            if (env('APP_ENV') == 'local') {
                Log::info($message);
            }
            if (env('SMS_PROVIDER') === 'mobtexting') {
                if (env('SMS_KEY')) {
                    try {
                        (new Client())->get(env('SMS_URL').'/api/v2/sms/send', [
                            'headers' => [
                                'Authorization' => 'Bearer '.env('SMS_KEY'),
                            ],
                            'query' => [
                                'message' => $message,
                                'sender' => env('SMS_SENDER_ID'),
                                'to' => env('TEST_MOBILE', $to),
                                'service' => 'T',
                            ],
                            'timeout' => 30,
                        ])->getBody()->__toString();
                    } catch (Throwable $e) {
                    }
                }
            }

            if (env('SMS_PROVIDER') === 'gupshup') {
                if (env('SMS_GUPSHUP_LOGIN_ID') && env('SMS_GUPSHUP_PASSWORD')) {
                    try {
                        return Http::timeout(30)
                            ->get('http://mlmservices.msg4all.com/GatewayAPI/rest', [
                                'v' => '1.1',
                                'method' => 'sendMessage',
                                'loginid' => env('SMS_GUPSHUP_LOGIN_ID'),
                                'password' => env('SMS_GUPSHUP_PASSWORD'),
                                'send_to' => "91$to",
                                'msg' => $message,
                            ])->__toString();
                    } catch (Throwable $e) {
                    }
                }
            }
        }
    }

    public static function balance()
    {
        if (env('SMS_PROVIDER') === 'mobtexting') {
            if (! env('SMS_KEY') || ! settings('sms_enabled')) {
                return null;
            }

            try {
                $response = json_decode(
                    (new Client())->get(env('SMS_URL').'/api/v2/account/balance', [
                        'headers' => [
                            'Authorization' => 'Bearer '.env('SMS_KEY'),
                        ],
                        'timeout' => 30,
                    ])->getBody()
                );

                if ($transactionalBalance = collect($response->data)->firstWhere('service', 'T')) {
                    return $transactionalBalance->credits;
                }

                return null;
            } catch (Throwable $e) {

                return null;
            }
        }
    }
}
