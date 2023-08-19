<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Report;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    
    public function view(User $user, Report $report)
    {
        return true; 
    }

    /**
     * Determine whether the user can create report.
     *
     * @param  \App\User  $user
     * @param  \App\report  $report
     * @return mixed
     */
    public function create(User $user, Report $report)
    {
        // Update $user authorization to create $report here.
        return true;
    }

    /**
     * Determine whether the user can update the report.
     *
     * @param  \App\User  $user
     * @param  \App\report  $report
     * @return mixed
     */
    public function update(User $user, Report $report)
    {
        // Update $user authorization to update $report here.
        return true;
    }

    /**
     * Determine whether the user can delete the report.
     *
     * @param  \App\User  $user
     * @param  \App\report  $report
     * @return mixed
     */
    public function delete(User $user, Report $report)
    {
        // Update $user authorization to delete $report here.
        return true;
    }
}
