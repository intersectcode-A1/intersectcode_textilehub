<div class="max-w-md mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-1 text-center">toko.usahamuda</h2>
    <h3 class="mb-3 text-center">Silahkan Login Untuk Melanjutkan</h3>

    @if (session()->has('error'))
        <div class="bg-red-200 p-2 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="login" class="space-y-4">
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

        <button type="submit"class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Login
        </button>
    </form>

    <p class="mt-4">Belum punya akun?
        <a href="/register" class="text-blue-600">Daftar di sini</a>
    </p>
    <a href="/forgot-password" class="text-sm text-blue-500">Lupa password</a>
</div>