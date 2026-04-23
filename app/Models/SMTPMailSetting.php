<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class SMTPMailSetting extends Model
{
    protected $fillable = ['key', 'value', 'encrypted'];

     protected $casts = [
        'encrypted' => 'boolean',
    ];

    public function getValueAttribute($value)
    {
        if ($this->encrypted && $value) {
            try {
                return Crypt::decryptString($value);
            } catch (\Exception $e) {
                return $value;
            }
        }
        return $value;
    }

    public function setValueAttribute($value)
    {
        if ($this->encrypted && $value) {
            $this->attributes['value'] = Crypt::encryptString($value);
        } else {
            $this->attributes['value'] = $value;
        }
    }

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $encrypted = false)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'encrypted' => $encrypted]
        );
    }
}
