<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    /**
     * Default Permissions of the Application.
     */
    public static function defaultPermissions()
    {
        return [
            
       



         

            

         

     
        





            

       


           

        
      
            
            'view_service' => 'View Service',
            'add_service' => 'Add Service',
            'edit_service' => 'Edit Service',
            'delete_service' => 'Delete Service',
            'add_assign_service' => 'Add Asign Service',

            'view_category' => 'View Category',
            'add_category' => 'Add Category',
            'edit_category' => 'Edit Category',
            'delete_category' => 'Delete Category',

            'view_subcategory' => 'View Subcategory',
            'add_subcategory' => 'Add Subcategory',
            'edit_subcategory' => 'Edit Subcategory',
            'delete_subcategory' => 'Delete Subcategory',

            'view_user' => 'View User',
            'add_user' => 'Add User',
            'edit_user' => 'Edit User',
            'delete_user' => 'Delete User',

            'view_change_password' => 'View Change Password',
            'view_send_notification' => 'View Send Notification',
            'view_subscribe_user' => 'View Subscriber  User',
            'view_paid_plan_expire_user' => 'View Paid Plan Expire User',

            'view_syetem_service' => 'View System Service',
            'add_syetem_service' => 'Add System Service',
            'edit_syetem_service' => 'Edit System Service',
            'delete_syetem_service' => 'Delete System Service',


            'view_subscriptions' => 'View Subscription',


            'view_subscriptions_plan' => 'View Subscription Plan',
            'add_subscriptions_plan' => 'Add Subscription Plan',
            'edit_subscriptions_plan' => 'Edit Subscription Plan',
            'delete_subscriptions_plan' => 'Delete Subscription Plan',

            'view_customtemplate' => 'View CustomTemplate',
            'add_customtemplate' => 'Add CustomTemplate',
            'edit_customtemplate' => 'Edit CustomTemplate',
            'delete_customtemplate' => 'Delete CustomTemplate',


    

            'view_page' => 'View Pages',
            'add_page' => 'Add Page',
            'edit_page' => 'Edit Page',
            'delete_page' => 'Delete Page',

            'view_setting' => 'View Setting',
            'add_setting' => 'Add Setting',
            'edit_setting' => 'Edit Setting',
            'delete_setting' => 'Delete Setting',

            'view_notification' => 'View Notification',
            'add_notification' => 'Add Notification',
            'edit_notification' => 'Edit Notification',
            'delete_notification' => 'Delete Notification',

            'view_notification_template' => 'View Notification Template',
            'add_notification_template' => 'Add Notification Template',
            'edit_notification_template' => 'Edit Notification Template',
            'delete_notification_template' => 'Delete Notification Template',

            'view_app_banner' => 'View App Banner',
            'add_app_banner' => 'Add App Banner',
            'edit_app_banner' => 'Edit App Banner',
            'delete_app_banner' => 'Delete App Banner',  

            'view_permission' => 'View Permission',
            'edit_permission' => 'Edit Permission',
         
        ];
    }

    /**
     * Name should be lowercase.
     *
     * @param  string  $value  Name value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}
