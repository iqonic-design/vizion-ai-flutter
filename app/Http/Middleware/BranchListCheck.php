<?php

namespace App\Http\Middleware;

use App\Models\Branch;
use Closure;
use Illuminate\Http\Request;
use Auth;

class BranchListCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
         
            $auth = auth()->user();

            if (auth()->user()->hasRole('admin')) {
                if (str_contains($request->route()->getName(), 'backend.bookings')
                      && $request->route()->getName() !== 'backend.bookings.index_data'
                      && $request->route()->getName() !== 'backend.bookings.datatable_view'
            );
            }

            $data = [
              
                'permissions' => auth()->user()->getAllPermissions()->pluck('name')->toArray()
            ];

           
            view()->share($data);
        }

        return $next($request);
    }
}
