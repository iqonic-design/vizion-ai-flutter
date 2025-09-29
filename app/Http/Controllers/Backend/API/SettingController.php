<?php

namespace App\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Modules\Currency\Models\Currency;


class SettingController extends Controller
{
    public function appConfiguraton(Request $request)
    {
        $settings = Setting::all()->pluck('val', 'name');
        $currencies = Currency::all();
        $response = [];

        // Define the specific names you want to include
        $specificNames = ['app_name', 'footer_text', 'primary', 'razorpay_secretkey', 'razorpay_publickey', 'stripe_secretkey', 'stripe_publickey', 'paystack_secretkey', 'paystack_publickey', 'paypal_secretkey', 'paypal_clientid', 'flutterwave_secretkey', 'flutterwave_publickey',  'customer_app_play_store', 'customer_app_app_store', 'helpline_number', 'copyright', 'inquriy_email', 'site_description', 'isForceUpdateforAndroid','isForceUpdateforIos', 'version_code','account_id','client_id','client_secret','airtel_secretkey', 'airtel_clientid','phonepay_app_id','phonepay_merchant_id','phonepay_salt_key','phonepay_salt_index','midtrans_clientid','sadad_id','sadad_key','sadad_domain','cinet_siteid','cinet_apikey','cinet_secretkey'];
        foreach ($settings as $name => $value) {
            if (in_array($name, $specificNames)) {
              if (strpos($name, 'customer_app_') === 0 ) {
                    $nestedKey = 'customer_app_url';
                    $nestedName = str_replace('', 'customer_app_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } 
                 elseif (strpos($name, 'razorpay_') === 0 && $request->is_authenticated == 1 && $settings['razor_payment_method'] == 1) {
                    $nestedKey = 'razor_pay';
                    $nestedName = str_replace('', 'razorpay_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'stripe_') === 0 && $request->is_authenticated == 1 && $settings['str_payment_method'] == 1) {
                    $nestedKey = 'stripe_pay';
                    $nestedName = str_replace('', 'stripe_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'paystack_') === 0 && $request->is_authenticated == 1 && $settings['paystack_payment_method'] == 1) {
                    $nestedKey = 'paystack_pay';
                    $nestedName = str_replace('', 'paystack_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'paypal_') === 0 && $request->is_authenticated == 1 && $settings['paypal_payment_method'] == 1) {
                    $nestedKey = 'paypal_pay';
                    $nestedName = str_replace('', 'paypal_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                } elseif (strpos($name, 'flutterwave_') === 0 && $request->is_authenticated == 1 && $settings['flutterwave_payment_method'] == 1) {
                    $nestedKey = 'flutterwave_pay';
                    $nestedName = str_replace('', 'flutterwave_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                }elseif (strpos($name, 'airtel_') === 0 && $request->is_authenticated == 1 && $settings['airtel_payment_method'] == 1) {
                    $nestedKey = 'airtel_pay';
                    $nestedName = str_replace('', 'airtel_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;

                }elseif (strpos($name, 'phonepay_') === 0 && $request->is_authenticated == 1 && $settings['phonepay_payment_method'] == 1) {
                    $nestedKey = 'phonepay_pay';
                    $nestedName = str_replace('', 'phonepay_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                }elseif (strpos($name, 'midtrans_') === 0 && $request->is_authenticated == 1 && $settings['midtrans_payment_method'] == 1) {
                    $nestedKey = 'midtrans_pay';
                    $nestedName = str_replace('', 'midtrans_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;

                }elseif (strpos($name, 'sadad_') === 0 && $request->is_authenticated == 1 && $settings['sadad_payment_method'] == 1) {
                    $nestedKey = 'sadad_pay';
                    $nestedName = str_replace('', 'sadad_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                }elseif (strpos($name, 'cinet_') === 0 && $request->is_authenticated == 1 && $settings['cinet_payment_method'] == 1) {
                    $nestedKey = 'cinet_pay';
                    $nestedName = str_replace('', 'cinet_', $name);
                    if (! isset($response[$nestedKey])) {
                        $response[$nestedKey] = [];
                    }
                    $response[$nestedKey][$nestedName] = $value;
                }
                if (! strpos($name, 'customer_app_') === 0) {
                    $response[$name] = $value;
                }  elseif (! strpos($name, 'stripe_') === 0) {
                    $response[$name] = $value;
                } elseif (! strpos($name, 'razorpay_') === 0) {
                    $response[$name] = $value;
                } elseif (! strpos($name, 'paystack_') === 0) {
                    $response[$name] = $value;
                } elseif (! strpos($name, 'paypal_') === 0) {
                    $response[$name] = $value;
                } elseif (! strpos($name, 'flutterwave_') === 0) {
                    $response[$name] = $value;
                }elseif (! strpos($name, 'airtel_') === 0) {
                    $response[$name] = $value;
                }elseif (! strpos($name, 'phonepay_') === 0) {
                    $response[$name] = $value;
                }elseif (! strpos($name, 'midtrans_') === 0) {
                    $response[$name] = $value;
                }elseif (! strpos($name, 'sadad_') === 0) {
                    $response[$name] = $value;
                }elseif (! strpos($name, 'cinet_') === 0) {
                    $response[$name] = $value;
                }
            }
        }
        // Fetch currency data
        $currencies = Currency::all();

        $currencyData = null;
        if ($currencies->isNotEmpty()) {
            $currency = $currencies->first();
            $currencyData = [
                'currency_name' => $currency->currency_name,
                'currency_symbol' => $currency->currency_symbol,
                'currency_code' => $currency->currency_code,
                'currency_position' => $currency->currency_position,
                'no_of_decimal' => $currency->no_of_decimal,
                'thousand_separator' => $currency->thousand_separator,
                'decimal_separator' => $currency->decimal_separator,
            ];
        }

        $requiredSettings = ['isForceUpdateforAndroid', 'android_minimum_force_update_code', 'android_latest_version_update_code'];

           foreach ($requiredSettings as $setting) {
               if (isset($settings[$setting])) {
                   $response[$setting] = intval($settings[$setting]);
               } else {
                   $response[$setting] = 0;
               }
           }

           $requiredSettings = ['isForceUpdateforIos', 'iso_minimum_force_update_code', 'iso_latest_version_update_code'];

           foreach ($requiredSettings as $setting) {
               if (isset($settings[$setting])) {
                   $response[$setting] = intval($settings[$setting]);
               } else {
                   $response[$setting] = 0;
               }
           } 

        $response['currency'] = $currencyData;
        $response['site_description'] = $settings['site_description'] ?? null;
        $response['is_user_push_notification'] = isset($settings['is_user_push_notification']) ? intval($settings['is_user_push_notification']) : 0;
        $response['test_without_key'] = isset($settings['test_without_key']) ? intval($settings['test_without_key']) : 0;
        $response['enable_chat_gpt'] = isset($settings['enable_chat_gpt']) ? intval($settings['enable_chat_gpt']) : 0;
        $response['chatgpt_key'] = $response['enable_chat_gpt'] === 0 ? null : ($settings['chatgpt_key'] ?? null);


        $response['enable_ads'] = isset($settings['enable_ads']) ? intval($settings['enable_ads']) : 0;
        $response['interstitial_ad_id'] = $settings['interstitial_ad_id'] ?? null;
        $response['native_ad_id'] = $settings['native_ad_id'] ?? null;
        $response['banner_ad_id'] = $settings['banner_ad_id'] ?? null;
        $response['open_ad_id'] = $settings['open_ad_id'] ?? null;
        $response['rewarded_ad_id'] = $settings['rewarded_ad_id'] ?? null;
        $response['rewardinterstitial_ad_id'] = $settings['rewardinterstitial_ad_id'] ?? null;

        $response['enable_ios_ads'] = isset($settings['enable_ios_ads']) ? intval($settings['enable_ios_ads']) : 0;
        $response['ios_interstitial_ad_id'] = $settings['ios_interstitial_ad_id'] ?? null;
        $response['ios_native_ad_id'] = $settings['ios_native_ad_id'] ?? null;
        $response['ios_bnr_ad_id'] = $settings['ios_bnr_ad_id'] ?? null;
        $response['ios_open_ad_id'] = $settings['ios_open_ad_id'] ?? null;
        $response['ios_rewarded_ad_id'] = $settings['ios_rewarded_ad_id'] ?? null;
        $response['ios_rewardinterstitial_ad_id'] = $settings['ios_rewardinterstitial_ad_id'] ?? null;

        $response['enable_picsart'] = isset($settings['enable_picsart']) ? intval($settings['enable_picsart']) : 0;
        $response['picsart_key'] = $settings['picsart_key'] ?? null;
        $response['enable_cutoutpro'] = isset($settings['enable_cutoutpro']) ? intval($settings['enable_cutoutpro']) : 0;
        $response['cutoutpro_key'] = $settings['cutoutpro_key'] ?? null;
        $response['is_in_app_purchase_enable'] = isset($settings['is_in_app_purchase_enable']) ? intval($settings['is_in_app_purchase_enable']) : 0;
        $response['entitlement_id'] = $settings['entitlement_id'] ?? null;
        $response['google_public_api_key'] = $settings['google_public_api_key'] ?? null;
        $response['apple_public_api_key'] = $settings['apple_public_api_key'] ?? null;
        $response['enable_gemini'] = isset($settings['enable_gemini']) ? intval($settings['enable_gemini']) : 0;
        $response['gemini_key'] = $settings['gemini_key'] ?? null;
        $response['daily_limit'] = intval($settings['daily_limit']) ?? 5;

        $response['notification'] = isset($settings['notification']) ? $settings['notification'] : Null;
        $response['firebase_key'] = $settings['firebase_key'] ?? null;

        $response['in_app_purchase'] = isset($settings['in_app_purchase']) ? intval($settings['in_app_purchase']) : 0;

        $response['application_language'] = app()->getLocale();
        $response['status'] = true;

        return response()->json($response);
    }
}
