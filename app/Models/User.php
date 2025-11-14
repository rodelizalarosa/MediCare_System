<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'role',
        'email_verified',
        'status',
        'verify_token',
        'verification_pin',
        'pin_created_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Ensure we only hash plain passwords (avoid double-hashing).
     */
    public function setPasswordAttribute($value)
    {
        if (empty($value)) {
            return;
        }

        // If value already looks like a password hash, store it as-is.
        // password_get_info(...) returns ['algo' => 0] for plain text.
        if (is_string($value) && password_get_info($value)['algo'] !== 0) {
            $this->attributes['password'] = $value;
            return;
        }

        $this->attributes['password'] = \Illuminate\Support\Facades\Hash::make($value);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id');
    }
}
