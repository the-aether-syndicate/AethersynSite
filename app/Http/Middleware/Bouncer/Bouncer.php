<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/29/2019
 * Time: 8:23 PM
 */

namespace App\Http\Middleware\Bouncer;


use Illuminate\Http\Request;

class Bouncer
{

    public function handle(Request $request, \Closure $next, Role $role = null)
    {
        $user = auth()->user();

        if($user->has($role, false))
            return $next($request);
        $message = 'Request to '.$request->path().' was denied by the Bouncer.  You require the permission '.$permission.'.';
        return redirect()->route('auth.unauthorized');
    }


}