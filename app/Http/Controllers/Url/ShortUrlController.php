<?php

  namespace App\Http\Controllers\Url;

  use App\Http\Controllers\Controller;
  use App\Http\Requests\StoreShortUrlRequest;
  use App\Models\Models\Urls\ShortUrl;
  use App\Models\Models\Urls\UserShortUrl;
  use App\Services\Database\DatabaseMetaService;
  use App\Services\ShortUrlService;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Facades\Log;
  use Inertia\Inertia;
  use Throwable;

  class ShortUrlController extends Controller
  {

    public function index(Request $request)
    {
      try {
        $me = $request->user();

        if ($me->hasRole('admin')) {
          $navItems = [
            ['label' => 'Home', 'href' => route('home', [], false)],
            ['label' => 'Dashboard', 'href' => route('dashboard', [], false)],
            ['label' => 'Admin', 'href' => route('admin', [], false)],
          ];
        } else {
          $navItems = [
            ['label' => 'Home', 'href' => route('home', [], false)],
            ['label' => 'Dashboard', 'href' => route('dashboard', [], false)],
          ];
        }

        return Inertia::render('urls/ShortUrls', ['navItems' => $navItems]);
      } catch (Throwable $e) {
        Log::error($e);
      }
    }

    public function redirectUrl($code)
    {
      try {
        $userShortUrl = UserShortUrl::getRedirectUrl($code);

        return redirect($userShortUrl->url->origin_url);
      } catch (Throwable $e) {
        Log::error($e);
        return redirect(route('home'));
      }
    }

    public function redirectUserUrl($userId, $code)
    {
      try {
        $userShortUrl = UserShortUrl::getRedirectUserUrl($userId, $code);

        return redirect($userShortUrl->url->origin_url);
      } catch (Throwable $e) {
        Log::error($e);
        return redirect(route('home'));
      }
    }

    /**
     * @throws Throwable
     */
    public function store(StoreShortUrlRequest $request)
    {
      try {
        $me        = $request->user();
        $validated = $request->validated();

        $url = $validated['url'];

        $shortUrl = ShortUrl::store($me, $url);

        return redirect()->back()->with('success', [
          'message' => $shortUrl['message'],
          'data'    => $shortUrl['data'],
        ]);
      } catch (Throwable $e) {
        DB::rollBack();
        Log::error($e);

        return redirect()->back()->withErrors([
          'message' => 'Failed to create short URL',
          'error'   => $e->getMessage(),
        ], 500);
      }
    }
  }
