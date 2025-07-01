@php
    $pendingOrders = auth()->check() ? auth()->user()->orders()->where('status', 'pending')->count() : 0;
@endphp

<div class="relative">
    <a href="{{ route('order.status') }}" 
       class="group inline-flex items-center p-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" 
             class="h-6 w-6 group-hover:scale-110 transition-transform duration-200" 
             fill="none" 
             viewBox="0 0 24 24" 
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        @if($pendingOrders > 0)
            <span class="absolute -top-1 -right-1 bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center shadow-lg border-2 border-white">
                {{ $pendingOrders > 99 ? '99+' : $pendingOrders }}
            </span>
        @endif
    </a>
</div>