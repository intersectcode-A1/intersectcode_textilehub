<components.layouts.app>
    <div class="relative min-h-[100vh] flex items-center justify-center overflow-hidden">

        <!-- Background Gambar -->

        <!-- Card Form -->
        <div class="bg-white/90 shadow-2xl border border-gray-200 rounded-2xl px-10 py-8 w-full max-w-md">
            <h2 class="text-3xl font-bold text-center text-blue-800 mb-1">Toko Usaha Muda</h2>
            <p class="text-center text-gray-600 mb-6">Masukkan email untuk reset password</p>

            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="relative mt-1">
                        <input type="email" id="email" name="email" required
                               placeholder="Masukkan email kamu"
                               class="w-full px-4 py-2 pl-10 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-800">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl transition duration-300 shadow">
                    Kirim Link Reset
                </button>
            </form>

            <p class="mt-6 text-sm text-center text-gray-700">
                <a href="/login" class="text-blue-500 hover:underline font-medium">Kembali ke Login</a>
            </p>
        </div>
    </div>
</components.layouts.app>
