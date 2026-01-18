<?php

  namespace App\Models\Models\Urls;

  use App\Models\User;
  use App\Services\Database\DatabaseMetaService;
  use App\Services\ShortUrlService;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\BelongsToMany;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Facades\Log;
  use Throwable;

  class ShortUrl extends Model
  {

    protected $table = 'short_urls';

    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
      'code',
      'origin_url',
    ];

    public function users(): BelongsToMany
    {
      return $this->belongsToMany(User::class, 'user_short_urls')
        ->withPivot(['expire_date', 'status'])
        ->withTimestamps();
    }

    /**
     * @throws Throwable
     */
    public static function store($me, $url): array
    {
      try {
        $id = DatabaseMetaService::nextAutoIncrement(new ShortUrl());

        $code = ShortUrlService::generate($id);

        DB::beginTransaction();

        $shortUrl = ShortUrl::firstOrCreate(
          ['origin_url' => $url],
          [
            'code' => $code,
          ]
        );
        $shortUrl->users()->syncWithoutDetaching([
          $me->id => [
            'status'       => true,
            'expires_date' => now()->addMonth(),
          ],
        ]);;

        DB::commit();

        return [
          'status'  => true,
          'message' => 'Short URL created successfully 🎉',
          'data'    => [
            'originalUrl' => $url,
            'shortCode'   => $shortUrl->code,
            'shortUrl'    => url("/r/{$me->id}{$shortUrl->code}"),
          ]
        ];
      } catch (Throwable $e) {
        DB::rollBack();
        Log::error($e);

        throw $e;
      }
    }

  }
