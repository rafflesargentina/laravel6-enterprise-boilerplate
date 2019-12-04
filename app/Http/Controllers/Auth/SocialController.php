<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController as Controller;
use App\Models\{ User, FeaturedPhoto };

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Socialite;

class SocialController extends Controller
{
    /**
     * Obtain the user informacion from provider.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        $provider = $request->provider;
        $socialUser = Socialite::driver($provider)->stateless()->user();

        $user = $this->updateOrCreateUser($socialUser, $provider);

        if ($request->wantsJson()) {
            try {
                $user->load('permissions', 'roles');
                $token = $user->createToken(env('APP_NAME'));
                $accessToken = $token->accessToken;

                $data = [
                    'token' => $accessToken,
                    'remember' => $request->remember,
                    'user' => $user
                ];

                return $this->authenticated($request, $request->user())
                    ?: $this->validSuccessJsonResponse('Success', $data, $this->redirectPath());

            } catch (\Exception $e) {
                return $this->validInternalServerErrorJsonResponse($e, $e->getMessage());
            }
        }

        $sessionKey = "{$provider}_token";
        $request->session()->put($sessionKey, $socialUser->token);
        $this->guard('socialite')->login($user);
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * Redirect the user to the specified provider authentication page.
     *
     * @param string $provider The provider.
     * @param string $scopes   The scopes.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider, $scopes = [])
    {
        return Socialite::driver($provider)
            ->scopes($scopes)
            ->stateless()
            ->redirect();
    }

    /**
     * Update or create the user's avatar.
     *
     * @param \App\Models\User                  $user       The Eloquent User model.
     * @param \Laravel\Socialite\Contracts\User $socialUser The User instance for the authenticated user.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function updateOrCreateAvatar($user, $socialUser)
    {
        $data = ['featured' => '1', 'location' => $socialUser->getAvatar()];

        $user->avatar()->updateOrCreate($data, $data);
    }

    /**
     * Update or create the Eloquent User model.
     *
     * @param \Laravel\Socialite\Contracts\User $socialUser The User instance for the authenticated user.
     * @param string                            $provider   The provider.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function updateOrCreateUser($socialUser, $provider)
    {
        $user = User::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'nickname' => $socialUser->getNickname(),
            'first_name' => $socialUser->getName(),
            'provider' => $provider,
            'provider_id' => $socialUser->id
            ]
        );

        $this->updateOrCreateAvatar($user, $socialUser);

        if ($user->wasRecentlyCreated) {
            event(new Registered($user));
        }
    
        return $user;
    }
}
