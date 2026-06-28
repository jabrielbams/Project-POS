<div>
    @if($showModal)
    <!-- Delete Sale Modal -->
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

            <!-- Spacer for centering -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <!-- Modal header -->
                <div class="bg-white px-4 py-4 sm:px-6 border-b">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Hapus Transaksi #{{ $deletingSale?->invoice_no }}
                    </h3>
                </div>

                <!-- Modal body -->
                <form wire:submit="submitDelete" class="px-4 py-4 sm:px-6">
                    <!-- Sale details -->
                    <div class="mb-4 bg-gray-50 p-3 rounded">
                        <p class="text-sm"><strong>Invoice:</strong> {{ $deletingSale?->invoice_no }}</p>
                        <p class="text-sm"><strong>Total Penjualan:</strong> Rp {{ number_format($deletingSale?->total_amount ?? 0, 0, ',', '.') }}</p>
                    </div>

                    <!-- Reason for deletion -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Alasan Penghapusan
                        </label>
                        <textarea wire:model="reason"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                                  placeholder="Alasan penghapusan"></textarea>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button"
                                wire:click="closeModal"
                                class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded-md transition">
                            Hapus Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
