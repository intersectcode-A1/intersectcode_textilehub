<!-- resources/views/auth/reset-password.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <form method="POST" action="{{ route('password.update') }}" class="bg-white p-6 rounded-lg shadow-md w-full max-w-md space-y-4">
        @csrf
        <h2 class="text-xl font-bold text-center">Reset Password</h2>

        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', request('email')) }}" required
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Password Baru</label>
            <input type="password" name="password" required
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-500"
                   placeholder="Password baru">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Ulangi Password</label>
            <input type="password" name="password_confirmation" required
                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-500"
                   placeholder="Ulangi password">
        </div>

        <div>
            <button type="submit"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                Reset Password
            </button>
        </div>
    </form>

</body>
</html>
