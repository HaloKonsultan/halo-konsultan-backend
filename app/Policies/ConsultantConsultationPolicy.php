<?php

namespace App\Policies;

use App\Consultant;
use App\Consultation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsultantConsultationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Consultation  $consultation
     * @return mixed
     */
    public function view(Consultant $consultant, Consultation $consultation)
    {
        //
        return $consultant->id == $consultation->consultant_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Consultation  $consultation
     * @return mixed
     */
    public function update(Consultant $consultant, Consultation $consultation)
    {
        //
        return $consultant->id == $consultation->consultant_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Consultation  $consultation
     * @return mixed
     */
    public function delete(User $user, Consultation $consultation)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Consultation  $consultation
     * @return mixed
     */
    public function restore(User $user, Consultation $consultation)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Consultation  $consultation
     * @return mixed
     */
    public function forceDelete(User $user, Consultation $consultation)
    {
        //
    }
}
