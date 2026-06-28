<?php

namespace App\Actions;

use App\Models\Sale;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class DeleteSaleAction
{
    /**
     * Soft delete a sale and record the audit log.
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
        if (!$user->can('delete', $sale)) {
            throw new \Illuminate\Auth\Access\AuthorizationException('Not authorized to delete this sale');
        }

        // Validation
        $this->validate($sale);

        // Capture values before delete for audit log
        $oldValues = $sale->toArray();

        // Soft delete the sale
        $sale->delete();

        // Record audit log
        AuditLog::create([
            'auditable_type' => Sale::class,
            'auditable_id' => $sale->id,
            'user_id' => $user->id,
            'action' => 'delete',
            'old_values' => $oldValues,
            'new_values' => ['deleted_at' => now()],
            'changed_fields' => ['deleted_at'],
            'reason' => $reason,
        ]);

        return $sale;
    }

    /**
     * Validate delete operation.
     */
    private function validate(Sale $sale): void
    {
        $errors = [];

        // Cannot delete if already deleted
        if ($sale->trashed()) {
            $errors['sale'] = 'This sale is already deleted';
        }

        // Cannot delete if has pending installment payments
        if ($sale->status === 'installment' && $sale->installmentPayments()->count() > 0) {
            $errors['sale'] = 'Cannot delete sales with pending installment payments';
        }

        // Cannot delete sales older than 7 days (configurable)
        $maxDaysOld = config('pos.delete_max_days_old', 7);
        if ($sale->created_at->diffInDays(now()) > $maxDaysOld) {
            $errors['sale'] = "Cannot delete sales older than {$maxDaysOld} days";
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }
}
