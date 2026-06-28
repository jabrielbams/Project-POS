<div class="animate-in fade-in duration-300 relative w-full pb-10">

    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-1.5 text-[13px] font-medium mb-2" aria-label="Breadcrumb">
        <span class="text-gray-400">Overview</span>
        <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-gray-600">Dashboard</span>
    </nav>

    <!-- Page Header -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">Ringkasan performa toko hari ini.</p>
        </div>
        <div class="flex items-center gap-3">
            <div
                class="inline-flex items-center gap-2 bg-white border border-gray-200 rounded-lg px-3.5 py-2 text-[13px] font-medium text-gray-600 shadow-sm">
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                {{ now()->translatedFormat('d M Y') }}
            </div>
        </div>
    </div>

    <!-- Due Date Information Banners -->
    @if(isset($upcomingDueInstallments) && $upcomingDueInstallments->count() > 0)
        <div class="mb-6 space-y-3">
            @foreach($upcomingDueInstallments as $installment)
                <div
                    class="flex items-center gap-3 p-4 rounded-xl bg-amber-50 border border-amber-200 shadow-sm animate-in fade-in slide-in-from-top-2 duration-300">
                    <div class="flex-shrink-0">
                        <div
                            class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center border border-amber-200">
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
                    <div>
                        <a href="{{ route('admin.sales.show', $installment->id) }}"
                            class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-amber-700 bg-white border border-amber-300 rounded-lg hover:bg-amber-50 hover:text-amber-800 transition-colors shadow-sm whitespace-nowrap">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Sales History Section -->
    <div class="space-y-4">

        @include('admin.sales.partials.metrics', [
            'totalRevenue' => $totalRevenue,
            'totalProfit' => $totalProfit,
            'totalTransactions' => $totalTransactions,
            'totalProductsSold' => $totalProductsSold,
        ])

        @include('admin.sales.partials.table', [
            'sales' => $sales,
            'showPagination' => true,
            'showActions' => false,
        ])
    </div>

    <!-- Revenue Chart -->
    <div class="mt-6 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col" x-data="{
            activeTab: 'daily',
            chartInitAttempts: 0,
            charts: {
                daily: null,
                monthly: null,
                yearly: null,
            },
            datasets: {
                daily: {
                    labels: @js($dailyChart->pluck('label')),
                    data: @js($dailyChart->pluck('value'))
                },
                monthly: {
                    labels: @js($monthlyChart->pluck('label')),
                    data: @js($monthlyChart->pluck('value'))
                },
                yearly: {
                    labels: @js($yearlyChart->pluck('label')),
                    data: @js($yearlyChart->pluck('value'))
                }
            },
            chartOptions() {
                return {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: { x: 12, y: 8 },
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(ctx) {
                                    return 'Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: '500' }, color: '#9ca3af' },
                            border: { display: false }
                        },
                        y: {
                            grid: { color: '#f3f4f6', drawBorder: false },
                            ticks: {
                                font: { size: 10, weight: '500' },
                                color: '#9ca3af',
                                callback: function(value) {
                                    if (value >= 1000000) return (value / 1000000).toFixed(1) + 'M';
                                    if (value >= 1000) return (value / 1000).toFixed(0) + 'K';
                                    return value;
                                },
                                maxTicksLimit: 5
                            },
                            border: { display: false }
                        }
                    },
                    interaction: { intersect: false, mode: 'index' }
                };
            },
            normalizedDataset(tab) {
                const source = this.datasets[tab] || { labels: [], data: [] };
                const labels = Array.isArray(source.labels) ? source.labels : Object.values(source.labels || {});
                const data = (Array.isArray(source.data) ? source.data : Object.values(source.data || {}))
                    .map(value => Number(value || 0));

                return { labels, data };
            },
            canvasRefFor(tab) {
                if (tab === 'monthly') return 'revenueChartMonthly';
                if (tab === 'yearly') return 'revenueChartYearly';
                return 'revenueChartDaily';
            },
            ensureChart(tab) {
                if (this.charts[tab]) return;

                const canvas = this.$refs[this.canvasRefFor(tab)];
                if (!canvas) return;

                const ctx = canvas.getContext('2d');
                const dataset = this.normalizedDataset(tab);

                const gradient = ctx.createLinearGradient(0, 0, 0, 250);
                gradient.addColorStop(0, 'rgba(59, 130, 246, 0.15)');
                gradient.addColorStop(1, 'rgba(59, 130, 246, 0.01)');

                this.charts[tab] = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dataset.labels,
                        datasets: [{
                            label: 'Revenue',
                            data: dataset.data,
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: gradient,
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: 'rgb(59, 130, 246)',
                            pointBorderWidth: 2,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: 'rgb(59, 130, 246)',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 2.5,
                        }]
                    },
                    options: this.chartOptions(),
                });
            },
            initChart() {
                if (typeof Chart === 'undefined') {
                    if (this.chartInitAttempts < 30) {
                        this.chartInitAttempts++;
                        setTimeout(() => this.initChart(), 100);
                    }
                    return;
                }

                this.$nextTick(() => {
                    this.ensureChart('daily');
                });
            },
            switchTab(tab) {
                if (this.activeTab === tab) return;

                this.activeTab = tab;
                this.$nextTick(() => this.ensureChart(tab));
            }
        }" x-init="initChart()">
        <!-- Chart Header -->
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between shrink-0">
            <div>
                <h3 class="text-sm font-bold text-gray-900">Perkembangan Revenue</h3>
                <p class="text-[11px] text-gray-400 mt-0.5">Keuntungan berdasarkan periode</p>
            </div>
            <!-- Tab Switcher -->
            <div class="flex items-center bg-gray-100 rounded-lg p-0.5 gap-0.5">
                <button type="button" @click="switchTab('daily')" :class="activeTab === 'daily' ? 'bg-white text-gray-900 shadow-sm' :
                        'text-gray-500 hover:text-gray-700'"
                    class="px-3 py-1.5 text-[11px] font-semibold rounded-md transition-all">
                    Harian
                </button>
                <button type="button" @click="switchTab('monthly')" :class="activeTab === 'monthly' ? 'bg-white text-gray-900 shadow-sm' :
                        'text-gray-500 hover:text-gray-700'"
                    class="px-3 py-1.5 text-[11px] font-semibold rounded-md transition-all">
                    Bulanan
                </button>
                <button type="button" @click="switchTab('yearly')" :class="activeTab === 'yearly' ? 'bg-white text-gray-900 shadow-sm' :
                        'text-gray-500 hover:text-gray-700'"
                    class="px-3 py-1.5 text-[11px] font-semibold rounded-md transition-all">
                    Tahunan
                </button>
            </div>
        </div>
        <!-- Chart Canvas -->
        <div class="p-5 grow flex items-center">
            <div class="w-full" style="height: 280px;">
                <canvas x-show="activeTab === 'daily'" x-ref="revenueChartDaily"></canvas>
                <canvas x-show="activeTab === 'monthly'" x-ref="revenueChartMonthly" style="display: none;"></canvas>
                <canvas x-show="activeTab === 'yearly'" x-ref="revenueChartYearly" style="display: none;"></canvas>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
@endpush
