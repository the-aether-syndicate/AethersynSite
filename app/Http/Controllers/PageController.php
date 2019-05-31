<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/29/2019
 * Time: 8:12 PM
 */

namespace App\Http\Controllers;


class PageController extends Controller
{

    function getJoin()
    {
        return view('pages.join');
    }

}