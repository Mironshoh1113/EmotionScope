@extends('profile.layout')
@section('content')
<h2 class="text-xl font-bold mb-4">{{ __('edit_profile_title') }}</h2>
@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <ul class="text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('profile.update') }}" class="space-y-5 max-w-lg">
    @csrf
    <div>
        <label class="block mb-1 font-semibold">{{ __('name') }}</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
    </div>
    <div>
        <label class="block mb-1 font-semibold">{{ __('email') }}</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
    </div>
    <div>
        <label class="block mb-1 font-semibold">{{ __('new_password') }}</label>
        <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition" placeholder="{{ __('enter_new_password_if_you_want_to_change') }}">
    </div>
    <div>
        <label class="block mb-1 font-semibold">{{ __('repeat_new_password') }}</label>
        <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition" placeholder="{{ __('repeat_new_password') }}">
    </div>
    <button type="submit" class="w-full py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">{{ __('save') }}</button>
</form>
@endsection 