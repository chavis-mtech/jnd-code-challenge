<?php

  use App\Http\Controllers\Url\ShortUrlController;
  use App\Http\Controllers\User\UserController;

  Route::prefix('/api')
    ->group(function () {

      Route::prefix('/urls')->middleware(['auth', 'role:user|admin'])->group(function () {
        Route::post('/shorten', [ShortUrlController::class, 'store'])->name('url.store');

        Route::put('/status/{id}', [UserController::class, 'updateStatusUrl'])->name('url.status');

        Route::delete('/{id}', [UserController::class, 'removeUrl'])->name('url.remove');
      });

      Route::prefix('/user')->middleware(['role:admin'])
        ->group(function () {
          Route::put('/status/{id}', [UserController::class, 'updateStatusUser'])->name('admin.user.status');
          Route::put('/{id}', [UserController::class, 'updateUser'])->name('admin.user.update');

          Route::delete('/{id}', [UserController::class, 'removeUser'])->name('admin.user.remove');
        });

    });

  Route::get('/r/{userId}/{code}', [ShortUrlController::class, 'redirectUserUrl'])->name('url.show');

  Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/r/{code}', [ShortUrlController::class, 'redirectUrl'])->name('url.redirect.admin');
  });
