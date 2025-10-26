@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Edit Product</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="sku" class="block mb-1 font-semibold">SKU</label>
            <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}"
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" />
            @error('sku') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="name" class="block mb-1 font-semibold">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" />
            @error('name') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="quantity" class="block mb-1 font-semibold">Quantity</label>
            <input type="number" id="quantity" name="quantity" min="0" value="{{ old('quantity', $product->quantity) }}"
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" />
            @error('quantity') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="purchase_price" class="block mb-1 font-semibold">Purchase Price</label>
            <input type="number" step="0.01" min="0" id="purchase_price" name="purchase_price"
                   value="{{ old('purchase_price', $product->purchase_price) }}"
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" />
            @error('purchase_price') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="price" class="block mb-1 font-semibold">Sell Price</label>
            <input type="number" step="0.01" min="0" id="price" name="price" value="{{ old('price', $product->price) }}"
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" />
            @error('price') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded font-semibold hover:bg-blue-700 transition">
                Update Product
            </button>
            <a href="{{ route('products.index') }}"
               class="bg-gray-300 text-gray-800 px-6 py-2 rounded font-semibold hover:bg-gray-400 transition flex items-center justify-center">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
