<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        // 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function docente()
    {
        return $this->hasOne(Docente::class);
    }

    public static function getUserData($perPage = 10)
    {
        return self::withTrashed()
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COALESCE(roles.name, \'No\') AS role'),
                DB::raw('CASE WHEN users.deleted_at IS NULL THEN \'Activo\' ELSE \'Eliminado\' END as estado')
            )
            ->orderBy('users.id')
            ->simplePaginate($perPage);
    }

    public static function filterUsers(array $filters)
    {
        $users = self::query()
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->when(!empty($filters['name']), function ($query) use ($filters) {
                $query->whereRaw('LOWER(users.name) LIKE ?', ['%' . strtolower($filters['name']) . '%']);
            })
            ->when(!empty($filters['email']), function ($query) use ($filters) {
                $query->whereRaw('LOWER(users.email) LIKE ?', ['%' . strtolower($filters['email']) . '%']);
            })
            ->when(!empty($filters['role']), function ($query) use ($filters) {
                $query->whereRaw('LOWER(roles.name) = ?', [strtolower($filters['role'])]);
            })
            ->when(!empty($filters['estado']), function ($query) use ($filters) {
                if ($filters['estado'] === 'Activo') {
                    $query->whereNull('users.deleted_at');
                } elseif ($filters['estado'] === 'Eliminado') {
                    $query->whereNotNull('users.deleted_at');
                }
            })
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COALESCE(roles.name, \'No\') AS role'),
                DB::raw('CASE WHEN users.deleted_at IS NULL THEN \'Activo\' ELSE \'Eliminado\' END as estado')
            );

        return $users->paginate(10);
    }
}
