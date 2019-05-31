<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/30/2019
 * Time: 10:19 PM
 */

namespace App\Models\Sde;

use Illuminate\Database\Eloquent\Model;
class DgmTypeAttributes extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'dgmTypeAttributes';
    protected $primaryKey = 'typeID, attributeID';
}