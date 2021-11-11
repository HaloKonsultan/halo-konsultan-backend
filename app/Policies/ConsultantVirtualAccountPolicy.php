<?php

namespace App\Policies;

use App\Consultant;
use App\ConsultantVirtualAccount;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsultantVirtualAccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the Consultant
     *  can view any models.
     *
     * @param  \App\Consultant
     *   $Consultant
     * 
     * @return mixed
     */
    public function viewAny(Consultant $consultant)
    {
        //
    }

    /**
     * Determine whether the Consultant
     *  can view the model.
     *
     * @param  \App\Consultant
     *   $Consultant
     * 
     * @param  \App\ConsultantVirtualAccount  $consultantVirtualAccount
     * @return mixed
     */
    public function view(Consultant $consultant, ConsultantVirtualAccount $consultantVirtualAccount)
    {
        //
    }

    /**
     * Determine whether the Consultant
     *  can create models.
     *
     * @param  \App\Consultant
     *   $Consultant
     * 
     * @return mixed
     */
    public function create(Consultant $consultant)
    {
        //
    }

    /**
     * Determine whether the Consultant
     *  can update the model.
     *
     * @param  \App\Consultant
     *   $Consultant
     * 
     * @param  \App\ConsultantVirtualAccount  $consultantVirtualAccount
     * @return mixed
     */
    public function update(Consultant $consultant, ConsultantVirtualAccount $consultantVirtualAccount)
    {
        //
    }

    /**
     * Determine whether the Consultant
     *  can delete the model.
     *
     * @param  \App\Consultant
     *   $Consultant
     * 
     * @param  \App\ConsultantVirtualAccount  $consultantVirtualAccount
     * @return mixed
     */
    public function delete(Consultant $consultant, ConsultantVirtualAccount $consultantVirtualAccount)
    {
        //
        return $consultant->id = $consultantVirtualAccount->consultant_id;
    }

    /**
     * Determine whether the Consultant
     *  can restore the model.
     *
     * @param  \App\Consultant
     *   $Consultant
     * 
     * @param  \App\ConsultantVirtualAccount  $consultantVirtualAccount
     * @return mixed
     */
    public function restore(Consultant $consultant, ConsultantVirtualAccount $consultantVirtualAccount)
    {
        //
    }

    /**
     * Determine whether the Consultant
     *  can permanently delete the model.
     *
     * @param  \App\Consultant
     *   $Consultant
     * 
     * @param  \App\ConsultantVirtualAccount  $consultantVirtualAccount
     * @return mixed
     */
    public function forceDelete(Consultant $consultant, ConsultantVirtualAccount $consultantVirtualAccount)
    {
        //
    }
}
