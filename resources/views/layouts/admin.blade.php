<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @media print {
            aside { display: none !important; }
            header { display: none !important; }
            main {
                overflow: visible !important;
                overflow-x: visible !important;
                overflow-y: visible !important;
                height: auto !important;
                max-height: none !important;
            }
            .max-w-7xl, .max-w-5xl, .max-w-2xl {
                max-width: none !important;
            }
            body { background: white !important; }
            .flex.h-screen {
                display: block !important;
                height: auto !important;
                max-height: none !important;
                overflow: visible !important;
            }
            .no-print, [data-no-print] { display: none !important; }
        }
    </style>
</head>

<body class="font-sans text-slate-600 bg-white">
    <div class="flex h-screen overflow-hidden bg-white" x-data="{ sidebarExpanded: true }">

        <!-- Sidebar -->
        <aside
            class="border-r border-gray-200 bg-gray-50 flex flex-col shrink-0 z-20 transition-all duration-300 relative"
            :class="sidebarExpanded ? 'w-64' : 'w-[72px]'">

            <!-- Toggle Button -->
            <button @click="sidebarExpanded = !sidebarExpanded"
                class="absolute -right-3 top-1/2 -translate-y-1/2 bg-white border border-gray-200 rounded-full p-1 text-gray-400 hover:text-gray-600 shadow-sm z-30 transition-transform duration-300"
                :class="!sidebarExpanded && 'rotate-180'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Header: App Name & Dropdown Toggle -->
            <div class="px-3 pt-4 shrink-0">
                <button
                    class="flex w-full items-center rounded-lg border border-gray-200 bg-white text-sm transition-all hover:bg-white hover:border-gray-200 focus:ring-1 focus:ring-gray-500/10"
                    :class="sidebarExpanded ? 'p-2.5 gap-x-2.5' : 'p-2 justify-center'" type="button" title="App Info">
                    <span
                        class="flex aspect-square size-9 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 text-[12px] font-bold text-white shadow-lg"
                        aria-hidden="true">
                        {{ strtoupper(substr(config('app.name', 'PT'), 0, 2)) }}
                    </span>
                    <div x-show="sidebarExpanded" class="flex w-full items-center justify-between gap-x-2 truncate">
                        <div class="truncate text-left">
                            <p class="truncate whitespace-nowrap text-[14px] font-medium text-gray-900 tracking-tight">
                                {{ config('app.name', 'POS TOYS') }}
                            </p>
                            <p
                                class="text-left text-[12px] text-gray-400 font-medium tracking-normal leading-none mt-1">
                                {{ auth()->user()->role ?? 'Admin' }}
                            </p>
                        </div>
                    </div>
                </button>
            </div>

            <!-- Menu Navigation -->
            <nav class="flex-1 px-3 space-y-4 pb-8 mt-4 overflow-y-auto w-full transition-all">

                <!-- Top Level -->
                <div class="space-y-1">
                    <a href="{{ route('dashboard') }}"
                        class="group flex items-center py-1.5 text-[14px] font-medium transition-all duration-200 border 
                              {{ request()->routeIs('dashboard') ? 'bg-white text-blue-700 border-gray-200 shadow-sm rounded-lg' : 'text-gray-600 hover:bg-gray-100 rounded-lg border-transparent' }}"
                        :class="sidebarExpanded ? 'px-2.5 justify-start' : 'px-0 justify-center'" title="Dashboard">
                        <svg class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-400' }}"
                            :class="sidebarExpanded ? 'mr-3' : 'mr-0'" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span x-show="sidebarExpanded" class="truncate">Dashboard</span>
                    </a>
                </div>

                <!-- Section: Master Data -->
                <div>
                    <h3 x-show="sidebarExpanded" class="px-3 text-[12px] font-medium text-gray-400 tracking-tight mb-2">
                        Master Data</h3>
                    <div x-show="!sidebarExpanded" class="px-3 mb-2 flex justify-center">
                        <div class="w-5 border-b-2 border-gray-200" title="Master Data"></div>
                    </div>
                    <div class="space-y-1">
                        <a href="/admin/stores"
                            class="group flex items-center py-1.5 text-[14px] font-medium transition-all duration-200 border 
                                  {{ request()->is('admin/stores*') ? 'bg-white text-blue-700 border-gray-200 shadow-sm rounded-lg' : 'text-gray-600 hover:bg-gray-100  rounded-lg border-transparent' }}"
                            :class="sidebarExpanded ? 'px-2.5 justify-start' : 'px-0 justify-center'"
                            title="Store">
                            <svg class="w-[18px] h-[18px] shrink-0 {{ request()->is('admin/stores*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-400' }}"
                                :class="sidebarExpanded ? 'mr-3' : 'mr-0'" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                </path>
                            </svg>
                            <span x-show="sidebarExpanded" class="truncate">Store</span>
                        </a>

                        <a href="/admin/products"
                            class="group flex items-center py-1.5 text-[14px] font-medium transition-all duration-200 border 
                                  {{ request()->is('admin/products*') ? 'bg-white text-blue-700 border-gray-200 shadow-sm rounded-lg' : 'text-gray-600 hover:bg-gray-100  rounded-lg border-transparent' }}"
                            :class="sidebarExpanded ? 'px-2.5 justify-start' : 'px-0 justify-center'" title="Products">
                            <svg class="w-[18px] h-[18px] shrink-0 {{ request()->is('admin/products*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-400' }}"
                                :class="sidebarExpanded ? 'mr-3' : 'mr-0'" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span x-show="sidebarExpanded" class="truncate">Products</span>
                        </a>
                    </div>
                </div>

                <!-- Section: Transactions -->
                <div>
                    <h3 x-show="sidebarExpanded" class="px-3 text-[12px] font-medium text-gray-400 tracking-tight mb-2">
                        Transactions</h3>
                    <div x-show="!sidebarExpanded" class="px-3 mb-2 flex justify-center">
                        <div class="w-5 border-b-2 border-gray-200" title="Transactions"></div>
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('admin.pos.terminal') }}"
                            class="group flex items-center py-1.5 text-[14px] font-medium transition-all duration-200 border 
                                  {{ request()->routeIs('admin.pos.terminal') ? 'bg-white text-blue-700 border-gray-200 shadow-sm rounded-lg' : 'text-gray-600 border-transparent hover:bg-gray-100 rounded-lg' }}"
                            :class="sidebarExpanded ? 'px-2.5 justify-start' : 'px-0 justify-center'"
                            title="Point of Sale">
                            <svg class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('admin.pos.terminal') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-400' }}"
                                :class="sidebarExpanded ? 'mr-3' : 'mr-0'" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            <span x-show="sidebarExpanded" class="truncate">Point of Sale</span>
                        </a>
                        <a href="{{ route('admin.sales-history.index') }}"
                            class="group flex items-center py-1.5 text-[14px] font-medium transition-all duration-200 border 
                                  {{ request()->routeIs('admin.sales-history.index') ? 'bg-white text-blue-700 border-gray-200 shadow-sm rounded-lg' : 'text-gray-600 border-transparent hover:bg-gray-100 rounded-lg' }}"
                            :class="sidebarExpanded ? 'px-2.5 justify-start' : 'px-0 justify-center'"
                            title="Sales History">
                            <svg class="w-[18px] h-[18px] shrink-0 {{ request()->routeIs('admin.sales-history.index') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-400' }}"
                                :class="sidebarExpanded ? 'mr-3' : 'mr-0'" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                            <span x-show="sidebarExpanded" class="truncate">Sales History</span>
                        </a>
                    </div>
                </div>
            </nav>

            <!-- User Profile (Pinned to Bottom) -->
            <div class="p-3 border-t border-gray-200/50 bg-gray-50/50 relative" x-data="{ open: false }">
                <!-- Dropdown Menu -->
                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute bottom-full mb-2 bg-white rounded-lg border border-gray-200 overflow-hidden z-30 shadow-lg"
                    :class="sidebarExpanded ? 'left-3 right-3 w-auto' : 'left-3 w-48'" @click.away="open = false"
                    style="display: none;">

                    <div class="p-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 px-3 py-2 text-sm font-medium text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all group/logout">
                                <svg class="w-4 h-4 text-gray-400 group-hover/logout:text-red-500 transition-colors shrink-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Log out
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Profile Trigger -->
                <div @click="open = !open"
                    class="bg-white rounded-xl p-2 flex items-center border border-gray-200 transition-all cursor-pointer group"
                    :class="sidebarExpanded ? 'justify-between' : 'justify-center'">
                    <div class="flex items-center min-w-0" :class="sidebarExpanded ? 'gap-3' : 'gap-0'">
                        <!-- Avatar -->
                        <div
                            class="w-8 h-8 rounded-full bg-gray-50 border border-gray-200 flex shrink-0 items-center justify-center shadow-sm">
                            <span class="text-[10px] font-bold text-gray-600 uppercase">
                                @php
                                    $name = auth()->user()->name ?? 'User Name';
                                    $names = explode(' ', $name);
                                    $initials = substr($names[0], 0, 1) . (count($names) > 1 ? substr($names[count($names) - 1], 0, 1) : '');
                                @endphp
                                {{ $initials }}
                            </span>
                        </div>
                        <!-- User Info -->
                        <div class="min-w-0" x-show="sidebarExpanded">
                            <p class="text-[14px] font-medium text-gray-900 truncate tracking-tight">
                                {{ auth()->user()->name ?? 'Administrator' }}
                            </p>
                        </div>
                    </div>

                    <!-- Menu Icon -->
                    <div x-show="sidebarExpanded" class="text-gray-400 group-hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-white flex flex-col relative w-full">

            <!-- Mobile header (hidden on md-up) -->
            <header
                class="md:hidden h-14 border-b border-gray-200 flex items-center px-4 bg-white sticky top-0 z-10 w-full">
                <button class="text-gray-500 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="ml-4 font-semibold text-gray-900">POS TOYS</div>
            </header>

            <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>

    </div>
</body>

</html>
