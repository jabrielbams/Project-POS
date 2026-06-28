<!-- Activity Log Tab -->
<div class="py-4">
    @if($auditLogs)
        <div class="flow-root">
            <ul role="list" class="-mb-8">
                @foreach($auditLogs as $log)
                    <li>
                        <div class="relative pb-8">
                            @if(!$loop->last)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"></span>
                            @endif
                            <div class="relative flex space-x-3">
                                <!-- Avatar -->
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                        @if($log['action'] === 'edit')
                                            <span class="text-white text-sm">✏️</span>
                                        @elseif($log['action'] === 'delete')
                                            <span class="text-white text-sm">🗑️</span>
                                        @elseif($log['action'] === 'restore')
                                            <span class="text-white text-sm">↩️</span>
                                        @endif
                                    </span>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $this->getActivityLabel($log['action']) }}
                                            @if($log['user'])
                                                by <strong>{{ $log['user']['name'] }}</strong>
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($log['created_at'])->format('M d, Y H:i:s') }}
                                        </p>
                                    </div>

                                    @if($log['reason'])
                                        <div class="mt-2 text-sm text-gray-700 bg-yellow-50 p-2 rounded border-l-2 border-yellow-400">
                                            <strong>Reason:</strong> {{ $log['reason'] }}
                                        </div>
                                    @endif

                                    <!-- Changes -->
                                    @if($log['changed_fields'])
                                        <div class="mt-3 text-sm">
                                            <p class="font-medium text-gray-900 mb-2">Changes:</p>
                                            <div class="bg-gray-50 p-2 rounded space-y-1">
                                                @foreach($log['changed_fields'] as $field)
                                                    <div class="text-xs text-gray-600">
                                                        <strong>{{ ucfirst(str_replace('_', ' ', $field)) }}:</strong>
                                                        @if(isset($log['old_values'][$field]))
                                                            <code class="bg-red-100 text-red-700 px-1 rounded">{{ $this->formatValue($log['old_values'][$field]) }}</code>
                                                        @endif
                                                        →
                                                        @if(isset($log['new_values'][$field]))
                                                            <code class="bg-green-100 text-green-700 px-1 rounded">{{ $this->formatValue($log['new_values'][$field]) }}</code>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 text-sm">No activity log entries for this sale</p>
        </div>
    @endif
</div>
