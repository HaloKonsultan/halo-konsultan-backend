<?php

namespace App\Policies;

use App\ConsultantExperience;
use App\Consultant;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsultantExperiencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the Consultant can view any models.
     *
     * @param  \App\Consultant  $Consultant
     * @return mixed
     */
    public function viewAny(Consultant $Consultant)
    {
        //
    }

    /**
     * Determine whether the Consultant can view the model.
     *
     * @param  \App\Consultant  $Consultant
     * @param  \App\ConsultantExperience  $consultantExperience
     * @return mixed
     */
    public function view(Consultant $Consultant, ConsultantExperience $consultantExperience)
    {
        //
    }

    /**
     * Determine whether the Consultant can create models.
     *
     * @param  \App\Consultant  $Consultant
     * @return mixed
     */
    public function create(Consultant $Consultant)
    {
        //
    }

    /**
     * Determine whether the Consultant can update the model.
     *
     * @param  \App\Consultant  $Consultant
     * @param  \App\ConsultantExperience  $consultantExperience
     * @return mixed
     */
    public function update(Consultant $Consultant, ConsultantExperience $consultantExperience)
    {
        //
    }

    /**
     * Determine whether the Consultant can delete the model.
     *
     * @param  \App\Consultant  $Consultant
     * @param  \App\ConsultantExperience  $consultantExperience
     * @return mixed
     */
    public function delete(Consultant $Consultant, ConsultantExperience $consultantExperience)
    {
        //
        return $Consultant->id = $consultantExperience->consultant_id;
    }

    /**
     * Determine whether the Consultant can restore the model.
     *
     * @param  \App\Consultant  $Consultant
     * @param  \App\ConsultantExperience  $consultantExperience
     * @return mixed
     */
    public function restore(Consultant $Consultant, ConsultantExperience $consultantExperience)
    {
        //
    }

    /**
     * Determine whether the Consultant can permanently delete the model.
     *
     * @param  \App\Consultant  $Consultant
     * @param  \App\ConsultantExperience  $consultantExperience
     * @return mixed
     */
    public function forceDelete(Consultant $Consultant, ConsultantExperience $consultantExperience)
    {
        //
    }
}
