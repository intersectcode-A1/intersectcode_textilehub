<!-- resources/views/auth/forgot-password.blade.php -->
{{-- <form method="POST" action="{{ route('password.email') }}">
    @csrf
    <input type="email" name="email" placeholder="Masukkan email kamu" required />
    <button type="submit">Kirim Link Reset</button>
</form> --}}

<div class="max-w-md mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4">toko.usahamuda</h2>

    @if (session('status'))
        <div class="bg-green-200 p-2 rounded mb-3 text-green-800">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-200 p-2 rounded mb-3 text-red-800">
            <ul class="text-sm pl-4 list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <input type="email" name="email" placeholder="Masukkan email kamu" required
                   class="w-full p-2 border rounded" />
        </div>

        <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Kirim Link Reset
        </button>
    </form>

    <p class="mt-4">
        <a href="/login" class="text-sm text-blue-600">Kembali ke Login</a>
    </p>
</div>
