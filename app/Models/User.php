<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 性别
    public const GENDER_NONE = 'none';
    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';

    //系统用户Id
    public const SYSTEM_USER_ID = 1;

    /**
     * 可以对外输出字段.
     */
    public const SAFE_FIELDS = [
        'id', 'name', 'real_name', 'username', 'avatar', 'is_admin',
    ];

    public const DEFAULT_AVATAR = '/img/default-avatar.png';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVATED = 'inactivated';
    public const STATUS_FROZEN = 'frozen';

    public const STATUS_LABELS = [
        self::STATUS_INACTIVATED => '未激活',
        self::STATUS_ACTIVE => '正常',
        self::STATUS_FROZEN => '已冻结',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'name',
        'real_name',
        'avatar',
        'email',
        'phone',
        'gender',
        'status',
        'birthday',
        'email_verified_at',
        'password',
        'frozen_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'creator_id' => 'int',
        'cache' => 'array',
        'extends' => 'array',
        'settings' => 'array',
        'is_admin' => 'bool',
        'is_visible' => 'bool',
        'birthday' => 'date',
    ];

    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * @return string
     */
    public function getAvatarAttribute()
    {
        return $this->attributes['avatar'] ?? self::DEFAULT_AVATAR;
    }

    /**
     * @return string
     */
    public function getDisplayStatusAttribute()
    {
        return self::STATUS_LABELS[$this->status ?? self::STATUS_ACTIVE];
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function (User $user) {
            $user->username = $user->username ?? $user->email;
            $user->name = $user->name ?? $user->real_name ?? $user->username;

            if (Hash::needsRehash($user->password)) {
                $user->password = \bcrypt($user->password);
            }
        });
    }
}
