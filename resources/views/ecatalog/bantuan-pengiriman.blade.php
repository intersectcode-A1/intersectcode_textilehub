<x-layouts.catalog>
    <section class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-50 via-white to-emerald-50 py-12 px-4">
        <div class="w-full max-w-xl mx-auto">
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-blue-100 p-6 md:p-10 animate-fadeIn">
                <a href="{{ route('ecatalog.index') }}" class="inline-flex items-center mb-6 px-5 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-bold rounded-xl shadow hover:scale-105 hover:shadow-lg transition-all duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    Kembali ke E-Catalog
                </a>
                <h1 class="text-3xl md:text-4xl font-extrabold text-blue-900 mb-2 text-center tracking-tight drop-shadow">Bantuan Pengiriman</h1>
                <p class="text-base md:text-lg text-blue-700 mb-8 text-center font-medium">Kami siap membantu Anda 24 jam jika mengalami kendala atau butuh informasi terkait pengiriman pesanan.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="relative group bg-white/90 rounded-xl border border-green-200 shadow hover:shadow-2xl hover:-translate-y-1 transition-all duration-200 p-6 flex flex-col items-center">
                        <span class="absolute top-4 right-4 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">24 Jam</span>
                        <div class="bg-green-100 rounded-full p-4 mb-3 shadow-inner">
                            <svg class="w-10 h-10 text-green-600" viewBox="0 0 32 32" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><g><path d="M16 3C9.373 3 4 8.373 4 15c0 2.385.668 4.678 1.934 6.68L4.07 28.07a1 1 0 0 0 1.26 1.26l6.39-1.864A12.94 12.94 0 0 0 16 27c6.627 0 12-5.373 12-12S22.627 3 16 3zm0 22.5c-2.09 0-4.13-.61-5.86-1.76l-.42-.27-3.79 1.11 1.13-3.69-.27-.43A9.97 9.97 0 0 1 6 15c0-5.514 4.486-10 10-10s10 4.486 10 10-4.486 10-10 10zm5.13-7.47c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.7.9-.86 1.08-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.25-1.4-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.32.42-.48.14-.16.18-.28.28-.46.09-.18.05-.34-.02-.48-.07-.14-.61-1.47-.84-2.01-.22-.53-.45-.46-.61-.47-.16-.01-.34-.01-.52-.01-.18 0-.48.07-.73.34-.25.27-.97.95-.97 2.3 0 1.35.99 2.65 1.13 2.83.14.18 1.95 2.98 4.73 4.06.66.28 1.18.45 1.58.58.66.21 1.26.18 1.73.11.53-.08 1.65-.67 1.88-1.32.23-.65.23-1.2.16-1.32-.07-.12-.25-.19-.53-.33z"/></g></svg>
                        </div>
                        <span class="text-lg font-bold text-green-700 mb-2">WhatsApp</span>
                        <a href="https://wa.me/6281234567890" target="_blank" class="w-full flex items-center justify-center gap-2 mt-2 px-4 py-2 rounded-xl bg-gradient-to-r from-green-500 to-emerald-500 text-white font-bold text-base shadow hover:from-green-600 hover:to-emerald-600 hover:scale-105 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-green-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 32 32"><g><path d="M16 3C9.373 3 4 8.373 4 15c0 2.385.668 4.678 1.934 6.68L4.07 28.07a1 1 0 0 0 1.26 1.26l6.39-1.864A12.94 12.94 0 0 0 16 27c6.627 0 12-5.373 12-12S22.627 3 16 3zm0 22.5c-2.09 0-4.13-.61-5.86-1.76l-.42-.27-3.79 1.11 1.13-3.69-.27-.43A9.97 9.97 0 0 1 6 15c0-5.514 4.486-10 10-10s10 4.486 10 10-4.486 10-10 10zm5.13-7.47c-.28-.14-1.65-.81-1.9-.9-.25-.09-.43-.14-.61.14-.18.28-.7.9-.86 1.08-.16.18-.32.2-.6.07-.28-.14-1.18-.44-2.25-1.4-.83-.74-1.39-1.65-1.55-1.93-.16-.28-.02-.43.12-.57.13-.13.28-.32.42-.48.14-.16.18-.28.28-.46.09-.18.05-.34-.02-.48-.07-.14-.61-1.47-.84-2.01-.22-.53-.45-.46-.61-.47-.16-.01-.34-.01-.52-.01-.18 0-.48.07-.73.34-.25.27-.97.95-.97 2.3 0 1.35.99 2.65 1.13 2.83.14.18 1.95 2.98 4.73 4.06.66.28 1.18.45 1.58.58.66.21 1.26.18 1.73.11.53-.08 1.65-.67 1.88-1.32.23-.65.23-1.2.16-1.32-.07-.12-.25-.19-.53-.33z"/></g></svg>
                            Chat WhatsApp
                        </a>
                        <span class="text-xs text-gray-500 mt-2">Klik tombol untuk chat langsung</span>
                    </div>
                    <div class="relative group bg-white/90 rounded-xl border border-blue-200 shadow hover:shadow-2xl hover:-translate-y-1 transition-all duration-200 p-6 flex flex-col items-center">
                        <span class="absolute top-4 right-4 bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">24 Jam</span>
                        <div class="bg-blue-100 rounded-full p-4 mb-3 shadow-inner">
                            <svg class="w-10 h-10 text-blue-600" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M6.62 10.79a15.053 15.053 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.07 21 3 13.93 3 5a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.46.57 3.58a1 1 0 0 1-.24 1.01l-2.2 2.2z"/></svg>
                        </div>
                        <span class="text-lg font-bold text-blue-700 mb-2">Telepon</span>
                        <a href="tel:081234567890" class="w-full flex items-center justify-center gap-2 mt-2 px-4 py-2 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-bold text-base shadow hover:from-blue-600 hover:to-indigo-600 hover:scale-105 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79a15.053 15.053 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1C10.07 21 3 13.93 3 5a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.46.57 3.58a1 1 0 0 1-.24 1.01l-2.2 2.2z"/></svg>
                            Telepon Sekarang
                        </a>
                        <span class="text-xs text-gray-500 mt-2">Klik tombol untuk langsung menelepon</span>
                    </div>
                </div>
                <div class="mt-8">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"/></svg>
                        <span class="font-bold text-blue-700">Jam Layanan:</span>
                        <span class="text-gray-700">24 Jam / 7 Hari</span>
                    </div>
                    <div class="mt-4">
                        <h2 class="text-lg font-bold text-blue-900 mb-2">FAQ</h2>
                        <ul class="list-disc pl-6 text-gray-700 space-y-1">
                            <li><span class="font-semibold">Bagaimana jika tidak ada respon?</span> Silakan coba hubungi di jam berbeda atau gunakan kedua kontak yang tersedia.</li>
                            <li><span class="font-semibold">Apakah layanan ini gratis?</span> Ya, bantuan pengiriman tidak dipungut biaya apapun.</li>
                            <li><span class="font-semibold">Apakah bisa menghubungi di luar jam kerja?</span> Ya, layanan ini 24 jam, namun respon tercepat di jam kerja (08.00-20.00).</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.catalog> 