<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('users_title') }}</title>
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
    <div class="max-w-4xl mx-auto mt-12 bg-white rounded-xl shadow-lg p-8 animate-fade-in-up">
        <h2 class="text-2xl font-bold mb-6 text-blue-700">{{ __('users_list') }}</h2>
        <table class="min-w-full border rounded-lg overflow-hidden">
            <thead class="bg-blue-100">
                <tr>
                    <th class="py-2 px-4 text-left">#</th>
                    <th class="py-2 px-4 text-left">{{ __('name') }}</th>
                    <th class="py-2 px-4 text-left">{{ __('email') }}</th>
                    <th class="py-2 px-4 text-left">{{ __('oken') }}</th>
                    <th class="py-2 px-4 text-left">{{ __('profile') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-b hover:bg-blue-50 transition">
                        <td class="py-2 px-4">{{ $user->id }}</td>
                        <td class="py-2 px-4">{{ $user->name }}</td>
                        <td class="py-2 px-4">{{ $user->email }}</td>
                        <td class="py-2 px-4">{{ $user->oken }}</td>
                        <td class="py-2 px-4">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:underline">{{ __('view') }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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