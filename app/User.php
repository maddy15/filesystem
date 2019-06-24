<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\HasRoles;
use Carbon\Carbon;
use App\Traits\HasPermissions;

class User extends Authenticatable
{
    use Notifiable,HasRoles,HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','stripe_id','stripe_key'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isTheSameAs(User $user)
    {
        return $user->id === $this->id;
    }

    public function lifetimeSales()
    {
        return $this->sales->sum('sale_price');
    }

    public function thisMonthSale()
    {
        $now = Carbon::now();

        return $this->sales()->whereBetween('created_at',[
            $now->startOfMonth(),
            $now->copy()->endOfMonth()
        ])
        ->get()
        ->sum('sale_price');
    }
}