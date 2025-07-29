@extends('admin.layout')

@section('content')
<div class="max-w-2xl mx-auto py-10 px-4">
    <div class="mb-8">
        <a href="{{ route('admin.feedbacks') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            {{ __('admin.feedbacks') }}
        </a>
    </div>
    <div class="bg-white rounded-xl shadow border border-gray-200 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ __('admin.feedback') }} #{{ $feedback->id }}</h1>
        <div class="mb-4">
            <span class="text-gray-500 text-sm">{{ __('admin.name') }}:</span>
            <span class="text-gray-900 font-medium">{{ $feedback->name }}</span>
        </div>
        <div class="mb-4">
            <span class="text-gray-500 text-sm">{{ __('admin.email') }}:</span>
            <span class="text-gray-900 font-medium">{{ $feedback->email }}</span>
        </div>
        <div class="mb-4">
            <span class="text-gray-500 text-sm">{{ __('admin.status') }}:</span>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $feedback->status === 'new' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                {{ __('admin.' . $feedback->status) }}
            </span>
        </div>
        <div class="mb-4">
            <span class="text-gray-500 text-sm">{{ __('admin.created_at') }}:</span>
            <span class="text-gray-900 font-medium">{{ $feedback->created_at->format('Y-m-d H:i') }}</span>
        </div>
        <div class="mb-6">
            <span class="text-gray-500 text-sm block mb-2">{{ __('admin.message') }}:</span>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-gray-800 whitespace-pre-line">{{ $feedback->message }}</div>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('admin.feedbacks') }}" class="bg-gray-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition-colors">{{ __('admin.back') }}</a>
        </div>
    </div>
</div>
@endsection 