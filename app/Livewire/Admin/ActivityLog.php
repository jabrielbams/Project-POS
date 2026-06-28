<?php

namespace App\Livewire\Admin;

use App\Models\AuditLog;
use Livewire\Component;
use Livewire\WithPagination;

class ActivityLog extends Component
{
    use WithPagination;

    public $search = '';
    public $filterAction = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterAction()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = AuditLog::with('user')
            ->orderByDesc('created_at');

        if (!empty($this->search)) {
            $searchTerm = strtolower($this->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('user', function ($q2) use ($searchTerm) {
                    $q2->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
                })
                ->orWhere('auditable_id', 'like', '%' . $searchTerm . '%')
                ->orWhere('reason', 'like', '%' . $searchTerm . '%');
            });
        }

        if (!empty($this->filterAction)) {
            $query->where('action', $this->filterAction);
        }

        $logs = $query->paginate(15);

        return view('livewire.admin.activity-log', [
            'logs' => $logs,
        ])->layout('layouts.admin', ['title' => 'Activity Log - Project POS']);
    }
}
