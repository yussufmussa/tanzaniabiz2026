<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\GoogleRecaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GoogleRecaptchaController extends Controller
{
     public function index()
    {
        $recaptchaSettings = [
            'nocaptcha_secret' => GoogleRecaptcha::get('nocaptcha_secret', config('captcha.secret')),
            'nocaptcha_sitekey' => GoogleRecaptcha::get('nocaptcha_sitekey', config('captcha.sitekey')),
            
        ];

        return view('backend.general_pages.google_recaptcha', compact('recaptchaSettings'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nocaptcha_secret' => 'required|string|max:255',
            'nocaptcha_sitekey' => 'required|string|max:255',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
             GoogleRecaptcha::set('nocaptcha_secret', $request->nocaptcha_secret, true); // encrypted
            GoogleRecaptcha::set('nocaptcha_sitekey', $request->nocaptcha_sitekey);

            return back()->with('success', 'Google Recaptcha keys updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating settings: ' . $e->getMessage())->withInput();
        }
    }
}
