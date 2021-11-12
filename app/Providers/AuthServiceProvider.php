<?php

namespace App\Providers;

use App\Consultant;
use App\ConsultantDocumentation;
use App\ConsultantEducation;
use App\ConsultantExperience;
use App\ConsultantSkill;
use App\ConsultantVirtualAccount;
use App\Consultation;
use App\ConsultationDocument;
use App\Policies\ConsultantConsultationPolicy;
use App\Policies\ConsultantDocumentationPolicy;
use App\Policies\ConsultantEducationPolicy;
use App\Policies\ConsultantExperiencePolicy;
use App\Policies\ConsultantSkillPolicy;
use App\Policies\ConsultantVirtualAccountPolicy;
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
        Consultation::class => ConsultantConsultationPolicy::class,
        ConsultantVirtualAccount::class => ConsultantVirtualAccountPolicy::class,
        ConsultantEducation::class => ConsultantEducationPolicy::class,
        ConsultantDocumentation::class => ConsultantDocumentationPolicy::class,
        ConsultantExperience::class => ConsultantExperiencePolicy::class,
        ConsultantSkill::class => ConsultantSkillPolicy::class
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
