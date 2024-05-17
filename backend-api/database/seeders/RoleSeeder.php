<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name'=>'admin'],
            ['name'=>'attendee'],
            ['name'=>'promotor'],
            ['name'=>'accountant']
        ];
        foreach ($data as $item ) {
            $role =  new Role;
            $role->create($item);
        }
        // seeding relationship
        $permissions = Permission::all();
        $role1 = Role::where('name','admin')->get()->first();
        foreach ($permissions as $permission) { //Seeding Admin Permission
            DB::table('role_permission')->insert([
                'role_id' => $role1->id,
                'permission_id' => $permission->id,
            ]);
        }        
        
        $role2 = Role::where('name','attendee')->first(); // Seed Attendee Permissions
        $attendeePermissions = [
            Permission::where('code','can_view_event')->first()->id,
            Permission::where('code','can_subscribe_event')->first()->id,
            
        ];
        foreach ($attendeePermissions as $permission) {
            DB::table('role_permission')->insert([
                'role_id' => $role2->id,
                'permission_id' => $permission,
            ]);
        }        

        $role3 = Role::where('name','promotor')->first();
        $promotoPermissions = [
            Permission::where('code','can_view_event')->first()->id,
            Permission::where('code','can_view_all_events')->first()->id,
            Permission::where('code','can_create_event')->first()->id,
            Permission::where('code','can_edit_event')->first()->id,
            Permission::where('code','can_delete_event')->first()->id,
            Permission::where('code','can_subscribe_event')->first()->id,
            Permission::where('code','can_set_event')->first()->id,
        ];
        foreach ($promotoPermissions as $permission) {
            DB::table('role_permission')->insert([
                'role_id' => $role3->id,
                'permission_id' => $permission,
            ]);
        }        
    }
}
