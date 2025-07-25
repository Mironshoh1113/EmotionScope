<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('admin_profile_title') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 min-h-screen">
    <nav class="flex items-center justify-between px-8 py-4 bg-white shadow">
        <div class="text-2xl font-bold text-blue-600">{{ __('brand_title') }} Admin</div>
        <div>
            <a href="/admin" class="text-gray-700 hover:text-blue-600 font-semibold">{{ __('admin_panel') }}</a>
            <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                @csrf
                <button type="submit" class="text-gray-700 hover:text-blue-600 font-semibold">{{ __('logout') }}</button>
            </form>
        </div>
    </nav>
    <div class="max-w-lg mx-auto mt-12 bg-white rounded-xl shadow-lg p-8 animate-fade-in-up">
        <h2 class="text-2xl font-bold mb-6 text-blue-700">{{ __('admin_profile_title') }}</h2>
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
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
        <a href="{{ route('admin.profile.edit') }}" class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">{{ __('edit_profile') }}</a>
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