@extends('profile.layout')
@section('title', __('admin.plans'))
@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ __('admin.plans') }}</h1>
                <p class="text-lg text-gray-600">{{ __('admin.choose_best_plan') }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <i class="fas fa-crown text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    <!-- Current User Plan & Usage -->
    <div class="mb-10 bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-8 border border-blue-100 shadow">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <div class="flex items-center mb-2">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user-tag text-white"></i>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600">{{ __('admin.current_plan') }}</div>
                        <div class="text-lg font-bold text-blue-700">
                            {{ auth()->user()->plan ? auth()->user()->plan->name : __('admin.no_plan') }}
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 mt-2">
                    <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                        <i class="fas fa-wallet mr-1"></i> {{ __('admin.balance') }}: <span class="ml-1">{{ auth()->user()->balance }}</span>
                    </div>
                    <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                        <i class="fas fa-bolt mr-1"></i> {{ __('admin.request_limit') }}: <span class="ml-1">{{ auth()->user()->request_limit }}</span>
                    </div>
                    <div class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                        <i class="fas fa-chart-line mr-1"></i> {{ __('admin.requests_used') }}: <span class="ml-1">{{ auth()->user()->requests_used }}</span>
                    </div>
                </div>
            </div>
            <div class="flex-1">
                <div class="mb-2 text-sm text-gray-600">{{ __('admin.usage') }}</div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-4 rounded-full text-xs flex items-center justify-end pr-2 text-white font-bold transition-all duration-300" style="width: {{ min(100, round((auth()->user()->requests_used / max(1, auth()->user()->request_limit)) * 100, 2)) }}%">
                        {{ min(100, round((auth()->user()->requests_used / max(1, auth()->user()->request_limit)) * 100, 2)) }}%
                    </div>
                </div>
                <div class="mt-1 text-xs text-gray-500">{{ auth()->user()->requests_used }} / {{ auth()->user()->request_limit }} {{ __('admin.requests') }}</div>
            </div>
        </div>
    </div>

    <!-- Plans Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-12">
        @foreach($plans as $plan)
        <div class="relative bg-white border border-gray-200 rounded-2xl p-10 shadow-lg hover:shadow-xl transition-shadow duration-200 group">
            @if(auth()->user()->plan_id == $plan->id)
                <span class="absolute top-0 right-0 mt-3 mr-3 bg-gradient-to-r from-green-400 to-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">{{ __('admin.current') }}</span>
            @endif
            <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-2 flex items-center justify-center">
                    <i class="fas fa-crown mr-2 text-yellow-400"></i> {{ $plan->name }}
                </h3>
                <div class="text-4xl font-extrabold text-blue-600 mb-1">{{ $plan->price }}</div>
                <div class="text-sm text-gray-500">{{ __('admin.currency') }}</div>
            </div>
            <div class="space-y-3 mb-8">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-semibold">{{ $plan->request_limit }} {{ __('admin.requests') }}</span>
                </div>
                @if($plan->description)
                <div class="text-sm text-gray-600">{{ $plan->description }}</div>
                @endif
            </div>
            @if($plan->is_active)
                @if($plan->price == 0)
                    @php
                        $lastFreePlanPurchase = auth()->user()->transactions()
                            ->where('type', 'purchase')
                            ->where('plan_id', $plan->id)
                            ->where('created_at', '>=', now()->subMonth())
                            ->first();
                    @endphp
                    @if($lastFreePlanPurchase)
                        <div class="text-center">
                            <div class="text-orange-600 text-sm mb-2">{{ __('admin.free_plan_monthly_limit') }}</div>
                            <div class="text-xs text-gray-500">{{ __('admin.free_plan_next_available') }}: {{ $lastFreePlanPurchase->created_at->addMonth()->format('Y-m-d') }}</div>
                        </div>
                    @else
                        <form action="{{ route('plans.purchase', $plan) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-lg hover:from-green-600 hover:to-blue-600 transition font-semibold shadow">
                                {{ __('admin.get_free_plan') }}
                            </button>
                        </form>
                    @endif
                @else
                    @if(auth()->user()->balance >= $plan->price)
                        <form action="{{ route('plans.purchase', $plan) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition font-semibold shadow">
                                {{ __('admin.choose_plan') }}
                            </button>
                        </form>
                    @else
                        <div class="text-center">
                            <div class="text-red-600 text-sm mb-2">{{ __('admin.insufficient_balance') }}</div>
                            <a href="{{ route('profile.balance') }}" class="inline-block px-4 py-2 bg-gradient-to-r from-orange-500 to-yellow-400 text-white rounded-lg hover:from-orange-600 hover:to-yellow-500 transition font-semibold shadow">
                                {{ __('admin.top_up_balance') }}
                            </a>
                        </div>
                    @endif
                @endif
            @else
                <div class="text-center text-gray-500 text-sm">{{ __('admin.plan_inactive') }}</div>
            @endif
        </div>
        @endforeach
    </div>
    @if($plans->hasPages())
        <div class="mt-8">{{ $plans->links() }}</div>
    @endif
</div>
@endsection 