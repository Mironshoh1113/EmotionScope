@extends('admin.layout')
@section('title', __('admin.plans'))
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">{{ __('admin.plans') }}</h1>
    <a href="{{ route('admin.plans.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ __('admin.add_plan') }}</a>
</div>
@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
@endif
<table class="min-w-full bg-white rounded shadow overflow-hidden">
    <thead>
        <tr class="bg-gray-100">
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">{{ __('admin.name') }}</th>
            <th class="px-4 py-2">{{ __('admin.price') }}</th>
            <th class="px-4 py-2">{{ __('admin.request_limit') }}</th>
            <th class="px-4 py-2">{{ __('admin.status') }}</th>
            <th class="px-4 py-2">{{ __('admin.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($plans as $plan)
        <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-2">{{ $plan->id }}</td>
            <td class="px-4 py-2">{{ $plan->name }}</td>
            <td class="px-4 py-2">{{ $plan->price }}</td>
            <td class="px-4 py-2">{{ $plan->request_limit }}</td>
            <td class="px-4 py-2">
                @if($plan->is_active)
                    <span class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs">{{ __('admin.active') }}</span>
                @else
                    <span class="px-2 py-1 bg-red-200 text-red-800 rounded text-xs">{{ __('admin.inactive') }}</span>
                @endif
            </td>
            <td class="px-4 py-2 flex gap-2">
                <a href="{{ route('admin.plans.edit', $plan) }}" class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">{{ __('admin.edit') }}</a>
                <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('{{ __('admin.delete_confirm') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">{{ __('admin.delete') }}</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-4">{{ $plans->links() }}</div>
@endsection 