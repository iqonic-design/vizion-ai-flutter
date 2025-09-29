<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Google\Client as Google_Client;

function DefaultNotification()
{

    $setting_data = \App\Models\Setting::where('name', 'notification')->first();

    return $setting_data->val;
}

function mail_footer($type,$notify_message)
{
    return [
        'notification_type' => $type,
        'notification_message' => $notify_message,
        'logged_in_user_fullname' => auth()->user() ? auth()->user()->full_name ?? default_user_name() : '',
        'logged_in_user_role' => auth()->user() ? auth()->user()->getRoleNames()->first()->name ?? '-' : '',
        'company_name' => setting('app_name'),
        'company_contact_info' => implode('', [
            setting('helpline_number') . PHP_EOL,
            setting('inquriy_email'),
        ]),
    ];
}
function sendNotification($data)
{

    $mailable = \Modules\NotificationTemplate\Models\NotificationTemplate::where('type', $data['notification_type'])->with('defaultNotificationTemplateMap')->first();

    if ($mailable != null && $mailable->to != null) {
        $mails = json_decode($mailable->to);



        foreach ($mails as $key => $mailTo) {

            $data['type'] = $data['notification_type'];


            $subscription = isset($data['subscription']) ? $data['subscription'] : null;
            $rechargeReminder = isset($data['recharge']) ? $data['recharge'] : null;

            if (isset($subscription) && $subscription != null) {

                $data['id'] =  $subscription['id'];
                $data['user_id'] =  $subscription['user_id'];
                $data['plan_id'] =  $subscription['plan_id'];
                $data['name'] =  $subscription['name'];
                $data['identifier'] =  $subscription['identifier'];
                $data['type'] =  $subscription['type'];
                $data['status'] =  $subscription['status'];
                $data['amount'] =  $subscription['amount'];
                $data['plan_type'] =  $subscription['plan_type'];
                $data['username'] =  $subscription['user']->full_name;
                $data['notification_group'] = 'subscription';
                $data['site_url'] = env('APP_URL');


                unset($data['subscription']);
            } else if ($rechargeReminder) {

                $data['notification_group'] = 'recharge_reminder';
                $data['service_name'] =  $rechargeReminder['service_name'];
                $data['site_url'] = env('APP_URL');

                unset($data['recharge']);
            }

            switch ($mailTo) {

                case 'admin':

                    $admin = \App\Models\User::role('admin')->first();
                    $data['user_name'] = $admin->first_name . ' ' . $admin->last_name;

                    if (isset($admin->email)) {
                        try {
                            $admin->notify(new \App\Notifications\CommonNotification($data['notification_type'], $data));
                        } catch (\Exception $e) {
                            Log::error($e);
                        }
                    }

                    break;

                case 'demo_admin':

                    $demo_admin = \App\Models\User::role('demo_admin')->first();
                    $data['user_name'] = $demo_admin->first_name . ' ' . $demo_admin->last_name;

                    if (isset($demo_admin->email)) {
                        try {
                            $demo_admin->notify(new \App\Notifications\CommonNotification($data['notification_type'], $data));
                        } catch (\Exception $e) {
                            Log::error($e);
                        }
                    }

                    break;

                case 'user':
                    if (isset($data['user_id'])) {
                        $user = \App\Models\User::find($data['user_id']);
                        try {
                            $user->notify(new \App\Notifications\CommonNotification($data['notification_type'], $data));
                        } catch (\Exception $e) {
                            Log::error($e);
                        }
                    }
                    break;
            }
        }
    }
}
function timeAgoInt($date)
{
    if ($date == null) {
        return '-';
    }
    $datetime = new \DateTime($date);
    $datetime->setTimezone(new \DateTimeZone(setting('time_zone') ?? 'UTC'));
    $diff_time = \Carbon\Carbon::parse($datetime)->diffInHours();

    return $diff_time;
}
function timeAgo($date)
{
    if ($date == null) {
        return '-';
    }
    $datetime = new \DateTime($date);
    $datetime->setTimezone(new \DateTimeZone(setting('time_zone') ?? 'UTC'));
    $diff_time = \Carbon\Carbon::parse($datetime)->diffForHumans();

    return $diff_time;
}
function dateAgo($date, $type2 = '')
{
    if ($date == null || $date == '0000-00-00 00:00:00') {
        return '-';
    }
    $diff_time1 = \Carbon\Carbon::createFromTimeStamp(strtotime($date))->diffForHumans();
    $datetime = new \DateTime($date);
    $datetime->setTimezone(new \DateTimeZone(setting('time_zone') ?? 'UTC'));
    $diff_time = \Carbon\Carbon::parse($datetime->format('Y-m-d H:i:s'))->isoFormat('LLL');
    if ($type2 != '') {
        return $diff_time;
    }

    return $diff_time1 . ' on ' . $diff_time;
}

function customDate($date, $format = 'd-m-Y h:i A')
{
    if ($date == null || $date == '0000-00-00 00:00:00') {
        return '-';
    }
    $datetime = new \DateTime($date);
    // $la_time = new \DateTimeZone(\Auth::check() ? \Auth::user()->time_zone ?? 'UTC' : 'UTC');
    $la_time = new \DateTimeZone(setting('time_zone') ?? 'UTC');
    $datetime->setTimezone($la_time);
    $newDate = $datetime->format('Y-m-d H:i:s');
    $diff_time = \Carbon\Carbon::createFromTimeStamp(strtotime($newDate))->format($format);

    return $diff_time;
}

function saveDate($date)
{
    if ($date == null || $date == '0000-00-00 00:00:00') {
        return null;
    }
    $datetime = new \DateTime($date);
    // $la_time = new \DateTimeZone(\Auth::check() ? \Auth::user()->time_zone ?? 'UTC' : 'UTC');
    $la_time = new \DateTimeZone(setting('time_zone') ?? 'UTC');
    $datetime->setTimezone($la_time);
    $newDate = $datetime->format('Y-m-d H:i:s');
    $diff_time = \Carbon\Carbon::createFromTimeStamp(strtotime($newDate));

    return $diff_time;
}
function strtotimeToDate($date)
{
    if ($date == null || $date == '0000-00-00 00:00:00') {
        return '-';
    }
    $datetime = new \DateTime($date);
    $datetime->setTimezone(new \DateTimeZone(setting('time_zone') ?? 'UTC'));
    $diff_time = \Carbon\Carbon::createFromTimeStamp($datetime);

    return $diff_time;
}
function formatOffset($offset)
{
    $hours = $offset / 3600;
    $remainder = $offset % 3600;
    $sign = $hours > 0 ? '+' : '-';
    $hour = (int) abs($hours);
    $minutes = (int) abs($remainder / 60);

    if ($hour == 0 and $minutes == 0) {
        $sign = ' ';
    }

    return 'GMT' . $sign . str_pad($hour, 2, '0', STR_PAD_LEFT)
        . ':' . str_pad($minutes, 2, '0');
}

function timeZoneList()
{
    $list = \DateTimeZone::listAbbreviations();
    $idents = \DateTimeZone::listIdentifiers();

    $data = $offset = $added = [];
    foreach ($list as $abbr => $info) {
        foreach ($info as $zone) {
            if (!empty($zone['timezone_id']) and !in_array($zone['timezone_id'], $added) and in_array($zone['timezone_id'], $idents)) {

                $z = new \DateTimeZone($zone['timezone_id']);
                $c = new \DateTime(null, $z);
                $zone['time'] = $c->format('H:i a');
                $offset[] = $zone['offset'] = $z->getOffset($c);
                $data[] = $zone;
                $added[] = $zone['timezone_id'];
            }
        }
    }

    array_multisort($offset, SORT_ASC, $data);
    $options = [];
    foreach ($data as $key => $row) {

        $options[$row['timezone_id']] = $row['time'] . ' - ' . formatOffset($row['offset']) . ' ' . $row['timezone_id'];
    }

    return $options;
}

/*
 * Global helpers file with misc functions.
 */
if (!function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return setting('app_name') ?? config('app.name');
    }
}
/**
 * Avatar Find By Gender
 */
if (!function_exists('default_user_avatar')) {
    function default_user_avatar()
    {
        return asset(config('app.avatar_base_path') . 'avatar.png');
    }
    function default_user_name()
    {
        return __('messages.unknown_user');
    }
}
if (!function_exists('user_avatar')) {
    function user_avatar()
    {
        if (auth()->user()->profile_image ?? null) {
            return auth()->user()->profile_image;
        } else {
            return asset(config('app.avatar_base_path') . 'avatar.png');
        }
    }
}

if (!function_exists('default_feature_image')) {
    function default_feature_image()
    {
        return asset(config('app.image_path') . 'default.png');
    }
}

/*
 * Global helpers file with misc functions.
 */
if (!function_exists('user_registration')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function user_registration()
    {
        $user_registration = false;

        if (env('USER_REGISTRATION') == 'true') {
            $user_registration = true;
        }

        return $user_registration;
    }
}

/**
 * Global Json DD
 * !USAGE
 * return jdd($id);
 */
if (!function_exists('jdd')) {
    function jdd($data)
    {
        return response()->json($data, 500);
        exit();
    }
}

/*
 *
 * label_case
 *
 * ------------------------------------------------------------------------
 */
if (!function_exists('label_case')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function label_case($text)
    {
        $order = ['_', '-'];
        $replace = ' ';

        $new_text = trim(\Illuminate\Support\Str::title(str_replace('"', '', $text)));
        $new_text = trim(\Illuminate\Support\Str::title(str_replace($order, $replace, $text)));
        $new_text = preg_replace('!\s+!', ' ', $new_text);

        return $new_text;
    }
}

/*
 *
 * show_column_value
 *
 * ------------------------------------------------------------------------
 */
if (!function_exists('show_column_value')) {
    /**
     * Return Column values as Raw and formatted.
     *
     * @param  string  $valueObject  Model Object
     * @param  string  $column  Column Name
     * @param  string  $return_format  Return Type
     * @return string Raw/Formatted Column Value
     */
    function show_column_value($valueObject, $column, $return_format = '')
    {
        $column_name = $column->Field;
        $column_type = $column->Type;

        $value = $valueObject->$column_name;

        if ($return_format == 'raw') {
            return $value;
        }

        if (($column_type == 'date') && $value != '') {
            $datetime = \Carbon\Carbon::parse($value);

            return $datetime->isoFormat('LL');
        } elseif (($column_type == 'datetime' || $column_type == 'timestamp') && $value != '') {
            $datetime = \Carbon\Carbon::parse($value);

            return $datetime->isoFormat('LLLL');
        } elseif ($column_type == 'json') {
            $return_text = json_encode($value);
        } elseif ($column_type != 'json' && \Illuminate\Support\Str::endsWith(strtolower($value), ['png', 'jpg', 'jpeg', 'gif', 'svg'])) {
            $img_path = asset($value);

            $return_text = '<figure class="figure">
                                <a href="' . $img_path . '" data-lightbox="image-set" data-title="Path: ' . $value . '">
                                    <img src="' . $img_path . '" style="max-width:200px;" class="figure-img img-fluid rounded img-thumbnail" alt="">
                                </a>
                                <figcaption class="figure-caption">Path: ' . $value . '</figcaption>
                            </figure>';
        } else {
            $return_text = $value;
        }

        return $return_text;
    }
}

/*
 *
 * fielf_required
 * Show a * if field is required
 *
 * ------------------------------------------------------------------------
 */
if (!function_exists('fielf_required')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function fielf_required($required)
    {
        $return_text = '';

        if ($required != '') {
            $return_text = '<span class="text-danger">*</span>';
        }

        return $return_text;
    }
}

/*
 * Get or Set the Settings Values
 *
 * @var [type]
 */
if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        if (is_null($key)) {
            return new App\Models\Setting();
        }

        if (is_array($key)) {
            return App\Models\Setting::set($key[0], $key[1]);
        }

        $value = App\Models\Setting::get($key);

        return is_null($value) ? value($default) : $value;
    }
}

/*
 * Show Human readable file size
 *
 * @var [type]
 */
if (!function_exists('humanFilesize')) {
    function humanFilesize($size, $precision = 2)
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $step = 1024;
        $i = 0;

        while (($size / $step) > 0.9) {
            $size = $size / $step;
            $i++;
        }

        return round($size, $precision) . $units[$i];
    }
}

/*
 *
 * Encode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (!function_exists('encode_id')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function encode_id($id)
    {
        $hashids = new Hashids\Hashids(config('app.salt'), 3, 'abcdefghijklmnopqrstuvwxyz1234567890');
        $hashid = $hashids->encode($id);

        return $hashid;
    }
}

/*
 *
 * Decode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (!function_exists('decode_id')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function decode_id($hashid)
    {
        $hashids = new Hashids\Hashids(config('app.salt'), 3, 'abcdefghijklmnopqrstuvwxyz1234567890');
        $id = $hashids->decode($hashid);

        if (count($id)) {
            return $id[0];
        } else {
            abort(404);
        }
    }
}

/*
 *
 * Prepare a Slug for a given string
 * Laravel default str_slug does not work for Unicode
 *
 * ------------------------------------------------------------------------
 */
if (!function_exists('slug_format')) {
    /**
     * Format a string to Slug.
     */
    function slug_format($string)
    {
        $base_string = $string;

        $string = preg_replace('/\s+/u', '-', trim($string));
        $string = str_replace('/', '-', $string);
        $string = str_replace('\\', '-', $string);
        $string = strtolower($string);

        $slug_string = $string;

        return $slug_string;
    }
}

/*
 *
 * icon
 * A short and easy way to show icon fornts
 * Default value will be check icon from FontAwesome
 *
 * ------------------------------------------------------------------------
 */
if (!function_exists('icon')) {
    /**
     * Format a string to Slug.
     */
    function icon($string = 'fas fa-check')
    {
        $return_string = "<i class='" . $string . "'></i>";

        return $return_string;
    }
}

/*
 *
 * Decode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (!function_exists('generate_rgb_code')) {
    /**
     * Prepare the Column Name for Lables.
     */
    function generate_rgb_code($opacity = '0.9')
    {
        $str = '';
        for ($i = 1; $i <= 3; $i++) {
            $num = mt_rand(0, 255);
            $str .= "$num,";
        }
        $str .= "$opacity,";
        $str = substr($str, 0, -1);

        return $str;
    }
}

/*
 *
 * Return Date with weekday
 *
 * ------------------------------------------------------------------------
 */
if (!function_exists('date_today')) {
    /**
     * Return Date with weekday.
     *
     * Carbon Locale will be considered here
     * Example:
     * Friday, July 24, 2020
     */
    function date_today()
    {
        $str = \Carbon\Carbon::now()->isoFormat('dddd, LL');

        return $str;
    }
}

if (!function_exists('language_direction')) {
    /**
     * return direction of languages.
     *
     * @return string
     */
    function language_direction($language = null)
    {
        if (empty($language)) {
            $language = app()->getLocale();
        }
        $language = strtolower(substr($language, 0, 2));
        $rtlLanguages = [
            'ar', //  'العربية', Arabic
            'arc', //  'ܐܪܡܝܐ', Aramaic
            'bcc', //  'بلوچی مکرانی', Southern Balochi
            'bqi', //  'بختياري', Bakthiari
            'ckb', //  'Soranî / کوردی', Sorani Kurdish
            'dv', //  'ދިވެހިބަސް', Dhivehi
            'fa', //  'فارسی', Persian
            'glk', //  'گیلکی', Gilaki
            'he', //  'עברית', Hebrew
            'lrc', //- 'لوری', Northern Luri
            'mzn', //  'مازِرونی', Mazanderani
            'pnb', //  'پنجابی', Western Punjabi
            'ps', //  'پښتو', Pashto
            'sd', //  'سنڌي', Sindhi
            'ug', //  'Uyghurche / ئۇيغۇرچە', Uyghur
            'ur', //  'اردو', Urdu
            'yi', //  'ייִדיש', Yiddish
        ];
        if (in_array($language, $rtlLanguages)) {
            return 'rtl';
        }

        return 'ltr';
    }
}

if (!function_exists('module_exist')) {
    /**
     * return value for module exist or not.
     *
     * @return bool
     */
    function module_exist($module_name)
    {
        return \Module::find($module_name)?->isEnabled() ?? false;
    }
}

function storeMediaFile($module, $file, $key = 'feature_image')
{
    if (isset($module) && isset($file)) {
        $module->clearMediaCollection($key);
        $mediaItems = $module->addMedia($file)->toMediaCollection($key);
    }

    if ($key == 'profile_image' && $file == '') {

        $module->clearMediaCollection($key);
    }
}
function getCustomizationSetting($name, $key = 'customization_json')
{

    $settingObject = setting($key);
    if (isset($settingObject) && $key == 'customization_json') {
        try {
            $settings = (array) json_decode(html_entity_decode(stripslashes($settingObject)))->setting;

            return collect($settings[$name])['value'];
        } catch (\Exception $e) {
            return '';
        }

        return '';
    } elseif ($key == 'root_color') {
        //
    }

    return '';
}
// Usage: getCustomizationSetting('app_name') it will return value of this json
// getCustomizationSetting('footer')
// getCustomizationSetting('menu_style)

function str_slug($title, $separator = '-', $language = 'en')
{
    return Str::slug($title, $separator, $language);
}

function formatCurrency($number, $noOfDecimal, $decimalSeparator, $thousandSeparator, $currencyPosition, $currencySymbol)
{
    // Convert the number to a string with the desired decimal places
    $formattedNumber = number_format($number, $noOfDecimal, '.', '');

    // Split the number into integer and decimal parts
    $parts = explode('.', $formattedNumber);
    $integerPart = $parts[0];
    $decimalPart = isset($parts[1]) ? $parts[1] : '';

    // Add thousand separators to the integer part
    $integerPart = number_format($integerPart, 0, '', $thousandSeparator);

    // Construct the final formatted currency string
    $currencyString = '';

    if ($currencyPosition == 'left' || $currencyPosition == 'left_with_space') {
        $currencyString .= $currencySymbol;
        if ($currencyPosition == 'left_with_space') {
            $currencyString .= ' ';
        }
        $currencyString .= $integerPart;
        // Add decimal part and decimal separator if applicable
        if ($noOfDecimal > 0) {
            $currencyString .= $decimalSeparator . $decimalPart;
        }
    }

    if ($currencyPosition == 'right' || $currencyPosition == 'right_with_space') {
        // Add decimal part and decimal separator if applicable
        if ($noOfDecimal > 0) {
            $currencyString .= $integerPart . $decimalSeparator . $decimalPart;
        }
        if ($currencyPosition == 'right_with_space') {
            $currencyString .= ' ';
        }
        $currencyString .= $currencySymbol;
    }

    return $currencyString;
}

function fcm($fields)
{
    $otherSetting = \App\Models\Setting::where('type', 'notification')->where('name','firebase_project_id')->first();
    $projectID = $otherSetting->val ?? null;
    $access_token = getAccessToken();
    $headers = [
        'Authorization: Bearer ' . $access_token,
        'Content-Type: application/json',
    ];
    $ch = curl_init('https://fcm.googleapis.com/v1/projects/' . $projectID . '/messages:send');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    $response = curl_exec($ch);
    Log::info($response);
    curl_close($ch);
}

function getAccessToken()
{
    $directory = storage_path('app/data');
    $credentialsFiles = File::glob($directory . '/*.json');
    if (empty($credentialsFiles)) {
        throw new Exception('No JSON credentials found in the specified directory.');
    } 
    $client = new Google_Client();
    $client->setAuthConfig($credentialsFiles[0]);
    $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

    $token = $client->fetchAccessTokenWithAssertion();

    return $token['access_token'];
}

function timeAgoFormate($date)
{
    if ($date == null) {
        return '-';
    }

    // date_default_timezone_set('UTC');

    $diff_time = \Carbon\Carbon::createFromTimeStamp(strtotime($date))->diffForHumans();

    return $diff_time;
}

function formatTime($time)
{
    // Create a new Carbon instance from the provided time string
    $parsedTime = Carbon::parse($time);

    // Get the hours and minutes from the Carbon instance
    $hours = $parsedTime->format('H');
    $minutes = $parsedTime->format('i');

    // Initialize an empty array to store the parts of the formatted string
    $formattedParts = [];

    // Format hours
    if ($hours > 0) {
        $formattedParts[] = $hours . ' ' . ($hours == 1 ? 'hour' : 'hours');
    }

    // Format minutes
    if ($minutes > 0) {
        $formattedParts[] = $minutes . ' ' . ($minutes == 1 ? 'minute' : 'minutes');
    }

    // Combine the formatted parts into a single string
    $formattedTime = implode(' ', $formattedParts);

    return $formattedTime;
}




function  checkTemplateInWishList($template_id, $user_id)
{

    $templateExists = Modules\CustomTemplate\Models\WishListTemplates::where('template_id', $template_id)->where('user_id', $user_id)->exists();

    return $templateExists ? 1 : 0;
}



function countUnitvalue($unit)
{
    switch ($unit) {
        case 'mile':
            return 3956;
            break;
        default:
            return 6371;
            break;
    }
}


if (!function_exists('formatCount')) {
    function formatCount($total_count)
    {
        if ($total_count >= 1000000) {
            $formatted_count = round($total_count / 1000000, 1) . 'M';
        } elseif ($total_count >= 1000) {
            $formatted_count = round($total_count / 1000, 1) . 'K';
        } else {
            $formatted_count = $total_count;
        }

        return $formatted_count;
    }
}

function SendPushNotification($data)
{

    $heading = array(
        "en" => $data['title']
    );

    $content = array(
        "en" => $data['description']
    );

    $user_id = $data['user_id'];

    return fcm([
        "message" => [
            "topic" => 'user_'.$user_id,
            "notification" => [
                "title" => $heading,
                "body" => $content,
            ],
            "data" => [
                "sound"=>"default",
                "story_id" => "story_12345",                
                "click_action"=> "FLUTTER_NOTIFICATION_CLICK",
            ],
            "android" => [
                "priority" => "high",
                "notification" => [
                    "click_action"=> "FLUTTER_NOTIFICATION_CLICK",
                ],
            ],
            "apns" => [
                "payload" => [
                    "aps" => [
                        "category" => "NEW_MESSAGE_CATEGORY",
                    ],
                ],
            ],
        ],

    ]);
}



if (!function_exists('isActive')) {
    /**
     * Returns 'active' or 'done' class based on the current step.
     *
     * @param  string|array  $route
     * @param  string  $className
     * @return string
     */
    function isActive($route, $className = 'active') {
        $currentRoute = Route::currentRouteName();

        if (is_array($route)) {
            return in_array($currentRoute, $route) ? $className : '';
        }

        return $currentRoute == $route ? $className : '';
    }
}

function dbConnectionStatus(): bool
{
    try {
        DB::connection()->getPdo();
    return true;
    } catch (Exception $e) {
        return false;
    }
}

