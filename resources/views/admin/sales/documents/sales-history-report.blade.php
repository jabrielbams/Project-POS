@extends('layouts.admin')

@section('content')
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 1cm;
            }
            body {
                padding: 0;
                background-color: white !important;
            }
            /* Fix the main content overflow that clips page 2+ */
            .bg-white.rounded-xl.border.border-gray-200 {
                overflow: visible !important;
            }
            .border.border-gray-200.rounded-lg.overflow-hidden {
                overflow: visible !important;
            }
            /* Allow table rows to break across pages */
            table {
                page-break-inside: auto !important;
            }
            thead {
                display: table-header-group !important;
            }
            tr {
                page-break-inside: avoid !important;
                page-break-after: auto !important;
            }
        }
    </style>
    @php
        $periodLabel = 'Semua Waktu';
        if (($filters['filterDate'] ?? 'semua') === 'harian') {
            $periodLabel = now()->translatedFormat('d M Y');
        } elseif (($filters['filterDate'] ?? 'semua') === 'mingguan') {
            $periodLabel = now()->subDays(7)->translatedFormat('d M Y') . ' - ' . now()->translatedFormat('d M Y');
        } elseif (($filters['filterDate'] ?? 'semua') === 'bulanan') {
            $periodLabel = now()->translatedFormat('F Y');
        } elseif (($filters['filterDate'] ?? 'semua') === 'custom') {
            $startDate = $filters['startDate'] ?? '';
            $endDate = $filters['endDate'] ?? '';
            if ($startDate !== '' && $endDate !== '') {
                $periodLabel = \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') . ' - ' . \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y');
            } elseif ($startDate !== '') {
                $periodLabel = \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') . ' - Sekarang';
            } elseif ($endDate !== '') {
                $periodLabel = 'Sampai ' . \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y');
            }
        }

        $statusLabel = $filters['filterStatus'] ?? '';
        if ($statusLabel === 'completed') {
            $statusLabel = 'Lunas';
        } elseif ($statusLabel === 'installment') {
            $statusLabel = 'Cicilan';
        } else {
            $statusLabel = 'Semua Status';
        }

        $storeLabel = $filters['filterStore'] ?? '';
        $storeLabel = $storeLabel !== '' ? $storeLabel : 'Semua Kategori Store';

        $searchLabel = trim($filters['search'] ?? '') !== '' ? $filters['search'] : 'Tanpa Pencarian';
    @endphp

    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-4 flex justify-between items-center no-print print:hidden">
            <a href="{{ route('admin.sales-history.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Back to Sales History
            </a>
            <button onclick="window.print()" type="button "
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-all">
                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                Print / Save PDF
            </button>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden print:shadow-none print:border-none print:rounded-none">
            <div class="p-6 sm:p-8">
                <div class="flex justify-between items-start pb-6 mb-4 border-b border-gray-100">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 tracking-tight">DVS Jaya</h2>
                        <p class="text-xs text-gray-500 mt-2">Jl. Ringin Tirto No 82 Bancarkembar Purwokerto Utara</p>
                        <p class="text-xs text-gray-500 mt-2">No Telp : 082138292998</p>
                    </div>
                    <div class="text-right">
                        <h1 class="text-2xl font-light text-gray-400 tracking-widest uppercase mb-1.5">Laporan Penjualan</h1>
                        <p class="text-[11px] text-gray-500 uppercase tracking-wider">{{ $periodLabel }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-y-4 gap-x-12 pb-6 mb-6 border-b border-gray-100">
                    <div>
                        <h5 class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-1">Status</h5>
                        <p class="text-sm font-semibold text-gray-900">{{ $statusLabel }}</p>
                    </div>
                    <div>
                        <h5 class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-1">Kategori Store</h5>
                        <p class="text-sm font-semibold text-gray-900">{{ $storeLabel }}</p>
                    </div>
                    <div>
                        <h5 class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-1">Pencarian</h5>
                        <p class="text-sm font-semibold text-gray-900">{{ $searchLabel }}</p>
                    </div>
                    <div>
                        <h5 class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-1">Dibuat</h5>
                        <p class="text-sm font-semibold text-gray-900">{{ $generatedAt->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div class="mb-6 border border-gray-200 rounded-lg overflow-hidden print:border-gray-300">
                    <table class="w-full text-left divide-y divide-gray-200 print:divide-gray-300">
                        <thead class="bg-gray-50 print:bg-transparent">
                            <tr>
                                <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider w-10">No</th>
                                <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                                <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider">Kasir</th>
                                <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider">Store</th>
                                <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider text-right">Total</th>
                                <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider text-right">Profit</th>
                                <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider text-center">Pembayaran</th>
                                <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider text-center">Status</th>
                                <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider text-center">Jatuh Tempo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white print:divide-gray-300">
                            @forelse ($sales as $index => $sale)
                                <tr>
                                    <td class="px-3 py-2.5 text-[12px] text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-3 py-2.5 text-[12px] text-gray-900 font-medium">
                                        {{ $sale->invoice_no ?? '#' . str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-3 py-2.5 text-[12px] text-gray-600">
                                        {{ $sale->sold_at ? $sale->sold_at->format('d M Y, H:i') : $sale->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-3 py-2.5 text-[12px] text-gray-700">
                                        {{ $sale->cashier ? $sale->cashier->name : 'System' }}
                                    </td>
                                    <td class="px-3 py-2.5 text-[12px] text-gray-700">
                                        {{ $sale->store?->name ?? '-' }}
                                        @if($sale->store)
                                            <div class="text-[10px] text-gray-400">{{ $sale->store->code }} · {{ $sale->store->store_category }}</div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2.5 text-[12px] text-gray-700 text-right whitespace-nowrap">Rp
                                        {{ number_format($sale->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-2.5 text-[12px] text-right whitespace-nowrap">
                                        <span class="font-semibold {{ $sale->profit_amount >= 0 ? 'text-emerald-700' : 'text-red-600' }}">Rp
                                            {{ number_format(abs($sale->profit_amount), 0, ',', '.') }}{{ $sale->profit_amount < 0 ? ' (Rugi)' : '' }}</span>
                                    </td>
                                    <td class="px-3 py-2.5 text-[12px] text-center">
                                        {{ ucfirst($sale->payment_method ?? 'Cash') }}
                                    </td>
                                    <td class="px-3 py-2.5 text-[12px] text-center">
                                        {{ $sale->status === 'completed' ? 'Lunas' : 'Cicilan' }}
                                    </td>
                                    <td class="px-3 py-2.5 text-[12px] text-center">
                                        @if($sale->due_date)
                                            {{ \Carbon\Carbon::parse($sale->due_date)->translatedFormat('d M Y') }}
                                        @else
                                            &mdash;
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-3 py-8 text-center text-sm text-gray-500 italic">
                                        Tidak ada data penjualan yang dipilih.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end">
                    <div class="w-full sm:w-2/3 md:w-1/2">
                        <div class="space-y-1.5">
                            <div class="mb-2 flex justify-between text-[13px] text-gray-500">
                                <span>Total Transaksi</span>
                                <span class="font-medium text-gray-900">{{ number_format($totalTransactions, 0, ',', '.') }}</span>
                            </div>
                            <div class="mb-2 flex justify-between text-[13px] text-gray-500">
                                <span>Total Produk Terjual</span>
                                <span class="font-medium text-gray-900">{{ number_format($totalProductsSold, 0, ',', '.') }}</span>
                            </div>
                            <div class="mb-2 flex justify-between text-[13px] text-gray-500">
                                <span>Total Pendapatan</span>
                                <span class="font-medium text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                            </div>
                            <div class="mb-2 flex justify-between text-[13px] text-gray-500">
                                <span>Total Profit</span>
                                <span class="font-medium text-gray-900">Rp {{ number_format($totalProfit, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
