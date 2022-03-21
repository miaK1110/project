<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\SellerCustomResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seller extends Authenticatable
{
    use Notifiable, SoftDeletes;
    protected $table = 'sellers';
    protected $dates = ['deleted_at'];

    /**
     * パスワード再設定メールの送信
     *
     * @param  string  $token
     * @return void
     */

    // Illuminate/Auth/Passwords/CanResetPassword.php (:link: コード)の定義をオーバーライド
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new SellerCustomResetPassword($token));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'company', 'branch', 'postcode', 'prefecture', 'city', 'address', 'phone'
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

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
