<?php

namespace App\Actions;

use App\Models\Sale;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class RestoreSaleAction
{
    /**
     * Restore a soft-deleted sale and record the audit log.
     *
     * @param Sale $sale
     * @param User $user
     * @param string|null $reason
     * @return Sale
     * @throws ValidationException
     */
    public function execute(Sale $sale, User $user, ?string $reason = null): Sale
    {
        // Authorization check
        if (!$user->can('restore', $sale)) {
            throw new \Illuminate\Auth\Access\AuthorizationException('Not authorized to restore this sale');
        }

        // Validation
        $this->validate($sale);

        // Capture values before restore for audit log
        $oldValues = $sale->only(['deleted_at']);

        // Restore the sale
        $sale->restore();

        // Record audit log
        AuditLog::create([
            'auditable_type' => Sale::class,
            'auditable_id' => $sale->id,
            'user_id' => $user->id,
            'action' => 'restore',
            'old_values' => $oldValues,
            'new_values' => ['deleted_at' => null],
            'changed_fields' => ['deleted_at'],
            'reason' => $reason,
        ]);

        return $sale;
    }

    /**
     * Validate restore operation.
     */
    private function validate(Sale $sale): void
    {
        $errors = [];

        // Sale must be soft-deleted
        if (!$sale->trashed()) {
            $errors['sale'] = 'This sale is not deleted';
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }
}
