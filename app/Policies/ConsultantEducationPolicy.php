<?php

namespace App\Policies;

use App\ConsultantEducation;
use App\Consultant;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsultantEducationPolicy
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
     * @param  \App\ConsultantEducation  $consultantEducation
     * @return mixed
     */
    public function view(Consultant $Consultant, ConsultantEducation $consultantEducation)
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
     * @param  \App\ConsultantEducation  $consultantEducation
     * @return mixed
     */
    public function update(Consultant $Consultant, ConsultantEducation $consultantEducation)
    {
        //
    }

    /**
     * Determine whether the Consultant can delete the model.
     *
     * @param  \App\Consultant  $Consultant
     * @param  \App\ConsultantEducation  $consultantEducation
     * @return mixed
     */
    public function delete(Consultant $Consultant, ConsultantEducation $consultantEducation)
    {
        //
        return $Consultant->id = $consultantEducation->consultant_id;
    }

    /**
     * Determine whether the Consultant can restore the model.
     *
     * @param  \App\Consultant  $Consultant
     * @param  \App\ConsultantEducation  $consultantEducation
     * @return mixed
     */
    public function restore(Consultant $Consultant, ConsultantEducation $consultantEducation)
    {
        //
    }

    /**
     * Determine whether the Consultant can permanently delete the model.
     *
     * @param  \App\Consultant  $Consultant
     * @param  \App\ConsultantEducation  $consultantEducation
     * @return mixed
     */
    public function forceDelete(Consultant $Consultant, ConsultantEducation $consultantEducation)
    {
        //
    }
}
