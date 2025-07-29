<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emotion Scope — {{ __('welcome') }}</title>
    <link rel="icon" type="image/x-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🎭</text></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <style>
        .card-anim {
            transition: transform 0.4s cubic-bezier(.4,2,.3,1), box-shadow 0.4s;
        }
        .card-anim:hover {
            transform: translateY(-12px) scale(1.04) rotate(-1deg);
            box-shadow: 0 8px 32px 0 rgba(0,0,0,0.4);
        }
        .fade-in-up {
            opacity: 0;
            transform: translateY(40px);
            animation: fadeInUp 1s cubic-bezier(.39,.575,.565,1) forwards;
        }
        @keyframes fadeInUp {
            to { opacity: 1; transform: none; }
        }
        .menu-anim {
            transition: background 0.3s, color 0.3s, transform 0.3s;
        }
        .menu-anim:hover, .menu-anim:focus {
            background: #23272f;
            color: #facc15;
            transform: scale(1.08) translateY(-2px);
        }
        </style>
    </head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-black min-h-screen text-gray-100">
    <!-- Navbar -->
    <nav class="flex items-center justify-between px-8 py-4 bg-black/80 shadow-lg sticky top-0 z-50 animate-fade-in-down">
        <div class="text-2xl font-extrabold tracking-tight text-yellow-400">
            <span class="text-4xl mr-2">🎭</span>Emotion Scope
        </div>
        <ul class="flex gap-6 font-semibold items-center">
            <li><a href="#about" class="menu-anim px-3 py-1 rounded">{{ __('menyu_about') }}</a></li>
            <li><a href="#features" class="menu-anim px-3 py-1 rounded">{{ __('menyu_features') }}</a></li>
            <li><a href="#pricing" class="menu-anim px-3 py-1 rounded">{{ __('menyu_pricing') }}</a></li>
            <li>
                <form method="GET" action="" id="langForm">
                    <select name="lang" onchange="window.location.href='/lang/' + this.value" class="rounded px-2 py-1 border border-gray-700 bg-gray-900 text-gray-100 focus:outline-none">
                        <option value="uz" @if(app()->getLocale()=='uz')selected @endif>UZ</option>
                        <option value="ru" @if(app()->getLocale()=='ru')selected @endif>RU</option>
                        <option value="en" @if(app()->getLocale()=='en')selected @endif>EN</option>
                    </select>
                </form>
            </li>
            @auth
            <li class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">
                <button type="button" @click="open = !open" @blur="setTimeout(() => open = false, 150)" class="flex items-center gap-2 px-3 py-1 bg-gray-800 border border-gray-700 rounded-lg shadow hover:bg-gray-700 transition select-none focus:outline-none">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    <span>{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <ul x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-gray-900 border border-gray-700 rounded-lg shadow-lg py-2 z-50" @click.away="open = false">
                    @if(Auth::user()->is_admin)
                        <li><a href="/admin/profile" class="block px-4 py-2 hover:bg-gray-800">Admin profili</a></li>
                        <li><a href="/admin/users" class="block px-4 py-2 hover:bg-gray-800">{{ __('admin_panel') }}</a></li>
                    @else
                        <li><a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-800">{{ __('profile') }}</a></li>
                    @endif
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-800">{{ __('logout') }}</button>
                        </form>
                    </li>
                </ul>
            </li>
            @else
            <li><a href="{{ route('login') }}" class="menu-anim px-3 py-1 rounded">{{ __('menyu_login') }}</a></li>
            <li><a href="{{ route('register') }}" class="menu-anim px-3 py-1 rounded">{{ __('menyu_register') }}</a></li>
            <li>
                <a href="{{ route('google.login') }}" class="inline-flex items-center gap-2 px-3 py-1 bg-white border border-gray-300 rounded-lg shadow hover:bg-gray-100 transition text-gray-900">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5"> Google
                </a>
            </li>
            @endauth
        </ul>
    </nav>

    <!-- Hero Section -->
    <section class="text-center py-24 bg-gradient-to-r from-gray-900 via-gray-800 to-black text-yellow-400 fade-in-up">
        <h1 class="text-5xl md:text-6xl font-extrabold mb-6 drop-shadow-lg tracking-tight">{{ __('brand_title') }}</h1>
        <h2 class="text-2xl md:text-3xl font-semibold mb-8 text-gray-100">{{ __('brand_subtitle') }}</h2>
        <p class="text-lg md:text-xl mb-8 max-w-2xl mx-auto text-gray-300">{{ __('brand_intro') }}</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('register') }}" class="inline-flex items-center bg-green-500 text-white px-8 py-3 rounded-full font-bold shadow hover:bg-green-600 transition text-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ __('try_free') }}
            </a>
            <a href="#about" class="inline-flex items-center bg-yellow-400 text-gray-900 px-8 py-3 rounded-full font-bold shadow hover:bg-yellow-300 transition text-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ __('learn_more') }}
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 px-4 max-w-4xl mx-auto fade-in-up">
        <h2 class="text-3xl font-bold text-center mb-6 text-yellow-400">{{ __('about_title') }}</h2>
        <p class="text-lg text-gray-200 text-center mb-8">{{ __('about_text') }}</p>
        <div class="grid md:grid-cols-3 gap-8 mt-12">
            <div class="bg-gray-900 card-anim rounded-xl shadow-lg p-6 text-center border border-gray-800">
                <div class="flex justify-center mb-2">
                    <svg class="w-12 h-12 text-yellow-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 8h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2"></path><rect width="10" height="6" x="7" y="2" rx="1"/></svg>
                </div>
                <h3 class="font-bold text-xl mb-2 text-yellow-300">{{ __('about_card1_title') }}</h3>
                <p class="text-gray-300">{{ __('about_card1_text') }}</p>
            </div>
            <div class="bg-gray-900 card-anim rounded-xl shadow-lg p-6 text-center border border-gray-800">
                <div class="flex justify-center mb-2">
                    <svg class="w-12 h-12 text-yellow-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z"></path><path d="M19.4 15a1.65 1.65 0 0 0 .33-1.82l-1.1-2.2a1.65 1.65 0 0 0-1.48-.98h-2.22a1.65 1.65 0 0 0-1.48.98l-1.1 2.2a1.65 1.65 0 0 0 .33 1.82l1.1 1.1a1.65 1.65 0 0 0 2.34 0l1.1-1.1z"></path></svg>
                </div>
                <h3 class="font-bold text-xl mb-2 text-yellow-300">{{ __('about_card2_title') }}</h3>
                <p class="text-gray-300">{{ __('about_card2_text') }}</p>
                                </div>
            <div class="bg-gray-900 card-anim rounded-xl shadow-lg p-6 text-center border border-gray-800">
                <div class="flex justify-center mb-2">
                    <svg class="w-12 h-12 text-yellow-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 17v-2a4 4 0 0 1 8 0v2"></path><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                <h3 class="font-bold text-xl mb-2 text-yellow-300">{{ __('about_card3_title') }}</h3>
                <p class="text-gray-300">{{ __('about_card3_text') }}</p>
                                </div>
                            </div>
    </section>

    <!-- Examples Section -->
    <section class="py-20 px-4 max-w-4xl mx-auto fade-in-up">
        <h2 class="text-3xl font-bold text-center mb-10 text-yellow-400">{{ __('examples_title') }}</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-900 border border-gray-800 rounded-xl shadow-lg">
                <thead class="bg-gray-800 text-yellow-300">
                    <tr>
                        <th class="py-2 px-4">{{ __('examples_col_comment') }}</th>
                        <th class="py-2 px-4">{{ __('examples_col_result') }}</th>
                        <th class="py-2 px-4">{{ __('examples_col_action') }}</th>
                    </tr>
                </thead>
                <tbody class="text-gray-200">
                    <tr class="hover:bg-gray-800 transition">
                        <td class="py-2 px-4">{{ __('examples_row1_comment') }}</td>
                        <td class="py-2 px-4">{{ __('examples_row1_result') }}</td>
                        <td class="py-2 px-4">{{ __('examples_row1_action') }}</td>
                    </tr>
                    <tr class="hover:bg-gray-800 transition">
                        <td class="py-2 px-4">{{ __('examples_row2_comment') }}</td>
                        <td class="py-2 px-4">{{ __('examples_row2_result') }}</td>
                        <td class="py-2 px-4">{{ __('examples_row2_action') }}</td>
                    </tr>
                    <tr class="hover:bg-gray-800 transition">
                        <td class="py-2 px-4">{{ __('examples_row3_comment') }}</td>
                        <td class="py-2 px-4">{{ __('examples_row3_result') }}</td>
                        <td class="py-2 px-4">{{ __('examples_row3_action') }}</td>
                    </tr>
                    <tr class="hover:bg-gray-800 transition">
                        <td class="py-2 px-4">{{ __('examples_row4_comment') }}</td>
                        <td class="py-2 px-4">{{ __('examples_row4_result') }}</td>
                        <td class="py-2 px-4">{{ __('examples_row4_action') }}</td>
                    </tr>
                    <tr class="hover:bg-gray-800 transition">
                        <td class="py-2 px-4">{{ __('examples_row5_comment') }}</td>
                        <td class="py-2 px-4">{{ __('examples_row5_result') }}</td>
                        <td class="py-2 px-4">{{ __('examples_row5_action') }}</td>
                    </tr>
                </tbody>
            </table>
                                </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gradient-to-r from-gray-900 via-gray-800 to-black fade-in-up">
        <div class="max-w-4xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-bold mb-4 text-yellow-400">{{ __('pricing_title') }}</h2>
            <p class="text-gray-300">{{ __('pricing_subtitle') }}</p>
                            </div>
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <div class="bg-gray-900 card-anim rounded-lg shadow p-8 flex flex-col items-center border border-gray-800">
                <h3 class="font-bold text-xl mb-2 text-yellow-300">{{ __('starter') }}</h3>
                <div class="text-3xl font-extrabold mb-4 text-yellow-200">{{ __('starter_price') }}</div>
                <ul class="mb-6 text-gray-300">
                    <li>{{ __('starter_1') }}</li>
                    <li>{{ __('starter_2') }}</li>
                    <li>{{ __('starter_3') }}</li>
                </ul>
                <button class="bg-yellow-400 text-gray-900 px-6 py-2 rounded-full font-semibold hover:bg-yellow-300 transition">{{ __('choose') }}</button>
                                </div>
            <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 text-gray-900 rounded-lg shadow-lg p-8 flex flex-col items-center scale-105 card-anim border-2 border-yellow-400">
                <h3 class="font-bold text-xl mb-2">{{ __('pro') }}</h3>
                <div class="text-3xl font-extrabold mb-4">{{ __('pro_price') }}</div>
                <ul class="mb-6">
                    <li>{{ __('pro_1') }}</li>
                    <li>{{ __('pro_2') }}</li>
                    <li>{{ __('pro_3') }}</li>
                    <li>{{ __('pro_4') }}</li>
                </ul>
                <button class="bg-gray-900 text-yellow-400 px-6 py-2 rounded-full font-semibold hover:bg-gray-800 transition">{{ __('choose') }}</button>
                            </div>
            <div class="bg-gray-900 card-anim rounded-lg shadow p-8 flex flex-col items-center border border-gray-800">
                <h3 class="font-bold text-xl mb-2 text-yellow-300">{{ __('enterprise') }}</h3>
                <div class="text-3xl font-extrabold mb-4 text-yellow-200">{{ __('enterprise_price') }}</div>
                <ul class="mb-6 text-gray-300">
                    <li>{{ __('enterprise_1') }}</li>
                    <li>{{ __('enterprise_2') }}</li>
                    <li>{{ __('enterprise_3') }}</li>
                    <li>{{ __('enterprise_4') }}</li>
                </ul>
                <button class="bg-yellow-400 text-gray-900 px-6 py-2 rounded-full font-semibold hover:bg-yellow-300 transition">{{ __('choose') }}</button>
                        </div>
                    </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-4 max-w-5xl mx-auto fade-in-up">
        <h2 class="text-3xl font-bold text-center mb-10 text-yellow-400">{{ __('features_title') }}</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-900 card-anim rounded-lg shadow p-6 text-center border border-gray-800">
                <div class="text-4xl mb-2">⚡</div>
                <h3 class="font-bold text-xl mb-2 text-yellow-300">{{ __('features_card1_title') }}</h3>
                <p class="text-gray-300">{{ __('features_card1_text') }}</p>
                        </div>
            <div class="bg-gray-900 card-anim rounded-lg shadow p-6 text-center border border-gray-800">
                <div class="text-4xl mb-2">🛡️</div>
                <h3 class="font-bold text-xl mb-2 text-yellow-300">{{ __('features_card2_title') }}</h3>
                <p class="text-gray-300">{{ __('features_card2_text') }}</p>
                    </div>
            <div class="bg-gray-900 card-anim rounded-lg shadow p-6 text-center border border-gray-800">
                <div class="text-4xl mb-2">🧹</div>
                <h3 class="font-bold text-xl mb-2 text-yellow-300">{{ __('features_card3_title') }}</h3>
                <p class="text-gray-300">{{ __('features_card3_text') }}</p>
            </div>
        </div>
    </section>

    <!-- Feedback Section -->
    <section id="feedback" class="py-20 px-4 max-w-2xl mx-auto fade-in-up">
        <h2 class="text-3xl font-bold text-center mb-8 text-yellow-400">{{ __('feedback.title') }}</h2>
        <form action="{{ route('feedback.store') }}" method="POST" class="bg-gray-900 rounded-xl shadow-lg border border-gray-800 p-8 space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-200 mb-2">{{ __('feedback.name') }}</label>
                <input type="text" id="name" name="name" required class="w-full px-4 py-3 border border-gray-700 rounded-lg bg-gray-800 text-gray-100 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition-colors duration-200" placeholder="{{ __('feedback.name_placeholder') }}">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-200 mb-2">{{ __('feedback.email') }}</label>
                <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-700 rounded-lg bg-gray-800 text-gray-100 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition-colors duration-200" placeholder="{{ __('feedback.email_placeholder') }}">
            </div>
            <div>
                <label for="message" class="block text-sm font-medium text-gray-200 mb-2">{{ __('feedback.message') }}</label>
                <textarea id="message" name="message" rows="5" required class="w-full px-4 py-3 border border-gray-700 rounded-lg bg-gray-800 text-gray-100 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition-colors duration-200" placeholder="{{ __('feedback.message_placeholder') }}"></textarea>
            </div>
            <div class="flex justify-center">
                <button type="submit" class="inline-flex items-center px-8 py-3 bg-yellow-400 text-gray-900 font-bold rounded-lg shadow hover:bg-yellow-300 transition text-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    {{ __('feedback.send') }}
                </button>
            </div>
        </form>
    </section>

    <!-- Footer -->
    <footer class="py-8 text-center text-gray-400 bg-black mt-12 border-t border-gray-800 animate-fade-in-up">
        &copy; {{ date('Y') }} Emotion Scope. {{ __('all_rights_reserved') }}
    </footer>
    </body>
</html>
