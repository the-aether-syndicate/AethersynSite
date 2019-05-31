<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/29/2019
 * Time: 10:23 PM
 */

namespace App\Http\Controllers\Auth;

use App\Models\Auth\RefreshToken;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\User as SocialiteUser;
use App\Http\Controllers\Controller;


class SsoController extends Controller
{

    public function redirectToProvider(Socialite $social)
    {
        return $social->driver('eveonline')->scopes(['publicData'])
            ->redirect();
    }

    public function handleProviderCallback(Socialite $social)
    {

        $eve_data = $social->driver('eveonline')->user();
        //logger()->debug(dd($eve_data));
        // Get or create the User bound to this login.
        $user = $this->findOrCreateUser($eve_data);
        logger()->debug('Found user.');
        // Update the refresh token for this character.
        $this->updateRefreshToken($eve_data);
        //Try to log in the user
        if (! $this->loginUser($user))
            return redirect()->route('auth.fail')
                ->with('error', 'Login failed. Please contact your administrator.');

        return redirect()->route('landing');
    }

    public function findOrCreateUser(SocialiteUser $eve_user): User
    {
        if($existing = User::find($eve_user->character_id)) {
            logger()->debug('Found User '.$existing->name);
            return $existing;
        }
        logger()->debug('Creating User '.$eve_user->name);
        return User::forceCreate([
            'id'            => $eve_user->character_id,
            'name'          => $eve_user->name,
            'active'        => true
        ]);

    }
    public function updateRefreshToken(SocialiteUser $eve_data): void
    {
        RefreshToken::withTrashed()->firstOrNew(['character_id' => $eve_data->character_id])
            ->fill([
                'refresh_token' => $eve_data->refresh_token,
                'scopes'        => explode(' ', $eve_data->scopes),
                'token'         => $eve_data->token,
                'expires_on'    => $eve_data->expires_on,
            ])
            ->save();
        // restore soft deleted token if any
        RefreshToken::onlyTrashed()->where('character_id', $eve_data->character_id)->restore();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function loginUser(User $user)
    {
        if(!$user->active)
        {
            return false;
        }
        //dd($user);
        logger()->debug('Logging in');
        Auth::login($user, true);

        return true;
    }
}