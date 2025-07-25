<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('user_profile_title') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 min-h-screen">
    <nav class="flex items-center justify-between px-8 py-4 bg-white shadow">
        <div class="text-2xl font-bold text-blue-600">TextAnalyzer Admin</div>
        <div>
            <a href="/admin" class="text-gray-700 hover:text-blue-600 font-semibold">{{ __('admin_panel') }}</a>
            <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                @csrf
                <button type="submit" class="text-gray-700 hover:text-blue-600 font-semibold">{{ __('logout') }}</button>
            </form>
        </div>
    </nav>
    <div class="max-w-lg mx-auto mt-12 bg-white rounded-xl shadow-lg p-8 animate-fade-in-up">
        <h2 class="text-2xl font-bold mb-6 text-blue-700">{{ __('user_profile_title') }}</h2>
        <div class="mb-4">
            <span class="font-semibold">{{ __('name') }}:</span> {{ $user->name }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">{{ __('email') }}:</span> {{ $user->email }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">{{ __('oken') }}:</span>
            <span class="bg-gray-100 px-2 py-1 rounded text-blue-700 select-all">{{ $user->oken }}</span>
        </div>
        <div class="mb-4">
            <span class="font-semibold">{{ __('admin') }}:</span> <span class="font-mono">{{ $user->is_admin ? __('yes') : __('no') }}</span>
        </div>
        <div class="mb-4">
            <span class="font-semibold">{{ __('blocked') }}:</span> <span class="font-mono">{{ $user->is_blocked ? __('yes') : __('no') }}</span>
        </div>
        <div class="mb-4">
            <span class="font-semibold">{{ __('balance') }}:</span>
            <span class="bg-gray-100 px-2 py-1 rounded text-blue-700">${{ number_format($user->balance, 2) }}</span>
        </div>
        <div class="mb-4">
            <span class="font-semibold">{{ __('request_limit') }}:</span>
            <span class="bg-gray-100 px-2 py-1 rounded text-blue-700">{{ $user->requests_used }} / {{ $user->request_limit }}</span>
        </div>
        <div class="flex gap-4 mt-6">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">{{ __('edit') }}</a>
            <form method="POST" action="{{ route('admin.users.block', $user->id) }}">
                @csrf
                <button type="submit" class="px-4 py-2 rounded {{ $user->is_blocked ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-white transition">
                    {{ $user->is_blocked ? __('unblock') : __('block') }}
                </button>
            </form>
        </div>
        <a href="{{ route('admin.users') }}" class="inline-block mt-4 text-blue-600 hover:underline">{{ __('back') }}</a>
    </div>
    <style>
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.7s cubic-bezier(.39,.575,.565,1) both;
        }
    </style>
</body>
</html> 