<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'deleted',
        'created_by',
        'update_by',
    ];



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
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($user) {
                if ($userAuth = Auth::user()) {
                    $user->created_by = $userAuth->id;
                    $user->updated_by = $userAuth->id;
                }
            }
        );
        static::updating(function ($user) {
            if ($userAuth = Auth::user()) {
                $user->updated_by = $userAuth->id;
            }
        });
        static::deleting(function ($user) {
            $user->deleted= 'INACTIVO';
            if ($userAuth = Auth::user()) {
                $user->deleted_by = $userAuth->id;
            }
        });

    }



}
