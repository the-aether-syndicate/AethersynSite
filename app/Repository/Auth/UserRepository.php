<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/30/2019
 * Time: 11:03 PM
 */

namespace App\Repository\Auth;


use App\Models\Auth\User as UserModel;

trait UserRepository
{

    public function getAllFullUsers() : Builder
    {
        return UserModel::with('refresh_token', 'group.roles')->select('users.*')
            ->where('id', '<>', 1)
            ->orderBy('group_id', 'asc');
    }

    public function getFullUser($user_id)
    {
        return UserModel::with('group', 'group.users', 'group.roles.permissions', 'affiliations')
            ->where('id', $user_id)
            ->first();
    }
    public function getUser($user_id)
    {
        return UserModel::findOrFail($user_id);
    }
    public function flipUserAccountStatus($user_id)
    {
        $user = $this->getUser($user_id);
        $user->active = $user->active == false ? true : false;
        $user->save();
    }
}