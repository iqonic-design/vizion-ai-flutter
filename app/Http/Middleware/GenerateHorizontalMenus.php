<?php

namespace App\Http\Middleware;

use App\Trait\HorizontalMenu;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GenerateHorizontalMenus
{
    use HorizontalMenu;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        \Menu::make('horizontal_menu', function ($menu) {

            // MAIN
            $main = $this->parentMenu($menu, [
                'icon' => '',
                'title' => 'MAIN',
                'nickname' => 'main',
                'order' => 200,
            ]);

            // Main -Child
            $this->childMain($main, [
                'title' => 'Dashboard',
                'route' => 'backend.home',
                'active' => ['app', 'app/dashboard'],
                'order' => 10,
            ]);

           
            $users = $this->parentMenu($menu, [
                'icon' => '',
                'title' => 'USERS',
                'nickname' => 'user',
                'order' => 230,
            ]);


            $this->childMain($users, [
                'title' => 'Customers',
                'route' => ['backend.customers.index'],
                'active' => 'app/customers',
                'permission' => 'view_customer',
                'order' => 20,
            ]);

          
            // Access Permission Check
            $menu->filter(function ($item) {
                if ($item->data('permission')) {
                    if (auth()->check()) {
                        if (auth()->user()->hasAnyPermission($item->data('permission')) || auth()->user()->hasRole('admin')) {
                            return true;
                        }
                    }

                    return false;
                } else {
                    return true;
                }
            });

            // Set Active Menu
            $menu->filter(function ($item) {
                if ($item->activematches) {
                    $activematches = (is_string($item->activematches)) ? [$item->activematches] : $item->activematches;
                    foreach ($activematches as $pattern) {
                        if (request()->is($pattern)) {
                            $item->active();
                            if ($item->hasParent()) {
                                $item->parent()->active();
                            }
                        }
                    }
                }

                return true;
            });
        })->sortBy('order');

        return $next($request);
    }
}
