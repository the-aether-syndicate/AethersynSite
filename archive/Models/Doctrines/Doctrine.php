<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/29/2019
 * Time: 9:57 PM
 */

namespace App\Models\Doctrines;


use Illuminate\Database\Eloquent\Model;

class Doctrine extends Model
{
    public $timestamps = true;
    protected $table = 'doctrine';
    protected $fillable = ['id', 'name'];
    public function fittings()
    {
        return $this->hasMany(Fitting::class,  'doctrine_id');
    }

}