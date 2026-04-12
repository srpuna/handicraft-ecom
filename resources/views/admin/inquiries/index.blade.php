@extends('admin.layout')

@section('header')
    <h2 class="font-semibold text-xl text-truffle-extra-dark leading-tight">
        Inquiries
    </h2>
@endsection

@section('content')
    <div class="bg-cream rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-[#F5F2EA]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-truffle-extra-dark uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-truffle-extra-dark uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-truffle-extra-dark uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-truffle-extra-dark uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-truffle-extra-dark uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-cream divide-y divide-gray-200">
                @foreach($inquiries as $inquiry)
                    <tr class="{{ $inquiry->status == 'pending' ? 'bg-green-premium/10' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-truffle-extra-dark">
                            {{ $inquiry->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-truffle-extra-dark">{{ $inquiry->name }}</div>
                            <div class="text-sm text-truffle-extra-dark">{{ $inquiry->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-truffle-extra-dark">
                            {{ $inquiry->product ? $inquiry->product->name : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($inquiry->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                    @if($inquiry->status == 'replied') bg-blue-100 text-blue-800 @endif
                                    @if($inquiry->status == 'checkout_sent') bg-purple-100 text-purple-800 @endif
                                    @if($inquiry->status == 'completed') bg-green-premium/20 text-green-800 @endif
                                ">
                                {{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.inquiries.show', $inquiry) }}"
                                class="text-indigo-600 hover:text-indigo-900">View Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $inquiries->links() }}
    </div>
@endsection
