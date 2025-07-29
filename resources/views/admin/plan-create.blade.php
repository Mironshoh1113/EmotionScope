@extends('admin.layout')
@section('title', __('admin.add_plan'))
@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">{{ __('admin.add_plan') }}</h1>
    <form action="{{ route('admin.plans.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1 font-medium">{{ __('admin.name') }}</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <label class="block mb-1 font-medium">{{ __('admin.price') }}</label>
            <input type="number" name="price" class="w-full border rounded px-3 py-2" min="0" step="0.01" required>
        </div>
        <div>
            <label class="block mb-1 font-medium">{{ __('admin.request_limit') }}</label>
            <input type="number" name="request_limit" class="w-full border rounded px-3 py-2" min="1" required>
        </div>
        <div>
            <label class="block mb-1 font-medium">{{ __('admin.description') }}</label>
            <textarea name="description" class="w-full border rounded px-3 py-2"></textarea>
        </div>
        <div>
            <label class="block mb-1 font-medium">{{ __('admin.status') }}</label>
            <select name="is_active" class="w-full border rounded px-3 py-2">
                <option value="1">{{ __('admin.active') }}</option>
                <option value="0">{{ __('admin.inactive') }}</option>
            </select>
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.plans.index') }}" class="px-4 py-2 bg-gray-200 rounded">{{ __('admin.cancel') }}</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ __('admin.save') }}</button>
        </div>
    </form>
</div>
@endsection 