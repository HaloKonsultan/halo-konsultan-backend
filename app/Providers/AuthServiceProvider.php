<?php

namespace App\Providers;

use App\Consultant;
use App\Consultation;
use App\ConsultationDocument;
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

        Gate::define('user-consultation', function (User $user, 
        Consultation $consultation) {
            return $user->id === $consultation->user_id;
        });

        Gate::define('user-consultation-document', function (User $user, 
        Consultation $consultation, ConsultationDocument $consultationDocument) {
            if($user->id === $consultation->user_id && 
            $consultation->id == $consultationDocument->consultation_id) {
                return true;
            }
            return false;
        });
    }
}
