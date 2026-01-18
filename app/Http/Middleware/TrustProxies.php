<?php

  namespace App\Http\Middleware;

  use Closure;
  use Illuminate\Http\Request;
  use Symfony\Component\HttpFoundation\Response;

  class TrustProxies
  {
    /**
     * Trust all proxies (required for Vercel, Cloudflare, etc.)
     */
    protected $proxies = '*';

    /**
     * Headers that should be used to detect proxies
     */
    protected $headers =
      Request::HEADER_X_FORWARDED_FOR |
      Request::HEADER_X_FORWARDED_HOST |
      Request::HEADER_X_FORWARDED_PORT |
      Request::HEADER_X_FORWARDED_PROTO;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      return $next($request);
    }
  }
