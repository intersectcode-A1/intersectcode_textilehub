<!-- resources/views/livewire/auth/otp-verification.blade.php -->
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-center mb-4">Verifikasi OTP</h2>
    
    @if (session()->has('error'))
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="verifyOtp">
        <div class="mb-4">
            <label for="otp" class="block text-sm font-medium text-gray-700">Kode OTP</label>
            <input type="text" id="otp" wire:model="otp" class="w-full p-2 mt-2 border rounded-md" placeholder="Masukkan kode OTP" required>
        </div>

        <div class="mb-4">
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">
                Verifikasi OTP
            </button>
        </div>
    </form>

    <div class="text-center">
        <a href="{{ route('login') }}" class="text-sm text-blue-500 hover:underline">Kembali ke login</a>
    </div>
</div>
