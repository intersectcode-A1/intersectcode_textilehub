<div>
    @if ($step == 1)
        <form wire:submit.prevent="submitRegistration">
            <input type="text" wire:model="name" placeholder="Name">
            <input type="email" wire:model="email" placeholder="Email">
            <input type="password" wire:model="password" placeholder="Password">
            <button type="submit">Daftar</button>
        </form>
    @elseif ($step == 2)
        <form wire:submit.prevent="verifyOtp">
            <input type="text" wire:model="otp" placeholder="Masukkan OTP">
            <button type="submit">Verifikasi</button>
        </form>
    @endif

    @if (session()->has('error'))
        <div style="color:red;">{{ session('error') }}</div>
    @endif
</div>