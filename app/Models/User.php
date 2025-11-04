<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'last_login_at',
        'last_login_ip',
        'profile_photo_path',
        'is_active',
    ];
    protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];
}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
        'last_login_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }
    public function getProfilePhotoUrlAttribute()
{
    if ($this->profile_photo_path) {
        // Check if the path already has http:// or https://
        if (strpos($this->profile_photo_path, 'http://') === 0 || strpos($this->profile_photo_path, 'https://') === 0) {
            return $this->profile_photo_path;
        }

        // Check if it uses the asset path format
        if (strpos($this->profile_photo_path, 'assets/') === 0) {
            return asset($this->profile_photo_path);
        }

        // Default to storage path
        return asset('storage/' . $this->profile_photo_path);
    }

    return null;
}

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function getDefaultAddressAttribute()
    {
        return $this->addresses?->first();
    }
    public function getNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (!$user->name && ($user->first_name || $user->last_name)) {
                $user->name = trim($user->first_name . ' ' . $user->last_name);
            }
        });
    }

}
