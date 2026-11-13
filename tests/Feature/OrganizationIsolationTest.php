<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\OrganizationMembership;
use App\Models\User;
use App\Support\OrganizationAccess;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationIsolationTest extends TestCase
{
    use RefreshDatabase;

    private function member(Organization $organization, string $role = 'teacher'): User
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => uniqid('user-', true).'@example.test',
            'password' => 'development-password',
        ]);

        OrganizationMembership::create([
            'organization_id' => $organization->id,
            'user_id' => $user->id,
            'role' => $role,
            'is_active' => true,
        ]);

        return $user;
    }

    public function test_members_only_see_their_own_organizations(): void
    {
        $first = Organization::create(['name' => 'First School', 'slug' => 'first-school']);
        $second = Organization::create(['name' => 'Second School', 'slug' => 'second-school']);
        $user = $this->member($first);

        $this->actingAs($user)->get('/organizations')
            ->assertOk()
            ->assertSee('First School')
            ->assertDontSee('Second School');

        $this->get('/organizations/'.$second->id)->assertNotFound();
    }

    public function test_only_organization_admin_can_view_member_directory(): void
    {
        $organization = Organization::create(['name' => 'School', 'slug' => 'school']);
        $teacher = $this->member($organization);
        $this->actingAs($teacher)->get('/organizations/'.$organization->id.'/members')->assertNotFound();

        $admin = $this->member($organization, 'organization_admin');
        $this->assertDatabaseHas('organization_memberships', [
            'organization_id' => $organization->id,
            'user_id' => $admin->id,
            'role' => 'organization_admin',
            'is_active' => true,
        ]);
        $this->assertTrue(
            app(OrganizationAccess::class)->allows($admin, $organization, 'members.view'),
            'An active organization_admin should have members.view permission.'
        );
        $this->actingAs($admin)->get('/organizations/'.$organization->id)->assertOk();
        $this->get('/organizations/'.$organization->id.'/members')->assertOk();
    }

    public function test_inactive_membership_and_inactive_organization_are_denied(): void
    {
        $organization = Organization::create(['name' => 'School', 'slug' => 'school']);
        $user = $this->member($organization);
        $membership = $user->memberships()->firstOrFail();
        $membership->update(['is_active' => false]);

        $this->actingAs($user)->get('/organizations/'.$organization->id)->assertNotFound();

        $membership->update(['is_active' => true]);
        $organization->update(['is_active' => false]);
        $this->get('/organizations/'.$organization->id)->assertNotFound();
    }
}
