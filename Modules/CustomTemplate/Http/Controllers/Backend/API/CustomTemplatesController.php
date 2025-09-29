<?php

namespace Modules\CustomTemplate\Http\Controllers\Backend\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CustomTemplate\Models\CustomTemplate;
use Modules\CustomTemplate\Models\WishListTemplates;
use Modules\CustomTemplate\Transformers\CustomTemplateResource;
use Modules\CustomTemplate\Transformers\WishListResource;

class CustomTemplatesController extends Controller
{
    

    public function CustomTemplateList(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $customtemplates =  CustomTemplate::where('status',1)->with(['category','package']);
      
        if($request->has('category_id') && $request->category_id != '') {
            $customtemplates = $customtemplates->Where('category_id', $request->category_id);
        }
       
        if ($request->has('search')) {
            $searchTerm = $request->search; 
            $customtemplates = $customtemplates->where(function ($query) use ($searchTerm) {
                $query->where('template_name', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%")
                ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                    $categoryQuery->where('name', 'like', "%{$searchTerm}%");
                });

            });
        }

        $customtemplates = $customtemplates->orderBy('updated_at', 'desc');

        $customtemplates = $customtemplates->paginate($perPage);
        $responseData = CustomTemplateResource::collection($customtemplates);

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('customtemplate.custom_template_list'),
        ], 200);
    }

    public function addWishListTemplate(Request $request){

         $data=$request->all();

         WishListTemplates::create($data);
         
         $message = __('customtemplate.added_wishlist');

         return response()->json(['message' => $message, 'status' => true], 200);

    }

    public function WishListTemplateList(Request $request){

        $perPage = $request->input('per_page', 10);
        $user_id=$request->user_id;


        $wishlist_templates =  WishListTemplates::where('user_id',$user_id);

        $wishlist_templates = $wishlist_templates->paginate($perPage);

        $responseData = WishListResource::collection($wishlist_templates);

        return response()->json([
            'status' => true,
            'data' =>  $responseData ,
            'message' => __('customtemplate.wishlist_template_list'),
        ], 200);

    }

    public function removeWishListTemplates($id)
    {
        
        $data = WishListTemplates::where('template_id',$id)->first();

        if($data){

            $data->delete();
    
            $message = __('customtemplate.wishlist_delete');
    
           return response()->json(['message' => $message, 'status' => true], 200);


        }else{

            $message = __('customtemplate.wishlist_not_found');
    
            return response()->json(['message' => $message, 'status' => false],200);
        }

     
    }

    
}
