<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class SocialLoginSetting extends Model
{
     protected $fillable = ['key', 'value', 'encrypted'];

    protected $casts = [
        'encrypted' => 'boolean',
    ];

    /**
     * Automatically decrypt value if encrypted
     */
    public function getValueAttribute($value)
    {
        if ($this->encrypted && $value) {
            try {
                return Crypt::decryptString($value);
            } catch (\Exception $e) {
                return $value; // fallback in case decryption fails
            }
        }

        return $value;
    }

    /**
     * Automatically encrypt value if encrypted
     */
    public function setValueAttribute($value)
    {
        if ($this->encrypted && $value) {
            $this->attributes['value'] = Crypt::encryptString($value);
        } else {
            $this->attributes['value'] = $value;
        }
    }

    /**
     * Get setting by provider + key
     * e.g. SocialLoginSetting::get('facebook', 'client_id')
     */
    public static function get($providerOrKey, $key = null, $default = null)
{
    $fullKey = is_null($key)
        ? $providerOrKey
        : "social.$providerOrKey.$key";

    $setting = static::where('key', $fullKey)->first();

    if ($setting && $setting->value !== null && $setting->value !== '') {
        return $setting->value;
    }

    if (!is_null($key)) {
        return config("services.$providerOrKey.$key", $default);
    }

    return $default;
}


    /**
     * Set a setting by provider + key
     * e.g. SocialLoginSetting::set('facebook', 'client_secret', 'value', true)
     */
    public static function set($providerOrKey, $key = null, $value = null, $encrypted = false)
    {
        $fullKey = is_null($key) ? $providerOrKey : "social.$providerOrKey.$key";

        return static::updateOrCreate(
            ['key' => $fullKey],
            ['value' => $value, 'encrypted' => $encrypted]
        );
    }
}
