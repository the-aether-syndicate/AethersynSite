<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/31/2019
 * Time: 3:59 PM
 */

namespace App\Http\Controllers\Auth;


use App\Models\Auth\Role;
use App\Models\Auth\User;
use App\Validation\RoleModValidation;
use App\Validation\RoleValidation;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;

class RoleController
{

    public function giveUserRole(RoleModValidation $request){
        $role = Role::where('name',$request->role)->first();
        $user = User::where('name',$request->user)->first();
        $user->roles()->attach($role->id);
        return redirect()->back();
    }
    public function giveUserRoleAjax($user, $role){
        $role = Role::where('name',$role)->first();
        $user = User::where('name',$user)->first();
        $user->roles()->attach($role->id);
        return $this->getUserRoles($user->id);
    }
    public function takeUserRole(RoleModValidation $request){
        $role = Role::where('name',$request->role)->first();
        $user = User::where('name',$request->user)->first();
        $user->roles()->detach($role->id);
        return redirect()->back();
    }
    public function takeUserRoleAjax($user,$role){
        $role = Role::where('name',$role)->first();
        $user = User::where('name',$user)->first();
        $user->roles()->detach($role->id);
        return $this->getUserRoles($user->id);
    }
    public function addRole(RoleValidation $request)
    {
        Role::firstOrCreate(
            ['name' => $request->name],
            ['description'=> $request->description]
        );
        return redirect()->back();
    }
    public function deleteRole(RoleValidation $request)
    {
        $role = Role::where('name', $request->name)->first();
        $role->users()->detach();
        $role->delete();
        return redirect()->back();
    }
    public function getRoles()
    {
        $roles=Role::all();
        $rolelist = [];

        foreach ($roles as $role)
        {
            array_push($rolelist,
                [
                    'name' => $role->name

                ]);
        }
        return $rolelist;
    }
    public function getUsers()
    {
        $users = User::all();
        $userlist = [];

        foreach ($users as $user)
        {
            array_push($userlist,
                [
                    'name' => $user->name,
                    'id'   => $user->id,

                ]);
        }
        return $userlist;
    }
    public function getUsersData()
    {

        return DataTables::of(User::all())->make();
    }
    public function getUserRoles($userid)
    {
        $user = User::find($userid);
        $roles= $user->roles;
        $rolelist = [];

        foreach ($roles as $role)
        {
            array_push($rolelist,
                [
                    'name' => $role->name,
                    'description' => $role->description,

                ]);
        }
        return $rolelist;
    }
    public function getRoleUsers($role)
    {
        $role = Role::where('name', $role)->first();
        $users= $role->users;
        $userlist = [];

        foreach ($users as $user)
        {
            array_push($userlist,
                [
                    'name' => $user->name

                ]);
        }
        return $userlist;
    }

}