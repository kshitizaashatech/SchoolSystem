<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class StaffUserService
{
    public function getStaffsForDataTable($request)
    {
        return User::join('staffs', 'users.id', '=', 'staffs.user_id')
            ->where('users.user_type_id', '=', 6)
            ->where('staffs.school_id', session('school_id'))
            ->when(isset($request->id), function ($query) use ($request) {
                $query->where('users.id', $request->id);
            })
            ->select('users.*', 'staffs.*')
            ->get();
    }
}