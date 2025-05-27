@extends('components.layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Kategori</h1>

<form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label class="block font-semibold">Nama Kategori</label>
        <input type="text" name="name" class="w-full border border-gray-300 px-3 py-2 rounded px-3 py-2 text-black bg-white" required>
    </div>
    <div class="flex gap-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
    </div>
</form>
@endsection
