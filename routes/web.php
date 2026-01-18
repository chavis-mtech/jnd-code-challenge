<?php

  use App\Http\Controllers\Admin\AdminController;
  use App\Http\Controllers\Url\ShortUrlController;
  use App\Http\Controllers\User\UserController;
  use Illuminate\Support\Facades\Route;
  use Inertia\Inertia;

  Route::prefix('/auth')->middleware('guest')
    ->group(function () {
      Route::get('/sign-in', fn() => Inertia::render('auth/SignIn'))->name('sign-in');
      Route::get('/sign-up', fn() => Inertia::render('auth/SignUp'))->name('sign-up');
      Route::get('/forgot-password', fn() => Inertia::render('auth/ForgotPassword'))->name('forgot-password');
    });

  Route::prefix('/')
    ->group(function () {
      Route::get('/welcome', fn() => Inertia::render('Welcome'))->name('welcome');

      Route::middleware(['auth', 'role:user|admin'])->group(function () {
        Route::get('/', [ShortUrlController::class, 'index'])->name('home');
        Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
      });

      Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
      });

    });

  require __DIR__ . '/actions.php';
