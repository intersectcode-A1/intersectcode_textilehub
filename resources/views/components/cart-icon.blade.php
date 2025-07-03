@php
    $cartCount = 0;
    $cart = session()->get('cart', []);
    foreach($cart as $item) {
        $cartCount += $item['quantity'];
    }
@endphp

<div class="relative">
    <a href="{{ route('cart.index') }}" 
       class="group inline-flex items-center p-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" 
             class="h-6 w-6 group-hover:scale-110 transition-transform duration-200" 
             fill="none" 
             viewBox="0 0 24 24" 
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        @if($cartCount > 0)
            <span class="absolute -top-1 -right-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center shadow-lg border-2 border-white">
                {{ $cartCount > 99 ? '99+' : $cartCount }}
            </span>
        @endif
    </a>
</div>