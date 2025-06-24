<!-- resources/views/auth/reset-password.blade.php -->
<x-layouts.app>
    <div class="relative min-h-[100vh] flex items-center justify-center overflow-hidden">

        <!-- Card Form -->
        <div class="bg-white/90 shadow-2xl border border-gray-200 rounded-2xl px-10 py-8 w-full max-w-md">
            <h2 class="text-3xl font-bold text-center text-blue-800 mb-1">Toko Usaha Muda</h2>
            <p class="text-center text-gray-600 mb-6">Reset Password Akun Anda</p>

            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="relative mt-1 group">
                        <input type="email" id="email" name="email" value="{{ old('email', request('email')) }}" required
                               class="w-full px-4 py-2 pl-10 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-800">
                        <div class="absolute left-3 top-2.5 text-gray-400 transition-all duration-300 group-hover:text-blue-500 group-hover:scale-110">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <div class="relative mt-1 group">
                        <input type="password" id="password" name="password" required
                               placeholder="Masukkan password baru"
                               class="w-full px-4 py-2 pl-10 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-800">
                        <div class="absolute left-3 top-2.5 text-gray-400 transition-all duration-300 group-hover:text-blue-500 group-hover:scale-110">
                            <i class="fas fa-lock"></i>
                        </div>
                        <button type="button" id="togglePassword"
                            class="absolute right-3 top-2.5 text-gray-400 hover:text-blue-500 transition-all duration-300 hover:scale-110 focus:outline-none" tabindex="-1">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Ulangi Password</label>
                    <div class="relative mt-1 group">
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               placeholder="Ulangi password baru"
                               class="w-full px-4 py-2 pl-10 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 focus:outline-none text-gray-800">
                        <div class="absolute left-3 top-2.5 text-gray-400 transition-all duration-300 group-hover:text-blue-500 group-hover:scale-110">
                            <i class="fas fa-lock"></i>
                        </div>
                        <button type="button" id="togglePasswordConfirmation"
                            class="absolute right-3 top-2.5 text-gray-400 hover:text-blue-500 transition-all duration-300 hover:scale-110 focus:outline-none" tabindex="-1">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl transition duration-300 shadow">
                    Reset Password
                </button>
            </form>

            <p class="mt-6 text-sm text-center text-gray-700">
                <a href="/login" class="text-blue-500 hover:underline font-medium">Kembali ke Login</a>
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });

            const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
            const passwordConfirmation = document.querySelector('#password_confirmation');
            togglePasswordConfirmation.addEventListener('click', function () {
                const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmation.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    </script>
</x-layouts.app>
