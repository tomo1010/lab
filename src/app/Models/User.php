<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use App\Models\Tirecalc;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Billable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_postal',
        'company_address',
        'company_name',
        'company_tel',
        'company_fax',
        'company_handyphone',
        'company_mail',
        'company_url',
        'company_registration_number',
        'company_transfer_1',
        'company_transfer_2',
        'company_transfer_3',
        'company_note',
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


    /**
     * ユーザの保存　制限設定（プレミアム会員　：　一般会員）
     *
     * @return bool
     */
    public function limit(): int
    {
        return $this->subscribed() ? 10 : 3;
    }


    /**
     ** このユーザが所有する見積もり
     */
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }


    /**
     ** このユーザが所有するラベル
     */
    public function labels()
    {
        return $this->hasMany(Label::class);
    }


    /**
     ** このユーザが所有する請求書
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }


    /**
     ** このユーザが所有するタイヤ計算
     */
    public function tirecalcs()
    {
        return $this->hasMany(Tirecalc::class);
    }
}
