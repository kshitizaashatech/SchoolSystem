<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;

class StaffRoleDateService
{
    /**
     * Get staff data filtered by role and optionally by user ID.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getStaffDateRoleForDataTable(Request $request)
    {
        $query = User::join('staffs', 'users.id', '=', 'staffs.user_id')
            ->where('users.user_type_id', '=', 6); // Assuming user_type_id 6 corresponds to staff

        // Optional filters
        if ($request->has('id')) {
            $query->where('users.id', $request->id);
        }

        // Filter by school_id from session
        $schoolId = $request->session()->get('school_id');
        if ($schoolId) {
            $query->where('staffs.school_id', $schoolId);
        }

        // Select specific columns
        $query->select('users.*', 'staffs.*', 'staffs.id as staff_id');

        // Execute the query and return the result
        return $query->get();
    }
}