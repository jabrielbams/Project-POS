<?php

namespace App\Livewire\Admin\Sales;

use Livewire\Component;

/**
 * Sales Table Row Actions - Add edit/delete buttons to sales table
 *
 * This component extends the sales table to add action buttons for edit and delete operations.
 * Dispatches events to open modals in parent SalesHistory component.
 */
class SalesRowActions extends Component
{
    public $sale;
    public $showActionMenu = false;

    public function mount($sale)
    {
        $this->sale = $sale;
    }

    public function openEditModal()
    {
        $this->dispatch('openEditModal', saleId: $this->sale->id);
    }

    public function openDeleteModal()
    {
        $this->dispatch('openDeleteModal', saleId: $this->sale->id);
    }

    public function render()
    {
        return view('livewire.admin.sales.sales-row-actions');
    }
}
