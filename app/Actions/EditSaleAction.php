<?php

namespace App\Actions;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class EditSaleAction
{
    /**
     * Edit a sale and record the audit log.
     *
     * @param Sale $sale
     * @param array $data - ['amount_paid', 'notes', 'payment_method', 'status']
     * @param User $user
     * @param string|null $reason
     * @return Sale
     * @throws ValidationException
     */
    public function execute(Sale $sale, array $data, User $user, ?string $reason = null): Sale
    {
        // Authorization check
        if (!$user->can('edit', $sale)) {
            throw new \Illuminate\Auth\Access\AuthorizationException('Not authorized to edit this sale');
        }

        // Validation
        $this->validate($sale, $data);

        $newTotalAmount = isset($data['total_amount']) ? (float) $data['total_amount'] : (float) $sale->total_amount;
        $newAmountPaid  = isset($data['amount_paid'])  ? (float) $data['amount_paid']  : (float) $sale->amount_paid;
        $newAmountDue   = max(0, $newTotalAmount - $newAmountPaid);

        // Capture old values for audit log
        $oldValues     = $sale->only(['total_amount', 'amount_paid', 'amount_due', 'notes', 'payment_method']);
        $changedFields = array_keys(array_diff_assoc(
            [
                'total_amount'   => $newTotalAmount,
                'amount_paid'    => $newAmountPaid,
                'notes'          => $data['notes'] ?? $sale->notes,
                'payment_method' => $data['payment_method'] ?? $sale->payment_method,
            ],
            $sale->only(['total_amount', 'amount_paid', 'notes', 'payment_method'])
        ));

        // Update the sale (status intentionally excluded — keeps original)
        $sale->update([
            'total_amount'   => $newTotalAmount,
            'amount_paid'    => $newAmountPaid,
            'amount_due'     => $newAmountDue,
            'notes'          => $data['notes'] ?? $sale->notes,
            'payment_method' => $data['payment_method'] ?? $sale->payment_method,
            'last_edited_by' => $user->id,
            'last_edited_at' => now(),
        ]);

        // If total_amount changed, scale each sale item's unit_price proportionally
        // so that the per-row profit (unit_price - cost) * qty stays consistent with the new total
        $oldTotal = (float) $oldValues['total_amount'];
        if ($oldTotal > 0 && abs($newTotalAmount - $oldTotal) > 0.001) {
            $ratio = $newTotalAmount / $oldTotal;
            $sale->saleItems()->each(function (SaleItem $item) use ($ratio) {
                $item->update([
                    'unit_price' => round((float) $item->unit_price * $ratio, 2),
                    'subtotal'   => round((float) $item->unit_price * $ratio * $item->qty, 2),
                ]);
            });
        }

        // Record audit log
        AuditLog::create([
            'auditable_type' => Sale::class,
            'auditable_id'   => $sale->id,
            'user_id'        => $user->id,
            'action'         => 'edit',
            'old_values'     => $oldValues,
            'new_values'     => $sale->only(['total_amount', 'amount_paid', 'amount_due', 'notes', 'payment_method']),
            'changed_fields' => $changedFields,
            'reason'         => $reason,
        ]);

        return $sale;
    }

    /**
     * Validate edit data.
     */
    private function validate(Sale $sale, array $data): void
    {
        $errors = [];

        $newTotal = isset($data['total_amount']) ? (float) $data['total_amount'] : (float) $sale->total_amount;
        $newPaid  = isset($data['amount_paid'])  ? (float) $data['amount_paid']  : (float) $sale->amount_paid;

        // total_amount validation
        if (isset($data['total_amount']) && $newTotal <= 0) {
            $errors['total_amount'] = 'Total amount must be greater than 0';
        }

        // amount_paid must not exceed the new total
        if ($newPaid < 0 || $newPaid > $newTotal) {
            $errors['amount_paid'] = 'Amount paid must be between 0 and ' . $newTotal;
        }

        // payment_method validation
        if (isset($data['payment_method']) && !in_array($data['payment_method'], ['cash', 'qris', 'transfer'])) {
            $errors['payment_method'] = 'Invalid payment method';
        }

        // notes validation
        if (isset($data['notes']) && strlen($data['notes'] ?? '') > 255) {
            $errors['notes'] = 'Notes cannot exceed 255 characters';
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }
}
