<?php

namespace App\Livewire\Admin;

use App\Models\Sale;
use App\Models\Store;
use App\Livewire\Admin\Sales\EditSaleModal;
use App\Livewire\Admin\Sales\DeleteSaleModal;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SalesHistory extends Component
{
    use WithPagination;

    public $refreshKey = 0;

    #[Url]
    public $search = '';

    #[Url]
    public $filterStatus = '';

    #[Url]
    public $filterStore = '';

    #[Url]
    public $filterDate = 'semua';

    #[Url]
    public $startDate = '';

    #[Url]
    public $endDate = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterStore()
    {
        $this->resetPage();
    }

    public function updatingFilterDate()
    {
        $this->resetPage();
    }

    #[On('saleUpdated')]
    public function refreshAfterEdit($saleId)
    {
        $this->refreshKey++;
        $this->resetPage();
        $this->dispatch('notify', message: 'Sale updated successfully', type: 'success');
    }

    #[On('saleDeleted')]
    public function refreshAfterDelete($saleId)
    {
        $this->refreshKey++;
        $this->resetPage();
        $this->dispatch('notify', message: 'Sale deleted successfully', type: 'success');
    }

    public function render()
    {
        $query = Sale::historyBase();

        $search = $this->search;
        $statusFilter = $this->filterStatus;
        $storeFilter = $this->filterStore;
        $filterDate = $this->filterDate;
        $startDate = $this->startDate;
        $endDate = $this->endDate;

        if (!empty($search)) {
            $searchTerm = strtolower($search);
            $query->where(function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(invoice_no) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereHas('cashier', function ($q2) use ($searchTerm) {
                      $q2->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
                  })
                  ->orWhereHas('store', function ($q3) use ($searchTerm) {
                      $q3->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%'])
                        ->orWhereRaw('LOWER(code) LIKE ?', ['%' . $searchTerm . '%']);
                  });
            });
        }

        if ($statusFilter === 'completed') {
            $query->where('status', 'completed');
        } elseif ($statusFilter === 'installment') {
            $query->where('status', 'installment');
        }

        if ($storeFilter !== '') {
            $query->whereHas('store', function ($q) use ($storeFilter) {
                $q->where('store_category', $storeFilter);
            });
        }

        if ($filterDate === 'harian') {
            $query->whereDate('sold_at', now()->toDateString());
        } elseif ($filterDate === 'mingguan') {
            $query->where('sold_at', '>=', now()->subDays(7)->startOfDay());
        } elseif ($filterDate === 'bulanan') {
            $query->whereMonth('sold_at', now()->month)
                  ->whereYear('sold_at', now()->year);
        } elseif ($filterDate === 'custom') {
            if (!empty($startDate)) {
                $query->whereDate('sold_at', '>=', $startDate);
            }
            if (!empty($endDate)) {
                $query->whereDate('sold_at', '<=', $endDate);
            }
        }

        $metricsQuery = clone $query;
        $sales = $query->latestSold()->paginate(10);
        $sales->getCollection()->transform(function ($sale) {
            $sale->profit_amount = $sale->saleItems->sum(function ($item) {
                return ((float) $item->unit_price - (float) ($item->product->cost ?? 0)) * $item->qty;
            });

            return $sale;
        });

        // Metrics calculations (filtered)
        $totalRevenue = (clone $metricsQuery)->sum('amount_paid');
        $totalTransactions = (clone $metricsQuery)->count();
        $totalProductsSold = \App\Models\SaleItem::whereIn('sale_id', (clone $metricsQuery)->select('id'))->sum('qty');
        $totalProfit = (float) \App\Models\SaleItem::query()
            ->leftJoin('products', 'products.id', '=', 'sale_items.product_id')
            ->whereIn('sale_items.sale_id', (clone $metricsQuery)->select('id'))
            ->selectRaw('COALESCE(SUM((sale_items.unit_price - COALESCE(products.cost, 0)) * sale_items.qty), 0) as total_profit')
            ->value('total_profit');

        // Upcoming due installments (next 3 days)
        $upcomingDueInstallments = Sale::where('status', 'installment')
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [now()->startOfDay(), now()->addDays(3)->endOfDay()])
            ->orderBy('due_date', 'asc')
            ->get();

        // Unpaid installments for reminder modal
        $unpaidInstallments = Sale::with('cashier')
            ->where('status', 'installment')
            ->orderByDesc('created_at')
            ->get();

        $storeCategories = Store::query()
            ->select('store_category')
            ->distinct()
            ->orderBy('store_category')
            ->pluck('store_category');

        return view('livewire.admin.sales-history', [
            'sales' => $sales,
            'storeCategories' => $storeCategories,
            'totalRevenue' => $totalRevenue,
            'totalProfit' => $totalProfit,
            'totalTransactions' => $totalTransactions,
            'totalProductsSold' => $totalProductsSold,
            'upcomingDueInstallments' => $upcomingDueInstallments,
            'unpaidInstallments' => $unpaidInstallments,
            'search' => $search,
            'filterStatus' => $statusFilter,
            'filterStore' => $storeFilter,
            'filterDate' => $filterDate,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ])->layout('layouts.admin', ['title' => 'Sales History - Project POS']);
    }
}
