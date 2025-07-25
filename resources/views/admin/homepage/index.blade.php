<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asosiy sahifa matnlari</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="flex items-center justify-between px-8 py-4 bg-white shadow">
        <div class="text-2xl font-bold text-blue-600">Emotion Scope Admin</div>
        <div>
            <a href="/admin" class="text-gray-700 hover:text-blue-600 font-semibold">Admin panel</a>
            <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                @csrf
                <button type="submit" class="text-gray-700 hover:text-blue-600 font-semibold">Chiqish</button>
            </form>
        </div>
    </nav>
    <div class="max-w-4xl mx-auto mt-12 bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-blue-700">Asosiy sahifa matnlari (3 til)</h2>
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        <table class="min-w-full border rounded-lg overflow-hidden">
            <thead class="bg-blue-100">
                <tr>
                    <th class="py-2 px-4 text-left">Kalit</th>
                    <th class="py-2 px-4 text-left">O‘zbekcha</th>
                    <th class="py-2 px-4 text-left">Русский</th>
                    <th class="py-2 px-4 text-left">English</th>
                    <th class="py-2 px-4 text-left">Tahrirlash</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contents as $content)
                    <tr class="border-b hover:bg-blue-50 transition">
                        <td class="py-2 px-4 font-mono">{{ $content->key }}</td>
                        <td class="py-2 px-4">{{ Str::limit($content->uz, 40) }}</td>
                        <td class="py-2 px-4">{{ Str::limit($content->ru, 40) }}</td>
                        <td class="py-2 px-4">{{ Str::limit($content->en, 40) }}</td>
                        <td class="py-2 px-4">
                            <a href="{{ route('admin.homepage.edit', $content->id) }}" class="text-blue-600 hover:underline">Tahrirlash</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html> 