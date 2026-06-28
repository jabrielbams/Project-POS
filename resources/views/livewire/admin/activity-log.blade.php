<div class="animate-in fade-in duration-300 relative w-full pb-10">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Log Aktivitas</h1>
    </div>

    <!-- Filters -->
    <div class="mb-4 flex flex-col sm:flex-row items-start sm:items-center gap-3">
        <div class="relative w-full sm:w-[300px]">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search"
                class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm"
                placeholder="Search by user, sale ID, or reason">
        </div>

        <select wire:model.live="filterAction"
            class="appearance-none px-3 py-2 border border-gray-300 bg-white rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors shadow-sm">
            <option value="">All Actions</option>
            <option value="edit">Edit</option>
            <option value="delete">Delete</option>
            <option value="restore">Restore</option>
        </select>
    </div>

    <!-- Table -->
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-2.5 text-xs font-medium text-gray-500">Date</th>
                        <th class="px-4 py-2.5 text-xs font-medium text-gray-500">User</th>
                        <th class="px-4 py-2.5 text-xs font-medium text-gray-500">Action</th>
                        <th class="px-4 py-2.5 text-xs font-medium text-gray-500">Sale ID</th>
                        <th class="px-4 py-2.5 text-xs font-medium text-gray-500">Reason</th>
                        <th class="px-4 py-2.5 text-xs font-medium text-gray-500">Changes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-[13px] text-gray-600 whitespace-nowrap">
                                {{ $log->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-3 text-[13px] text-gray-900 font-medium">
                                {{ $log->user?->name ?? 'System' }}
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $actionClass = match($log->action) {
                                        'edit' => 'bg-blue-50 text-blue-700 border-blue-100',
                                        'delete' => 'bg-red-50 text-red-700 border-red-100',
                                        'restore' => 'bg-green-50 text-green-700 border-green-100',
                                        default => 'bg-gray-50 text-gray-700 border-gray-200',
                                    };
                                    $actionLabel = match($log->action) {
                                        'edit' => 'Edit',
                                        'delete' => 'Delete',
                                        'restore' => 'Restore',
                                        default => ucfirst($log->action),
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold border {{ $actionClass }}">
                                    {{ $actionLabel }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.sales.show', $log->auditable_id) }}"
                                   class="text-[13px] text-blue-600 hover:text-blue-800 font-mono font-medium hover:underline">
                                    #{{ $log->auditable_id }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-[13px] text-gray-600 max-w-[200px] truncate">
                                {{ $log->reason ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-[12px] text-gray-500">
                                @if($log->changed_fields)
                                    <span class="font-mono">{{ implode(', ', $log->changed_fields) }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center">
                                <svg class="mx-auto h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No activity logs</h3>
                                <p class="mt-1 text-xs text-gray-500">No audit records found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($logs->hasPages())
            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50/50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
