<div class="max-w-md mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-1 text-center">toko.usahamuda</h2>
    <h3 class="mb-3 text-center">
        @if ($step == 1)
            Silahkan Daftar Untuk Melanjutkan
        @elseif ($step == 2)
            Masukkan Kode OTP
        @endif
    </h3>

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

    {{-- STEP 1: FORM REGISTRASI --}}
    @if ($step == 1)
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
        <div>
            <input type="password" wire:model="password_confirmation" placeholder="Konfirmasi Password" required
                   class="w-full p-2 border rounded">
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Daftar
        </button>
    </form>

    <p class="mt-4">Sudah punya akun?
        <a href="/login" class="text-blue-600">Login di sini</a>
    </p>
    @endif

    {{-- STEP 2: FORM OTP --}}
    @if ($step == 2)
    <form wire:submit.prevent="verifyOtp" class="space-y-4">
        <div>
            <input type="text" wire:model="otp" placeholder="Masukkan Kode OTP" required
                   class="w-full p-2 border rounded">
            @error('otp')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-400">
            Verifikasi OTP
        </button>
    </form>

    <p class="mt-4 text-sm text-gray-600 text-center">
        Tidak menerima kode? <button wire:click="submitRegistration" class="text-blue-600 underline">Kirim Ulang</button>
    </p>
    @endif
</div>
