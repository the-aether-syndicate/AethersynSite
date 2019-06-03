<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/29/2019
 * Time: 10:28 PM
 */

namespace App\Models\Auth;


use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use App\Models\Fleet\Punch;

/**
 * @property boolean active
 */
class User extends Model implements AuthenticatableContract
{
    use Authenticatable, Notifiable;

    public $incrementing = false;
    protected $table = 'user';
    protected $casts = [
        'active' => 'boolean'
    ];

    protected $fillable = [
        'name',
    ];

    public function refresh_token()
    {
        return $this->hasOne(RefreshToken::class, 'character_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function punches()
    {
        return $this->hasMany(Punch::class);
    }
    public function checkRoles($roles)
    {
        if(!is_array($roles))
        {
            $roles=[$roles];
        }

        if($this->hasAnyRole($roles))
        {
            return true;
        }
        return false;
    }
    public function hasAnyRole($roles)
    {
        return (bool) $this->roles()->whereIn('name', $roles)->first();
    }
    public function hasRole($role)
    {
        return (bool) $this->roles()->where('name', $role)->first();
    }

}