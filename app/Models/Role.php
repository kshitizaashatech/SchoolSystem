<?php
namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Permission;

class Role extends SpatieRole
{
    const ADMINISTRATOR = 1;
    const USER = 2;

    protected $fillable = ['name', 'display_name', 'description'];

    public function getRequestPath()
    {
        if ($this->id == self::ADMINISTRATOR) {
            return 'admin';
        } elseif ($this->id == self::USER) {
            return 'user';
        }

        return null;
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
}
