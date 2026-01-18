<?php

  namespace App\Services\Database;

  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Support\Facades\DB;

  class DatabaseMetaService
  {
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
      //
    }

    public static function nextAutoIncrement(Model $model): ?int
    {
      return DB::table('information_schema.TABLES')
        ->where('TABLE_SCHEMA', DB::getDatabaseName())
        ->where('TABLE_NAME', $model->getTable())
        ->value('AUTO_INCREMENT');
    }
  }
