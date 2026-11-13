<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class SecurityHeaders {
 public function handle(Request $request, Closure $next): Response {
  $response=$next($request);
  $response->headers->set('X-Content-Type-Options','nosniff');
  $response->headers->set('Referrer-Policy','strict-origin-when-cross-origin');
  $response->headers->set('X-Frame-Options','DENY');
  $response->headers->set('Permissions-Policy','camera=(), microphone=(), geolocation=()');
  if($request->is('dashboard','curriculum/*/assessment','research/*','authoring*')) {
   $response->headers->set('Cache-Control','private, no-store');
  }
  if($request->isSecure() && app()->environment('production')) {
   $response->headers->set('Strict-Transport-Security','max-age=31536000');
  }
  return $response;
 }
}
