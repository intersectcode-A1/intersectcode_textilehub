<div class="max-w-md mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4">Login</h2>

    @if (session()->has('error'))
        <div class="bg-red-200 p-2 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="login" class="space-y-4">
        <input type="email" wire:model="email" placeholder="Email" class="w-full p-2 border rounded">
        <input type="password" wire:model="password" placeholder="Password" class="w-full p-2 border rounded">
        <button type="submit"
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-400">
            Login
        </button>

    </form>

    <p class="mt-4">Belum punya akun? <a href="/register" class="text-blue-600">Daftar di sini</a></p>
    <a href="/forgot-password">Lupa password</a>
</div>
