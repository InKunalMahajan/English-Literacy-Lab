<?php
namespace Tests\Feature;
use Tests\TestCase;
class SecurityHeadersTest extends TestCase {
 public function test_public_pages_send_security_headers(): void {
  $response=$this->get('/');
  $response->assertOk()->assertHeader('X-Content-Type-Options','nosniff')
   ->assertHeader('X-Frame-Options','DENY')
   ->assertHeader('Referrer-Policy','strict-origin-when-cross-origin');
 }
 public function test_research_routes_are_not_cached(): void {
  $response=$this->get('/research/consent');
  $response->assertRedirect('/login');
  $response->assertHeader('Cache-Control', function (string $value): bool {
   $directives = array_map('trim', explode(',', strtolower($value)));
   return in_array('private', $directives, true) && in_array('no-store', $directives, true);
  });
 }
}
