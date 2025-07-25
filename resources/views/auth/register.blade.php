<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('register_title') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-100 via-blue-100 to-indigo-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md p-8 bg-white rounded-2xl shadow-2xl animate-fade-in-up">
        <h2 class="text-3xl font-bold text-center text-indigo-700 mb-6">{{ __('register_title') }}</h2>
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ url('/register') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block mb-1 font-semibold">{{ __('name') }}</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold">{{ __('email') }}</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold">{{ __('password') }}</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold">{{ __('password_confirm') }}</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
            </div>
            <button type="submit" class="w-full py-2 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition">{{ __('register') }}</button>
        </form>
        <div class="mt-6 text-center">
            <a href="{{ route('google.login') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg shadow hover:bg-gray-100 transition">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5"> {{ __('register_with_google') }}
            </a>
        </div>
        <p class="mt-6 text-center text-gray-600">{{ __('have_account') }} <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">{{ __('login') }}</a></p>
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