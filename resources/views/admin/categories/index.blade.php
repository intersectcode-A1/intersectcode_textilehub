@extends('components.layouts.admin')

@section('title', 'Daftar Kategori')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Daftar Kategori</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            + Tambah Kategori
        </a>
    </div>

    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
        @if ($categories->isEmpty())
            <p class="p-4 text-gray-500 dark:text-gray-300">Belum ada kategori.</p>
        @else
            <table class="w-full table-auto text-left border border-gray-600 dark:border-gray-500">
                <thead class="bg-gray-100 dark:bg-gray-700 text-sm uppercase text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3 border border-gray-600 dark:border-gray-500">ID</th>
                        <th class="px-4 py-3 border border-gray-600 dark:border-gray-500">Nama</th>
                        <th class="px-4 py-3 border border-gray-600 dark:border-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $index => $category)
                        <tr class="border border-gray-600 dark:border-gray-500">
                            <td class="px-4 py-2 border border-gray-600 dark:border-gray-500">{{ $index + 1 }}
                            </td>
                            <td class="px-4 py-2 border border-gray-600 dark:border-gray-500">{{ $category->name }}
                            </td>
                            <td class="border border-gray-700 px-4 py-2">
                                <div class="flex gap-2">
                                    <a href="{{ route('categories.edit', $category->id) }}">
                                        <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                            Edit
                                        </button>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
@endsection
