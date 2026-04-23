<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Socialite;

class SocialiteController extends Controller
{
    public function loginSocial(Request $request, string $provider): RedirectResponse
    {
        $this->validateProvider($request);

        return Socialite::driver($provider)->redirect();
    }

    public function callbackSocial(Request $request, string $provider)
    {
        $this->validateProvider($request);

        $response = Socialite::driver($provider)->user();

        $email = $response->getEmail();
        $existingUser = User::where('email', $email)->first();
        if ($existingUser && $existingUser->hasAnyRole(['admin', 'editor', 'writer'])) {
            Auth::logout(); 
            return redirect()->route('login')->withErrors([
                'social' => 'Social login is not allowed for this account.',
            ]);
        }

        $user = User::firstOrCreate(
            ['email' => $response->getEmail()],
            [
                'name' => $response->getName(),
                'profile_picture' => 'user.png',
                'password' => Hash::make(Str::random(16)),
            ]
        );

        if ($user->wasRecentlyCreated) {
            $user->assignRole('business_owner');
        }

        $data = [$provider . '_id' => $response->getId()];

        if ($user->wasRecentlyCreated) {
            $data['name'] = $response->getName() ?? $response->getNickname();

            $user->markEmailAsVerified();
        }

        $user->update($data);

        Auth::login($user, remember: true);

        return redirect(auth()->user()->redirectToDashboard());
    }

    protected function validateProvider(Request $request): array
    {
        $validator = Validator::make(
            $request->route()->parameters(),
            ['provider' => 'in:facebook,google']
        );

        return $validator->validate();
    }
}
