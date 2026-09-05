@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, config('app.rtl_locales', ['ar', 'ur']));
    $storeName = __('Store name');
    if ($storeName === 'Store name') {
        $storeName = config('app.name', 'تقنيات القمّة');
    }
@endphp
<!DOCTYPE html>
<html lang="{{ $locale === 'ur' ? 'ur' : str_replace('_', '-', $locale) }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Meta SEO -->
    <meta name="description" content="تقنيات القمة - منصة متكاملة للحلول التقنية، الأمن السيبراني، صيانة الأجهزة والمنتجات الحديثة.">
    <meta name="keywords" content="تقنيات القمة, الأمن السيبراني, صيانة حاسب, أجهزة ذكية, كاميرات مراقبة, Cloud Security, Cybersecurity">
    <meta property="og:title" content="@yield('title', $storeName) - {{ $storeName }}">
    <meta property="og:description" content="حلول ومنتجات تقنية وأمن سيبراني متقدمة بأعلى جودة وضمان.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('images/cybersecurity.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    @if($locale === 'ur')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;700&display=swap" rel="stylesheet">
    @endif

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @if($isRtl)
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @endif

    <!-- Modern App Styles -->
    <style>
        :root {
            --primary-glow: #6366f1;
            --cyber-green: #10b981;
            --cyber-accent: #38bdf8;
            --dark-bg: #0f172a;
        }

        body {
            @if($locale === 'ar')
            font-family: 'Cairo', system-ui, -apple-system, sans-serif;
            @elseif($locale === 'ur')
            font-family: 'Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq', serif;
            @else
            font-family: 'Outfit', 'Cairo', system-ui, sans-serif;
            @endif
            background-color: #f8fafc;
            color: #1e293b;
        }

        .navbar-main {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.25);
            padding: 0.8rem 1rem;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.6rem;
            background: linear-gradient(135deg, #ffffff 0%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 600;
            font-size: 1.05rem;
            transition: all 0.25s ease;
            border-radius: 8px;
            padding: 0.5rem 0.9rem !important;
        }

        .nav-link:hover, .nav-link.active {
            color: #38bdf8 !important;
            background: rgba(56, 189, 248, 0.08);
        }

        .whatsapp-nav-link {
            background: rgba(37, 211, 102, 0.12);
            border: 1px solid rgba(37, 211, 102, 0.3);
            border-radius: 30px !important;
            color: #25D366 !important;
            font-weight: 700;
            padding: 0.4rem 1.1rem !important;
        }

        .whatsapp-nav-link:hover {
            background: #25D366 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
        }

        .whatsapp-nav-link:hover .whatsapp-icon {
            color: #ffffff !important;
        }

        .badge-cyber {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .footer-cyber {
            background: linear-gradient(180deg, #0f172a 0%, #020617 100%);
            color: #94a3b8;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .card-hover-effect {
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
        }

        .card-hover-effect:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.12) !important;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-main sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">{{ $storeName }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav {{ $isRtl ? 'ms-auto' : 'me-auto' }}">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">{{ __('Products') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('maintenance.create') }}">{{ __('Maintenance') }}</a>
                    </li>
                </ul>
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-1 whatsapp-nav-link" href="https://wa.me/966509283779" target="_blank" rel="noopener noreferrer" aria-label="تواصل معنا على واتساب">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="currentColor" class="whatsapp-icon">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            <span class="d-none d-md-inline">{{ __('Contact WhatsApp') }}</span>
                        </a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                {{ __('Cart') }} 
                                @if(auth()->user()->cartItems()->count() > 0)
                                    <span class="badge bg-danger">{{ auth()->user()->cartItems()->count() }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile.index') }}">{{ __('Profile') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">{{ __('Orders') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('maintenance.index') }}">{{ __('Maintenance Requests') }}</a></li>
                                @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">{{ __('Admin Panel') }}</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">{{ __('Logout') }}</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-2 gap-md-3">
                <span>&copy; {{ date('Y') }} {{ $storeName }}. {{ __('All rights reserved.') }}</span>
                <span class="opacity-75">|</span>
                <span class="d-flex align-items-center gap-2 flex-wrap justify-content-center">
                    <span class="opacity-75">{{ __('Language') }}:</span>
                    @foreach(config('app.locales', []) as $langCode => $langLabel)
                        <a href="{{ route('locale.switch', $langCode) }}" class="text-light text-decoration-none {{ $locale === $langCode ? 'fw-bold' : 'opacity-75' }}">{{ $langLabel }}</a>
                        @if(!$loop->last)<span class="opacity-50">·</span>@endif
                    @endforeach
                </span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show/Hide password toggles
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.js-toggle-password');
            if (!btn) return;

            const selector = btn.getAttribute('data-target');
            if (!selector) return;

            const input = document.querySelector(selector);
            if (!input) return;

            const isHidden = input.getAttribute('type') === 'password';
            input.setAttribute('type', isHidden ? 'text' : 'password');

            const eye = btn.querySelector('.js-eye');
            const eyeSlash = btn.querySelector('.js-eye-slash');
            if (eye && eyeSlash) {
                eye.classList.toggle('d-none', !isHidden);
                eyeSlash.classList.toggle('d-none', isHidden);
            }

            btn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
        });
    </script>
    @stack('scripts')
</body>
</html>
