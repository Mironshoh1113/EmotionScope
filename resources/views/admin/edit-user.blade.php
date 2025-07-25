<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foydalanuvchini tahrirlash</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 min-h-screen">
    <nav class="flex items-center justify-between px-8 py-4 bg-white shadow">
        <div class="text-2xl font-bold text-blue-600">TextAnalyzer Admin</div>
        <div>
            <a href="/admin" class="text-gray-700 hover:text-blue-600 font-semibold">Admin panel</a>
            <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                @csrf
                <button type="submit" class="text-gray-700 hover:text-blue-600 font-semibold">Chiqish</button>
            </form>
        </div>
    </nav>
    <div class="max-w-lg mx-auto mt-12 bg-white rounded-xl shadow-lg p-8 animate-fade-in-up">
        <h2 class="text-2xl font-bold mb-6 text-blue-700">Foydalanuvchini tahrirlash</h2>
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-5">
            @csrf
            <div>
                <label class="block mb-1 font-semibold">Ism</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Yangi parol</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition" placeholder="Agar o‘zgartirmoqchi bo‘lsangiz kiriting">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Parolni tasdiqlang</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition" placeholder="Yangi parolni takrorlang">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Adminlik</label>
                <select name="is_admin" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
                    <option value="0" @if(!$user->is_admin) selected @endif>Yo‘q</option>
                    <option value="1" @if($user->is_admin) selected @endif>Ha</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">{{ __('balance') }}</label>
                <input type="number" step="0.01" name="balance" value="{{ old('balance', $user->balance) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold">{{ __('request_limit') }}</label>
                <input type="number" name="request_limit" value="{{ old('request_limit', $user->request_limit) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <div>
                <label class="block mb-1 font-semibold">{{ __('requests_used') }}</label>
                <input type="number" name="requests_used" value="{{ old('requests_used', $user->requests_used) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition">
            </div>
            <button type="submit" class="w-full py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">Saqlash</button>
        </form>
        <a href="{{ route('admin.users.show', $user->id) }}" class="inline-block mt-4 text-blue-600 hover:underline">Ortga</a>
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