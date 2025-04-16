<!-- resources/views/auth/forgot-password.blade.php -->
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <input type="email" name="email" placeholder="Masukkan email kamu" required />
    <button type="submit">Kirim Link Reset</button>
</form>
