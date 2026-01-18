<?php

  namespace App\Http\Controllers\User;

  use App\Http\Controllers\Controller;
  use App\Http\Requests\UpdateUrlStatusRequest;
  use App\Http\Requests\UpdateUserRequest;
  use App\Models\Models\Urls\UserShortUrl;
  use App\Models\User;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Log;
  use Inertia\Inertia;
  use Throwable;

  class UserController extends Controller
  {
    public function index(Request $request)
    {
      try {
        $me = $request->user();

        $userShortUrl = UserShortUrl::getListUrlMe($me);

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

        return Inertia::render('user/DashboardUrls', ['urls' => $userShortUrl, 'navItems' => $navItems]);
      } catch (Throwable $e) {
        Log::error($e);
      }
    }

    //#region #REGION PUT-METHOD
    public function updateStatusUser($id, UpdateUrlStatusRequest $request)
    {
      try {
        $me        = $request->user();
        $validated = $request->validated();

        $status = $validated['status'];

        $userShortUrl = User::updateStatus($id, $me, $status);

        if ($userShortUrl['status']) {
          return redirect()->back()->with('success', ['message' => $userShortUrl['message'],]);
        } else {
          return redirect()->back()->withErrors([
            'message' => $userShortUrl['message'],
            'errors'  => $userShortUrl['message']
          ], 500);
        }
      } catch (Throwable $e) {
        Log::error($e);

        return redirect()->back()->withErrors([
          'message' => 'Status update failed',
          'error'   => $e->getMessage(),
        ], 500);
      }
    }

    public function updateStatusUrl($id, UpdateUrlStatusRequest $request)
    {
      try {
        $me        = $request->user();
        $validated = $request->validated();

        $status = $validated['status'];

        $userShortUrl = UserShortUrl::updateStatus($id, $me, $status);

        if ($userShortUrl['status']) {
          return redirect()->back()->with('success', ['message' => $userShortUrl['message'],]);
        } else {
          return redirect()->back()->withErrors([
            'message' => $userShortUrl['message'],
            'errors'  => $userShortUrl['message']
          ], 500);
        }
      } catch (Throwable $e) {
        Log::error($e);

        return redirect()->back()->withErrors([
          'message' => 'Status update failed',
          'error'   => $e->getMessage(),
        ], 500);
      }
    }


    public function updateUser(string $id, UpdateUserRequest $request)
    {
      try {
        $validated = $request->validated();

        $userShortUser = User::edit($id, $validated);

        if ($userShortUser['status']) {
          return redirect()->back()->with('success', ['message' => $userShortUser['message'],]);
        } else {
          return redirect()->back()->withErrors([
            'message' => $userShortUser['message'],
            'errors'  => $userShortUser['message']
          ], 500);
        }
      } catch (Throwable $e) {
        Log::error($e);

        return redirect()->back()->withErrors([
          'message' => 'Status update failed',
          'error'   => $e->getMessage(),
        ], 500);
      }
    }

    //#endregion

    //#region #REGION DELETE-METHOD
    public function removeUser($id)
    {
      try {
        $userShortUrl = User::remove($id);

        if ($userShortUrl['status']) {
          return redirect()->back()->with('success', ['message' => $userShortUrl['message'],]);
        } else {
          return redirect()->back()->withErrors([
            'message' => $userShortUrl['message'],
            'errors'  => $userShortUrl['message']
          ], 500);
        }
      } catch (Throwable $e) {
        Log::error($e);

        return redirect()->back()->withErrors([
          'message' => 'Status update failed',
          'error'   => $e->getMessage(),
        ], 500);
      }
    }

    public function removeUrl($id, Request $request)
    {
      try {
        $me = $request->user();

        $userShortUrl = UserShortUrl::remove($id, $me);

        if ($userShortUrl['status']) {
          return redirect()->back()->with('success', ['message' => $userShortUrl['message'],]);
        } else {
          return redirect()->back()->withErrors([
            'message' => $userShortUrl['message'],
            'errors'  => $userShortUrl['message']
          ], 500);
        }
      } catch (Throwable $e) {
        Log::error($e);

        return redirect()->back()->withErrors([
          'message' => 'Status update failed',
          'error'   => $e->getMessage(),
        ], 500);
      }
    }

    //#endregion
  }
