<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLoginSetting;
use Illuminate\Http\Request;

class SocialLoginController extends Controller
{
    public function index()
    {
        $providers = ['google', 'facebook'];

        $settings = [];

        foreach ($providers as $provider) {
            $settings[$provider] = [
                'enabled'       => SocialLoginSetting::get($provider, 'enabled', false),
                'client_id'     => SocialLoginSetting::get($provider, 'client_id'),
                'client_secret'=> SocialLoginSetting::get($provider, 'client_secret'),
            ];
        }
        return view('backend.general_pages.social_login', compact('settings'));
    }

    /**
     * Update social login settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'google.client_id'      => 'nullable|string',
            'google.client_secret' => 'nullable|string',

            'facebook.client_id'      => 'nullable|string',
            'facebook.client_secret' => 'nullable|string',
        ]);

        foreach (['google', 'facebook'] as $provider) {
            SocialLoginSetting::set($provider, 'enabled', $request->boolean("$provider.enabled"));

            SocialLoginSetting::set($provider, 'client_id', $request->$provider['client_id'] ?? null);

            if (!empty($request->$provider['client_secret'])) {
                SocialLoginSetting::set(
                    $provider,
                    'client_secret',
                    $request->$provider['client_secret'],
                    true 
                );
            }

        }

        return redirect()->back()->with('success', 'Social login settings updated successfully.');
    }
}
