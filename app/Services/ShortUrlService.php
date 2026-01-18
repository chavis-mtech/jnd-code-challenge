<?php

  namespace App\Services;

  use Base62\Base62;
  use Exception;

  class ShortUrlService
  {
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
      //
    }

    /**
     * @throws Exception
     */
    public static function generate(int $number)
    {
      try {
        $base62 = new Base62();

        return $base62->encode($number);
      } catch (Exception $err) {
        throw $err;
      }
    }
  }
