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
            
            if (env('SMS_PROVIDER') === 'bulksmsplans') {
                if (env('SMS_BULKSMS_API_ID') && env('SMS_BULKSMS_API_PASSWORD')) {
                    try {
                        // Determine template ID based on message content
                        $templateId = self::getTemplateId($message);
                        
                        $response = Http::timeout(30)
                            ->post('https://www.bulksmsplans.com/api/send_sms', [
                                'api_id' => env('SMS_BULKSMS_API_ID'),
                                'api_password' => env('SMS_BULKSMS_API_PASSWORD'),
                                'sms_type' => env('SMS_BULKSMS_TYPE', 'Transactional'),
                                'sms_encoding' => env('SMS_BULKSMS_ENCODING', 'text'),
                                'sender' => env('SMS_BULKSMS_SENDER_ID', 'ALSYPL'),
                                'number' => $to,
                                'message' => $message,
                                'template_id' => $templateId
                            ]);
                        
                        Log::info('BulkSMS Response: ' . $response->body());
                        return $response->body();
                    } catch (Throwable $e) {
                        Log::error('BulkSMS Error: ' . $e->getMessage());
                    }
                }
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

    /**
     * Determine the correct template ID based on message content
     */
    private static function getTemplateId($message)
    {
        // Determine template ID based on message content
        if (strpos($message, 'OTP for your mobile number verification') !== false) {
            return '182323'; // SendOTPSMS
        } elseif (strpos($message, 'Welcome') !== false && strpos($message, 'USER ID') !== false) {
            return '182322'; // SendRegisteredSMS
        } elseif (strpos($message, 'reset password request') !== false) {
            return '182321'; // MemberSendForgotPasswordSMS
        } elseif (strpos($message, 'successfully activated') !== false) {
            return '182315'; // ActivationSMS
        } elseif (strpos($message, 'Admin') !== false && strpos($message, 'reset password request') !== false) {
            return '182320'; // AdminSendForgotPasswordSMS
        } else {
            return '182087'; // BSP-DEMO (fallback)
        }
    }

    public static function balance()
    {
        if (env('SMS_PROVIDER') === 'bulksmsplans') {
            if (!env('SMS_BULKSMS_API_ID') || !env('SMS_BULKSMS_API_PASSWORD') || !settings('sms_enabled')) {
                return null;
            }

            try {
                $response = Http::timeout(30)
                    ->post('https://www.bulksmsplans.com/api/balance', [
                        'api_id' => env('SMS_BULKSMS_API_ID'),
                        'api_password' => env('SMS_BULKSMS_API_PASSWORD'),
                    ]);
                
                $data = $response->json();
                Log::info('BulkSMS Balance Response: ' . $response->body());
                
                // Return balance if available in response
                return $data['balance'] ?? null;
            } catch (Throwable $e) {
                Log::error('BulkSMS Balance Error: ' . $e->getMessage());
                return null;
            }
        }
        
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
