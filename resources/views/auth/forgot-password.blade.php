<!-- resources/views/auth/forgot-password.blade.php -->
{{-- <form method="POST" action="{{ route('password.email') }}">
    @csrf
    <input type="email" name="email" placeholder="Masukkan email kamu" required />
    <button type="submit">Kirim Link Reset</button>
</form> --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - toko.usahamuda</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #93c5fd, #bfdbfe); /* gradasi biru muda */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">

    <div class="max-w-md w-full bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-4 text-blue-600">toko.usahamuda</h2>

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
                <label for="email" class="block text-sm font-medium mb-1 text-gray-700">Email</label>
                <input type="email" name="email" placeholder="Masukkan email kamu" required
                       class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                Kirim Link Reset
            </button>
        </form>

        <p class="mt-4 text-center">
            <a href="/login" class="text-sm text-blue-600 hover:underline">Kembali ke Login</a>
        </p>
    </div>

</body>
</html>
