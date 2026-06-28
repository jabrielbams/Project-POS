<div wire:key="sales-history-root" class="animate-in fade-in duration-300 relative w-full pb-10">
<!-- Single root wrapper for Livewire -->

    <!-- Breadcrumbs Section -->
    <nav class="flex items-center space-x-1.5 text-sm font-medium mb-4" aria-label="Breadcrumb">
        <span class="text-gray-400">Sales History</span>
        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </nav>

    <!-- Header Section -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Sales History</h1>
            <p class="text-sm text-gray-500 mt-1">View completed transactions and sales records</p>
        </div>

        <div class="flex items-center gap-3">
            <form id="sales-report-form" method="POST" action="{{ route('admin.sales-history.report') }}" target="_blank"
                class="inline-flex items-center">
                @csrf
                <input type="hidden" name="select_all" value="1" data-select-all-input>
                <input type="hidden" name="search" value="{{ $search }}">
                <input type="hidden" name="filterStatus" value="{{ $filterStatus }}">
                <input type="hidden" name="filterStore" value="{{ $filterStore }}">
                <input type="hidden" name="filterDate" value="{{ $filterDate }}">
                <input type="hidden" name="startDate" value="{{ $startDate }}">
                <input type="hidden" name="endDate" value="{{ $endDate }}">
                <button type="submit"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Export Data
                </button>
            </form>

            <!-- Notification Bell (Unpaid Installments) -->
            <button type="button" @click="$dispatch('open-reminder-modal')"
                class="flex items-center justify-center w-10 h-10 border border-amber-200 bg-amber-50 rounded-lg text-amber-700 hover:text-amber-800 hover:border-amber-300 hover:bg-amber-100 transition-all shadow-sm relative shrink-0"
                title="Pengingat Cicilan">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <span class="sr-only">Pengingat Cicilan</span>
                @if (isset($unpaidInstallments) && count($unpaidInstallments) > 0)
                    <span class="absolute -top-1 -right-1 flex h-3.5 w-3.5">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-red-500 border-2 border-white"></span>
                    </span>
                @endif
            </button>
        </div>
    </div>

    <!-- Due Date Information Banners -->
    @if(isset($upcomingDueInstallments) && $upcomingDueInstallments->count() > 0)
        <div class="mb-6 space-y-3">
            @foreach($upcomingDueInstallments as $installment)
                <div x-data="{ show: true }" x-show="show"
                    class="flex items-center gap-3 p-4 rounded-xl bg-amber-50 border border-amber-200 shadow-sm transition-all duration-300">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center border border-amber-200">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-amber-900 tracking-tight">Pengingat Jatuh Tempo!</h4>
                        <p class="text-[13px] text-amber-800 mt-0.5">
                            Transaksi <span class="font-semibold">{{ $installment->invoice_no }}</span>
                            akan jatuh tempo pada
                            <span
                                class="font-bold underline decoration-amber-300">{{ \Carbon\Carbon::parse($installment->due_date)->translatedFormat('d F Y') }}</span>.
                            Sisa tagihan: <span class="font-semibold">Rp
                                {{ number_format($installment->amount_due, 0, ',', '.') }}</span>.
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.sales.show', $installment->id) }}"
                            class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-amber-700 bg-white border border-amber-300 rounded-lg hover:bg-amber-50 hover:text-amber-800 transition-colors shadow-sm whitespace-nowrap">
                            Lihat Detail
                        </a>
                        <button type="button" @click="show = false"
                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-amber-500 hover:bg-amber-100/50 hover:text-amber-800 transition-colors outline-none focus:ring-2 focus:ring-amber-500/20"
                            aria-label="Tutup Pengingat" title="Tutup">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @include('admin.sales.partials.metrics')

    <!-- Filter and Search Section -->
    <form method="GET" action="{{ url()->current() }}"
        class="mb-4 flex flex-row items-center justify-between gap-3 mt-4">

        <!-- Left: Search input -->
        <div class="relative w-full max-w-xs">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ $search }}"
                class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                placeholder="Cari invoice, kasir, atau store...">
        </div>

        <!-- Right: Filters dropdowns + clear -->
        <div x-data="{
            dateType: '{{ $filterDate ?? 'semua' }}',
            previousDateType: '{{ $filterDate ?? 'semua' }}',
            showCustomModal: false
        }" class="flex items-center gap-2 shrink-0">

            <!-- Filter Date Type -->
            <div class="relative">
                <select name="filterDate" x-model="dateType"
                    @change="if($event.target.value === 'custom') { showCustomModal = true; } else { $event.target.form.submit(); }"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm pr-8">
                    <option value="semua">Semua</option>
                    <option value="harian">Harian</option>
                    <option value="mingguan">7 Hari</option>
                    <option value="bulanan">30 Hari</option>
                    <option value="custom">Custom</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    </svg>
                </div>
            </div>

            <!-- Custom Date Modal -->
            <div x-show="showCustomModal" style="display: none;"
                class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/50 backdrop-blur-sm p-4 sm:p-0">
                <!-- Modal Backdrop -->
                <div x-show="showCustomModal" x-transition.opacity class="fixed inset-0"
                    @click="showCustomModal = false; dateType = previousDateType"></div>

                <!-- Modal Panel -->
                <div x-show="showCustomModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    style="max-width: 320px;"
                    class="relative w-full transform overflow-hidden rounded-xl bg-white text-left align-middle shadow-2xl transition-all mx-4">

                    <div class="border-b border-gray-100 px-4 py-3 flex items-center justify-between bg-gray-50/80">
                        <h3 class="text-[15px] font-bold text-gray-900 tracking-tight">Pilih Rentang Waktu</h3>
                        <button type="button" @click="showCustomModal = false; dateType = previousDateType"
                            class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors rounded-lg hover:bg-gray-200/50 p-1">
                            <span class="sr-only">Tutup</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="p-4 space-y-3.5">
                        <div class="mb-4">
                            <label
                                class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Dari</label>
                            <input type="date" name="startDate" value="{{ $startDate }}"
                                class="block w-full px-3 py-1.5 border border-gray-300 rounded-lg text-[13px] bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors shadow-sm">
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Sampai</label>
                            <input type="date" name="endDate" value="{{ $endDate }}"
                                class="block w-full px-3 py-1.5 border border-gray-300 rounded-lg text-[13px] bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors shadow-sm">
                        </div>
                    </div>

                    <div class="border-t border-gray-100 px-4 py-3 bg-gray-50/80 flex justify-end gap-2">
                        <button type="button" @click="showCustomModal = false; dateType = previousDateType"
                            class="px-3 py-1.5 text-[13px] font-semibold text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all shadow-sm">
                            Batal
                        </button>
                        <button type="button" @click="$event.target.closest('form').submit()"
                            class="px-3 py-1.5 text-[13px] font-semibold text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all shadow-sm">
                            Terapkan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filter Status -->
            <div class="relative">
                <select name="filterStatus" onchange="this.form.submit()"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm pr-8">
                    <option value="">Status</option>
                    <option value="completed" {{ $filterStatus === 'completed' ? 'selected' : '' }}>Lunas</option>
                    <option value="installment" {{ $filterStatus === 'installment' ? 'selected' : '' }}>Cicilan</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    </svg>
                </div>
            </div>

            <!-- Filter Store Category -->
            <div class="relative">
                <select name="filterStore" onchange="this.form.submit()"
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm pr-8">
                    <option value="">Toko</option>
                    @foreach($storeCategories as $storeCategory)
                        <option value="{{ $storeCategory }}" {{ (string) $filterStore === (string) $storeCategory ? 'selected' : '' }}>
                            {{ $storeCategory }}
                        </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    </svg>
                </div>
            </div>

            <!-- Clear Filters Button -->
            <a href="{{ request()->url() }}"
                class="inline-flex items-center gap-1.5 px-3 py-2 border border-gray-200 bg-white rounded-lg text-gray-500 hover:text-red-600 hover:border-red-100 hover:bg-red-50 transition-all shadow-sm text-[13px] font-medium shrink-0"
                title="Clear Filters">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>Reset</span>
            </a>
        </div>
    </form>

    <!-- Data Table Section -->
    @include('admin.sales.partials.table', [
        'sales' => $sales,
        'showPagination' => true,
        'selectionEnabled' => true,
        'formId' => 'sales-report-form',
    ])

    <!-- Alpine.js Reminder Modal -->
    <div x-data="{ open: false }" x-on:open-reminder-modal.window="open = true" x-show="open"
        class="fixed inset-0 z-[99998] overflow-y-auto" style="display: none;">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="open = false"
                x-show="open" x-transition:outline></div>

            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl border border-gray-100 flex flex-col max-h-[85vh]">

                <!-- Modal Header -->
                <div
                    class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/80 shrink-0">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Pengingat Tagihan Cicilan</h3>
                            <p class="text-[13px] text-gray-500 font-medium">Transaksi yang belum lunas hari ini.</p>
                        </div>
                    </div>
                    <button type="button" @click="open = false"
                        class="text-gray-400 hover:text-gray-500 p-2 rounded-full hover:bg-gray-100 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body (Scrollable) -->
                <div class="p-0 overflow-y-auto grow">
                    @if (isset($unpaidInstallments) && count($unpaidInstallments) > 0)
                        <ul class="divide-y divide-gray-100">
                            @foreach ($unpaidInstallments as $installment)
                                <li class="p-5 hover:bg-gray-50/50 transition-colors">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span
                                                    class="text-[14px] font-bold text-gray-900">{{ $installment->invoice_no ?? '#' . str_pad($installment->id, 6, '0', STR_PAD_LEFT) }}</span>
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700">Belum
                                                    Lunas</span>
                                            </div>
                                            <p class="text-[13px] text-gray-500 mb-2">Kasir: <span
                                                    class="font-medium text-gray-700">{{ $installment->cashier->name ?? 'System' }}</span>
                                                •
                                                {{ $installment->sold_at ? $installment->sold_at->format('d M Y, H:i') : $installment->created_at->format('d M Y, H:i') }}
                                            </p>

                                            <div class="flex items-center gap-4 text-[13px]">
                                                <div>
                                                    <span class="text-gray-400">Terbayar:</span>
                                                    <span class="font-bold text-emerald-600">Rp
                                                        {{ number_format($installment->amount_paid, 0, ',', '.') }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-400">Sisa Tagihan:</span>
                                                    <span class="font-bold text-red-600">Rp
                                                        {{ number_format($installment->amount_due, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.sales.show', $installment->id) }}" wire:navigate
                                            class="shrink-0 inline-flex items-center justify-center px-4 py-2 text-[13px] font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                                            Update Cicilan
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="py-12 px-6 text-center">
                            <div
                                class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-[15px] font-bold text-gray-900 mb-1">Semua Tagihan Lunas!</h4>
                            <p class="text-[13px] text-gray-500">Tidak ada transaksi cicilan yang perlu diperhatikan saat
                                ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Sale Modal Component -->
    <livewire:admin.sales.edit-sale-modal />

    <!-- Delete Sale Modal Component -->
    <livewire:admin.sales.delete-sale-modal />

    <script>
        (function () {
            function initSalesHistorySelection() {
                var form = document.getElementById('sales-report-form');
                if (!form) return;

                var selectAllInput = form.querySelector('[data-select-all-input]');
                var selectAllBox = document.querySelector('[data-select-all]');
                var rowBoxes = Array.prototype.slice.call(document.querySelectorAll('[data-sale-checkbox]'));

                if (!selectAllInput || !selectAllBox || rowBoxes.length === 0) return;

                function syncSelectAll() {
                    var allChecked = rowBoxes.every(function (checkbox) {
                        return checkbox.checked;
                    });
                    selectAllBox.checked = allChecked;
                    selectAllInput.value = allChecked ? '1' : '0';
                }

                selectAllBox.addEventListener('change', function () {
                    rowBoxes.forEach(function (checkbox) {
                        checkbox.checked = selectAllBox.checked;
                    });
                    selectAllInput.value = selectAllBox.checked ? '1' : '0';
                });

                rowBoxes.forEach(function (checkbox) {
                    checkbox.addEventListener('change', syncSelectAll);
                });

                syncSelectAll();
            }

            document.addEventListener('DOMContentLoaded', initSalesHistorySelection);
            document.addEventListener('livewire:initialized', initSalesHistorySelection);
            document.addEventListener('livewire:navigated', initSalesHistorySelection);
            document.addEventListener('livewire:updated', initSalesHistorySelection);
        })();
    </script>
</div>
