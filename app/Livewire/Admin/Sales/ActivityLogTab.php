<?php

namespace App\Livewire\Admin\Sales;

use App\Models\Sale;
use App\Models\AuditLog;
use Livewire\Component;

class ActivityLogTab extends Component
{
    public $sale = null;
    public $auditLogs = [];

    public function mount(Sale $sale)
    {
        $this->sale = $sale;
        $this->loadAuditLogs();
    }

    public function loadAuditLogs()
    {
        $this->auditLogs = AuditLog::forSale($this->sale->id)
            ->with('user')
            ->get()
            ->toArray();
    }

    public function getActivityLabel($action)
    {
        return match($action) {
            'edit' => 'Edited',
            'delete' => 'Deleted',
            'restore' => 'Restored',
            default => ucfirst($action),
        };
    }

    public function formatValue($value)
    {
        if (is_array($value) || is_object($value)) {
            return json_encode($value, JSON_PRETTY_PRINT);
        }
        return $value;
    }

    public function render()
    {
        return view('livewire.admin.sales.activity-log-tab');
    }
}
