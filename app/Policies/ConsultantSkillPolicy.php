<?php

namespace App\Policies;

use App\ConsultantSkill;
use App\Consultant;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsultantSkillPolicy
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
     * @param  \App\ConsultantSkill  $consultantSkill
     * @return mixed
     */
    public function view(Consultant $Consultant, ConsultantSkill $consultantSkill)
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
     * @param  \App\ConsultantSkill  $consultantSkill
     * @return mixed
     */
    public function update(Consultant $Consultant, ConsultantSkill $consultantSkill)
    {
        //
    }

    /**
     * Determine whether the Consultant can delete the model.
     *
     * @param  \App\Consultant  $Consultant
     * @param  \App\ConsultantSkill  $consultantSkill
     * @return mixed
     */
    public function delete(Consultant $Consultant, ConsultantSkill $consultantSkill)
    {
        //
        return $Consultant->id = $consultantSkill->consultant_id;
    }

    /**
     * Determine whether the Consultant can restore the model.
     *
     * @param  \App\Consultant  $Consultant
     * @param  \App\ConsultantSkill  $consultantSkill
     * @return mixed
     */
    public function restore(Consultant $Consultant, ConsultantSkill $consultantSkill)
    {
        //
    }

    /**
     * Determine whether the Consultant can permanently delete the model.
     *
     * @param  \App\Consultant  $Consultant
     * @param  \App\ConsultantSkill  $consultantSkill
     * @return mixed
     */
    public function forceDelete(Consultant $Consultant, ConsultantSkill $consultantSkill)
    {
        //
    }
}
