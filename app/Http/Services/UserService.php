<?php

namespace App\Http\Services;

use App, Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * @var User
     */
    protected $user;


    public static function getUsers($role_id, $userCount = null, $rows = false, $auth_org_id = null)
    {


        $qry = User::select(
            array(
                'id',
                'district_id',
                'municipality_id',
                'username',
                'f_name',
                'm_name',
                'l_name',
                'email',
                'is_active',
                'mobile_number',
                'image',
                'created_at',
            )
        );

        $qry->where('role_id', '=', $role_id);

        if ($userCount) {
            return $qry->where('is_active', 1)->count();
        }

        return $qry->orderBy('created_at', 'asc')->get();


    }

    public static function filterUserByRole($role_id, $input = null)
    {

    }


    public static function getRoleUsers($role_id, $userCount = null, $rows = false, $auth_id = null)
    {

    }


    public static function getAdminRoleUsers($role_id, $userCount = false)
    {

    }


    public static function getAdminUsers($role_id)
    {

    }

    public static function panCheck($panNo, $id = null)
    {

    }

    public static function mobileNoCheck($mobileno, $id = null)
    {

    }

    public static function getAllSubcategories()
    {

    }


    public static function getCount()
    {


    }

}