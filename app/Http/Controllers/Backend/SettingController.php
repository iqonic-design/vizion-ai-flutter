<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Google\Client as Google_Client;
use Illuminate\Support\Facades\Log;
class SettingController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'settings.title';

        // module name
        $this->module_name = 'settings';

        // module icon
        $this->module_icon = 'fas fa-cogs';

        $this->global_booking = false;

        view()->share([
            'module_title' => $this->module_title,
            'module_name' => $this->module_name,
            'module_icon' => $this->module_icon,
            'global_booking' => $this->global_booking,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $module_action = 'List';

        return view('backend.settings.index', compact('module_action'));
    }

    public function index_data(Request $request)
    {
        
        if (!isset($request->fields)) {
            return ;
        }


        $fields = explode(',', $request->fields);

        $data = Setting::whereIn('name', $fields)->get();

        $newData = [];

        foreach ($fields as $field) {
            $newData[$field] = setting($field);
            if (in_array($field, ['logo', 'mini_logo', 'mini_logo', 'dark_logo', 'dark_mini_logo', 'favicon'])) {
                $newData[$field] = asset(setting($field));
            }
        }

        return response()->json($newData, 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->has('json_file') && $request->json_file !=null) {
            $file = $request->file('json_file');
            $fileName = $file->getClientOriginalName();
            $directoryPath = storage_path('app/data');

            if (!File::isDirectory($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            $files = File::files($directoryPath);

            foreach ($files as $existingFile) {
                $filePath = $existingFile->getPathname();
                if (strtolower($existingFile->getExtension()) === 'json') {
                    File::delete($filePath);
                }
            }

            
            $file->move($directoryPath, $fileName);
        }

        unset($data['json_file']);
        if ($request->wantsJson()) {
            $rules = Setting::getSelectedValidationRules(array_keys($data));
        } else {
            $rules = Setting::getValidationRules();
        }


        $data = $this->validate($request, $rules);

        $validSettings = array_keys($rules);

        foreach ($data as $key => $val) {
            if (in_array($key, $validSettings)) {
                $mimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/vnd.microsoft.icon'];

                if (gettype($val) == 'object') {
                    if ($val->getType() == 'file' && in_array($val->getMimeType(), $mimeTypes)) {
                        $setting = Setting::add($key, '', Setting::getDataType($key));
                        $mediaItems = $setting->addMedia($val)->toMediaCollection($key);
                        $setting->update(['val' => $mediaItems->getUrl()]);
                    }
                } else {
                    $setting = Setting::add($key, $val, Setting::getDataType($key));
                }
            }
        }


        if ($request->wantsJson()) {
            $message = __('settings.save_setting');
            return response()->json(['message' => $message, 'status' => true], 200);
        } else {
            return redirect()->back()->with('status', __('messages.setting_save'));
        }
    }

    public function clear_cache()
    {

        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('config:cache');

        $message = __('messages.cache_cleard');

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function reload_database()
    {

        \Illuminate\Support\Facades\Artisan::call('config:clear');

        \Illuminate\Support\Facades\Artisan::call('config:cache');
        set_time_limit(100);
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh --seed');




        $message = __('messages.reload_database');

        return response()->json(['message' => $message, 'status' => true], 200);
    }


    public function verify_email(Request $request)
    {
        $mailObject = $request->all();
        try {
            \Config::set('mail', $mailObject);
            Mail::raw('This is a smtp mail varification test mail!', function ($message) use ($mailObject) {
                $message->to($mailObject['email'])->subject('Test Email');
            });
            return response()->json(['message' => 'Verification Successful', 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Verification Failed', 'status' => false], 500);
        }
    }

    public function get_service_price(Request $request)
    {

        $data = Setting::where('name', $request->type)->first();

        return response()->json(['data' => $data, 'status' => true]);
    }
    public function import_data()
    {

        Artisan::call('migrate:fresh --seed');

        $message = __('messages.import_data');

        return response()->json(['message' => $message, 'status' => true], 200);
    }


    public function sendPushNotification(Request $request)
    {
        $data = $request->all();

        $heading      = array(
            "en" => $data['title']
        );
        $content      = array(
            "en" => $data['description']
        );

        $othersetting = Setting::where('name', 'notification')->first();
        $firebaseprojectID = Setting::where('name', 'firebase_project_id')->first();


        $notification_type = isset($othersetting) ? 1 : 0;

        if ($notification_type == 1) {

            $projectID = isset($firebaseprojectID->val) ? $firebaseprojectID->val : null;

            $apiUrl = 'https://fcm.googleapis.com/v1/projects/' . $projectID . '/messages:send';

            $access_token = getAccessToken();
            $headers = [
                'Authorization: Bearer ' . $access_token,
                'Content-Type: application/json',
            ];


            $firebase_data = [                
                "message" => [
                    "topic" => 'userApp',
                    'notification' => [
                        'title' => $heading['en'],
                        'body' => $content['en'],
                    ],
                    "data" => [
                        "sound" => "default",
                        "story_id" => "story_12345",

                        "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                    ],
                    "android" => [
                        "priority" => "high",
                        "notification" => [
                            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
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
            ];

            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($firebase_data));

            $response = curl_exec($ch);
            Log::info($response);
            curl_close($ch);
        }

        if ($response) {
            $message = trans('messages.update_form', ['form' => trans('messages.pushnotification_settings')]);
        } else {
            $message = trans('messages.failed');
        }
        // if (request()->is('api/*')) {
        //     return comman_message_response($message);
        // }
        return response()->json(['message' => $message, 'status' => true], 200);
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
}
