<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('profile') }}</title>
    <link rel="icon" type="image/x-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🎭</text></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-100 min-h-screen">
    <!-- Top Navbar -->
    <nav class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="/" class="text-2xl font-bold text-blue-600 hover:text-blue-700 transition">
                            <span class="text-3xl mr-2">🎭</span>{{ __('brand_title') }}
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-gray-700 hover:text-blue-600 font-medium transition flex items-center">
                        <i class="fas fa-home mr-2"></i>{{ __('menyu_home') }}
                    </a>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-600 font-medium transition flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>{{ __('logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-56 bg-white shadow-xl border-r border-gray-200">
            <div class="p-6">
                <div class="flex items-center mb-8">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user-circle text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ __('profile') }}</h2>
                        <p class="text-sm text-gray-500">{{ auth()->user()->name }}</p>
                    </div>
                </div>
                
                <nav class="space-y-2">
                    <a href="{{ route('profile.projects.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-lg transition group {{ request()->routeIs('profile.projects.*') ? 'bg-indigo-100 text-indigo-700 border-r-2 border-indigo-500' : '' }}">
                        <i class="fas fa-project-diagram mr-3 w-5 text-center"></i>
                        <span class="font-medium">My Projects</span>
                    </a>
                    
                    <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg transition group {{ request()->routeIs('profile.show') ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-500' : '' }}">
                        <i class="fas fa-user mr-3 w-5 text-center"></i>
                        <span class="font-medium">{{ __('profile_title') }}</span>
                    </a>
                    
                    <a href="{{ route('profile.balance') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-700 rounded-lg transition group {{ request()->routeIs('profile.balance') ? 'bg-green-100 text-green-700 border-r-2 border-green-500' : '' }}">
                        <i class="fas fa-wallet mr-3 w-5 text-center"></i>
                        <span class="font-medium">{{ __('balance') }}</span>
                    </a>
                    
                    <a href="{{ route('profile.api-test') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-700 rounded-lg transition group {{ request()->routeIs('profile.api-test*') ? 'bg-orange-100 text-orange-700 border-r-2 border-orange-500' : '' }}">
                        <i class="fas fa-code mr-3 w-5 text-center"></i>
                        <span class="font-medium">{{ __('api_test') }}</span>
                    </a>
                    
                    <a href="{{ route('plans.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-lg transition group {{ request()->routeIs('plans.index') ? 'bg-purple-100 text-purple-700 border-r-2 border-purple-500' : '' }}">
                        <i class="fas fa-crown mr-3 w-5 text-center"></i>
                        <span class="font-medium">{{ __('admin.plans') }}</span>
                    </a>
                    
                    <a href="{{ route('transactions.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-700 rounded-lg transition group {{ request()->routeIs('transactions.index') ? 'bg-orange-100 text-orange-700 border-r-2 border-orange-500' : '' }}">
                        <i class="fas fa-history mr-3 w-5 text-center"></i>
                        <span class="font-medium">{{ __('admin.transactions') }}</span>
                    </a>
                </nav>
                
                <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">{{ __('language') }}</span>
                        <i class="fas fa-globe text-gray-400"></i>
                    </div>
                    <form method="GET" action="" id="langFormSidebar">
                        <select name="lang" onchange="window.location.href='/lang/' + this.value" class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent px-3 py-2 text-sm">
                            <option value="uz" @if(app()->getLocale()=='uz')selected @endif>🇺🇿 O'zbekcha</option>
                            <option value="ru" @if(app()->getLocale()=='ru')selected @endif>🇷🇺 Русский</option>
                            <option value="en" @if(app()->getLocale()=='en')selected @endif>🇺🇸 English</option>
                        </select>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html> 