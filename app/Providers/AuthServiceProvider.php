<?php

namespace App\Providers;

namespace App\Providers;

use App\Models\User;
use App\Models\Payroll;
use App\Policies\UserPolicy;
use App\Policies\PayrollPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Payroll::class, PayrollPolicy::class);
    }
}