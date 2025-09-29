<?php

namespace App\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistroyImageMapping;
use App\Models\History;
use App\Models\Setting;
use App\Http\Resources\HistoryResource;
use App\Models\ChatHistory;
use App\Models\ChatHistoryMapping;
use App\Models\ChatHistoryImage;
use App\Models\IPAddress;
use App\Http\Resources\RecentChatResource;
use App\Http\Resources\ChatMessageResource;
use Illuminate\Support\Carbon;
use App\Models\Report;
class HistoryController extends Controller
{
    public function saveHistory(Request $request){

        $data = $request->except('history_image');

        $user = auth()->user();

        $auth_user=$user->where('id',$user->id)->with('subscriptionPackage')->first();

        $identifier = isset($auth_user->subscriptionPackage['identifier']) ? $auth_user->subscriptionPackage['identifier'] : null;


        //  if($data['type'] !== 'ai_chat'){

            if (request()->headers->has('ipaddress')) {

                $ip_address = request()->header('ipaddress');

                try {
                    IPAddress::create(['ip_address' => $ip_address, 'created_at' => Carbon::now()]);
                } catch (\Exception $e) {
                    // Log or display the exception message for debugging
                    dd($e->getMessage());
                }

            }

        //  }

        $data['history_data']=json_encode($data['history_data']);

        $history_data= History::create($data);

        $histroy_image=$request->file('history_image');

        if($request->hasFile('history_image')) {

            foreach ($histroy_image as $key => $value) {

                $histroyImage = HistroyImageMapping::create([
                    'history_id' => $history_data->id,
                ]);

                $histroyImage->addMedia($value)->toMediaCollection('histroy_image');
                $histroyImage->image_url = $histroyImage->getFirstMediaUrl('histroy_image');
                $histroyImage->save();
             }
         }

        return response()->json(['message' => __('messages.save_history'), 'status' => true]);

    }

    public function  getUserHistory(Request $request){

       $user_id = $request->has('user_id') && $request->user_id !== null ? $request->user_id : auth()->id();

       $perPage = $request->input('per_page', 6);

       $history_data=History::where('user_id',$user_id)->with('historyimage','templatedata','SystemService');

       if($request->has('type') && $request->type !=''){

         $history_data=$history_data->where('type',$request->type);

       }

       if($request->has('template_id') && $request->template_id !=null){

        $history_data=$history_data->where('template_id',$request->template_id);

       }

       $history_data= $history_data->orderByDesc('created_at')->paginate($perPage);

       $historyDataCollection = HistoryResource::collection($history_data);

       return response()->json([
           'status' => true,
           'data' => $historyDataCollection,
           'message' => __('messages.histroy_list'),
       ], 200);


    }

    public function clearUserHistory(Request $request){

        $user_id = $request->has('user_id') && $request->user_id !== null ? $request->user_id : auth()->id();

        if($request->has('histroy_id') && $request->histroy_id !=''){

            History::where('id',$request->histroy_id)->forceDelete();

            HistroyImageMapping::where('history_id',$request->histroy_id)->forceDelete();

        }

        if($request->has('template_id') && $request->template_id !=null){

          $histroy_id= History::where('user_id',$user_id)->where('template_id',$request->template_id)->pluck('id')->toArray();

          History::whereIn('id',$histroy_id)->forceDelete();

          HistroyImageMapping::whereIn('history_id',$histroy_id)->forceDelete();

        }

        if($request->has('type') && $request->type =='all'){

            $histroy_id= History::where('user_id',$user_id)->pluck('id')->toArray();

            History::whereIn('id',$histroy_id)->forceDelete();

            HistroyImageMapping::whereIn('history_id',$histroy_id)->forceDelete();

          }



        if($request->has('service') && $request->service !=''){

            $histroy_id= History::where('user_id',$user_id)->where('type', $request->service)->pluck('id')->toArray();

            History::whereIn('id',$histroy_id)->forceDelete();

            HistroyImageMapping::whereIn('history_id',$histroy_id)->forceDelete();

          }

        return response()->json(['message' => __('messages.delete_histroy'), 'status' => true]);

     }

     public function  saveRecentChat(Request $request){

         $data=$request->all();

         $recent_chat=ChatHistory::create($data);

         return response()->json([
            'status' => true,
            'data' => [$recent_chat],
            'message' => __('message.save_chat'),
        ], 200);


     }

     public function saveMessage(Request $request){

        $data=$request->all();

        ChatHistoryMapping::create($data);

        return response()->json(['message' => __('message.save_message'), 'status' => true]);

    }

    public function recentChatList(Request $request){

        $perPage = $request->input('per_page', 6);

        $user_id = $request->has('user_id') && $request->user_id !== null ? $request->user_id : auth()->id();

        $chathistory=ChatHistory::where('user_id',$user_id);

        $chathistory= $chathistory->orderByDesc('id')->paginate($perPage);

        $chathistoryCollection = RecentChatResource::collection($chathistory);

        return response()->json([
            'status' => true,
            'data' => $chathistoryCollection,
            'message' => __('message.recent_chat_list'),
        ], 200);


    }

    public function messageList(Request $request){

        $perPage = $request->input('per_page', 6);


        if($request->has('chat_id') && $request->chat_id !=''){

            $chat_id=$request->chat_id;

        }

        $messagelist=ChatHistoryMapping::where('chat_id',$chat_id);

        $messagelist= $messagelist->orderByDesc('id')->paginate($perPage);


        $chatmessageCollection = ChatMessageResource::collection($messagelist);

        return response()->json([
            'status' => true,
            'data' => $chatmessageCollection,
            'message' => __('message.chat'),
        ], 200);

    }

     public function uploadImage(Request $request)
    {
        $user_id = $request->has('user_id') && $request->user_id !== null ? $request->user_id : auth()->id();


        if ($request->hasFile('upload_image') &&  $request->file('upload_image') !=null ) {

            $uploadImages = [];
            foreach ($request->file('upload_image') as $file) {
                $uploadImage = ChatHistoryImage::create(['user_id' => $user_id]);
                $media = $uploadImage->addMedia($file)->toMediaCollection('upload_image');
                $uploadImages[] = $media->getUrl();
            }

            return response()->json([
                'status' => true,
                'upload_image' => $uploadImages,
                'message' => __('messages.upload_image_list'),
            ], 200);

        }



    }

    public function  EditRecentChat(Request $request){

        if($request->has('chat_id') && $request->chat_id !=''){

            $data=$request->all();

            $chathistroy=ChatHistory::where('id',$request->chat_id)->first();

            if($chathistroy){

                $chathistroy->update($data);

                return response()->json([
                    'status' => true,
                    'data' => [$chathistroy],
                    'message' => __('message.save_chat'),
                ], 200);

             }else{

                return response()->json(['message' => __('message.chat_not_found'), 'status' => false]);

             }


        }




    }

    public function  DeleteRecentChat(Request $request){

        if($request->has('chat_id') && $request->chat_id !=''){

          ChatHistory::where('id', $request->chat_id)->forceDelete();

        }

        return response()->json(['message' => __('message.chat_delete'), 'status' => true]);
    }





    public function  StoreReport(Request $request){

        $data=$request->all();

        Report::create($data);

        return response()->json(['message' => __('message.store_report_or_flag'), 'status' => true]);
    }


}



