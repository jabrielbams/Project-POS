<div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    <style>
        @media print {
            @page {
                margin: 0;
            }
            body {
                padding: 1cm;
                background-color: white !important;
            }
        }
    </style>

    {{-- Header Actions --}}
    <div class="mb-4 flex justify-between items-center no-print print:hidden">
        <a href="{{ route('admin.sales-history.index') }}" wire:navigate
            class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Back to Sales
        </a>
        <div class="flex items-center gap-4">
            {{-- Print Button --}}
            <button onclick="window.print()" type="button"
                class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-all">
                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                Print / Save PDF
            </button>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div x-data="{ activeTab: 'details' }" class="mt-6">
        <div class="flex border-b border-gray-200 gap-4 no-print">
            <button @click="activeTab = 'details'"
                    :class="activeTab === 'details' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'"
                    class="px-3 py-2 font-medium text-sm hover:text-blue-600 transition-colors">
                Details
            </button>
            <button @click="activeTab = 'activity'"
                    :class="activeTab === 'activity' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600'"
                    class="px-3 py-2 font-medium text-sm hover:text-blue-600 transition-colors">
                Activity Log
            </button>
        </div>

        <!-- Details Tab Content -->
        <div x-show="activeTab === 'details'" class="mt-4">
    {{-- Invoice Card --}}
    <div
    class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden print:shadow-none print:border-none print:rounded-none print:w-full print:max-w-none">
    <div class="p-6 sm:p-8">

        {{-- Company Header --}}
        <div class="flex justify-between items-start pb-8 mb-3 border-b border-gray-100">
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">DVS Jaya</h2>
                <p class="text-xs text-gray-500 mt-2">Jl. Ringin Tirto No 82 Bancarkembar Purwokerto Utara</p>
                <p class="text-xs text-gray-500 mt-2">No Telp : 082138292998</p>
            </div>
            <div class="text-right">
                <h1 class="text-2xl font-light text-gray-400 tracking-widest uppercase mb-1.5">Nota Pembelian</h1>
                @if($sale->status === 'completed')
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">Lunas</span>
                @else
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-100">Cicilan</span>
                @endif
            </div>
        </div>

        {{-- Transaction Meta --}}
<div class="space-y-2 pb-4 mb-4 border-b border-gray-100">
    <div class="flex justify-between items-center">
        <h5 class="text-[11px] font-medium text-gray-400 uppercase tracking-wider">No.</h5>
        <p class="text-sm font-semibold text-gray-500">
            {{ $sale->invoice_no ?? '#' . str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
        </p>
    </div>
    <div class="flex justify-between items-center">
        <h5 class="text-[11px] font-medium text-gray-400 uppercase tracking-wider">Tanggal & Waktu</h5>
        <p class="text-sm font-semibold text-gray-500">
            {{ $sale->sold_at ? $sale->sold_at->format('M d, Y H:i') : $sale->created_at->format('M d, Y H:i') }}
        </p>
    </div>
    <div class="flex justify-between items-center">
        <h5 class="text-[11px] font-medium text-gray-400 uppercase tracking-wider">Kasir</h5>
        <p class="text-sm font-semibold text-gray-500">
            {{ $sale->cashier ? $sale->cashier->name : 'System' }}
        </p>
    </div>
    <div class="flex justify-between items-center">
        <h5 class="text-[11px] font-medium text-gray-400 uppercase tracking-wider">Metode Pembayaran</h5>
        <p class="text-sm font-semibold text-gray-500 capitalize">{{ $sale->payment_method ?? 'Cash' }}</p>
    </div>
    <div class="flex justify-between items-center">
        <h5 class="text-[11px] font-medium text-gray-400 uppercase tracking-wider">Toko</h5>
        <p class="text-sm font-semibold text-gray-500">
            {{ $sale->store?->name ?? '-' }}
        </p>
    </div>
</div>

        {{-- Items Table --}}
        <div class="mb-6 mt-6 border border-gray-200 rounded-lg overflow-hidden print:border-gray-300">
            <table class="w-full table-fixed text-left divide-y divide-gray-200 print:divide-gray-300">
                <thead class="bg-gray-50 print:bg-transparent">
                    <tr>
                        <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider w-[5%]">No</th>
                        <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider text-center w-[10%]">qty</th>
                        <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider w-[45%]">Nama Barang</th>
                        <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider text-right w-[20%]">Harga</th>
                        <th class="px-3 py-2 text-[11px] font-medium text-gray-500 uppercase tracking-wider text-right w-[20%]">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white print:divide-gray-300">
                    @forelse ($sale->saleItems as $index => $item)
                        <tr>
                            <td class="px-3 py-3 text-[11px] text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-3 py-3 text-[11px] text-gray-900 text-center font-medium">{{ $item->qty }}</td>
                            <td class="px-3 py-3">
                                <div class="text-[11px] font-medium text-gray-900 break-all whitespace-normal" title="{{ $item->product->name ?? 'Produk Tidak Ada' }}">
                                    {{ \Illuminate\Support\Str::limit($item->product->name ?? 'Produk Tidak Ada', 36) }}
                                </div>
                            </td>
                            <td class="px-3 py-3 text-[11px] text-gray-500 text-right whitespace-nowrap">Rp
                                {{ number_format($item->unit_price, 0, ',', '.') }}
                            </td>
                            <td class="px-3 py-3 text-[11px] text-gray-900 text-right font-medium whitespace-nowrap">Rp
                                {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 py-6 text-center text-sm text-gray-500 italic">Tidak ada item yang ditemukan untuk transaksi ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Summary --}}
        <div class="flex justify-end mb-6">
            <div class="w-full sm:w-2/3 md:w-1/2">
                <div class="space-y-1.5 border-b pb-2 border-gray-200">
                    <div class="mb-2 flex justify-between text-[13px] text-gray-500">
                        <span>Jumlah</span>
                        <span class="font-medium text-gray-900">Rp
                            {{ number_format($sale->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="mb-2 flex justify-between text-[13px] text-gray-500">
                        <span>Terbayar</span>
                        <span class="font-medium text-gray-900">Rp
                            {{ number_format($sale->amount_paid ?? $sale->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="mb-2 flex justify-between text-[13px] text-gray-500">
                        <span>Sisa</span>
                        <span class="font-medium text-gray-900">Rp
                            {{ number_format($sale->amount_due ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="mb-2 flex justify-between text-[13px] text-gray-500">
                        <span>Kembali</span>
                        <span class="font-medium text-gray-900">Rp
                            {{ number_format($sale->change_due ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="flex justify-between items-start mt-3">
                        <span class="text-sm font-medium text-gray-900">Total</span>
                        <span class="text-sm font-medium text-gray-900 tracking-tight">Rp
                            {{ number_format($sale->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
                @if (isset($sale->amount_received) && $sale->amount_received > 0)
                    <div class="mt-1.5 pt-1.5 border-t border-dashed border-gray-200 space-y-1">
                        <div class="flex justify-between text-[12px] text-gray-500">
                            <span>Terbayar</span>
                            <span>Rp {{ number_format($sale->amount_received, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-[12px] text-gray-500">
                            <span>Kembali</span>
                            <span>Rp
                                {{ number_format(max(0, $sale->amount_received - $sale->total_amount), 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Footer --}}
        <div class="mt-3 pt-3 border-t border-gray-100 text-center print:pt-3">
            <p class="text-[13px] font-semibold text-gray-700 mt-5 italic">"TERIMAKASIH SUDAH PERCAYA DAN BELANJA DI TEMPAT KAMI !!!"</p>
        </div>

    </div>
</div>

    {{-- Installment Section (only shown if installment) --}}
    @if($sale->status === 'installment' && !$sale->trashed())
        <div x-data="{
                            showPayModal: false,
                            selectedMethod: '{{ $installMethod }}',
                            payAmount: {{ $sale->amount_due }},
                            isSubmitting: false,
                            async submitPayment() {
                                if (this.isSubmitting) return;
                                this.isSubmitting = true;
                                try {
                                    const res = await fetch('{{ route('admin.sales.pay-installment', $sale->id) }}', {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                                        body: JSON.stringify({ amount: this.payAmount, payment_method: this.selectedMethod })
                                    });
                                    const data = await res.json();
                                    if (res.ok) { window.location.reload(); }
                                    else { alert(data.message || 'Gagal'); this.isSubmitting = false; }
                                } catch (e) { alert('Koneksi gagal'); this.isSubmitting = false; }
                            }
                        }">
            <div class="mt-4 bg-white rounded-xl border border-amber-200 shadow-sm overflow-hidden no-print">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            <h3 class="text-sm font-bold text-gray-900">Status Cicilan</h3>
                        </div>
                        <button @click="showPayModal = true"
                            class="inline-flex items-center px-3 py-1.5 text-[13px] font-semibold text-white bg-blue-500 hover:bg-amber-600 rounded-lg shadow-sm transition-all gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Bayar Cicilan
                        </button>
                    </div>

                    {{-- Progress Bar --}}
                    @php $paidPercent = $sale->total_amount > 0 ? round(($sale->amount_paid / $sale->total_amount) * 100) : 0; @endphp
                    <div class="mb-3">
                        <div class="flex justify-between text-[12px] mb-1.5">
                            <span class="font-medium text-gray-500">Terbayar: Rp
                                {{ number_format($sale->amount_paid, 0, ',', '.') }}</span>
                            <span class="font-bold text-amber-700">Sisa: Rp
                                {{ number_format($sale->amount_due, 0, ',', '.') }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-500"
                                style="width: {{ $paidPercent }}%"></div>
                        </div>
                        <p class="text-[11px] text-gray-400 mt-1">{{ $paidPercent }}% dari total Rp
                            {{ number_format($sale->total_amount, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Payment History --}}
            @if($sale->installmentPayments && $sale->installmentPayments->count() > 0)
                <div class="mt-4 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden no-print">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-bold text-gray-900">Riwayat Pembayaran</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="px-4 py-2.5 text-[11px] font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-4 py-2.5 text-[11px] font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-4 py-2.5 text-[11px] font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-4 py-2.5 text-[11px] font-medium text-gray-500 uppercase">Metode</th>
                                    <th class="px-4 py-2.5 text-[11px] font-medium text-gray-500 uppercase">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($sale->installmentPayments->sortBy('paid_at') as $index => $payment)
                                    <tr class="hover:bg-gray-50/50">
                                        <td class="px-4 py-2.5 text-[13px] text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2.5 text-[13px] text-gray-600 font-medium">
                                            {{ $payment->paid_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-4 py-2.5 text-[13px] font-bold text-emerald-700">Rp
                                            {{ number_format($payment->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2.5">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 text-gray-600 border border-gray-200">{{ strtoupper($payment->payment_method) }}</span>
                                        </td>
                                        <td class="px-4 py-2.5 text-[12px] text-gray-400">{{ $payment->notes ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Pay Installment Modal --}}
            <div x-show="showPayModal" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4 no-print"
                style="display: none;">
                <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showPayModal = false"></div>
                <div x-show="showPayModal" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative bg-white rounded-xl shadow-2xl w-full max-w-md p-6 z-10">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Bayar Cicilan</h3>
                            <p class="text-sm text-gray-500">Sisa tagihan: <span class="font-bold text-amber-700">Rp
                                    {{ number_format($sale->amount_due, 0, ',', '.') }}</span></p>
                        </div>
                    </div>

                    <div class="space-y-4 mb-5">
                        <div>
                            <label class="block text-[13px] font-bold text-gray-700 mb-2">Metode Pembayaran</label>
                            <div class="grid grid-cols-3 gap-3">
                                @foreach(['cash', 'qris', 'transfer'] as $method)
                                    <button type="button"
                                        @click="selectedMethod = '{{ $method }}'; $wire.set('installMethod', '{{ $method }}')"
                                        :class="selectedMethod === '{{ $method }}' ? 'border-amber-500 bg-amber-50 text-amber-700' : 'border-gray-200 text-gray-600'"
                                        class="rounded-lg border px-3 py-2 text-center text-[13px] font-medium transition-all">{{ strtoupper($method) }}</button>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="block text-[13px] font-bold text-gray-700 mb-2">Jumlah Bayar (Rp)</label>
                            <input type="number" x-model.number="payAmount"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-xl text-lg font-bold placeholder-gray-400 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all"
                                placeholder="0" max="{{ $sale->amount_due }}">
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button @click="showPayModal = false"
                            class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Batal</button>
                        <button @click="submitPayment()"
                            :disabled="isSubmitting || payAmount <= 0 || payAmount > {{ $sale->amount_due }}"
                            :class="isSubmitting ? 'bg-gray-400' : 'bg-amber-500 hover:bg-amber-600'"
                            class="flex-1 px-4 py-2.5 text-sm font-semibold text-white rounded-lg bg-blue-500 transition-colors inline-flex items-center justify-center gap-2">
                            <svg x-show="isSubmitting" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span x-text="isSubmitting ? 'Processing...' : 'Konfirmasi Bayar'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
        </div> <!-- Close Details tab content -->

        <!-- Activity Log Tab Content -->
        <div x-show="activeTab === 'activity'" class="mt-4">
            <livewire:admin.sales.activity-log-tab :sale="$sale" />
        </div>
    </div> <!-- Close tab wrapper -->
{{-- blade-formatter-enable --}}
</div>
