<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ####----- system permissions
            ["code"=>"can_view_system_analytics","name"=>"View System Analytics",],
            ["code"=>"can_manage_site","name"=>"Manage Site",],
            ####-----users
            ["code"=>"can_view_all_users","name"=>"View all users",],
            ["code"=>"can_edit_user","name"=>"Edit user",],
            ["code"=>"can_delete_user","name"=>"Delete user",],
            ["code"=>"can_deactivate_user","name"=>"Deactivate user",],
            ####-----events
            ["code"=>"can_view_event","name"=>"View event",],
            ["code"=>"can_view_all_events","name"=>"View all events",],
            ["code"=>"can_create_event","name"=>"Create event",],
            ["code"=>"can_edit_event","name"=>"Edit event",],
            ["code"=>"can_delete_event","name"=>"Delete event",],
            ["code"=>"can_subscribe_event","name"=>"Subscribe event",],
            ["code"=>"can_set_event","name"=>"Set event",],

            ####-----auth Roles
            ["code"=>"can_view_role","name"=>"View role",],
            ["code"=>"can_create_role","name"=>"Create role",],
            ["code"=>"can_edit_role","name"=>"Edit role",],
            ["code"=>"can_delete_role","name"=>"Delete role",],
            ["code"=>"can_assign_role","name"=>"Assign role",],
           
            ];
            $permission = new Permission();
                foreach ($data as $item ) {
                $permission->create($item);
            }
    }
}
