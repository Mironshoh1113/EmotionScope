<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('profile') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 min-h-screen">
    <!-- Top Navbar -->
    <nav class="flex items-center justify-between px-8 py-4 bg-white shadow">
        <div class="text-2xl font-bold text-blue-600">{{ __('brand_title') }}</div>
        <div class="flex items-center gap-4">
            <a href="/" class="text-gray-700 hover:text-blue-600 font-semibold">{{ __('menyu_home') }}</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-gray-700 hover:text-blue-600 font-semibold">{{ __('logout') }}</button>
            </form>
        </div>
    </nav>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg flex flex-col py-8 px-6">
            <div class="text-2xl font-bold text-blue-600 mb-8">{{ __('profile') }}</div>
            <nav class="flex flex-col gap-4 mb-8">
                <a href="{{ route('profile.info') }}" class="text-blue-700 font-semibold hover:underline">{{ __('profile_title') }}</a>
                <a href="{{ route('profile.balance') }}" class="text-blue-700 font-semibold hover:underline">{{ __('balance') }}</a>
                <a href="{{ route('profile.stats') }}" class="text-blue-700 font-semibold hover:underline">{{ __('request_stats') }}</a>
                <a href="{{ route('profile.requests') }}" class="text-blue-700 font-semibold hover:underline">{{ __('requests_used') }}</a>
            </nav>
            <form method="GET" action="" id="langFormSidebar" class="mb-8">
                <select name="lang" onchange="window.location.href='/lang/' + this.value" class="rounded px-2 py-1 border border-gray-300 bg-gray-100 text-gray-900 focus:outline-none w-full">
                    <option value="uz" @if(app()->getLocale()=='uz')selected @endif>UZ</option>
                    <option value="ru" @if(app()->getLocale()=='ru')selected @endif>RU</option>
                    <option value="en" @if(app()->getLocale()=='en')selected @endif>EN</option>
                </select>
            </form>
         </aside>
        <!-- Main Content -->
        <main class="flex-1 p-10">
            @yield('content')
        </main>
    </div>
</body>
</html> 