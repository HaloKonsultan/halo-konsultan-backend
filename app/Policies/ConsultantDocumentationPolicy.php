<?php

namespace App\Policies;

use App\ConsultantDocumentation;
use App\Consultant;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsultantDocumentationPolicy
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
     * @param  \App\ConsultantDocumentation  $consultantDocumentation
     * @return mixed
     */
    public function view(Consultant $Consultant, ConsultantDocumentation $consultantDocumentation)
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
     * @param  \App\ConsultantDocumentation  $consultantDocumentation
     * @return mixed
     */
    public function update(Consultant $Consultant, ConsultantDocumentation $consultantDocumentation)
    {
        //
    }

    /**
     * Determine whether the Consultant can delete the model.
     *
     * @param  \App\Consultant  $Consultant
     * @param  \App\ConsultantDocumentation  $consultantDocumentation
     * @return mixed
     */
    public function delete(Consultant $Consultant, ConsultantDocumentation $consultantDocumentation)
    {
        //
        return $Consultant->id = $consultantDocumentation->consultant_id;
    }

    /**
     * Determine whether the Consultant can restore the model.
     *
     * @param  \App\Consultant  $Consultant
     * @param  \App\ConsultantDocumentation  $consultantDocumentation
     * @return mixed
     */
    public function restore(Consultant $Consultant, ConsultantDocumentation $consultantDocumentation)
    {
        //
    }

    /**
     * Determine whether the Consultant can permanently delete the model.
     *
     * @param  \App\Consultant  $Consultant
     * @param  \App\ConsultantDocumentation  $consultantDocumentation
     * @return mixed
     */
    public function forceDelete(Consultant $Consultant, ConsultantDocumentation $consultantDocumentation)
    {
        //
    }
}
