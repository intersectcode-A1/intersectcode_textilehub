<x-layouts.catalog>
    <section class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-white transition-colors duration-300 rounded-3xl">
        <!-- Subtle background gradient -->
        <div class="relative z-10 bg-white/80 glass rounded-2xl shadow-2xl overflow-hidden animate-fadeIn">
            <div class="p-8">
                <!-- Stepper -->
                <div class="flex items-center justify-center mb-8">
                    <div class="flex items-center gap-0.5">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-bold shadow">1</div>
                            <span class="text-xs text-blue-700 mt-1 font-semibold">Transfer</span>
                        </div>
                        <div class="w-8 h-1 bg-blue-200 mx-1 rounded"></div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gradient-to-r from-blue-400 to-emerald-400 text-white font-bold shadow">2</div>
                            <span class="text-xs text-blue-700 mt-1 font-semibold">Upload</span>
                        </div>
                        <div class="w-8 h-1 bg-blue-200 mx-1 rounded"></div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gradient-to-r from-emerald-400 to-green-500 text-white font-bold shadow">3</div>
                            <span class="text-xs text-blue-700 mt-1 font-semibold">Konfirmasi</span>
                        </div>
                    </div>
                </div>
                <!-- Header -->
                <div class="flex items-center gap-3 mb-8">
                    <div class="bg-gradient-to-tr from-blue-100 to-indigo-100 rounded-full p-3 shadow">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-1.79-8-4V6a2 2 0 012-2h12a2 2 0 012 2v8c0 2.21-3.582 4-8 4z"/></svg>
                    </div>
                    <h1 class="text-3xl font-extrabold text-blue-900">Pembayaran Pesanan <span class="text-indigo-600">#{{ $order->order_number }}</span></h1>
                </div>
                <!-- Payment Info & Rekening -->
                <div class="mb-10 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h2 class="text-lg font-bold text-blue-800 mb-2">Total Pembayaran</h2>
                        <div class="bg-gradient-to-r from-green-50 to-emerald-100 rounded-xl p-6 flex items-center gap-3 shadow">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-1.79-8-4V6a2 2 0 012-2h12a2 2 0 012 2v8c0 2.21-3.582 4-8 4z"/></svg>
                            <span class="text-3xl font-extrabold text-green-700">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-blue-800 mb-2">Rekening Tujuan</h2>
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-100 rounded-xl p-6 shadow">
                            <div class="mb-2 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 6h18M3 14h18M3 18h18" /></svg>
                                <span class="font-semibold">Bank BCA</span>
                            </div>
                            <div class="mb-1 text-lg font-bold text-blue-900 tracking-widest">1234567890</div>
                            <div class="text-blue-700 font-semibold">Toko Usaha Muda Padang</div>
                        </div>
                    </div>
                </div>
                <!-- Instruksi -->
                <div class="mb-10">
                    <h2 class="text-lg font-bold text-blue-800 mb-2">Instruksi Pembayaran</h2>
                    <div class="prose prose-sm text-blue-700">
                        <ol class="list-decimal list-inside space-y-2">
                            <li>Transfer total pembayaran ke rekening tujuan di atas.</li>
                            <li>Simpan bukti transfer Anda.</li>
                            <li>Upload bukti transfer pada form di bawah ini.</li>
                            <li>Tunggu konfirmasi dari admin (maksimal 1x24 jam).</li>
                        </ol>
                    </div>
                </div>
                <!-- Upload Bukti Pembayaran -->
                <form action="{{ route('payment.process', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    <div>
                        <label for="payment_proof" class="block text-sm font-bold text-blue-800 mb-2">
                            Upload Bukti Pembayaran
                        </label>
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <div class="flex-1">
                                <input type="file"
                                       id="payment_proof"
                                       name="payment_proof"
                                       accept="image/*"
                                       class="block w-full text-sm text-blue-700
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
                            <div class="flex flex-col items-center gap-1">
                                <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                <span class="text-xs text-blue-400">JPG/PNG, max 2MB</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:from-green-600 hover:to-emerald-600 transition duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5 inline -mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            Kirim Bukti Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @if(session('error'))
            <div class="mt-8 rounded-xl bg-gradient-to-r from-red-50 to-pink-50 p-4 border-l-4 border-red-500 shadow-lg animate-fadeIn">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-red-800 font-semibold">{{ session('error') }}</span>
                </div>
            </div>
        @endif
        @if(session('success'))
            <div class="mt-8 rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 p-4 border-l-4 border-green-500 shadow-lg animate-fadeIn">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-green-800 font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif
    </section>
</x-layouts.catalog> 