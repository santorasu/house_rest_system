<?php

namespace App\Domains\User\Controllers;

use App\Domains\User\Requests\RequestTenancyRequest;
use App\Domains\User\Resources\TenantResource;
use App\Domains\User\Services\TenantService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function __construct(
        private TenantService $tenantService
    ) {}

    public function index(Request $request)
    {
        $tenancies = $request->user()->tenancies;

        return TenantResource::collection($tenancies);
    }

    public function store(RequestTenancyRequest $request)
    {
        $tenant = $this->tenantService->requestTenancy(
            $request->user()->id,
            $request->validated('owner_id'),
            $request->validated('property_id'),
            $request->validated('lease_start_date')
        );

        return new TenantResource($tenant);
    }
}
