<?php

namespace App\Policies;

use App\Models\Sale;
use App\Models\User;

class SalePolicy
{
    /**
     * Determine if user can view the sale.
     */
    public function view(User $user, Sale $sale): bool
    {
        return true; // All authenticated users can view
    }

    /**
     * Determine if user can edit the sale.
     */
    public function edit(User $user, Sale $sale): bool
    {
        // Cannot edit deleted sales
        if ($sale->trashed()) {
            return false;
        }

        return true;
    }

    /**
     * Determine if user can delete the sale.
     */
    public function delete(User $user, Sale $sale): bool
    {
        return true;
    }

    /**
     * Determine if user can restore the sale.
     */
    public function restore(User $user, Sale $sale): bool
    {
        return true;
    }

    /**
     * Determine if user can view audit log for this sale.
     */
    public function viewAuditLog(User $user, Sale $sale): bool
    {
        return true;
    }
}
