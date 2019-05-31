<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/29/2019
 * Time: 9:55 PM
 */

namespace App\Models\Doctrines;


use Illuminate\Database\Eloquent\Model;

class Fitting extends Model
{
    public $timestamps = true;

    protected $table = 'fitting';

    protected $fillable = ['id', 'shiptype','fitname','eftfitting'];

    public function doctrine()
    {
        return $this->belongsTo(Doctrine::class, 'doctrine_id');
    }

}