<?php

namespace App\Livewire\Admin\Sales;

use App\Models\Sale;
use App\Actions\EditSaleAction;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

class EditSaleModal extends Component
{
    public $showModal = false;
    public $editingSale = null;

    public $amount_paid = 0;
    public $total_amount = 0;
    public $payment_method = 'cash';
    public $notes = '';

    protected $rules = [
        'total_amount'   => 'required|numeric|min:1',
        'amount_paid'    => 'required|numeric|min:0',
        'payment_method' => 'required|in:cash,qris,transfer',
        'notes'          => 'nullable|string|max:255',
    ];

    #[On('openEditModal')]
    public function openModal($saleId)
    {
        $sale = Sale::findOrFail($saleId);

        $this->editingSale  = $sale;
        $this->total_amount  = $sale->total_amount;
        $this->amount_paid   = $sale->amount_paid;
        $this->payment_method = $sale->payment_method;
        $this->notes         = $sale->notes;
        $this->showModal     = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function submitEdit()
    {
        $this->validate();

        try {
            $action = new EditSaleAction();
            $action->execute(
                $this->editingSale,
                [
                    'total_amount'   => $this->total_amount,
                    'amount_paid'    => $this->amount_paid,
                    'payment_method' => $this->payment_method,
                    'notes'          => $this->notes,
                ],
                auth()->user()
            );

            $this->dispatch('saleUpdated', saleId: $this->editingSale->id);
            $this->dispatch('notify', message: 'Sale updated successfully', type: 'success');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: $e->getMessage(), type: 'error');
        }
    }

    private function resetForm()
    {
        $this->total_amount   = 0;
        $this->amount_paid    = 0;
        $this->payment_method = 'cash';
        $this->notes          = '';
    }

    public function render()
    {
        return view('livewire.admin.sales.edit-sale-modal');
    }
}
