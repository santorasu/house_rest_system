<?php

namespace App\Providers;

use App\Domains\User\Models\Tenant;
use App\Domains\User\Models\UserProfile;
use App\Domains\User\Models\UserVerification;
use App\Domains\User\Policies\TenantPolicy;
use App\Domains\User\Policies\UserProfilePolicy;
use App\Domains\User\Policies\UserVerificationPolicy;
use App\Domains\User\Repositories\Interfaces\TenantRepositoryInterface;
use App\Domains\User\Repositories\Interfaces\UserProfileRepositoryInterface;
use App\Domains\User\Repositories\Interfaces\UserVerificationRepositoryInterface;
use App\Domains\User\Repositories\TenantRepository;
use App\Domains\User\Repositories\UserProfileRepository;
use App\Domains\User\Repositories\UserVerificationRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domains\User\Repositories\Interfaces\UserRepositoryInterface::class,
            \App\Domains\User\Repositories\UserRepository::class
        );

        $this->app->bind(
            UserProfileRepositoryInterface::class,
            UserProfileRepository::class
        );

        $this->app->bind(
            UserVerificationRepositoryInterface::class,
            UserVerificationRepository::class
        );

        $this->app->bind(
            TenantRepositoryInterface::class,
            TenantRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(UserProfile::class, UserProfilePolicy::class);
        Gate::policy(UserVerification::class, UserVerificationPolicy::class);
        Gate::policy(Tenant::class, TenantPolicy::class);
    }
}
