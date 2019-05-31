<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/29/2019
 * Time: 11:47 PM
 */

namespace App\Models\Auth;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RefreshToken extends Model
{
    use SoftDeletes;
    protected $casts = [
      'scopes' => 'array'
    ];
    protected $table = 'refreshToken';
    protected $dates = ['expires_on', 'deleted_at'];
    protected $primaryKey = 'character_id';
    protected $fillable = ['character_id', 'refresh_token', 'scopes', 'expires_on', 'token'];
    public function getTokenAttribute($value)
    {
        if ($this->expires_on->gt(Carbon::now()))
            return $value;
        return null;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'character_id', 'id');
    }
}