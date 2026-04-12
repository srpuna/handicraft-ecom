@extends('admin.layout')

@section('header')
    <h2 class="font-semibold text-xl text-truffle-extra-dark leading-tight">
        Edit Sub-Category
    </h2>
@endsection

@section('content')
    <div class="max-w-xl mx-auto bg-cream p-6 rounded-lg shadow">
        <form action="{{ route('admin.subcategories.update', $subcategory) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-truffle-extra-dark">Parent Category</label>
                <select name="category_id"
                    class="mt-1 block w-full rounded-md border-truffle-medium/30 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2"
                    required>
                    <option value="">Select Parent...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $subcategory->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-truffle-extra-dark">Sub-Category Name</label>
                <input type="text" name="name" value="{{ $subcategory->name }}"
                    class="mt-1 block w-full rounded-md border-truffle-medium/30 shadow-sm focus:border-green-500 focus:ring-green-500 border p-2"
                    required>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('admin.categories.index') }}" class="text-truffle-extra-dark hover:text-truffle-extra-dark">Cancel</a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700">Update
                    Sub-Category</button>
            </div>
        </form>
    </div>
@endsection
