@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4 py-16">
    <div class="max-w-lg w-full bg-cream rounded-2xl shadow-lg p-10 text-center">

        {{-- Success icon --}}
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 rounded-full bg-green-premium/20 flex items-center justify-center">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>

        <h1 class="text-2xl font-bold text-truffle-extra-dark mb-2">Thank you for your order!</h1>
        <p class="text-truffle-extra-dark mb-6">
            Your payment was successful and your order has been placed.
        </p>

        <div class="bg-[#F5F2EA] rounded-xl px-6 py-4 mb-8 text-left space-y-2 text-sm text-truffle-extra-dark">
            <div class="flex justify-between">
                <span class="font-medium text-truffle-extra-dark">Order number</span>
                <span class="font-semibold">#{{ $order->order_number }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-truffle-extra-dark">Total paid</span>
                <span class="font-semibold">${{ number_format($order->grand_total, 2) }}</span>
            </div>
            @if ($order->client?->email)
            <div class="flex justify-between">
                <span class="font-medium text-truffle-extra-dark">Confirmation sent to</span>
                <span class="font-semibold">{{ $order->client->email }}</span>
            </div>
            @endif
        </div>

        <a href="{{ route('home') }}"
           class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-xl transition">
            Continue Shopping
        </a>
    </div>
</div>
@endsection
