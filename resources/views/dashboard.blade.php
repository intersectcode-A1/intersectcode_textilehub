@extends('components.layouts.dashboard')

@section('content')
<div class="p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-dashboard.metric-card title="Total Users" :value="$totalUsers" />
        <x-dashboard.metric-card title="Total Orders" :value="$totalOrders" />
        <x-dashboard.metric-card title="Total Products" :value="$totalProducts" />
    </div>
</div>
@endsection