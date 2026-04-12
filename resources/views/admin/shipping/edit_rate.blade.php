@extends('admin.layout')

@section('header')
    <h2 class="font-semibold text-xl text-truffle-extra-dark leading-tight">
        Edit Shipping Rate
    </h2>
@endsection

@section('content')
    <div class="max-w-xl mx-auto bg-cream p-6 rounded-lg shadow">
        <form action="{{ route('admin.shipping.rates.update', $rate) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4 bg-[#F5F2EA] p-3 rounded">
                <p><strong>Zone:</strong> {{ $rate->zone->name }}</p>
                <p><strong>Provider:</strong> {{ $rate->provider->name }}</p>
                <input type="hidden" name="shipping_zone_id" value="{{ $rate->shipping_zone_id }}">
                <input type="hidden" name="shipping_provider_id" value="{{ $rate->shipping_provider_id }}">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-truffle-extra-dark">Min Weight (kg)</label>
                    <input type="number" step="0.001" name="min_weight" value="{{ $rate->min_weight }}"
                        class="mt-1 block w-full rounded-md border-truffle-medium/30 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-truffle-extra-dark">Max Weight (kg)</label>
                    <input type="number" step="0.001" name="max_weight" value="{{ $rate->max_weight }}"
                        class="mt-1 block w-full rounded-md border-truffle-medium/30 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2"
                        required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-truffle-extra-dark">Price ($)</label>
                <input type="number" step="0.01" name="price" value="{{ $rate->price }}"
                    class="mt-1 block w-full rounded-md border-truffle-medium/30 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2"
                    required>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('admin.shipping.index') }}" class="text-truffle-extra-dark hover:text-truffle-extra-dark">Cancel</a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">Update
                    Rate</button>
            </div>
        </form>
    </div>
@endsection
