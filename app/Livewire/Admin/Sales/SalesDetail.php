<?php

namespace App\Livewire\Admin\Sales;

use App\Models\Sale;
use App\Models\InstallmentPayment;
use Livewire\Component;

class SalesDetail extends Component
{
    public $sale;
    public $showPayModal = false;
    public $installAmount = 0;
    public $installMethod = 'cash';

    public function mount($id)
    {
        $this->sale = Sale::withTrashed()->with(['cashier', 'store', 'saleItems.product', 'installmentPayments'])->findOrFail($id);
    }

    public function openPayModal()
    {
        $this->installAmount = $this->sale->amount_due;
        $this->installMethod = 'cash';
        $this->showPayModal = true;
    }

    public function payInstallment()
    {
        $this->validate([
            'installAmount' => 'required|numeric|min:1|max:' . $this->sale->amount_due,
            'installMethod' => 'required|string|in:cash,qris,transfer',
        ]);

        InstallmentPayment::create([
            'sale_id' => $this->sale->id,
            'amount' => $this->installAmount,
            'payment_method' => $this->installMethod,
            'paid_at' => now(),
            'notes' => 'Cicilan ke-' . ($this->sale->installmentPayments->count() + 1),
        ]);

        $newAmountPaid = $this->sale->amount_paid + $this->installAmount;
        $newAmountDue = $this->sale->total_amount - $newAmountPaid;

        $this->sale->update([
            'amount_paid' => $newAmountPaid,
            'amount_due' => max(0, $newAmountDue),
            'status' => $newAmountDue <= 0 ? 'completed' : 'installment',
        ]);

        $this->sale = Sale::with(['cashier', 'store', 'saleItems.product', 'installmentPayments'])->findOrFail($this->sale->id);
        $this->showPayModal = false;
        $this->installAmount = 0;
    }

    public function render()
    {
        return view('livewire.admin.sales.sales-detail')
            ->layout('layouts.admin');
    }
}
