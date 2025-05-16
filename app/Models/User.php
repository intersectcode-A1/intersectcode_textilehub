<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Mendapatkan daftar role yang valid.
     *
     * @return array
     */
    public static function validRoles()
    {
        return ['admin', 'pembeli'];
    }

    /**
     * Set the user's role.
     *
     * @param  string  $value
     * @return void
     */
    public function setRoleAttribute($value)
    {
        // Pastikan role yang dimasukkan valid
        if (!in_array(strtolower($value), self::validRoles())) {
            throw new \InvalidArgumentException("Role yang diberikan tidak valid.");
        }

        // Set role menjadi huruf kecil
        $this->attributes['role'] = strtolower($value);
    }

    /**
     * Get the user's role.
     *
     * @param  string  $value
     * @return string
     */
    public function getRoleAttribute($value)
    {
        // Menampilkan role dalam huruf kapital
        return strtoupper($value);
    }

    /**
     * Relasi dengan model Order (Jika ada).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
