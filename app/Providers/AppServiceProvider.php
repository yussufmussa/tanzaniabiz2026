<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use App\Models\GoogleRecaptcha;
use App\Models\SMTPMailSetting;
use App\Models\SocialLoginSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('general_settings') && Schema::hasTable('seo_managers')) {

            $setting = \App\Models\GeneralSetting::first();
            $seo = \App\Models\SeoManager::first();

            // $categories = Category::with('subcategories')->active()->get();


            view()->share([
                'setting' => $setting,
                'seo' => $seo,
                // 'categories' => $categories,
            ]);
        }

        try {
            if (Schema::hasTable('s_m_t_p_mail_settings')) {
                $this->loadMailSettingsFromDatabase();
            }
        } catch (\Exception $e) {
            Log:
            info('Could not load smtp mail settings from database: ' . $e->getMessage());
        }

        if (Schema::hasTable('google_recaptchas')) {
            Config::set('captcha.sitekey', GoogleRecaptcha::get('nocaptcha_sitekey', config('captcha.sitekey')));
            Config::set('captcha.secret', GoogleRecaptcha::get('nocaptcha_secret', config('captcha.secret')));
        }

        Config::set('services.facebook.client_id', SocialLoginSetting::get('facebook', 'client_id', config('services.facebook.client_id')));
        Config::set('services.facebook.client_secret', SocialLoginSetting::get('facebook', 'client_secret', config('services.facebook.client_secret')));

        Config::set('services.google.client_id', SocialLoginSetting::get('google', 'client_id', config('services.google.client_id')));
        Config::set('services.google.client_secret', SocialLoginSetting::get('google', 'client_secret', config('services.google.client_secret')));
    }

    private function loadMailSettingsFromDatabase()
    {
        $settings = [
            'mail.default' => SMTPMailSetting::get('mail_mailer'),
            'mail.mailers.smtp.host' => SMTPMailSetting::get('mail_host'),
            'mail.mailers.smtp.port' => SMTPMailSetting::get('mail_port'),
            'mail.mailers.smtp.username' => SMTPMailSetting::get('mail_username'),
            'mail.mailers.smtp.password' => SMTPMailSetting::get('mail_password'),
            'mail.mailers.smtp.encryption' => SMTPMailSetting::get('mail_encryption'),
            'mail.from.address' => SMTPMailSetting::get('mail_from_address'),
            'mail.from.name' => SMTPMailSetting::get('mail_from_name'),
        ];

        foreach ($settings as $configKey => $value) {
            if ($value !== null) {
                Config::set($configKey, $value);
            }
        }
    }
}
