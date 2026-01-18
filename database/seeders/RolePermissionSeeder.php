<?php

  namespace Database\Seeders;

  use App\Models\User;
  use Illuminate\Database\Seeder;
  use Illuminate\Support\Facades\Hash;
  use Spatie\Permission\Models\Role;
  use Spatie\Permission\PermissionRegistrar;

  class RolePermissionSeeder extends Seeder
  {
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      app()[PermissionRegistrar::class]->forgetCachedPermissions();
      //
      // // Permissions
      // $permissions = [
      //   'create short url',
      //   'view own short url',
      //   'delete own short url',
      //
      //   'view all short urls',
      //   'delete any short url',
      // ];
      //
      // foreach ($permissions as $permission) {
      //   Permission::firstOrCreate([
      //     'name'       => $permission,
      //     'guard_name' => 'web',
      //   ]);
      // }

      // Roles
      Role::firstOrCreate([
        'name'       => 'user',
        'guard_name' => 'web',
      ]);

      $adminRole = Role::firstOrCreate([
        'name'       => 'admin',
        'guard_name' => 'web',
      ]);

      $admin = User::firstOrCreate(
        [
          'email' => 'm-short@gmail.com',
        ],
        [
          'name'     => 'Admin',
          'password' => Hash::make('12341234'),
        ]
      );

      if (!$admin->hasRole('admin')) {
        $admin->assignRole($adminRole);
      }

      // // Assign permissions
      // $user->givePermissionTo([
      //   'create short url',
      //   'view own short url',
      //   'delete own short url',
      // ]);

      // $admin->givePermissionTo(Permission::all());
    }
  }
