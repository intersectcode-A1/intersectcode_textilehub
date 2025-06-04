<x-layouts.catalog>
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <a href="{{ route('order.detail', $order->id) }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Detail Pesanan
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-6">Pembayaran Pesanan #{{ $order->order_number }}</h1>

                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembayaran</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-600 mb-2">Total Pembayaran:</p>
                        <p class="text-3xl font-bold text-green-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Instruksi Pembayaran</h2>
                    <div class="prose prose-sm text-gray-600">
                        <ol class="list-decimal list-inside space-y-2">
                            <li>Transfer total pembayaran ke rekening berikut:
                                <div class="bg-gray-50 rounded p-3 mt-2">
                                    <p class="font-medium">Bank BCA</p>
                                    <p class="font-medium">1234567890</p>
                                    <p class="font-medium">a.n. PT Textile Hub Indonesia</p>
                                </div>
                            </li>
                            <li>Simpan bukti transfer</li>
                            <li>Upload bukti transfer pada form di bawah ini</li>
                            <li>Tunggu konfirmasi dari admin (1x24 jam)</li>
                        </ol>
                    </div>
                </div>

                <form action="{{ route('payment.process', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Bukti Pembayaran
                        </label>
                        <input type="file" 
                               id="payment_proof" 
                               name="payment_proof" 
                               accept="image/*"
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-blue-50 file:text-blue-700
                                      hover:file:bg-blue-100"
                               required>
                        @error('payment_proof')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200">
                            Kirim Bukti Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(session('error'))
            <div class="mt-8 rounded-md bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </section>
</x-layouts.catalog> 