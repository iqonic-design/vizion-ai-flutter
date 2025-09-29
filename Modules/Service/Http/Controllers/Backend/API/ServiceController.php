<?php

namespace Modules\Service\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Category\Models\Category;
use Modules\Service\Models\Service;
use Modules\Service\Models\ServiceGallery;
use Modules\Service\Transformers\ServiceResource;


class ServiceController extends Controller
{  


    public function serviceList(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $service =  Service::where('status',1)->with(['category']);
      
        if ($request->has('category_id') && $request->category_id != '') {
            $service = $service->Where('category_id', $request->category_id);
        }
        if ($request->has('type') && $request->type != '') {
            $type = $request->type;

              $service = $service->Where('type', $request->type);
            
         }
   
        if ($request->has('search')) {
            $searchTerm = $request->search; 
            $service = $service->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%")
                ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                    $categoryQuery->where('name', 'like', "%{$searchTerm}%");
                });

            });
        }

        $service = $service->orderBy('updated_at', 'desc');

        $service = $service->paginate($perPage);
        $responseData = ServiceResource::collection($service);

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('service.service_list'),
        ], 200);
    }


    public function searchServices(Request $request)
    {
        $searchQuery = $request->query('query');

        if (! $searchQuery) {
            return response()->json(['message' => __('service.service_search')], 400);
        }

        $services = Service::where(function ($query) use ($searchQuery) {
            $query->where('name', 'like', '%'.$searchQuery.'%')
                ->orWhere('description', 'like', '%'.$searchQuery.'%')
                ->orWhere('category', 'like', '%'.$searchQuery.'%');
        })->get();

        return response()->json($services);
    }
}
