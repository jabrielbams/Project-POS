<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_logs';
    protected $fillable = [
        'auditable_type',
        'auditable_id',
        'user_id',
        'action',
        'old_values',
        'new_values',
        'changed_fields',
        'reason',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'json',
            'new_values' => 'json',
            'changed_fields' => 'json',
        ];
    }

    /**
     * Get the user that made this change.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: Get audit logs for a specific sale.
     */
    public function scopeForSale(Builder $query, int $saleId): Builder
    {
        return $query->where('auditable_type', Sale::class)
                     ->where('auditable_id', $saleId)
                     ->orderByDesc('created_at');
    }

    /**
     * Scope: Get only edit actions.
     */
    public function scopeEdits(Builder $query): Builder
    {
        return $query->where('action', 'edit');
    }

    /**
     * Scope: Get only delete actions.
     */
    public function scopeDeletes(Builder $query): Builder
    {
        return $query->where('action', 'delete');
    }

    /**
     * Scope: Get only restore actions.
     */
    public function scopeRestores(Builder $query): Builder
    {
        return $query->where('action', 'restore');
    }
}
