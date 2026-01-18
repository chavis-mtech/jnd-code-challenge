<?php

  namespace App\Http\Controllers\Admin;

  use App\Http\Controllers\Controller;
  use App\Models\Models\Urls\UserShortUrl;
  use App\Models\User;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Log;
  use Inertia\Inertia;
  use Throwable;

  class AdminController extends Controller
  {
    public function index(Request $request)
    {
      try {
        $me = $request->user();

        $userShortUrl = UserShortUrl::getListUrlMe($me);
        $users        = User::getUserList();

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

        return Inertia::render('admin/Admin', ['urls' => $userShortUrl, 'users' => $users, 'navItems' => $navItems]);
      } catch (Throwable $e) {
        Log::error($e);
      }
    }

  }
