<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/30/2019
 * Time: 10:19 PM
 */

namespace App\Models\Sde;

use Illuminate\Database\Eloquent\Model;
class InvType extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'invTypes';
    protected $primaryKey = 'typeID';
}