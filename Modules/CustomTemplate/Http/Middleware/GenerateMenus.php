<?php

namespace Modules\CustomTemplate\Http\Middleware;

use Closure;
use App\Trait\Menu;

class GenerateMenus
{
    use Menu;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
         *
         * Module Menu for Admin Backend
         *
         * *********************************************************************
         */
        \Menu::make('menu', function ($menu) {
            // CustomTemplates
            // $this->childMain($menu, [
            //     'icon' => '<i class="nav-icon fa-regular fa-sun"></i>',
            //     'title' => 'Staff',
            //     'route' => ['backend.customtemplates.index'],
            //     'active' => 'app/customtemplates*',
            //     'order' => 250,
            // ]);
        })->sortBy('order');

        return $next($request);
    }
}
