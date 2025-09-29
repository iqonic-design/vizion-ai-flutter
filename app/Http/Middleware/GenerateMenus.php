<?php

namespace App\Http\Middleware;

use App\Trait\Menu;
use Illuminate\Support\Facades\Request;

class GenerateMenus
{
    use Menu;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle()
    {
        return \Menu::make('menu', function ($menu) {

     if(auth()->user()->hasRole('admin')|| auth()->user()->hasRole('demo_admin')){

          $this->staticMenu($menu, ['title' => 'MAIN', 'order' => 0]);

           // main
            $this->mainRoute($menu, [
                'icon' => 'ph ph-squares-four',
                'title' => __('menu.dashboard'),
                'route' => 'backend.home',
                'active' => ['app', 'app/dashboard'],
                'order' => 0,
            ]);


        }

        $this->mainRoute($menu, [
            'icon' => 'ph ph-airplay',
            'title' => __('menu.system_service'),
            'route' => ['backend.services.systemservice.index'],
            'active' => ['app/service/systemservice'],
            'permission' => 'view_syetem_service',
            'order' => 0,
        ]);


        $this->mainRoute($menu, [
            'icon' => 'ph ph-magic-wand',
            'title' => __('menu.template_list'),
            'route' => ['backend.custom-templates.index'],
            'shortTitle' => 'PL',
            'active' => ['app/customtemplates'],
            'permission' => 'view_customtemplate',
            'order' => 0,
        ]);

        $this->mainRoute($menu, [
            'icon' => 'ph ph-list-magnifying-glass',
            'title' => __('menu.category_list'),
            'route' => ['backend.categories.index'],
            'shortTitle' => 'CL',
            'active' => ['app/categories'],
            'permission' => 'view_category',
            'order' => 0,
        ]);

        $permissionsToCheck = [

            'view_user','view_subscribe_user','view_subscribe_user','view_paid_plan_expire_user'

        ];

        if (collect($permissionsToCheck)->contains(fn ($permission) => auth()->user()->can($permission))) {
            $this->staticMenu($menu, ['title' => 'USERS', 'order' => 0]);
        }


        $this->mainRoute($menu, [
            'icon' => 'ph ph-user',
            'title' => __('menu.customer'),
            'route' => ['backend.users'],
            'shortTitle' => 'CL',
            'permission' => 'view_user',
            'active' => ['app/users'],
            'order' => 0,
        ]);

        $this->mainRoute($menu, [
            'icon' => 'ph ph-money',
            'title' => __('menu.subscribed_user_list'),
            'route' => ['backend.subscription_user_list','status' => 'subscription_user'],
            'shortTitle' => 'SL',
            'permission' => 'view_subscribe_user',
            'route' => ['backend.customers.index', 'type'=>'subscription_user'],
            'active' => ['app/customers?type=subscription_user'],
            'order' => 0,
        ]);


        $this->mainRoute($menu, [
            'icon' => 'ph ph-clock-countdown',
            'title' => __('menu.paid_plan_expire'),
            'permission' => 'view_paid_plan_expire_user',
            'route' => ['backend.customers.index','type'=>'soon-to-expire'],
            'shortTitle' => 'CA',
            'active' => ['app/customers?type=soon-to-expire'],
            'order' => 0,
        ]);


        $permissionsToCheck = [

            'view_subscriptions_plan','view_subscriptions'

        ];

        if (collect($permissionsToCheck)->contains(fn ($permission) => auth()->user()->can($permission))) {
            $this->staticMenu($menu, ['title' => 'Plans', 'order' => 0]);
        }



        $this->mainRoute($menu, [
            'icon' => 'ph ph-sliders',
            'title' => __('menu.plan'),
            'route' => ['backend.subscription.plans.index'],
            'shortTitle' => 'PL',
            'permission' => 'view_subscriptions_plan',
            'active' => ['app/subscriptions/plans'],
            'order' => 0,
        ]);

        $this->mainRoute($menu, [
            'icon' => 'ph ph-list',
            'title' => __('menu.planlimitations'),
            'route' => ['backend.subscription.planlimitation.index'],
            'shortTitle' => 'LL',
            'active' => ['app/subscription/planlimitation/index'],
            'order' => 0,
        ]);

        $this->mainRoute($menu, [
            'icon' => 'ph ph-currency-dollar-simple',
            'title' => __('menu.subscription'),
            'route' => ['backend.subscriptions.index'],
            'permission' => 'view_subscriptions',
            'shortTitle' => 'SL',
            'active' => ['app/subscriptions'],
            'order' => 0,
        ]);

            // System Static
            $permissionsToCheck = [
                'view_setting', 'view_page','view_notification','view_app_banner','view_permission'
            ];

            if (collect($permissionsToCheck)->contains(fn ($permission) => auth()->user()->can($permission))) {
                $this->staticMenu($menu, ['title' => 'SYSTEM', 'order' => 0]);
            }

            $this->mainRoute($menu, [
                'icon' => 'ph ph-gear',
                'title' => __('menu.settings'),
                'route' => 'backend.settings',
                'active' => 'app/settings',
                'permission' => 'view_setting',
                'order' => 0,
            ]);

            $this->mainRoute($menu, [
                'icon' => 'ph ph-list',
                'title' => __('menu.reports'),
                'route' => 'backend.reports',
                'active' => 'app/reports',
                'permission' => 'view_setting',
                'order' => 0,
            ]);

            $this->mainRoute($menu, [
                'icon' => 'ph ph-file',
                'title' => __('page.title'),
                'route' => ['backend.pages.index'],
                'active' => ['app/pages'],
                'permission' => 'view_page',
                'order' => 0,
            ]);

            $notification = $this->parentMenu($menu, [
                'icon' => 'ph ph-bell-ringing',
                'title' => __('notification.title'),
                'nickname' => 'notifications',
                'permission' => 'view_notification',
                'order' => 0,
            ]);

            $this->childMain($notification, [
                'title' => __('notification.list'),
                'route' => 'backend.notifications.index',
                'shortTitle' => 'Li',
                'active' => 'app/notifications',
                'permission' => 'view_notification',
                'order' => 0,
                'icon' => 'ph ph-sliders',
            ]);

            $this->childMain($notification, [
                'title' => __('notification.template'),
                'route' => 'backend.notification-templates.index',
                'shortTitle' => 'TE',
                'active' => 'app/notification-templates*',
                'permission' => 'view_notification_template',
                'order' => 0,
                'icon' => 'ph ph-sliders',
            ]);



            $this->mainRoute($menu, [
                'icon' => 'ph ph-git-commit',
                'title' => __('menu.access_control'),
                'route' => 'backend.permission-role.list',
                'active' => ['app/permission-role'],
                'permission' => 'view_permission',
                'order' => 0,
            ]);
            // Access Permission Check
            $menu->filter(function ($item) {
                if ($item->data('permission')) {
                    if (auth()->check()) {
                        if (\Auth::getDefaultDriver() == 'admin') {
                            return true;
                        }
                        if (auth()->user()->hasAnyPermission($item->data('permission'), \Auth::getDefaultDriver())) {
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
                            $item->link->active();
                            if ($item->hasParent()) {
                                $item->parent()->active();
                            }
                        }
                    }
                }

                return true;
            });
        })->sortBy('order');
    }
}
