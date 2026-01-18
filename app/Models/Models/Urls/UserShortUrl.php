<?php

  namespace App\Models\Models\Urls;

  use App\Http\Requests\UpdateUrlStatusRequest;
  use Illuminate\Database\Eloquent\Collection;
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\BelongsTo;
  use Illuminate\Database\Eloquent\SoftDeletes;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Log;
  use Throwable;

  class UserShortUrl extends Model
  {
    use SoftDeletes;

    protected $table = 'user_short_urls';


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
      'user_id',
      'short_url_id',
      'count',
      'last_accessed_at',
      'expires_at',
      'status',
    ];

    //#region #REGION : RELATIONSHIP
    public function url(): BelongsTo
    {
      return $this->belongsTo(ShortUrl::class, 'short_url_id');
    }

    //#endregion

    //#region #REGION : GET-METHOD
    public static function getListUrlMe($me): Collection
    {
      return UserShortUrl::query()
        ->with('url')
        ->where('user_id', $me->id)
        ->get();
    }

    public static function getRedirectUrl($code): Model|UserShortUrl
    {
      $userShortUrl = UserShortUrl::query()
        ->with('url:id,origin_url')
        ->whereHas('url', fn($q) => $q->where('code', $code))
        ->where('status', 1)
        ->where(function ($q) {
          $q->whereNull('expires_date')
            ->orWhere('expires_date', '>=', now());
        })
        ->firstOrFail();

      $userShortUrl->increment('count');
      $userShortUrl->update(['last_accessed_at' => now()]);

      return $userShortUrl;
    }

    public static function getRedirectUserUrl($userId, $code): Model|UserShortUrl
    {
      $userShortUrl = UserShortUrl::query()
        ->with('url:id,origin_url')
        ->whereHas('url', fn($q) => $q->where('code', $code))
        ->where('user_id', $userId)
        ->where('status', 1)
        ->where(function ($q) {
          $q->whereNull('expires_date')
            ->orWhere('expires_date', '>=', now());
        })
        ->firstOrFail();

      $userShortUrl->increment('count');
      $userShortUrl->update(['last_accessed_at' => now()]);

      return $userShortUrl;
    }

    //#endregion

    //#region #REGION :  PUT-METHOD
    public static function updateStatus($id, $me, $status): array
    {
      try {
        $updated = UserShortUrl::query()
          ->where('id', $id)
          ->where('user_id', $me->id)
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
    //#endregion

    //#region #REGION : DELETE-METHOD
    public static function remove($id, $me): array
    {
      try {
        $query = self::query()
          ->where('user_id', $me->id)
          ->where('id', (array)$id);

        $count = $query->count();

        if ($count == 0) {
          return [
            'status'  => false,
            'message' => 'No URLs found to delete',
          ];
        }

        $query->delete();

        return [
          'status'  => true,
          'message' => "Deleted URL successfully",
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
