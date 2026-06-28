<?php

namespace App\Livewire\Admin\Sales;

use App\Models\Sale;
use App\Actions\DeleteSaleAction;
use Livewire\Attributes\On;
use Livewire\Component;

class DeleteSaleModal extends Component
{
    public $showModal = false;
    public $deletingSale = null;
    public $reason = '';

    #[On('openDeleteModal')]
    public function openModal($saleId)
    {
        $sale = Sale::findOrFail($saleId);

        $this->deletingSale = $sale;
        $this->reason = '';
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function submitDelete()
    {
        try {
            $action = new DeleteSaleAction();
            $action->execute(
                $this->deletingSale,
                auth()->user(),
                $this->reason ?: null
            );

            $this->dispatch('saleDeleted', saleId: $this->deletingSale->id);
            $this->dispatch('notify', message: 'Sale deleted successfully', type: 'success');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: $e->getMessage(), type: 'error');
        }
    }

    private function resetForm()
    {
        $this->reason = '';
    }

    public function render()
    {
        return view('livewire.admin.sales.delete-sale-modal');
    }
}
