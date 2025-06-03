@props(['categories', 'currentCategory' => null])

<div class="bg-white shadow-md rounded-lg overflow-hidden">
    {{-- Category Header --}}
    <div class="px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700">
        <h2 class="text-lg font-semibold text-white flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            Kategori Produk
        </h2>
    </div>

    {{-- Search Category --}}
    <div class="p-3 border-b border-gray-100">
        <div class="relative">
            <input type="text" 
                   placeholder="Cari kategori..." 
                   class="w-full pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-blue-500"
                   x-model="searchCategory"
                   @input="filterCategories">
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </div>

    {{-- Category List --}}
    <nav class="p-2" x-data="{ searchCategory: '', visibleCategories: [] }">
        <a href="{{ route('ecatalog.index') }}" 
           class="block px-4 py-2.5 rounded-lg mb-1 transition-all duration-200 {{ !$currentCategory ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Semua Produk
                </div>
                <span class="text-sm text-gray-500">{{ $categories->sum('products_count') }}</span>
            </div>
        </a>

        @foreach($categories as $category)
            <a href="{{ route('ecatalog.index', ['category' => $category->id]) }}"
               class="block px-4 py-2.5 rounded-lg mb-1 transition-all duration-200 {{ $currentCategory == $category->id ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}"
               x-show="!searchCategory || category.name.toLowerCase().includes(searchCategory.toLowerCase())"
               x-transition>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        {{ $category->name }}
                    </div>
                    <span class="text-sm text-gray-500">({{ $category->products_count }})</span>
                </div>
            </a>
        @endforeach
    </nav>

    {{-- Empty State --}}
    <div x-show="!visibleCategories.length && searchCategory" class="p-4 text-center text-gray-500">
        <p>Tidak ada kategori yang sesuai</p>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('categoryNav', () => ({
        searchCategory: '',
        visibleCategories: [],
        
        filterCategories() {
            this.visibleCategories = this.categories.filter(category => 
                category.name.toLowerCase().includes(this.searchCategory.toLowerCase())
            )
        },

        init() {
            this.visibleCategories = this.categories
        }
    }))
})
</script>
@endpush 