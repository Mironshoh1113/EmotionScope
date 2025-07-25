@extends('profile.layout')
@section('content')
<h2 class="text-xl font-bold mb-4">{{ __('balance') }}</h2>
<div class="flex items-center gap-8">
    <div class="text-2xl font-bold text-blue-700">${{ number_format($user->balance, 2) }}</div>
    <div class="text-gray-600">{{ __('request_limit') }}: <b>{{ $user->requests_used }} / {{ $user->request_limit }}</b></div>
</div>
@endsection 