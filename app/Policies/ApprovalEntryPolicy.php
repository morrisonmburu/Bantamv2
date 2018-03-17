<?php

namespace App\Policies;

use App\User;
use App\ApprovalEntry;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApprovalEntryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the approvalEntry.
     *
     * @param  \App\User  $user
     * @param  \App\ApprovalEntry  $approvalEntry
     * @return mixed
     */
    public function view(User $user, ApprovalEntry $approvalEntry)
    {
        return (
          $user->Employee_Record->approvals->contains($approvalEntry)
        );
    }

    /**
     * Determine whether the user can create approvalEntries.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the approvalEntry.
     *
     * @param  \App\User  $user
     * @param  \App\ApprovalEntry  $approvalEntry
     * @return mixed
     */
    public function update(User $user, ApprovalEntry $approvalEntry)
    {
        //
    }

    /**
     * Determine whether the user can delete the approvalEntry.
     *
     * @param  \App\User  $user
     * @param  \App\ApprovalEntry  $approvalEntry
     * @return mixed
     */
    public function delete(User $user, ApprovalEntry $approvalEntry)
    {
        //
    }
}
