<components.layouts.app>
    <div class="relative min-h-[100vh] flex items-center justify-center overflow-hidden">


        <!-- Form Register -->
        <div class="bg-white/90 shadow-2xl border border-gray-200 rounded-2xl px-10 py-8 w-full max-w-md">
            <h2 class="text-3xl font-bold text-center text-blue-800 mb-1">Daftar Akun</h2>
            <p class="text-center text-gray-600 mb-6">
                {{ $step === 1 ? 'Buat akun untuk mulai berbelanja di Toko Usaha Muda' : 'Masukkan kode OTP yang dikirim ke email Anda' }}
            </p>

            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($step === 1)
                <form wire:submit.prevent="register" class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <div class="relative mt-1">
                            <input type="text" id="name" wire:model="name" required
                                   class="w-full px-4 py-2 pl-10 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-800">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="relative mt-1">
                            <input type="email" id="email" wire:model="email" required
                                   class="w-full px-4 py-2 pl-10 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-800">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                        @error('email') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
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
                        @error('password') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <div class="relative mt-1">
                            <input type="password" id="password_confirmation" wire:model="password_confirmation" required
                                   class="w-full px-4 py-2 pl-10 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-800">
                            <div class="absolute left-3 top-2.5 text-gray-400">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                        @error('password_confirmation') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl transition duration-300 shadow">
                        Daftar Sekarang
                    </button>
                </form>
            @elseif ($step === 2)
                <form wire:submit.prevent="verifyOtp" class="space-y-5">
                    <div>
                        <label for="otp" class="block text-sm font-medium text-gray-700">Kode OTP</label>
                        <input type="text" id="otp" wire:model="otp" maxlength="6" required
                            class="w-full px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-800">
                        @error('otp') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-xl transition duration-300 shadow">
                        Verifikasi OTP
                    </button>
                </form>

                <button wire:click="resendOtp" class="mt-4 w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 rounded-xl transition duration-300 shadow">
                    Kirim Ulang OTP
                </button>

                @if (session()->has('resent'))
                    <p class="text-green-600 mt-2 text-sm text-center">{{ session('resent') }}</p>
                @endif
            @endif

            <p class="mt-6 text-sm text-center text-gray-700">Sudah punya akun? 
                <a href="/login" class="text-blue-500 hover:underline font-medium">Login di sini</a>
            </p>
        </div>
    </div>
</components.layouts.app>