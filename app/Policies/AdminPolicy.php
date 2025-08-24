<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can upload files.
     *
     * @return mixed
     */
    public function uploadFiles(?Admin $admin)
    {
        return true;
    }
}
