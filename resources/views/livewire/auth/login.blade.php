<components.layouts.app>
    <div class="relative min-h-[100vh] flex items-center justify-center overflow-hidden">

        <!-- Background Gambar -->
        <div class="absolute inset-0 -z-10">
            <img src="{{ asset('image/ceo.jpg') }}" alt="Background Login"
                 class="w-full h-full object-cover brightness-90">
        </div>

        <!-- Form Login -->
        <div class="bg-white/90 shadow-2xl border border-gray-200 rounded-2xl px-10 py-8 w-full max-w-md">
            <h2 class="text-3xl font-bold text-center text-blue-800 mb-1">Toko Usaha Muda</h2>
            <p class="text-center text-gray-600 mb-6">Silakan login untuk melanjutkan</p>

            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="login" class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="relative mt-1">
                        <input type="email" id="email" wire:model="email" required
                            class="w-full px-4 py-2 pl-10 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-800">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    @error('email')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative mt-1">
                        <input type="password" id="password" wire:model="password" required
                            class="w-full px-4 py-2 pl-10 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-800">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    @error('password')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl transition duration-300 shadow">
                    Login
                </button>
            </form>

            @if (session()->has('message'))
                <p class="text-green-600 mt-4 text-sm text-center">{{ session('message') }}</p>
            @endif

            <p class="mt-6 text-sm text-center text-gray-700">Belum punya akun? 
                <a href="/register" class="text-blue-500 hover:underline font-medium">Daftar di sini</a>
            </p>
            <p class="text-sm text-center mt-2">
                <a href="/forgot-password" class="text-blue-500 hover:underline">Lupa password?</a>
            </p>
        </div>
    </div>
</components.layouts.app>
