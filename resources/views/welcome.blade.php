<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Usaha Muda</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('image/img_logo_tokousahamuda.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
</head>

<body class="bg-gradient-to-br from-white to-blue-50 text-gray-800 font-sans scroll-smooth">

    <!-- Navbar -->
    <header class="sticky top-0 z-50 bg-white/70 backdrop-blur shadow-md rounded-b-2xl">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold text-blue-600 drop-shadow">
                <a href="/" class="hover:scale-105 transition-all">Toko Usaha Muda</a>
            </div>
            <nav class="hidden md:flex space-x-6 text-gray-700 font-medium">
                <a href="#produk" class="hover:text-blue-600 transition">Produk</a>
                <a href="#testimoni" class="hover:text-blue-600 transition">Testimoni</a>
              <a href="#kenapa-memilih-kami" class="hover:text-blue-600 transition">Keunggulan</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-4 py-1 rounded-lg border border-gray-300 hover:bg-blue-100 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-1 rounded-lg border border-blue-500 text-blue-600 hover:bg-blue-600 hover:text-white transition">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-1 rounded-lg border border-blue-500 text-blue-600 hover:bg-blue-600 hover:text-white transition">Register</a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative max-w-7xl mx-auto my-12 p-10 bg-cover bg-center rounded-3xl shadow-2xl overflow-hidden" style="background-image: url('/image/ceo.jpg')" data-aos="zoom-in">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-md rounded-3xl"></div>
        <div class="relative z-10 text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 drop-shadow-lg">Selamat datang di <span class="text-blue-300">Toko Usaha Muda</span></h1>
            <p class="text-xl italic mb-8 text-gray-200">Temukan produk berkualitas dari kami</p>
            <a href="#produk" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-xl shadow-lg hover:bg-blue-700 transition duration-300">Lihat Produk</a>
            <div class="mt-10 animate-bounce">
                <svg class="mx-auto h-8 w-8 text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
    </section>

    <!-- Produk Section -->
<section id="produk" class="max-w-7xl w-full py-20 px-6" data-aos="fade-up">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-blue-600 mb-2">Produk Unggulan</h2>
        <p class="text-gray-500 text-lg">Dipilih khusus untuk memenuhi kebutuhan Anda</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

  <!-- Produk 1 -->
  <div class="bg-white/70 backdrop-blur-xl rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 hover:scale-105 p-6" data-aos="zoom-in" data-aos-delay="100">
    <img src="/image/kainrenda.jpeg" alt="Produk 1" class="rounded-xl h-48 w-full object-cover mb-4">
    <h3 class="text-xl font-semibold text-blue-700">Produk Terlaris</h3>
    <p class="text-gray-600 mt-2 text-sm">Kain Renda Eksklusif – Sentuhan Elegan untuk Setiap Kreasi
    Hadirkan kesan anggun dan mewah dalam setiap jahitan Anda. Kain renda berkualitas tinggi dengan motif detail dan tekstur lembut, sempurna untuk kebaya, gaun pesta, atau busana pengantin..</p>
    <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Lihat Detail</button>
  </div>

  <!-- Produk 2 -->
  <div class="bg-white/70 backdrop-blur-xl rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 hover:scale-105 p-6" data-aos="zoom-in" data-aos-delay="200">
    <img src="/image/pitasatin.jpeg" alt="Produk 2" class="rounded-xl h-48 w-full object-cover mb-4">
    <h3 class="text-xl font-semibold text-blue-700">Produk Ternama</h3>
    <p class="text-gray-600 mt-2 text-sm">Pita Satin Premium – Sentuhan Anggun untuk Setiap Dekorasi
    Terbuat dari bahan satin pilihan dengan kilau mewah dan tekstur lembut. Ideal untuk dekorasi pernikahan, hampers, buket bunga, hingga proyek DIY eksklusif Anda..</p>
    <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Lihat Detail</button>
  </div>

  <!-- Produk 3 -->
  <div class="bg-white/70 backdrop-blur-xl rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 hover:scale-105 p-6" data-aos="zoom-in" data-aos-delay="300">
    <img src="/image/benangobras.jpeg" alt="Produk 3" class="rounded-xl h-48 w-full object-cover mb-4">
    <h3 class="text-xl font-semibold text-blue-700">Produk Terbaru</h3>
    <p class="text-gray-600 mt-2 text-sm">Benang Obras Premium – Sempurna untuk Setiap Jahitan
    Hadir dengan bahan 100% polyester berkualitas tinggi, benang obras ini dirancang untuk memberikan hasil jahitan yang rapi, kuat, dan tahan lama.
    Teksturnya halus dan tidak mudah putus, menjadikannya pilihan tepat untuk segala jenis kain – mulai dari bahan ringan hingga tebal..</p>
    <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Lihat Detail</button>
  </div>

</div>

</section>

<!-- Testimoni Section -->
<section id="testimoni" class="max-w-7xl w-full py-20 px-6" data-aos="fade-up">

  <!-- Judul Section -->
  <div class="text-center mb-12">
    <h2 class="text-4xl font-bold text-blue-600 mb-2">Apa Kata Mereka</h2>
    <p class="text-gray-500 text-lg">Testimoni pelanggan kami yang puas</p>
  </div>

  <!-- Grid Testimoni -->
  <div class="grid md:grid-cols-3 gap-8">

    <!-- Testimoni 1 -->
    <div class="bg-white/80 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition duration-300" data-aos="fade-up" data-aos-delay="0">
      <p class="text-gray-700 italic">"Berbagai macam kain ada disini,bakal balik sini terus si!!"</p>
      <div class="mt-4 flex items-center space-x-4">
      <img src="{{ asset('image/cewecantik.jpeg') }}" alt="Foto Cewek Cantik" class="rounded-full w-16 h-16 object-cover" />
        <div>
          <p class="font-bold text-blue-700">Amira</p>
          <p class="text-sm text-gray-500">Pelanggan</p>
        </div>
      </div>
    </div>

    <!-- Testimoni 2 -->
    <div class="bg-white/80 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition duration-300" data-aos="fade-up" data-aos-delay="200">
      <p class="text-gray-700 italic">"Pelayanan luar biasa, produk berkualitas. Sangat direkomendasikan!"</p>
      <div class="mt-4 flex items-center space-x-4">
         <img src="{{ asset('image/cowoganteng.jpeg') }}" alt="Foto Cowo Ganteng" class="rounded-full w-16 h-16 object-cover" />
        <div>
          <p class="font-bold text-blue-700">Budi</p>
          <p class="text-sm text-gray-500">Pelanggan</p>
        </div>
      </div>
    </div>

    <!-- Testimoni 3 -->
    <div class="bg-white/80 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition duration-300" data-aos="fade-up" data-aos-delay="400">
      <p class="text-gray-700 italic">"Produknya sangat bagus,nyampe di bandung dengan baik dan tidak ada kerusakan"</p>
      <div class="mt-4 flex items-center space-x-4">
        <img src="{{ asset('image/cowo.jpeg') }}" alt="Foto Cowo " class="rounded-full w-16 h-16 object-cover" />
        <div>
          <p class="font-bold text-blue-700">Boy</p>
          <p class="text-sm text-gray-500">Pelanggan</p>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Kenapa memilih kami -->
<section id="kenapa-memilih-kami" class="py-12 bg-white mb-12">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <h2 class="text-3xl font-bold text-gray-800 mb-8" data-aos="fade-up">Kenapa Memilih Kami?</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

      <!-- Pengiriman cepat & aman -->
      <div class="flex flex-col items-center" data-aos="fade-up" data-aos-delay="0">
        <div class="bg-blue-100 p-4 rounded-full mb-4">
          <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 5m12-5l2 5m-6-5v5"></path>
          </svg>
        </div>
        <p class="text-gray-700 font-semibold">Pengiriman cepat & aman</p>
      </div>

      <!-- Kualitas kain terbaik -->
      <div class="flex flex-col items-center" data-aos="fade-up" data-aos-delay="100">
        <div class="bg-green-100 p-4 rounded-full mb-4">
          <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
        <p class="text-gray-700 font-semibold">Kualitas kain terbaik</p>
      </div>

      <!-- Harga bersaing -->
      <div class="flex flex-col items-center" data-aos="fade-up" data-aos-delay="200">
        <div class="bg-yellow-100 p-4 rounded-full mb-4">
          <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3m0-6v6m0 4v.01"></path>
          </svg>
        </div>
        <p class="text-gray-700 font-semibold">Harga bersaing</p>
      </div>

      <!-- Pelayanan pelanggan responsif -->
      <div class="flex flex-col items-center" data-aos="fade-up" data-aos-delay="300">
        <div class="bg-red-100 p-4 rounded-full mb-4">
          <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M18.364 5.636a9 9 0 11-12.728 0M12 3v9"></path>
          </svg>
        </div>
        <p class="text-gray-700 font-semibold">Pelayanan pelanggan responsif</p>
      </div>

    </div>
  </div>
</section>



{{-- <!-- Hubungi Kami Compact -->
<section id="hubungi" class="max-w-3xl mx-auto py-12 px-6" data-aos="fade-up" data-aos-duration="900" data-aos-easing="ease-out-cubic">
  <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-lg p-8">
    <h2 class="text-3xl font-semibold text-blue-700 mb-4 text-center">Hubungi Kami</h2>
    <p class="text-center text-gray-600 mb-6">
      Ada pertanyaan? Isi form singkat di bawah, kami siap membantu Anda.
    </p>
    <form class="space-y-6 max-w-xl mx-auto" action="#" method="POST">
      <input type="text" name="nama" required placeholder="Nama Lengkap"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
      <input type="email" name="email" required placeholder="Email"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
      <textarea name="pesan" rows="3" required placeholder="Pesan Anda"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition"></textarea>
      <button type="submit" class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
        Kirim
      </button>
    </form>
  </div>
</section> --}}


<!-- Footer -->
<section class="w-full bg-blue-800 text-white pt-12 pb-6">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-center md:text-left">
            <!-- Info Toko -->
            <div class="md:w-2/3 mx-auto">
                <h2 class="text-2xl font-bold mb-2">Toko Usaha Muda</h2>
                <p class="text-gray-200 ">
                    Kami menyediakan produk berkualitas untuk mendukung usaha dan kreativitas generasi muda Indonesia.
                </p>
            </div>

            <!-- Sosial Media -->
            <div class="flex justify-center space-x-6">
                <a href="https://www.instagram.com/toko.usahamuda/" class="hover:text-blue-300 transition" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                        <path d="M7.75 2C4.574 2 2 4.574 2 7.75v8.5C2 19.426 4.574 22 7.75 22h8.5c3.176 0 5.75-2.574 5.75-5.75v-8.5C22 4.574 19.426 2 16.25 2h-8.5zM4 7.75A3.75 3.75 0 017.75 4h8.5A3.75 3.75 0 0120 7.75v8.5A3.75 3.75 0 0116.25 20h-8.5A3.75 3.75 0 014 16.25v-8.5z" />
                        <path d="M12 7.25A4.75 4.75 0 1016.75 12 4.75 4.75 0 0012 7.25zM12 15a3 3 0 113-3 3 3 0 01-3 3zM17.5 6a1 1 0 11-1-1 1 1 0 011 1z" />
                    </svg>
                </a>
                <a href="https://wa.me/+628116655050" class="hover:text-blue-300 transition" aria-label="WhatsApp">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                        <path d="M12.004 2.003c-5.523 0-9.996 4.473-9.996 9.996a9.93 9.93 0 001.367 5.038l-1.41 5.164 5.288-1.39a10.007 10.007 0 004.75 1.198h.001c5.522 0 9.995-4.473 9.995-9.996s-4.473-9.996-9.995-9.996zm.003 17.99a8.08 8.08 0 01-4.099-1.125l-.292-.175-3.139.823.842-3.06-.19-.315a8.017 8.017 0 01-1.235-4.297c0-4.432 3.605-8.038 8.038-8.038 2.148 0 4.164.836 5.678 2.35a7.94 7.94 0 012.359 5.689c-.003 4.432-3.61 8.048-8.062 8.048zm4.324-5.94c-.237-.118-1.406-.694-1.625-.772-.218-.079-.377-.118-.536.119-.158.237-.615.772-.754.931-.138.158-.277.178-.514.059-.237-.118-1.002-.369-1.908-1.176-.705-.63-1.18-1.409-1.319-1.646-.138-.237-.015-.364.104-.482.107-.106.237-.277.356-.415.118-.138.158-.237.237-.396.079-.158.04-.297-.02-.416-.059-.118-.536-1.292-.735-1.772-.194-.467-.392-.404-.536-.413l-.456-.009c-.158 0-.416.059-.635.277s-.832.814-.832 1.987c0 1.173.853 2.309.972 2.467.118.158 1.677 2.56 4.064 3.588.569.245 1.013.391 1.359.5.571.181 1.09.155 1.5.094.457-.068 1.406-.575 1.606-1.131.198-.555.198-1.03.139-1.131-.059-.099-.217-.158-.456-.277z"/>
                    </svg>
                </a>
                <a href="#" class="hover:text-blue-300 transition" aria-label="Twitter">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                        <path d="M22.162 5.656c-.793.352-1.645.589-2.538.696a4.477 4.477 0 001.962-2.47 8.964 8.964 0 01-2.835 1.083 4.462 4.462 0 00-7.6 4.07 12.662 12.662 0 01-9.197-4.663 4.462 4.462 0 001.38 5.96 4.42 4.42 0 01-2.02-.558v.056a4.463 4.463 0 003.577 4.372 4.458 4.458 0 01-2.012.076 4.466 4.466 0 004.17 3.102A8.96 8.96 0 012 19.54a12.66 12.66 0 006.862 2.011c8.238 0 12.742-6.824 12.742-12.742 0-.194-.005-.388-.014-.58a9.093 9.093 0 002.24-2.315z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Copyright -->
<div class="w-full bg-blue-900 text-gray-300 text-center text-sm py-4">
    © {{ date('Y') }} Toko Usaha Muda. All rights reserved.
</div>



    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 1000,
        });
    </script>

</body>
</html>