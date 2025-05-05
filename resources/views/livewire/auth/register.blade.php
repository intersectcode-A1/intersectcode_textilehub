<div class="max-w-md mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-1 text-center">toko.usahamuda</h2>

    @if ($step === 1)
        <h3 class="mb-3 text-center">Silahkan Daftar Untuk Melanjutkan</h3>

        @if (session()->has('error'))
            <div class="bg-red-200 p-2 rounded mb-3">
                {{ session('error') }}
            </div>
        @endif

        @if (session()->has('success'))
            <div class="bg-green-200 p-2 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="submitRegistration" class="space-y-4">
            <div>
                <input type="text" wire:model="name" placeholder="Nama Lengkap" required
                       class="w-full p-2 border rounded">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <input type="email" wire:model="email" placeholder="Email" required
                       class="w-full p-2 border rounded">
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <input type="password" wire:model="password" placeholder="Password" required
                       class="w-full p-2 border rounded">
                @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                Daftar
            </button>
        </form>

        <p class="mt-4 text-center">Sudah punya akun?
            <a href="/login" class="text-blue-600">Login di sini</a>
        </p>

    @elseif ($step === 2)
        <h3 class="mb-3 text-center">Verifikasi OTP</h3>

        @if (session()->has('error'))
            <div class="bg-red-200 p-2 rounded mb-3">
                {{ session('error') }}
            </div>
        @endif

        <p class="text-center mb-3">Kode OTP telah dikirim ke email <strong>{{ $email }}</strong>. Masukkan kode OTP untuk menyelesaikan registrasi.</p>

        <div>
            <input type="text" wire:model="otp" placeholder="Kode OTP"
                   class="w-full p-2 border rounded text-center">
            @error('otp')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button wire:click="verifyOtp"
            class="mt-3 w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-400">
            Verifikasi OTP
        </button>

        <p class="mt-4 text-center text-sm text-gray-600">
            Tidak menerima OTP? <button wire:click="submitRegistration" class="text-blue-500 underline">Kirim Ulang</button>
        </p>
    @endif
</div>
