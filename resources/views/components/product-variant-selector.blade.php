@props(['product'])

<div class="space-y-4">
    @if($product->variants->where('type', 'color')->count() > 0)
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Warna</label>
            <div class="grid grid-cols-4 gap-2">
                @foreach($product->variants->where('type', 'color') as $variant)
                    <label class="relative">
                        <input type="radio" 
                               name="color_variant" 
                               value="{{ $variant->id }}"
                               class="sr-only peer"
                               required>
                        <div class="w-full p-2 text-sm border rounded-lg cursor-pointer peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:bg-gray-50">
                            {{ $variant->name }}
                            @if($variant->additional_price > 0)
                                <span class="block text-xs text-gray-500">
                                    +Rp {{ number_format($variant->additional_price, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                        <div class="absolute inset-0 border-2 border-transparent peer-checked:border-primary-500 rounded-lg pointer-events-none"></div>
                    </label>
                @endforeach
            </div>
        </div>
    @endif

    @if($product->variants->where('type', 'size')->count() > 0)
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Ukuran</label>
            <div class="grid grid-cols-4 gap-2">
                @foreach($product->variants->where('type', 'size') as $variant)
                    <label class="relative">
                        <input type="radio" 
                               name="size_variant" 
                               value="{{ $variant->id }}"
                               class="sr-only peer"
                               required>
                        <div class="w-full p-2 text-sm border rounded-lg cursor-pointer peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:bg-gray-50">
                            {{ $variant->name }}
                            @if($variant->additional_price > 0)
                                <span class="block text-xs text-gray-500">
                                    +Rp {{ number_format($variant->additional_price, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                        <div class="absolute inset-0 border-2 border-transparent peer-checked:border-primary-500 rounded-lg pointer-events-none"></div>
                    </label>
                @endforeach
            </div>
        </div>
    @endif

    <input type="hidden" name="selected_variants[]" id="selected_variants">
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorVariant = document.querySelector('input[name="color_variant"]');
    const sizeVariant = document.querySelector('input[name="size_variant"]');
    const selectedVariants = document.getElementById('selected_variants');

    function updateSelectedVariants() {
        const variants = [];
        if (colorVariant && colorVariant.checked) {
            variants.push(colorVariant.value);
        }
        if (sizeVariant && sizeVariant.checked) {
            variants.push(sizeVariant.value);
        }
        selectedVariants.value = variants.join(',');
    }

    document.querySelectorAll('input[name="color_variant"], input[name="size_variant"]').forEach(input => {
        input.addEventListener('change', updateSelectedVariants);
    });
});
</script>
@endpush 