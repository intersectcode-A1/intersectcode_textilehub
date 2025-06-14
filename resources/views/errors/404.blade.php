@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-xl w-full px-4">
        <div class="text-center">
            <h1 class="text-6xl font-bold text-gray-900 mb-4">404</h1>
            <p class="text-xl text-gray-600 mb-8">Maaf, halaman yang Anda cari tidak ditemukan.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection 