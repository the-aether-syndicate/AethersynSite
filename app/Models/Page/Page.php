<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/30/2019
 * Time: 4:51 PM
 */

namespace App\Models\Page;


use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $timestamps = true;
    protected $table = 'pages';

    protected $fillable = ['title','pagecontent','role'];

}
