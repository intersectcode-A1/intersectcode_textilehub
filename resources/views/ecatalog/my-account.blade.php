<x-layouts.catalog>
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Tombol Kembali ke E-Catalog (paling atas) --}}
        <a href="{{ route('ecatalog.index') }}" class="inline-flex items-center mb-8 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            Kembali ke E-Catalog
        </a>

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl overflow-hidden animate-fade-in border border-gray-100 dark:border-gray-800">
            {{-- Header Section --}}
            <div class="flex flex-col sm:flex-row items-center gap-6 px-8 py-8 border-b border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 transition-colors duration-300">
                <div class="relative group flex-shrink-0">
                    @if(auth()->user()->profile_photo)
                        <img class="h-28 w-28 rounded-full border-4 border-white dark:border-gray-800 shadow object-cover ring-4 ring-blue-300 dark:ring-blue-700 transition-transform duration-300 group-hover:scale-105" 
                             src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                             alt="{{ auth()->user()->name }}">
                    @else
                        <img class="h-28 w-28 rounded-full border-4 border-white dark:border-gray-800 shadow ring-4 ring-blue-300 dark:ring-blue-700 transition-transform duration-300 group-hover:scale-105" 
                             src="https://i.pravatar.cc/200?u={{ auth()->user()->email }}" 
                             alt="{{ auth()->user()->name }}">
                    @endif
                    <label for="profile_photo" class="absolute bottom-1 right-1 bg-white dark:bg-gray-800 rounded-full p-2 shadow-lg hover:bg-blue-50 dark:hover:bg-gray-700 cursor-pointer border border-blue-200 dark:border-blue-700 transition-all duration-200">
                        <svg class="w-5 h-5 text-blue-700 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </label>
                    @if(auth()->user()->profile_photo)
                        <form action="{{ route('profile.photo.delete') }}" method="POST" class="absolute -bottom-2 -left-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-rose-100 dark:bg-rose-900 text-rose-600 dark:text-rose-300 p-1.5 rounded-full hover:bg-rose-200 dark:hover:bg-rose-800 shadow border border-rose-200 dark:border-rose-800 transition-all duration-200" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus foto profil?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <h1 class="text-2xl sm:text-3xl font-extrabold mb-1 text-blue-900 dark:text-white">{{ auth()->user()->name }}</h1>
                    <p class="text-blue-700 dark:text-blue-200 text-lg font-medium">{{ auth()->user()->email }}</p>
                </div>
            </div>

            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="p-4 bg-green-50 dark:bg-green-900 border-l-4 border-green-500 dark:border-green-400 rounded-xl shadow animate-fade-in">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 dark:text-green-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-green-800 dark:text-green-200 font-semibold">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Profile Information Form --}}
            <div class="p-8 bg-white dark:bg-gray-900 transition-colors duration-300">
                <h2 class="text-2xl font-bold text-blue-900 dark:text-white mb-6">Informasi Profil</h2>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    {{-- Hidden file input --}}
                    <input type="file" name="profile_photo" id="profile_photo" class="hidden" accept="image/*" onchange="this.form.submit()">

                    <div>
                        <label for="name" class="block text-sm font-bold text-blue-800 dark:text-blue-200">Nama</label>
                        <input type="text" name="name" id="name" value="{{ auth()->user()->name }}"
                               class="mt-1 block w-full rounded-xl border-blue-200 dark:border-blue-700 bg-white dark:bg-gray-800 text-blue-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 transition-colors duration-200">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-blue-800 dark:text-blue-200">Email</label>
                        <input type="email" name="email" id="email" value="{{ auth()->user()->email }}"
                               class="mt-1 block w-full rounded-xl border-blue-200 dark:border-blue-700 bg-white dark:bg-gray-800 text-blue-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 transition-colors duration-200">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-bold text-blue-800 dark:text-blue-200">Nomor Telepon</label>
                        <input type="tel" name="phone" id="phone" value="{{ auth()->user()->phone }}"
                               class="mt-1 block w-full rounded-xl border-blue-200 dark:border-blue-700 bg-white dark:bg-gray-800 text-blue-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 transition-colors duration-200">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-bold text-blue-800 dark:text-blue-200">Alamat</label>
                        <textarea name="address" id="address" rows="3"
                                  class="mt-1 block w-full rounded-xl border-blue-200 dark:border-blue-700 bg-white dark:bg-gray-800 text-blue-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 transition-colors duration-200">{{ auth()->user()->address }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="btn btn-primary px-8 py-3 text-base font-bold rounded-xl shadow focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-200">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.catalog> 