@extends('profile.layout')
@section('title', __('admin.transactions'))
@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">{{ __('admin.transactions') }}</h1>
    
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    
    @if($transactions->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow overflow-hidden">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.amount') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.type') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.description') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('admin.date') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $transaction->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="font-semibold {{ $transaction->amount >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction->amount >= 0 ? '+' : '' }}{{ $transaction->amount }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->type }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $transaction->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($transactions->hasPages())
            <div class="mt-6">{{ $transactions->links() }}</div>
        @endif
    @else
        <div class="text-center py-12">
            <div class="text-gray-500 text-lg mb-2">{{ __('admin.no_transactions_found') }}</div>
            <div class="text-gray-400 text-sm">{{ __('admin.no_transactions_description') }}</div>
        </div>
    @endif
</div>
@endsection 