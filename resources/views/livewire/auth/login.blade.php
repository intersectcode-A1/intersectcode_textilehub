<div>
    <div class="max-w-md mx-auto mt-10 bg-white shadow-md rounded p-6">
        <h2 class="text-2xl font-bold mb-1 text-center">Toko Usaha Muda</h2>
        <h3 class="mb-3 text-center text-gray-600">Silakan login untuk melanjutkan</h3>

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-3">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="login" class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" wire:model="email" required class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('email') 
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div> 
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" wire:model="password" required class="mt-1 w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('password') 
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div> 
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                Login
            </button>
        </form>

        @if (session()->has('message'))
            <div class="text-green-600 mt-2">{{ session('message') }}</div>
        @endif

        <p class="mt-4 text-sm text-center">Belum punya akun? 
            <a href="/register" class="text-blue-600 hover:underline">Daftar di sini</a>
        </p>
        <p class="text-sm text-center mt-1">
            <a href="/forgot-password" class="text-blue-500 hover:underline">Lupa password?</a>
        </p>
    </div>
</div>
