@php
    $showPagination = $showPagination ?? true;
    $selectionEnabled = $selectionEnabled ?? false;
    $formId = $formId ?? null;
@endphp

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th scope="col" class="w-10 px-3 py-2 text-center border-r border-gray-200">
                        <input type="checkbox"
                            class="w-3.5 h-3.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            @if($selectionEnabled) checked data-select-all @endif
                            @if($selectionEnabled && $formId) form="{{ $formId }}" @endif>
                    </th>

                    <th scope="col"
                        class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                            <span>Invoice No</span>
                        </div>
                    </th>

                    <th scope="col"
                        class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>Date</span>
                        </div>
                    </th>

                    <th scope="col"
                        class="px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200 sm:w-auto min-w-[140px]">
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Kasir</span>
                        </div>
                    </th>

                    <th scope="col"
                        class="px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200 sm:w-auto min-w-[140px]">
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7M9 7V5a3 3 0 016 0v2"></path>
                            </svg>
                            <span>Store</span>
                        </div>
                    </th>

                    <th scope="col"
                        class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <span>Total Penjualan</span>
                        </div>
                    </th>

                    <th scope="col"
                        class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200">
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1m0-1h.01M4 12h1m14 0h1"></path>
                            </svg>
                            <span>Profit</span>
                        </div>
                    </th>

                    <th scope="col"
                        class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200 text-center">
                        <div class="flex items-center justify-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                            <span>Pembayaran</span>
                        </div>
                    </th>

                    <th scope="col"
                        class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200 text-center">
                        <div class="flex items-center justify-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Status</span>
                        </div>
                    </th>

                    <th scope="col"
                        class="w-px whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 border-r border-gray-200 text-center">
                        <div class="flex items-center justify-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Jatuh Tempo</span>
                        </div>
                    </th>

                    @if($showActions ?? true)
                    <th scope="col" class="px-3 py-2 text-xs font-medium text-gray-500 text-center w-40">
                        Actions
                    </th>
                    @endif

                    <th scope="col" class="px-3 py-2 text-center w-20 text-gray-400">
                        <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                            </path>
                        </svg>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($sales as $sale)
                    <tr wire:key="sale-row-{{ $sale->id }}"
                        class="hover:bg-gray-50 cursor-default transition-colors group">
                        <td class="px-3 py-2.5 text-center border-r border-gray-200">
                            <input type="checkbox"
                                class="w-3.5 h-3.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                @if($selectionEnabled) checked data-sale-checkbox name="sale_ids[]" value="{{ $sale->id }}" @endif
                                @if($selectionEnabled && $formId) form="{{ $formId }}" @endif>
                        </td>

                        <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                            <span
                                class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded text-[11px] font-mono tracking-tight font-semibold border border-gray-200/50">
                                {{ $sale->invoice_no ?? '#' . str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>

                        <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                            <span class="text-[13px] text-gray-600 font-medium">
                                {{ $sale->sold_at ? $sale->sold_at->format('d M Y, H:i') : $sale->created_at->format('d M Y, H:i') }}
                            </span>
                        </td>

                        <td class="px-3 py-2.5 border-r border-gray-200">
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-6 w-6 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 text-[10px] font-bold shrink-0">
                                    {{ strtoupper(substr($sale->cashier ? $sale->cashier->name : 'S', 0, 1)) }}
                                </div>
                                <span class="text-[13px] font-semibold text-gray-900 truncate block max-w-[180px]">
                                    {{ $sale->cashier ? $sale->cashier->name : 'System' }}
                                </span>
                            </div>
                        </td>

                        <td class="px-3 py-2.5 border-r border-gray-200">
                            <div class="flex flex-col">
                                <span class="text-[13px] font-semibold text-gray-900 truncate block max-w-[180px]">
                                    {{ $sale->store->name ?? '-' }}
                                </span>
                                @if($sale->store)
                                    <span class="text-[11px] text-gray-500">{{ $sale->store->code }} | {{ $sale->store->store_category }}</span>
                                @endif
                            </div>
                        </td>

                        <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                            <div class="flex flex-col gap-0.5">
                                <div class="flex items-center gap-1 font-mono">
                                    <span class="text-[10px] text-blue-400 font-sans">Rp</span>
                                    <span class="text-[13px] text-blue-700 font-bold">{{ number_format($sale->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200">
                            <div class="flex items-center gap-1.5 font-mono">
                                <span class="text-[10px] font-sans {{ $sale->profit_amount >= 0 ? 'text-emerald-400' : 'text-red-400' }}">Rp</span>
                                <span class="text-[13px] font-bold {{ $sale->profit_amount >= 0 ? 'text-emerald-700' : 'text-red-600' }}">
                                    {{ number_format(abs($sale->profit_amount), 0, ',', '.') }}{{ $sale->profit_amount < 0 ? ' (Rugi)' : '' }}
                                </span>
                            </div>
                        </td>

                        <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200 text-center">
                            @php
                                $paymentMethod = strtolower($sale->payment_method ?? 'cash');
                                $paymentClass = match ($paymentMethod) {
                                    'cash' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'qris' => 'bg-blue-50 text-blue-700 border-blue-100',
                                    'transfer' => 'bg-amber-50 text-amber-700 border-amber-100',
                                    default => 'bg-gray-50 text-gray-700 border-gray-200',
                                };
                            @endphp
                            <span
                                class="inline-flex items-center px-2 py-1 rounded text-[11px] font-semibold {{ $paymentClass }} shadow-sm leading-none">
                                {{ ucfirst($paymentMethod) }}
                            </span>
                        </td>

                        <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200 text-center">
                            @if($sale->status === 'completed')
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm leading-none">Lunas</span>
                            @else
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-100 shadow-sm leading-none">Cicilan</span>
                            @endif
                        </td>

                        <td class="w-px whitespace-nowrap px-3 py-2.5 border-r border-gray-200 text-center">
                            @if($sale->due_date)
                                <span
                                    class="text-[12px] text-gray-600 font-medium">{{ \Carbon\Carbon::parse($sale->due_date)->translatedFormat('d M Y') }}</span>
                            @else
                                <span class="text-gray-400 text-[12px]">&mdash;</span>
                            @endif
                        </td>

                        @if($showActions ?? true)
                        <td class="px-3 py-2.5 text-center">
                            @include('livewire.admin.sales.sales-row-actions', ['sale' => $sale])
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-3 py-10 text-center">
                            <svg class="mx-auto h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada transaksi</h3>
                            <p class="mt-1 text-xs text-gray-500">History penjualan masih kosong.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($showPagination && method_exists($sales, 'hasPages') && $sales->hasPages())
        <div class="px-6 py-3 border-t border-gray-100 bg-gray-50/50">
            {{ $sales->links('livewire.admin.pagination', ['scrollTo' => false]) }}
        </div>
    @endif
</div>
