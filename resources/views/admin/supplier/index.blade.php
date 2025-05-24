@extends('components.layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4 text-white">Daftar Supplier</h1>

    <a href="{{ route('supplier.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">+ Tambah Supplier</a>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mt-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto mt-6">
        <table class="table-auto w-full border-collapse border border-gray-700 text-white">
            <thead>
                <tr class="bg-gray-800">
                    <th class="border border-gray-700 px-4 py-2">No</th>
                    <th class="border border-gray-700 px-4 py-2">Nama</th>
                    <th class="border border-gray-700 px-4 py-2">Alamat</th>
                    <th class="border border-gray-700 px-4 py-2">Kontak</th>
                    <th class="border border-gray-700 px-4 py-2">Produk</th>
                    <th class="border border-gray-700 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                    <tr class="hover:bg-gray-700 text-center">
                        <td class="border border-gray-700 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $supplier->nama }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $supplier->alamat }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $supplier->kontak }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $supplier->produk }}</td>
                        <td class="border border-gray-700 px-4 py-2">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('supplier.edit', $supplier) }}">
                                    <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                        Edit
                                    </button>
                                </a>
                                <form action="{{ route('supplier.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus supplier ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-400 py-6 italic">Belum ada data supplier.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
