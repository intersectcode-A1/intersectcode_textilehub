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
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <!-- LeafletJS CSS (Dipindahkan ke Head) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-white to-blue-50 text-gray-800 font-sans scroll-smooth" style="font-family: 'Sora', ui-sans-serif, system-ui, sans-serif;">

    <!-- Navbar -->
    <header class="sticky top-0 z-[999] bg-gradient-to-b from-blue-200 via-blue-50 to-white shadow-lg">
        <div class="max-w-2xl md:max-w-4xl lg:max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold text-blue-600 drop-shadow">
                <a href="/" class="hover:scale-105 transition-all">Toko Usaha Muda</a>
            </div>
            <!-- Desktop Menu -->
            <nav class="hidden md:flex space-x-6 text-gray-700 font-medium">
                <a href="#produk" class="hover:text-blue-600 transition">Produk</a>
                <a href="#keunggulan" class="hover:text-blue-600 transition">Keunggulan</a>
                <a href="#testimoni" class="hover:text-blue-600 transition">Testimoni</a>
                <a href="#kontak" class="hover:text-blue-600 transition">Kontak</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-4 py-1 rounded-lg border border-gray-300 hover:bg-blue-100 transition">E-Katalog</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-1 rounded-lg border border-blue-500 text-blue-600 hover:bg-blue-600 hover:text-white transition">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-1 rounded-lg border border-blue-500 text-blue-600 hover:bg-blue-600 hover:text-white transition">Register</a>
                    @endif
                @endauth
            </nav>
            <!-- Hamburger Button Mobile -->
            <button id="mobile-menu-btn" class="block md:hidden p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" aria-label="Buka menu">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="fixed inset-0 z-[9999] bg-black/40 md:hidden transition-all duration-300 hidden flex justify-end">
            <div class="h-full w-[90vw] max-w-xs bg-gradient-to-b from-blue-100 via-white to-white shadow-2xl p-8 pt-8 flex flex-col gap-4 rounded-l-2xl" style="background: linear-gradient(to bottom, #dbeafe 0%, #fff 60%, #fff 100%) !important; opacity: 1 !important;">
                <button id="close-mobile-menu" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-red-500 bg-white rounded-full shadow focus:outline-none" aria-label="Tutup menu">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <a href="#produk" class="py-3 px-3 rounded-lg text-lg text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-600 transition">Produk</a>
                <a href="#keunggulan" class="py-3 px-3 rounded-lg text-lg text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-600 transition">Keunggulan</a>
                <a href="#testimoni" class="py-3 px-3 rounded-lg text-lg text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-600 transition">Testimoni</a>
                <a href="#kontak" class="py-3 px-3 rounded-lg text-lg text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-600 transition">Kontak</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="py-3 px-3 rounded-lg border border-gray-300 text-lg text-gray-700 font-semibold hover:bg-blue-100 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="py-3 px-3 rounded-lg border border-blue-500 text-lg text-blue-600 font-semibold hover:bg-blue-600 hover:text-white transition">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="py-3 px-3 rounded-lg border border-blue-500 text-lg text-blue-600 font-semibold hover:bg-blue-600 hover:text-white transition">Register</a>
                    @endif
                @endauth
            </div>
        </div>
        <script>
            // Hamburger menu logic
            document.addEventListener('DOMContentLoaded', function() {
                const btn = document.getElementById('mobile-menu-btn');
                const menu = document.getElementById('mobile-menu');
                const closeBtn = document.getElementById('close-mobile-menu');
                if(btn && menu && closeBtn) {
                    btn.onclick = () => menu.classList.remove('hidden');
                    closeBtn.onclick = () => menu.classList.add('hidden');
                    // Optional: close menu on click outside
                    menu.addEventListener('click', function(e) {
                        if(e.target === menu) menu.classList.add('hidden');
                    });
                }
            });
        </script>
    </header>

    <!-- Hero Section -->
    <section class="w-full bg-gradient-to-br from-blue-100 via-blue-200 to-blue-50 py-20 px-4">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
        <!-- Left: Text -->
        <div class="flex-1 flex flex-col justify-center items-start w-full">
          <!-- Gambar hanya tampil di mobile -->
          <img src="/image/Coverwelcome.png"
               alt="Ilustrasi Produk"
               class="block md:hidden mx-auto mb-8 w-32 h-32 sm:w-44 sm:h-44 object-contain" />
               <h1 class="text-5xl md:text-6xl font-extrabold mb-6 text-gray-900 leading-tight font-sans">
                Mulai perjalananmu bersama <span class="text-blue-600">Toko Usaha Muda</span>
              </h1>
          <p class="text-lg md:text-2xl mb-8 text-gray-600 max-w-xl font-light">
            Temukan dan beli produk tekstil berkualitas, harga bersaing, dan pelayanan terbaik untuk kebutuhan Anda. Belanja mudah, aman, dan cepat!
          </p>
          <div class="flex flex-row gap-4 mb-8">
            <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-xl shadow-lg hover:scale-105 hover:bg-blue-700 transition text-lg font-semibold">Mulai Belanja</a>
            <a href="#produk" class="inline-block px-8 py-3 bg-white border border-blue-600 text-blue-600 rounded-xl shadow hover:bg-blue-50 transition text-lg font-semibold">Liat Produk</a>
          </div>
          <div class="flex flex-row gap-8 items-center mb-6">
            <div class="flex flex-col items-start">
              <div class="flex items-center space-x-2 mb-1">
                <span class="text-yellow-400 text-xl">★★★★★</span>
                <span class="text-gray-700 font-semibold">4.8/5</span>
              </div>
              <span class="text-gray-400 text-sm">- dari 2.000+ review</span>
              <span class="text-gray-500 text-xs mt-1">Google</span>
            </div>
            <div class="flex flex-col items-start">
              <div class="flex items-center space-x-2 mb-1">
                <span class="text-yellow-400 text-xl">★★★★½</span>
                <span class="text-gray-700 font-semibold">4.6/5</span>
              </div>
              <span class="text-gray-400 text-sm">- dari 12k review</span>
              <span class="text-gray-500 text-xs mt-1">Toko</span>
            </div>
          </div>
          <div class="flex items-center space-x-2 bg-blue-50 px-3 py-1 rounded-lg shadow text-blue-700 font-medium w-max">
            <img src="/image/img_logo_tokousahamuda.png" alt="Logo" class="h-6 w-6 rounded-full">
            <span>Dipercaya oleh pelaku UMKM & konveksi</span>
          </div>
        </div>
        <!-- Right: Ilustrasi/produk -->
        <div class="flex-1 hidden md:flex justify-center md:justify-end items-center relative mt-8 md:mt-0">
          <img
            src="/image/Coverwelcome.png"
            alt="Ilustrasi Produk"
            class="max-w-[320px] md:max-w-[400px] lg:max-w-[480px] w-full h-auto object-contain"
          />
            </div>
        </div>
    </section>

    <!-- Produk Section -->
<section id="produk" class="max-w-7xl w-full py-20 px-6 mx-auto">
  <div class="text-center mb-10">
    <h2 class="text-4xl font-extrabold text-gray-900 mb-2 relative inline-block">
      Produk <span class="text-blue-600 relative z-10">Unggulan
        <span class="absolute left-0 -bottom-1 w-full h-2 bg-blue-200 rounded opacity-60 -z-10"></span>
      </span>
    </h2>
        <p class="text-gray-500 text-lg">Dipilih khusus untuk memenuhi kebutuhan Anda</p>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
    <!-- Card Produk 1 -->
    <div class="bg-white rounded-xl shadow-lg flex flex-col items-center p-8 hover:shadow-2xl transition">
      <img src="/image/kainrenda.jpeg" alt="Kain Renda Eksklusif" class="w-40 h-40 md:w-48 md:h-48 object-cover mb-4 rounded-lg" />
      <h3 class="text-xl font-bold text-gray-800 mb-2">Kain Renda Eksklusif</h3>
      <button onclick="showModal('modalRenda')" class="mt-2 px-5 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">Lihat Detail</button>
    </div>
    <!-- Card Produk 2 -->
    <div class="bg-white rounded-xl shadow-lg flex flex-col items-center p-8 hover:shadow-2xl transition">
      <img src="/image/pitasatin.jpeg" alt="Pita Satin Premium" class="w-40 h-40 md:w-48 md:h-48 object-cover mb-4 rounded-lg" />
      <h3 class="text-xl font-bold text-gray-800 mb-2">Pita Satin Premium</h3>
      <button onclick="showModal('modalSatin')" class="mt-2 px-5 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">Lihat Detail</button>
    </div>
    <!-- Card Produk 3 -->
    <div class="bg-white rounded-xl shadow-lg flex flex-col items-center p-8 hover:shadow-2xl transition">
      <img src="/image/benangobras.jpeg" alt="Benang Obras Premium" class="w-40 h-40 md:w-48 md:h-48 object-cover mb-4 rounded-lg" />
      <h3 class="text-xl font-bold text-gray-800 mb-2">Benang Obras Premium</h3>
      <button onclick="showModal('modalObras')" class="mt-2 px-5 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">Lihat Detail</button>
    </div>
  </div>

  <!-- Modal Produk Detail -->
  <div id="modalRenda" class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 relative animate-fade-in">
      <button onclick="closeModal('modalRenda')" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-2xl">&times;</button>
      <h3 class="text-2xl font-bold text-blue-700 mb-4 text-center">Kain Renda Eksklusif</h3>
      <img src="/image/kainrenda.jpeg" alt="Kain Renda Eksklusif" class="w-40 h-40 object-cover rounded-lg mb-4 mx-auto" />
      <p class="text-gray-700 text-base leading-relaxed">Kain renda eksklusif kami hadir dengan motif detail dan tekstur lembut, memberikan sentuhan elegan dan mewah pada setiap kreasi Anda. Cocok untuk kebaya, gaun pesta, busana pengantin, hingga dekorasi premium. Bahan berkualitas tinggi, tidak mudah robek, dan nyaman dipakai. Tersedia dalam berbagai warna cantik yang mudah dipadupadankan. Pilihan tepat untuk Anda yang mengutamakan kualitas dan keindahan dalam setiap jahitan.</p>
    </div>
  </div>
  <div id="modalSatin" class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 relative animate-fade-in">
      <button onclick="closeModal('modalSatin')" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-2xl">&times;</button>
      <h3 class="text-2xl font-bold text-blue-700 mb-4 text-center">Pita Satin Premium</h3>
      <img src="/image/pitasatin.jpeg" alt="Pita Satin Premium" class="w-40 h-40 object-cover rounded-lg mb-4 mx-auto" />
      <p class="text-gray-700 text-base leading-relaxed">Pita satin premium dengan kilau mewah dan tekstur lembut, cocok untuk dekorasi pernikahan, hampers, buket bunga, hingga proyek DIY eksklusif Anda. Bahan satin pilihan, mudah dibentuk, dan tidak mudah kusut. Tersedia dalam berbagai warna menarik yang akan mempercantik setiap kreasi Anda. Pilihan terbaik untuk hasil dekorasi yang elegan dan profesional.</p>
    </div>
  </div>
  <div id="modalObras" class="fixed inset-0 z-50 hidden bg-black/40 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 relative animate-fade-in">
      <button onclick="closeModal('modalObras')" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-2xl">&times;</button>
      <h3 class="text-2xl font-bold text-blue-700 mb-4 text-center">Benang Obras Premium</h3>
      <img src="/image/benangobras.jpeg" alt="Benang Obras Premium" class="w-40 h-40 object-cover rounded-lg mb-4 mx-auto" />
      <p class="text-gray-700 text-base leading-relaxed">Benang obras premium terbuat dari 100% polyester berkualitas tinggi, memberikan hasil jahitan yang rapi, kuat, dan tahan lama. Teksturnya halus, tidak mudah putus, dan cocok untuk segala jenis kain, mulai dari bahan ringan hingga tebal. Pilihan tepat untuk Anda yang mengutamakan kekuatan dan keindahan hasil jahitan. Tersedia dalam berbagai warna menarik untuk memenuhi kebutuhan konveksi dan UMKM Anda.</p>
    </div>
  </div>

  <script>
    function showModal(id) {
      document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
      document.getElementById(id).classList.add('hidden');
    }
  </script>
</section>

<!-- Kenapa memilih kami -->
<section id="keunggulan" class="py-20 bg-orange-300/50 rounded-2xl mt-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10">
      <h2 class="text-4xl font-extrabold text-gray-900 mb-2 relative inline-block">
        Kenapa <span class="text-blue-600 relative z-10">Memilih Kami?
          <span class="absolute left-0 -bottom-1 w-full h-2 bg-blue-200 rounded opacity-60 -z-10"></span>
        </span>
      </h2>
      <p class="text-gray-500 text-lg">Alasan mengapa pelanggan memilih kami sebagai mitra tekstil terpercaya</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      <!-- Card 1 -->
      <div class="bg-white rounded-xl shadow-lg flex items-center p-6 hover:shadow-2xl transition">
        <div class="flex-shrink-0 bg-blue-100 rounded-full p-4 mr-6">
          <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 5m12-5l2 5m-6-5v5"></path></svg>
        </div>
        <div class="flex-1 text-lg font-semibold text-gray-700">Pengiriman cepat & aman</div>
        <span class="hidden md:inline ml-4 text-blue-400 text-2xl">&rarr;</span>
      </div>
      <!-- Card 2 -->
      <div class="bg-white rounded-xl shadow-lg flex items-center p-6 hover:shadow-2xl transition">
        <div class="flex-shrink-0 bg-green-100 rounded-full p-4 mr-6">
          <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <div class="flex-1 text-lg font-semibold text-gray-700">Kualitas kain terbaik</div>
        <span class="hidden md:inline ml-4 text-blue-400 text-2xl">&rarr;</span>
      </div>
      <!-- Card 3 -->
      <div class="bg-white rounded-xl shadow-lg flex items-center p-6 hover:shadow-2xl transition">
        <div class="flex-shrink-0 bg-yellow-100 rounded-full p-4 mr-6">
          <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3m0-6v6m0 4v.01"></path></svg>
        </div>
        <div class="flex-1 text-lg font-semibold text-gray-700">Harga bersaing</div>
        <span class="hidden md:inline ml-4 text-blue-400 text-2xl">&rarr;</span>
      </div>
      <!-- Card 4 -->
      <div class="bg-white rounded-xl shadow-lg flex items-center p-6 hover:shadow-2xl transition">
        <div class="flex-shrink-0 bg-red-100 rounded-full p-4 mr-6">
          <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 13v6a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2v-6m16-4V7a2 2 0 0 0-2-2h-4.18a2 2 0 0 1-1.42-.59l-2.83-2.83a2 2 0 0 0-1.42-.59H8a2 2 0 0 0-2 2v2"></path></svg>
        </div>
        <div class="flex-1 text-lg font-semibold text-gray-700">Pelayanan pelanggan responsif</div>
        <span class="hidden md:inline ml-4 text-blue-400 text-2xl">&rarr;</span>
      </div>
    </div>
</div>
</section>

<!-- Testimoni Section -->
<section id="testimoni" class="max-w-7xl w-full py-20 px-4 sm:px-6 mx-auto bg-[#f3f6fb] rounded-2xl mt-16">
  <div class="text-center mb-10">
    <h2 class="text-4xl font-extrabold text-gray-900 mb-2">
      Customer <span class="text-blue-600 relative inline-block">
        Reviews
        <span class="block h-1 w-full bg-blue-400 rounded mt-1"></span>
      </span>
    </h2>
    <p class="text-gray-500 text-lg max-w-2xl mx-auto">
      Saya suka banget belanja di sini, kainnya lengkap dan kualitasnya bagus. Adminnya juga ramah, pengiriman cepat. Pasti bakal order lagi!
    </p>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Card Testimoni 1 -->
    <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col gap-4">
      <div class="flex items-center justify-between w-full mb-2">
        <div class="flex items-center gap-4">
          <img src="/image/cewecantik.jpeg" alt="Adren Roy" class="w-14 h-14 object-cover rounded-full border-2 border-blue-200" />
          <div>
            <div class="font-bold text-lg text-gray-800 leading-tight">Rosa Cahaya</div>
            <div class="text-gray-400 text-sm leading-tight">Pelanggan</div>
          </div>
        </div>
        <div class="text-gray-500 text-sm font-semibold whitespace-nowrap">Padang, 27 Juni 2024</div>
      </div>
      <div class="text-gray-700 mt-1">
        Saya suka banget belanja di sini, kainnya lengkap dan kualitasnya bagus. Adminnya juga ramah, pengiriman cepat. Pasti bakal order lagi!
      </div>
    </div>
    <!-- Card Testimoni 2 -->
    <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col gap-4">
      <div class="flex items-center justify-between w-full mb-2">
        <div class="flex items-center gap-4">
          <img src="/image/cowoganteng.jpeg" alt="Sonira Roy" class="w-14 h-14 object-cover rounded-full border-2 border-blue-200" />
          <div>
            <div class="font-bold text-lg text-gray-800 leading-tight">Ikhsan Hakim</div>
            <div class="text-gray-400 text-sm leading-tight">Pelanggan</div>
          </div>
        </div>
        <div class="text-gray-500 text-sm font-semibold whitespace-nowrap">Bukittinggi, 15 Mei 2024</div>
      </div>
      <div class="text-gray-700 mt-1">
        Toko ini recommended banget! Harga bersaing, pilihan kainnya banyak, dan proses belanjanya gampang. Sukses terus buat toko ini!
      </div>
    </div>
    <!-- Card Testimoni 3 -->
    <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col gap-4">
      <div class="flex items-center justify-between w-full mb-2">
        <div class="flex items-center gap-4">
          <img src="/image/cowo.jpeg" alt="William Harry" class="w-14 h-14 object-cover rounded-full border-2 border-blue-200" />
          <div>
            <div class="font-bold text-lg text-gray-800 leading-tight">Ahmad Maulana</div>
            <div class="text-gray-400 text-sm leading-tight">Pelanggan</div>
          </div>
        </div>
        <div class="text-gray-500 text-sm font-semibold whitespace-nowrap">Solok, 2 April 2024</div>
      </div>
      <div class="text-gray-700 mt-1">
        Sudah beberapa kali beli, selalu puas. Barang sampai dengan aman, sesuai pesanan, dan pelayanannya oke banget. Terima kasih!
      </div>
    </div>
    <!-- Card Testimoni 4 -->
    <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col gap-4">
      <div class="flex items-center justify-between w-full mb-2">
        <div class="flex items-center gap-4">
          <img src="/image/cowokkaya.png" alt="James Jack" class="w-14 h-14 object-cover rounded-full border-2 border-blue-200" />
          <div>
            <div class="font-bold text-lg text-gray-800 leading-tight">Teddy Gusnandar</div>
            <div class="text-gray-400 text-sm leading-tight">Pelanggan</div>
          </div>
        </div>
        <div class="text-gray-500 text-sm font-semibold whitespace-nowrap">Pariaman, 10 Maret 2024</div>
      </div>
      <div class="text-gray-700 mt-1">
        Awalnya coba-coba, ternyata hasilnya memuaskan. Kainnya bagus, pelayanan cepat, dan respon adminnya juga baik. Mantap!
      </div>
    </div>
  </div>
</section>

<!-- Contact & Location Section Tanpa Form -->
<section id="kontak" class="max-w-7xl mx-auto py-16 px-6">
  <div class="bg-white rounded-2xl shadow-lg p-8 flex flex-col md:flex-row gap-10 items-center">
    <!-- Kiri: Info Kontak saja -->
    <div class="flex-1 w-full">
      <div class="text-center mb-10">
        <h2 class="text-4xl font-extrabold text-gray-900 mb-2">
          Contact <span class="text-blue-600 relative inline-block">Info
            <span class="block h-1 w-full bg-blue-400 rounded mt-1"></span>
          </span>
        </h2>
        <p class="text-gray-500 text-lg max-w-2xl mx-auto">
          Hubungi kami melalui kontak berikut atau kunjungi lokasi toko kami di Padang, Sumatera Barat.
        </p>
      </div>
      <div class="flex flex-col gap-6 text-base">
        <div class="flex items-center gap-3">
          <!-- Icon Lokasi modern -->
          <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6-5.686-6-10A6 6 0 0112 5a6 6 0 016 6c0 4.314-6 10-6 10z"/><circle cx="12" cy="11" r="2.5"/></svg>
          <span class="text-gray-700 font-medium">Jl. Pasar Raya A No.24F, Kp. Jao, Kec. Padang Bar., Kota Padang, Sumatera Barat</span>
        </div>
        <div class="flex items-center gap-3">
          <!-- Icon Instagram modern -->
          <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="2"/><circle cx="17" cy="7" r="1.5" fill="currentColor"/></svg>
          <span class="text-gray-700 font-medium">@toko.usahamuda</span>
        </div>
        <div class="flex items-center gap-3">
          <!-- Icon Telepon modern -->
          <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M22 16.92v3a2 2 0 01-2.18 2A19.72 19.72 0 013 5.18 2 2 0 015 3h3a2 2 0 012 1.72c.13.81.36 1.6.7 2.34a2 2 0 01-.45 2.11l-1.27 1.27a16 16 0 006.29 6.29l1.27-1.27a2 2 0 012.11-.45c.74.34 1.53.57 2.34.7A2 2 0 0122 16.92z"/></svg>
          <span class="text-gray-700 font-medium">0811-6655-050</span>
        </div>
      </div>
    </div>
    <!-- Kanan: Map -->
    <div class="flex-1 w-full">
      <div class="rounded-2xl overflow-hidden shadow-lg" style="min-height:320px;">
        <div id="map" style="height: 320px; width: 100%; z-index:10; position:relative;"></div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-[#181f3a] text-gray-300 pt-12 pb-4 mt-16">
  <div class="max-w-7xl mx-auto px-6 md:px-12">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-8 border-b border-blue-900">
      <!-- Brand -->
      <div>
        <div class="flex items-center mb-4">
          <img src="/image/img_logo_tokousahamuda.png" alt="Toko Usaha Muda" class="h-10 w-10 rounded-lg shadow-lg mr-3">
          <span class="text-xl font-bold text-white">Toko Usaha Muda</span>
        </div>
        <p class="text-gray-400 text-sm">Kami menyediakan produk berkualitas untuk mendukung usaha dan kreativitas generasi muda Indonesia.</p>
      </div>
      <!-- Product -->
      <div>
        <h3 class="text-white font-semibold mb-3">Product</h3>
        <ul class="space-y-2 text-sm">
          <li><a href="#produk" class="hover:text-blue-400 transition">Produk Unggulan</a></li>
          <li><a href="#keunggulan" class="hover:text-blue-400 transition">Keunggulan</a></li>
          <li><a href="#testimoni" class="hover:text-blue-400 transition">Testimoni</a></li>
        </ul>
      </div>
      <!-- Company -->
      <div>
        <h3 class="text-white font-semibold mb-3">Company</h3>
        <ul class="space-y-2 text-sm">
          <li><a href="#" class="hover:text-blue-400 transition">About us</a></li>
          <li><a href="#" class="hover:text-blue-400 transition">Customers</a></li>
          <li><a href="#kontak" class="hover:text-blue-400 transition">Kontak</a></li>
        </ul>
      </div>
      <!-- Subscribe -->
      <div>
        <h3 class="text-white font-semibold mb-3">Media Sosial</h3>
        <div class="flex space-x-4 mt-6 md:mt-3">
          <a href="https://www.instagram.com/toko.usahamuda/" class="hover:text-blue-400 transition" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect width="20" height="20" x="2" y="2" rx="5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="17" cy="7" r="1.5" fill="currentColor"/></svg>
          </a>
          <a href="https://wa.me/+628116655050" class="hover:text-blue-400 transition" aria-label="WhatsApp" target="_blank" rel="noopener noreferrer">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.004 2.003c-5.523 0-9.996 4.473-9.996 9.996a9.93 9.93 0 001.367 5.038l-1.41 5.164 5.288-1.39a10.007 10.007 0 004.75 1.198h.001c5.522 0 9.995-4.473 9.995-9.996s-4.473-9.996-9.995-9.996zm.003 17.99a8.08 8.08 0 01-4.099-1.125l-.292-.175-3.139.823.842-3.06-.19-.315a8.017 8.017 0 01-1.235-4.297c0-4.432 3.605-8.038 8.038-8.038 2.148 0 4.164.836 5.678 2.35a7.94 7.94 0 012.359 5.689c-.003 4.432-3.61 8.048-8.062 8.048zm4.324-5.94c-.237-.118-1.406-.694-1.625-.772-.218-.079-.377-.118-.536.119-.158.237-.615.772-.754.931-.138.158-.277.178-.514.059-.237-.118-1.002-.369-1.908-1.176-.705-.63-1.18-1.409-1.319-1.646-.138-.237-.015-.364.104-.482.107-.106.237-.277.356-.415.118-.138.158-.237.237-.396.079-.158.04-.297-.02-.416-.059-.118-.536-1.292-.735-1.772-.194-.467-.392-.404-.536-.413l-.456-.009c-.158 0-.416.059-.635.277s-.832.814-.832 1.987c0 1.173.853 2.309.972 2.467.118.158 1.677 2.56 4.064 3.588.569.245 1.013.391 1.359.5.571.181 1.09.155 1.5.094.457-.068 1.406-.575 1.606-1.131.198-.555.198-1.03.139-1.131-.059-.099-.217-.158-.456-.277z"/></svg>
          </a>
          </div>
          <ul class="space-y-2 text-sm mt-3">
            <p class="text-gray-400 text-sm">
            Jl. Pasar Raya A No.24F, Kp. Jao, Kec. Padang Bar., Kota Padang, Sumatera Barat
            </p>
          </ul>
      </div>
    </div>
  </div>
  <div class="flex flex-col md:flex-row justify-between items-center max-w-7xl mx-auto px-6 md:px-12 pt-6">
    <span class="text-xs text-gray-400">© {{ date('Y') }} Intersectcode. All rights reserved.</span>
  </div>
</footer>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 1000,
        });
    </script>

    <!-- LeafletJS JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([-0.94924, 100.35817], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            var marker = L.marker([-0.94924, 100.35817]).addTo(map)
                .bindPopup('Jl. Pasar Raya A No.24F, Kp. Jao, Kec. Padang Bar., Kota Padang, Sumatera Barat')
                .openPopup();
        });
    </script>

</body>
</html>
