<?php

namespace App\Support;

use App\Models\Organization;
use App\Models\User;

final class OrganizationAccess
{
    private const PERMISSIONS = [
        'organization_admin' => ['organization.view', 'members.view', 'members.manage'],
        'teacher' => ['organization.view'],
        'learner' => ['organization.view'],
        'curriculum_developer' => ['organization.view'],
        'researcher' => ['organization.view'],
    ];

    public function allows(User $user, Organization $organization, string $permission): bool
    {
        if (! $user->is_active || ! $organization->is_active) {
            return false;
        }

        return $user->memberships()
            ->where('organization_id', $organization->getKey())
            ->where('is_active', true)
            ->get()
            ->contains(fn ($membership): bool => in_array(
                $permission,
                self::PERMISSIONS[$membership->role] ?? [],
                true
            ));
    }
}
