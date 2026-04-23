<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\SMTPMailSetting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;


class SMTPSettingController extends Controller
{
    public function index()
    {
      
        $mailSettings = [
            'mail_mailer' => SMTPMailSetting::get('mail_mailer', config('mail.default')),
            'mail_host' => SMTPMailSetting::get('mail_host', config('mail.mailers.smtp.host')),
            'mail_port' => SMTPMailSetting::get('mail_port', config('mail.mailers.smtp.port')),
            'mail_username' => SMTPMailSetting::get('mail_username', config('mail.mailers.smtp.username')),
            'mail_password' => SMTPMailSetting::get('mail_password', config('mail.mailers.smtp.password')),
            'mail_encryption' => SMTPMailSetting::get('mail_encryption', config('mail.mailers.smtp.encryption')),
            'mail_from_address' => SMTPMailSetting::get('mail_from_address', config('mail.from.address')),
            'mail_from_name' => SMTPMailSetting::get('mail_from_name', config('mail.from.name')),
        ];

        return view('backend.general_pages.mail_setting', compact('mailSettings'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mail_mailer' => 'required|in:smtp,sendmail,mailgun,ses,postmark',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|integer|between:1,65535',
            'mail_username' => 'required|email|max:255',
            'mail_password' => 'required|string|max:255',
            'mail_encryption' => 'nullable|in:tls,ssl',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Save all settings to database
            SMTPMailSetting::set('mail_mailer', $request->mail_mailer);
            SMTPMailSetting::set('mail_host', $request->mail_host);
            SMTPMailSetting::set('mail_port', $request->mail_port);
            SMTPMailSetting::set('mail_username', $request->mail_username);
            SMTPMailSetting::set('mail_password', $request->mail_password, true); // encrypted
            SMTPMailSetting::set('mail_encryption', $request->mail_encryption);
            SMTPMailSetting::set('mail_from_address', $request->mail_from_address);
            SMTPMailSetting::set('mail_from_name', $request->mail_from_name);

            // Apply settings immediately to current config
            $this->applyMailSettings();

            return back()->with('success', 'SMTP Mail settings updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating settings: ' . $e->getMessage())->withInput();
        }
    }

    private function applyMailSettings()
    {
        // Get settings from database
        $settings = [
            'mail_mailer' => SMTPMailSetting::get('mail_mailer'),
            'mail_host' => SMTPMailSetting::get('mail_host'),
            'mail_port' => SMTPMailSetting::get('mail_port'),
            'mail_username' => SMTPMailSetting::get('mail_username'),
            'mail_password' => SMTPMailSetting::get('mail_password'),
            'mail_encryption' => SMTPMailSetting::get('mail_encryption'),
            'mail_from_address' => SMTPMailSetting::get('mail_from_address'),
            'mail_from_name' => SMTPMailSetting::get('mail_from_name'),
        ];

        // Apply to current config
        if ($settings['mail_mailer']) {
            Config::set('mail.default', $settings['mail_mailer']);
        }
        if ($settings['mail_host']) {
            Config::set('mail.mailers.smtp.host', $settings['mail_host']);
        }
        if ($settings['mail_port']) {
            Config::set('mail.mailers.smtp.port', $settings['mail_port']);
        }
        if ($settings['mail_username']) {
            Config::set('mail.mailers.smtp.username', $settings['mail_username']);
        }
        if ($settings['mail_password']) {
            Config::set('mail.mailers.smtp.password', $settings['mail_password']);
        }
        if ($settings['mail_encryption']) {
            Config::set('mail.mailers.smtp.encryption', $settings['mail_encryption']);
        }
        if ($settings['mail_from_address']) {
            Config::set('mail.from.address', $settings['mail_from_address']);
        }
        if ($settings['mail_from_name']) {
            Config::set('mail.from.name', $settings['mail_from_name']);
        }

        // Purge mail manager to reload configuration
        Mail::purge();
    }
}
