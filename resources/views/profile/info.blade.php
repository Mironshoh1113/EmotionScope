@extends('profile.layout')
@section('content')
<h2 class="text-xl font-bold mb-4">{{ __('profile_title') }}</h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <div class="mb-2"><span class="font-semibold">{{ __('name') }}:</span> {{ $user->name }}</div>
        <div class="mb-2"><span class="font-semibold">{{ __('email') }}:</span> {{ $user->email }}</div>
        <div class="mb-2"><span class="font-semibold">{{ __('oken') }}:</span> <span class="bg-gray-100 px-2 py-1 rounded text-blue-700 select-all">{{ $user->oken }}</span></div>
    </div>
</div>
@endsection 