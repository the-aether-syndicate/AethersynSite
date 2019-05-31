<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/30/2019
 * Time: 4:52 PM
 */

namespace App\Models\Auth;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    public $incrementing = true;
    protected $fillable = ['id', 'name', 'description'];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}