@php
    $pendingOrders = auth()->check() ? auth()->user()->orders()->where('status', 'pending')->count() : 0;
@endphp

<div class="relative">
    <a href="{{ route('order.status') }}" class="inline-flex items-center text-white hover:text-gray-200 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        @if($pendingOrders > 0)
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                {{ $pendingOrders }}
            </span>
        @endif
    </a>
</div> 