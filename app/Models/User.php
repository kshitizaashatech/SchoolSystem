<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Staff;
use App\Models\FeeDue;
use App\Models\Student;
use App\Models\Municipality;
use App\Models\StudentLeave;
use App\Models\StudentSession;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'f_name',
        'm_name',
        'l_name',
        'username',
        'password',
        'role_id',
        'user_type_id', //user type is district nagarpalika, school_collective and school
        'school_id',
        'state_id',
        'district_id',
        'municipality_id',
        'ward_id',
        'category_id',
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'local_address',
        'permanent_address',
        'gender',
        'religion',
        'cast',
        'mobile_number',
        'email',
        'dob',
        'image',
        'blood_group',
        'father_name',
        'father_phone',
        'father_occupation',
        'mother_name',
        'mother_phone',
        'mother_occupation',
        'emergency_contact_person',
        'emergency_contact_phone',
        'bank_name',
        'bank_account_no',
        'bank_branch',
        'dis_reason',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'note',
        'disable_at',
        'verification_code',
        'is_active',
        'guardian_is'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    /**
     * Getting the district that the user belongs to.
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    /**
     * Getting the district that the user belongs to.
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }

    public function district_bystate($state_id)
    {
        // dd($state_id);
        return District::select('name', 'id', 'province_id as state_id')->where('province_id', $state_id)->get();
    }

    public function municipalities_bydistrict($district_id)
    {
        // Assuming you have a 'district_id' column in your municipalities table
        return Municipality::select('name', 'id', 'district_id as state_id')
            ->where('district_id', $district_id)
            ->get();
    }

    public static function getWards($municipalityId)
    {
        $municipality = Municipality::find($municipalityId);

        if ($municipality) {
            // Decode the wards array from JSON
            $wardsArray = json_decode($municipality->wards, true);

            // Create an array of stdClass objects to match the expected response
            $wards = [];
            foreach ($wardsArray as $ward) {
                $wards[] = (object)['id' => $ward, 'name' => "Ward $ward"];
            }

            return $wards;
        }

        return [];
    }


    public function students()
    {
        return $this->hasMany(Student::class, 'user_id');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }
    // public function feeDues()
    // {
    //     return $this->hasMany(FeeDue::class, 'user_id');
    // }
    public function studentSession()
    {
        return $this->hasMany(StudentSession::class, 'user_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
     public function role()
     {
         return $this->belongsTo(Staff::class, 'role_id');
     }
   
}
