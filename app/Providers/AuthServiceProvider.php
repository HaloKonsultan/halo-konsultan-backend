<?php

namespace App\Providers;

use App\Consultant;
use App\Consultation;
use App\Policies\ConsultantConsultationPolicy;
use App\Policies\UserConsultationPolicy;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Consultation::class => UserConsultationPolicy::class,
        Consultation::class => ConsultantConsultationPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Gate::define('show-consultant-query', function (Consultant $consultant, $id) {
            return $consultant->id === $id;
        });

        Gate::define('update-data-consultant', function (Consultant $consultant, $id) {
            return $consultant->id === $id;
        });

        Gate::define('update-data-user', function (User $user, $id) {
            return $user->id === $id;
        });

        Gate::define('show-user', function (User $user, $id) {
            return $user->id === $id;
        });
    }
}
