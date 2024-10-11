<?php

namespace Dev\AdvancedRole\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Dev\Base\Casts\SafeContent;
use Dev\Base\Models\BaseModel;
use Dev\Base\Supports\Avatar;
use Dev\Media\Facades\AppMedia;
use Dev\Media\Models\MediaFile;
use Dev\Member\Notifications\ConfirmEmailNotification;
use Dev\Member\Notifications\ResetPasswordNotification;
use Dev\AdvancedRole\Models\Team;
use Dev\Plan\Models\Transaction;
use Dev\AdvancedRole\Models\Member as BaseMember;

use Laravel\Sanctum\HasApiTokens;
use Exception;

use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;

class Member extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    LaratrustUser
{
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use MustVerifyEmail;
    use HasApiTokens;
    use Notifiable;
    use HasRolesAndPermissions;

    protected $table = 'members';

    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'description',
        'gender',
        'email',
        'password',
        'avatar_id',
        'dob',
        'phone',
        'confirmed_at',
        'email_verify_token',
        'remember_token',
        'department_id', // 'Bên MSSQL cũ là Nguoi_Su_Dung.MaKhoa, Mã Khoa cấp cứu (emergency department - ED)',
        'department_room_id', // 'Bên MSSQL cũ là Nguoi_Su_Dung.MaPhong, Mã phòng cấp cứu (emergency room - ER)',
        'role_name', // 'Bên MSSQL cũ là Nguoi_Su_Dung.MaNhom, có thể sẽ không sử dụng, chỉ dùng để đối chiếu data, xoá đi khi ổn định',
        'status', //
        'last_login',
        'expire_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'confirmed_at' => 'datetime',
        'dob' => 'date',
        'first_name' => SafeContent::class,
        'last_name' => SafeContent::class,
        'description' => SafeContent::class,
    ];

    protected static function booted(): void
    {
        static::deleting(function (Member $account) {
            $folder = Storage::path($account->upload_folder);
            if (File::isDirectory($folder) && Str::endsWith($account->upload_folder, '/' . $account->getKey())) {
                File::deleteDirectory($folder);
            }
        });
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new ConfirmEmailNotification());
    }

    public function avatar(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class)->withDefault();
    }

    public function posts(): MorphMany
    {
        return $this->morphMany('Dev\Blog\Models\Post', 'author');
    }

    protected function firstName(): Attribute
    {
        return Attribute::get(fn($value) => ucfirst((string)$value));
    }

    protected function lastName(): Attribute
    {
        return Attribute::get(fn($value) => ucfirst((string)$value));
    }

    protected function name(): Attribute
    {
        return Attribute::get(fn() => trim($this->first_name . ' ' . $this->last_name));
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->avatar->url) {
                return AppMedia::url($this->avatar->url);
            }

            try {
                return (new Avatar())->create($this->name)->toBase64();
            } catch (Exception) {
                return AppMedia::getDefaultImage();
            }
        });
    }

    protected function avatarThumbUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->avatar->url) {
                return AppMedia::getImageUrl($this->avatar->url, 'thumb');
            }

            try {
                return (new Avatar())->create($this->name)->toBase64();
            } catch (Exception) {
                return AppMedia::getDefaultImage();
            }
        })->shouldCache();
    }

    protected function uploadFolder(): Attribute
    {
        return Attribute::make(
            get: function () {
                $folder = $this->getKey() ? 'members/' . $this->getKey() : 'members';

                return apply_filters('member_account_upload_folder', $folder, $this);
            }
        )->shouldCache();
    }
}
