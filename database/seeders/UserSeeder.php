<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $superAdminRole = Role::create(['name' => "Super Admin"]);

        // // Creating Permission ------
        // $permissionAddUser = Permission::create(['name' => 'create_users']);
        // $permissionViewUser = Permission::create(['name' => 'list_users']);
        // $permissionEditUser = Permission::create(['name' => 'edit_users']);
        // $permissionDeleteUser = Permission::create(['name' => 'delete_users']);

        // // ASSIGNING PERMISSIONS ------
        // $permissionAddUser->assignRole($superAdminRole);
        // $permissionViewUser->assignRole($superAdminRole);
        // $permissionEditUser->assignRole($superAdminRole);
        // $permissionDeleteUser->assignRole($superAdminRole);

        $superAdminUserType = UserType::where('title', 'super_admin')->first();
        $districtAdminUserType = UserType::where('title', 'district')->first();
        $municipalityAdminUserType = UserType::where('title', 'municipality')->first();
        $headSchoolAdminUserType = UserType::where('title', 'head_school')->first();
        $schoolAdminUserType = UserType::where('title', 'school_admin')->first();

        // CREATING SUPER ADMIN USER
        $superAdminUser = User::create([
            'username' => "superadmin",
            'email' => 'superadmin@mail.com',
            'password' => 'password',
            'user_type_id' => $superAdminUserType->id,
            'role_id' => 1,
        ]);

        $districtAdminUser = User::create([
            'username' => "districtadmin",
            'email' => 'districtadmin@mail.com',
            'password' => 'password',
            'user_type_id' => $districtAdminUserType->id,
            'role_id' => 2,
        ]);

        $municipalityAdminUser = User::create([
            'username' => "municipalityadmin",
            'email' => 'municipalityadmin@mail.com',
            'password' => 'password',
            'user_type_id' => $municipalityAdminUserType->id,
            'role_id' => 3,
            'state_id' => 2,
            'district_id' => 18,
            'municipality_id' => 186
        ]);

        $headSchoolAdminUser = User::create([
            'username' => "headschooladmin",
            'email' => 'headschooladmin@mail.com',
            'password' => 'password',
            'user_type_id' => $headSchoolAdminUserType->id,
            'role_id' => 4,
            'state_id' => 2,
            'district_id' => 18,
            'municipality_id' => 186
        ]);

        $schoolAdminUser = User::create([
            'username' => "schooladmin",
            'email' => 'schooladmin@mail.com',
            'password' => 'password',
            'user_type_id' => $schoolAdminUserType->id,
            'role_id' => 5,
            'state_id' => 2,
            'district_id' => 18,
            'municipality_id' => 186,
            'school_id' => 1,
        ]);

        $superAdminUser->assignRole(1);
        $districtAdminUser->assignRole(2);
        $municipalityAdminUser->assignRole(3);
        $headSchoolAdminUser->assignRole(4);
        $schoolAdminUser->assignRole(5);
    }
}
