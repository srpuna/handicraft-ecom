@extends('admin.layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Shipping Zone
    </h2>
@endsection

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
        <form action="{{ route('admin.shipping.zones.update', $zone) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Zone Name</label>
                <input type="text" name="name" value="{{ $zone->name }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2"
                    required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Countries (Comma Separated)</label>
                <textarea name="countries" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2"
                    required>{{ implode(',', $zone->countries) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">E.g. US, CA, UK</p>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('admin.shipping.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">Update
                    Zone</button>
            </div>
        </form>
    </div>
@endsection