<?php

  namespace App\Models;

  // use Illuminate\Contracts\Auth\MustVerifyEmail;
  use App\Models\Models\Urls\ShortUrl;
  use Database\Factories\UserFactory;
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Relations\BelongsToMany;
  use Illuminate\Database\Eloquent\SoftDeletes;
  use Illuminate\Foundation\Auth\User as Authenticatable;
  use Illuminate\Notifications\Notifiable;
  use Illuminate\Support\Facades\Log;
  use Spatie\Permission\Traits\HasRoles;
  use Throwable;

  class User extends Authenticatable
  {
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
      'name',
      'email',
      'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
      'password',
      'remember_token',
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
        'password'          => 'hashed',
      ];
    }

    public function shortUrls(): BelongsToMany
    {
      return $this->belongsToMany(ShortUrl::class, 'user_short_urls')
        ->withPivot(['expire_date', 'status'])
        ->withTimestamps();
    }

    //#region #REGION : GET-METHOD
    public static function getUserList()
    {
      return self::query()->with('roles')->get();

    }
    //#endregion

    //#region #REGION : PUT-METHOD

    public static function updateStatus($id, mixed $me, mixed $status): array
    {
      try {
        $updated = User::query()
          ->where('id', $id)
          ->update(['status' => $status]);

        if (!$updated) {
          return [
            'status'  => false,
            'message' => 'Status update failed',
          ];
        }

        return ['status' => true, 'message' => 'Status updated successfully'];
      } catch (Throwable $e) {
        Log::error($e);

        return ['status' => false, 'message' => $e->getMessage()];
      }
    }

    public static function edit(string $id, $user): array
    {
      try {
        $updated = self::query()
          ->where('id', $id)
          ->update(['name' => $user['name']]);

        if (!$updated) {
          return [
            'status'  => false,
            'message' => 'User update failed',
          ];
        }

        return ['status' => true, 'message' => 'User updated successfully'];
      } catch (Throwable $e) {
        Log::error($e);

        return ['status' => false, 'message' => $e->getMessage()];
      }
    }
    //#endregion

    //#region #REGION : DELETE-METHOD
    public static function remove($id): array
    {
      try {
        $query = self::query()
          ->where('id', $id);

        $count = $query->count();

        if ($count == 0) {
          return [
            'status'  => false,
            'message' => 'No User found to delete',
          ];
        }

        $query->delete();

        return [
          'status'  => true,
          'message' => "Deleted User successfully",
        ];
      } catch (Throwable $e) {
        Log::error($e);

        return [
          'status'  => false,
          'message' => $e->getMessage(),
        ];
      }
    }


    //#endregion
  }
