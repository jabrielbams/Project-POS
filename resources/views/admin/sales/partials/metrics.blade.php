<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex flex-col justify-between">
        <div class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center bg-white mb-4">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
        </div>
        <div>
            <p class="text-xs font-medium text-gray-500 mb-1">Total Revenue</p>
            <div class="flex items-baseline justify-between">
                <h3 class="text-2xl font-bold text-gray-900 tracking-tight">Rp
                    {{ number_format($totalRevenue, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex flex-col justify-between">
        <div class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center bg-white mb-4">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1m0-1h.01M4 12h1m14 0h1"></path>
            </svg>
        </div>
        <div>
            <p class="text-xs font-medium text-gray-500 mb-1">Total Profit</p>
            <div class="flex items-baseline justify-between">
                <h3 class="text-2xl font-bold tracking-tight {{ $totalProfit >= 0 ? 'text-emerald-700' : 'text-red-600' }}">
                    Rp {{ number_format(abs($totalProfit), 0, ',', '.') }}{{ $totalProfit < 0 ? ' (Rugi)' : '' }}
                </h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex flex-col justify-between">
        <div class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center bg-white mb-4">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
        </div>
        <div>
            <p class="text-xs font-medium text-gray-500 mb-1">Total Transaksi</p>
            <div class="flex items-baseline justify-between">
                <h3 class="text-2xl font-bold text-gray-900 tracking-tight">
                    {{ number_format($totalTransactions, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm flex flex-col justify-between">
        <div class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center bg-white mb-4">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                </path>
            </svg>
        </div>
        <div>
            <p class="text-xs font-medium text-gray-500 mb-1">Produk Terjual</p>
            <div class="flex items-baseline justify-between">
                <h3 class="text-2xl font-bold text-gray-900 tracking-tight">
                    {{ number_format($totalProductsSold, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>
</div>
