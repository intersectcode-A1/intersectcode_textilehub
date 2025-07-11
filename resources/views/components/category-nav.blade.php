@props(['categories', 'currentCategory' => null])

<div x-data="{
    searchCategory: '',
    get filteredCategories() {
        return [
            @foreach($categories as $category)
                {
                    id: {{ $category->id }},
                    name: '{{ strtolower($category->name) }}',
                },
            @endforeach
        ].filter(cat => !this.searchCategory || cat.name.includes(this.searchCategory.toLowerCase()));
    }
}" class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden dark:bg-gray-800 dark:border-gray-700">
    {{-- Category Header --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
        <h3 class="text-white font-semibold text-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            Kategori
        </h3>
    </div>

    {{-- Search Category --}}
    <div class="p-4 border-b border-gray-100 dark:border-gray-700 dark:bg-gray-900">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" 
                   placeholder="Cari kategori..." 
                   class="w-full pl-10 pr-4 py-3 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                   x-model="searchCategory">
        </div>
    </div>

    {{-- Category List --}}
    <nav class="p-4 space-y-2 dark:bg-gray-800">
        <a href="{{ route('ecatalog.index') }}" 
           class="group block px-4 py-3 rounded-xl transition-all duration-200 {{ !$currentCategory ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 font-semibold border border-blue-200 shadow-sm dark:from-blue-900 dark:to-indigo-900 dark:text-blue-200 dark:border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600 dark:text-gray-100 dark:hover:bg-gray-900 dark:hover:text-blue-300' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors duration-200 dark:bg-blue-900 dark:group-hover:bg-blue-800">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <span class="font-medium">Semua Produk</span>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    {{ $categories->sum('products_count') }}
                </span>
            </div>
        </a>

        @foreach($categories as $category)
            <a href="{{ route('ecatalog.index', ['category' => $category->id]) }}"
               class="group block px-4 py-3 rounded-xl transition-all duration-200 {{ $currentCategory == $category->id ? 'bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 font-semibold border border-blue-200 shadow-sm dark:from-blue-900 dark:to-indigo-900 dark:text-blue-200 dark:border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600 dark:text-gray-100 dark:hover:bg-gray-900 dark:hover:text-blue-300' }}"
               x-show="!searchCategory || '{{ strtolower($category->name) }}'.includes(searchCategory.toLowerCase())"
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="opacity-0 transform -translate-y-1"
               x-transition:enter-end="opacity-100 transform translate-y-0"
               x-transition:leave="transition ease-in duration-150"
               x-transition:leave-start="opacity-100 transform translate-y-0"
               x-transition:leave-end="opacity-0 transform -translate-y-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center mr-3 group-hover:bg-blue-100 transition-colors duration-200 dark:bg-gray-900 dark:group-hover:bg-blue-900">
                            <svg class="w-4 h-4 text-gray-600 group-hover:text-blue-600 transition-colors duration-200 dark:text-gray-300 dark:group-hover:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <span class="font-medium">{{ $category->name }}</span>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 group-hover:bg-blue-100 group-hover:text-blue-800 transition-colors duration-200 dark:bg-gray-900 dark:text-gray-200 dark:group-hover:bg-blue-900 dark:group-hover:text-blue-200">
                        {{ $category->products_count }}
                    </span>
                </div>
            </a>
        @endforeach
    </nav>

    {{-- Empty State --}}
    <div x-show="searchCategory && filteredCategories.length === 0"
         class="p-6 text-center text-gray-500 border-t border-gray-100 dark:text-gray-400 dark:border-gray-700 dark:bg-gray-900">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 mb-3 dark:bg-gray-800">
            <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <p class="text-sm font-medium">Tidak ada kategori yang sesuai</p>
        <p class="text-xs text-gray-400 mt-1">Coba kata kunci yang berbeda</p>
    </div>
</div>