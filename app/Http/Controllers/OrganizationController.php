<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Support\OrganizationAccess;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    public function index(Request $request): View
    {
        $organizations = Organization::query()
            ->where('is_active', true)
            ->whereHas('memberships', function ($query) use ($request): void {
                $query->where('user_id', $request->user()->getKey())
                    ->where('is_active', true);
            })
            ->orderBy('name')
            ->get();

        return view('organizations.index', compact('organizations'));
    }

    public function show(Request $request, Organization $organization, OrganizationAccess $access): View
    {
        abort_unless($access->allows($request->user(), $organization, 'organization.view'), 404);

        return view('organizations.show', compact('organization'));
    }

    public function members(Request $request, Organization $organization, OrganizationAccess $access): View
    {
        abort_unless($access->allows($request->user(), $organization, 'members.view'), 404);

        $memberships = $organization->memberships()->with('user:id,name,email')->orderBy('id')->get();

        return view('organizations.members', compact('organization', 'memberships'));
    }
}
