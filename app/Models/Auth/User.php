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
    public function character()
    {
        return $this->belongsTo(CharacterInfo::class, 'id', 'character_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

}