@extends('layouts.app')

@section('title', __('Home'))

@section('content')
<!-- ========================================== -->
<!-- HORIZONTAL PRODUCT SLIDER SECTION -->
<!-- ========================================== -->
@if($sliderSettings->is_active && $sliderProducts->count() > 0)
<section class="product-slider-section">
    <div class="slider-container" id="product-slider">
        <!-- Slider Track - Contains all slides -->
        <div class="slider-track" id="slider-track">
            @foreach($sliderProducts as $index => $product)
            <div class="slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                <div class="slide-content">
                    <!-- Product Image -->
                    <div class="slide-image">
                        <img src="{{ $product->main_image }}" alt="{{ $product->name }}">
                        @if($product->condition === 'new')
                        <span class="product-badge new">{{ __('New') }}</span>
                        @else
                        <span class="product-badge used">{{ __('Used') }}</span>
                        @endif
                    </div>
                    <!-- Product Info -->
                    <div class="slide-info">
                        <h2 class="product-name">{{ $product->name }}</h2>
                        <p class="product-description">{{ \Illuminate\Support\Str::limit($product->description, 120) }}</p>
                        <div class="product-price">{{ number_format($product->price, 2) }} {{ __('SAR') }}</div>
                        <a href="{{ route('products.show', $product->slug) }}" class="btn-view-details">
                            {{ __('View Details') }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Navigation Arrows -->
        <button class="slider-nav prev" id="slider-prev" aria-label="Previous">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
        </button>
        <button class="slider-nav next" id="slider-next" aria-label="Next">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6"/>
            </svg>
        </button>
        
        <!-- Progress Indicators -->
        <div class="slider-indicators" id="slider-indicators">
            @foreach($sliderProducts as $index => $product)
            <button class="indicator {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}" aria-label="Go to slide {{ $index + 1 }}">
                <span class="indicator-progress"></span>
            </button>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ========================================== -->
<!-- ANIMATED LAPTOP COMPONENT -->
<!-- ========================================== -->
<div class="laptop-container">
    <div class="laptop">
        <!-- Laptop Base -->
        <div class="laptop-base">
            <div class="keyboard">
                <div class="keyboard-row">
                    <div class="key"></div><div class="key"></div><div class="key"></div><div class="key"></div>
                    <div class="key"></div><div class="key"></div><div class="key"></div><div class="key"></div>
                    <div class="key"></div><div class="key"></div><div class="key"></div><div class="key"></div>
                </div>
            </div>
        </div>
        
        <!-- Laptop Screen -->
        <div class="laptop-screen">
            <div class="screen-frame">
                <div class="screen-bezel">
                    <div class="camera"></div>
                </div>
                <div class="screen-content" data-welcome="{{ __("Welcome to store") }}" data-rtl="{{ app()->getLocale() === 'ar' || app()->getLocale() === 'ur' ? '1' : '0' }}">
                    <div class="screen-text" id="typing-text"></div>
                    <span class="cursor" id="typing-cursor">|</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row mb-5">
        <div class="col-12 text-center">
            @php $titleStoreName = __('Store name'); if ($titleStoreName === 'Store name') $titleStoreName = config('app.name', 'تقنيات القمّة'); @endphp
            <h1 class="display-4 fw-bold text-dark mb-3">{{ $titleStoreName }}</h1>
            <p class="lead text-secondary max-w-2xl mx-auto">{{ __('Welcome to our technology store') }} - {{ __('Your trusted partner in Cybersecurity, Cloud Solutions & Tech Products') }}</p>
        </div>
    </div>

    <!-- Categories -->
    <div class="row mb-5">
        <div class="col-12 d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold h3 text-dark mb-0">{{ __('Categories') }}</h2>
            <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">{{ $categories->count() }} {{ __('Categories Available') }}</span>
        </div>
        @foreach($categories as $category)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-0 h-100 shadow-sm rounded-4 overflow-hidden card-hover-effect">
                <img src="{{ $category->image_url }}" class="card-img-top" alt="{{ $category->name }}" style="height: 220px; object-fit: cover;" loading="lazy">
                <div class="card-body d-flex flex-column p-4">
                    <h5 class="card-title fw-bold h4 mb-2">{{ $category->name }}</h5>
                    <p class="card-text text-muted flex-grow-1 mb-4">{{ \Illuminate\Support\Str::limit($category->description, 100) }}</p>
                    <a href="{{ route('products.index', ['category' => $category->id]) }}" class="btn btn-outline-primary rounded-pill fw-bold w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                        <span>{{ __('View Products') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Featured Products -->
    <div class="row mb-5">
        <div class="col-12 mb-4">
            <h2 class="fw-bold h3 text-dark">{{ __('Featured Products') }}</h2>
        </div>
        @foreach($featuredProducts as $product)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-0 h-100 shadow-sm rounded-4 overflow-hidden card-hover-effect">
                <img src="{{ $product->main_image }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;" loading="lazy">
                <div class="card-body d-flex flex-column p-3">
                    <span class="badge bg-{{ $product->condition === 'new' ? 'success' : 'warning' }} align-self-start mb-2 px-2 py-1">
                        {{ $product->condition === 'new' ? __('New') : __('Used') }}
                    </span>
                    <h5 class="card-title fw-bold fs-6 mb-2">{{ $product->name }}</h5>
                    <p class="card-text text-muted small flex-grow-1 mb-3">{{ \Illuminate\Support\Str::limit($product->description, 75) }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="h5 fw-bold text-primary mb-0">{{ number_format($product->price, 2) }} {{ __('SAR') }}</span>
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-primary rounded-pill px-3 py-1 fw-bold">{{ __('View Details') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Cybersecurity & Cloud Security Showcase -->
    <div class="row my-5">
        <div class="col-12">
            <div class="p-4 p-md-5 rounded-5 text-white shadow-lg position-relative overflow-hidden" style="background: linear-gradient(135deg, #030712 0%, #0b1329 50%, #111c44 100%);">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-4 mb-lg-0">
                        <span class="badge bg-success text-white rounded-pill px-3 py-2 mb-3 font-monospace">
                            <span class="spinner-grow spinner-grow-sm me-1" role="status"></span>
                            CYBERSECURITY &amp; CLOUD ARCHITECTURE
                        </span>
                        <h2 class="display-6 fw-bold text-white mb-3">حلول الأمن السيبراني والحوسبة السحابية</h2>
                        <p class="text-light opacity-90 fs-5 mb-4">
                            نوفر أحدث التقنيات الدفاعية، جدران الحماية، تشفير البيانات، وصيانة البنية التحتية البرمجية لضمان أمان عملك واستمراريته.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="{{ route('maintenance.create') }}" class="btn btn-emerald btn-lg rounded-pill px-4 py-2 fw-bold text-white shadow" style="background: #10b981;">
                                {{ __('Request Technical Support') }}
                            </a>
                            <a href="https://wa.me/966509283779" target="_blank" class="btn btn-outline-light btn-lg rounded-pill px-4 py-2 fw-bold">
                                {{ __('Contact Security Team') }}
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5 text-center">
                        <img src="{{ asset('images/cybersecurity.svg') }}" alt="Cybersecurity Banner" class="img-fluid rounded-4 shadow-sm" style="max-height: 280px; width: 100%; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* ============================================ */
/* PRODUCT SLIDER STYLES */
/* ============================================ */

/* Slider Section Container */
.product-slider-section {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    padding: 0;
    overflow: hidden;
    position: relative;
}

/* Main Slider Container */
.slider-container {
    position: relative;
    width: 100%;
    height: 500px;
    overflow: hidden;
}

/* Slider Track - Holds all slides */
.slider-track {
    display: flex;
    width: 100%;
    height: 100%;
    transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

/* Individual Slide */
.slide {
    min-width: 100%;
    height: 100%;
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
    transition: opacity 0.8s ease-in-out, transform 0.8s ease-in-out;
    transform: translateX(100%);
}

.slide.active {
    opacity: 1;
    transform: translateX(0);
    position: relative;
}

.slide.prev {
    transform: translateX(-100%);
}

/* Slide Content Layout */
.slide-content {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    padding: 40px 80px;
    gap: 60px;
    max-width: 1400px;
    margin: 0 auto;
}

/* Product Image */
.slide-image {
    flex: 0 0 400px;
    height: 350px;
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
    transform: perspective(1000px) rotateY(-5deg);
    transition: transform 0.5s ease;
}

.slide-image:hover {
    transform: perspective(1000px) rotateY(0deg) scale(1.02);
}

.slide-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Product Badge */
.product-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    padding: 8px 20px;
    border-radius: 30px;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.product-badge.new {
    background: linear-gradient(135deg, #00c853, #00e676);
    color: #fff;
}

.product-badge.used {
    background: linear-gradient(135deg, #ff9800, #ffb300);
    color: #fff;
}

/* Product Info */
.slide-info {
    flex: 1;
    color: #fff;
    text-align: right;
    direction: rtl;
}

.product-name {
    font-size: 42px;
    font-weight: 700;
    margin-bottom: 20px;
    line-height: 1.2;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.product-description {
    font-size: 18px;
    line-height: 1.8;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 25px;
}

.product-price {
    font-size: 36px;
    font-weight: 700;
    color: #00e676;
    margin-bottom: 30px;
    text-shadow: 0 0 20px rgba(0, 230, 118, 0.3);
}

/* View Details Button */
.btn-view-details {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 35px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
    text-decoration: none;
    border-radius: 50px;
    font-size: 18px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
}

.btn-view-details:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
    color: #fff;
}

.btn-view-details svg {
    transition: transform 0.3s ease;
}

.btn-view-details:hover svg {
    transform: translateX(-5px);
}

/* Navigation Arrows */
.slider-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    border: none;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

.slider-nav:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-50%) scale(1.1);
}

.slider-nav.prev {
    left: 20px;
}

.slider-nav.next {
    right: 20px;
}

/* Progress Indicators */
.slider-indicators {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 12px;
    z-index: 10;
}

.indicator {
    width: 60px;
    height: 4px;
    border: none;
    border-radius: 2px;
    background: rgba(255, 255, 255, 0.3);
    cursor: pointer;
    overflow: hidden;
    transition: all 0.3s ease;
    padding: 0;
}

.indicator:hover {
    background: rgba(255, 255, 255, 0.5);
}

.indicator.active {
    background: rgba(255, 255, 255, 0.3);
}

.indicator-progress {
    display: block;
    width: 0;
    height: 100%;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
    transition: width 0.1s linear;
}

.indicator.active .indicator-progress {
    width: 100%;
    transition: width {{ $sliderSettings->slide_duration }}ms linear;
}

/* Responsive Design for Slider */
@media (max-width: 1024px) {
    .slider-container {
        height: 450px;
    }
    
    .slide-content {
        padding: 30px 60px;
        gap: 40px;
    }
    
    .slide-image {
        flex: 0 0 300px;
        height: 280px;
    }
    
    .product-name {
        font-size: 32px;
    }
    
    .product-price {
        font-size: 28px;
    }
}

@media (max-width: 768px) {
    .slider-container {
        height: auto;
        min-height: 600px;
    }
    
    .slide-content {
        flex-direction: column;
        padding: 40px 20px;
        gap: 30px;
        text-align: center;
    }
    
    .slide-image {
        flex: 0 0 auto;
        width: 280px;
        height: 220px;
        transform: none;
    }
    
    .slide-info {
        text-align: center;
    }
    
    .product-name {
        font-size: 28px;
    }
    
    .product-description {
        font-size: 16px;
    }
    
    .product-price {
        font-size: 24px;
    }
    
    .slider-nav {
        width: 40px;
        height: 40px;
    }
    
    .slider-nav.prev {
        left: 10px;
    }
    
    .slider-nav.next {
        right: 10px;
    }
    
    .indicator {
        width: 40px;
    }
}

@media (max-width: 480px) {
    .slide-image {
        width: 220px;
        height: 180px;
    }
    
    .product-name {
        font-size: 24px;
    }
    
    .btn-view-details {
        padding: 12px 25px;
        font-size: 16px;
    }
}

/* ============================================ */
/* LAPTOP COMPONENT STYLES */
/* ============================================ */

/* Laptop Container - Centered and Responsive */
.laptop-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 400px;
    padding: 40px 20px;
    margin-bottom: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

/* Laptop Base Structure */
.laptop {
    position: relative;
    width: 600px;
    max-width: 90%;
    perspective: 1000px;
}

/* Laptop Base (Keyboard Area) */
.laptop-base {
    width: 100%;
    height: 30px;
    background: linear-gradient(to bottom, #2c3e50, #34495e);
    border-radius: 8px 8px 0 0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    position: relative;
    z-index: 2;
}

/* Keyboard Styling */
.keyboard {
    padding: 4px 8px;
    display: flex;
    justify-content: center;
}

.keyboard-row {
    display: flex;
    gap: 2px;
}

.key {
    width: 8px;
    height: 3px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 1px;
}

/* Laptop Screen */
.laptop-screen {
    width: 100%;
    height: 380px;
    background: linear-gradient(to bottom, #34495e, #2c3e50);
    border-radius: 8px 8px 0 0;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
    transform-origin: bottom center;
    /* Start closed - rotated 90 degrees backward */
    transform: rotateX(-90deg);
    /* Smooth transition for opening animation */
    transition: transform 1.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    position: relative;
    z-index: 1;
}

/* Screen Opens when 'open' class is added (triggered by JavaScript) */
.laptop-screen.open {
    /* Rotate to 0 degrees - fully open position */
    transform: rotateX(0deg);
}

/* Screen Frame */
.screen-frame {
    width: 100%;
    height: 100%;
    background: #1a1a1a;
    border: 3px solid #000;
    border-radius: 4px;
    padding: 8px;
    box-sizing: border-box;
    position: relative;
}

/* Screen Bezel (Top Bar) */
.screen-bezel {
    height: 25px;
    background: #000;
    border-radius: 2px 2px 0 0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 2px;
}

/* Camera */
.camera {
    width: 8px;
    height: 8px;
    background: #333;
    border-radius: 50%;
    position: relative;
}

.camera::after {
    content: '';
    position: absolute;
    width: 4px;
    height: 4px;
    background: #1a1a1a;
    border-radius: 50%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* Screen Content Area */
.screen-content {
    width: 100%;
    height: calc(100% - 27px);
    background: #0a0a0a;
    border-radius: 0 0 2px 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
    position: relative;
    overflow: hidden;
}

/* Screen Text - direction set by JS from locale (RTL/LTR) */
.screen-text {
    color: #00ff00;
    font-family: 'Courier New', monospace;
    font-size: 24px;
    line-height: 1.6;
    text-align: center;
    font-weight: 600;
    text-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
    min-height: 50px;
}

/* Typing Cursor */
.cursor {
    color: #00ff00;
    font-size: 24px;
    animation: blink 1s infinite;
    margin-left: 2px;
}

@keyframes blink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0; }
}

/* Responsive Design */
@media (max-width: 768px) {
    .laptop-container {
        min-height: 300px;
        padding: 30px 15px;
        margin-bottom: 40px;
    }
    
    .laptop {
        width: 100%;
        max-width: 500px;
    }
    
    .laptop-screen {
        height: 280px;
    }
    
    .screen-text {
        font-size: 18px;
    }
    
    .cursor {
        font-size: 18px;
    }
}

@media (max-width: 480px) {
    .laptop-container {
        min-height: 250px;
        padding: 20px 10px;
    }
    
    .laptop-screen {
        height: 220px;
    }
    
    .screen-text {
        font-size: 16px;
    }
    
    .cursor {
        font-size: 16px;
    }
}
</style>
@endpush

@push('scripts')
<script>
/**
 * ============================================
 * HORIZONTAL PRODUCT SLIDER
 * Auto-rotating slider with pause on hover
 * ============================================
 */
(function() {
    'use strict';
    
    // Get slider elements
    const sliderContainer = document.getElementById('product-slider');
    if (!sliderContainer) return; // Exit if no slider
    
    const slides = sliderContainer.querySelectorAll('.slide');
    const indicators = sliderContainer.querySelectorAll('.indicator');
    const prevBtn = document.getElementById('slider-prev');
    const nextBtn = document.getElementById('slider-next');
    
    // Slider configuration
    const slideDuration = {{ $sliderSettings->slide_duration ?? 10000 }}; // Duration from admin settings
    const totalSlides = slides.length;
    
    let currentSlide = 0;
    let autoSlideInterval = null;
    let isPaused = false;
    
    /**
     * Go to specific slide
     * @param {number} index - Target slide index
     */
    function goToSlide(index) {
        // Wrap around if out of bounds
        if (index >= totalSlides) index = 0;
        if (index < 0) index = totalSlides - 1;
        
        // Update slides
        slides.forEach((slide, i) => {
            slide.classList.remove('active', 'prev');
            if (i === currentSlide) {
                slide.classList.add('prev');
            }
        });
        
        slides[index].classList.add('active');
        
        // Update indicators
        indicators.forEach((indicator, i) => {
            indicator.classList.remove('active');
            const progress = indicator.querySelector('.indicator-progress');
            if (progress) progress.style.width = '0';
        });
        
        indicators[index].classList.add('active');
        
        // Update current slide index
        currentSlide = index;
        
        // Restart progress animation
        startProgressAnimation();
    }
    
    /**
     * Go to next slide
     */
    function nextSlide() {
        goToSlide(currentSlide + 1);
    }
    
    /**
     * Go to previous slide
     */
    function prevSlide() {
        goToSlide(currentSlide - 1);
    }
    
    /**
     * Start progress animation for current indicator
     */
    function startProgressAnimation() {
        const activeIndicator = indicators[currentSlide];
        const progress = activeIndicator.querySelector('.indicator-progress');
        if (progress) {
            // Reset progress
            progress.style.width = '0';
            progress.style.transition = 'none';
            
            // Force reflow
            progress.offsetHeight;
            
            // Start animation
            progress.style.transition = `width ${slideDuration}ms linear`;
            progress.style.width = '100%';
        }
    }
    
    /**
     * Start auto-rotation
     */
    function startAutoSlide() {
        stopAutoSlide(); // Clear any existing interval
        autoSlideInterval = setInterval(function() {
            if (!isPaused) {
                nextSlide();
            }
        }, slideDuration);
        
        // Start initial progress animation
        startProgressAnimation();
    }
    
    /**
     * Stop auto-rotation
     */
    function stopAutoSlide() {
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
            autoSlideInterval = null;
        }
    }
    
    /**
     * Pause slider on hover
     */
    function pauseSlider() {
        isPaused = true;
        const activeIndicator = indicators[currentSlide];
        const progress = activeIndicator.querySelector('.indicator-progress');
        if (progress) {
            const currentWidth = progress.offsetWidth;
            const containerWidth = activeIndicator.offsetWidth;
            const percentage = (currentWidth / containerWidth) * 100;
            progress.style.transition = 'none';
            progress.style.width = percentage + '%';
        }
    }
    
    /**
     * Resume slider when mouse leaves
     */
    function resumeSlider() {
        isPaused = false;
        const activeIndicator = indicators[currentSlide];
        const progress = activeIndicator.querySelector('.indicator-progress');
        if (progress) {
            const currentWidth = parseFloat(progress.style.width) || 0;
            const remainingPercentage = 100 - currentWidth;
            const remainingTime = (remainingPercentage / 100) * slideDuration;
            
            progress.style.transition = `width ${remainingTime}ms linear`;
            progress.style.width = '100%';
        }
    }
    
    // Event Listeners
    
    // Navigation buttons
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            prevSlide();
            startAutoSlide(); // Reset timer
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            nextSlide();
            startAutoSlide(); // Reset timer
        });
    }
    
    // Indicator clicks
    indicators.forEach(function(indicator, index) {
        indicator.addEventListener('click', function() {
            goToSlide(index);
            startAutoSlide(); // Reset timer
        });
    });
    
    // Pause on hover
    sliderContainer.addEventListener('mouseenter', pauseSlider);
    sliderContainer.addEventListener('mouseleave', resumeSlider);
    
    // Touch support for mobile
    let touchStartX = 0;
    let touchEndX = 0;
    
    sliderContainer.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
        pauseSlider();
    }, { passive: true });
    
    sliderContainer.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
        resumeSlider();
    }, { passive: true });
    
    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // Swipe left - go to next (RTL: previous)
                prevSlide();
            } else {
                // Swipe right - go to previous (RTL: next)
                nextSlide();
            }
            startAutoSlide();
        }
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            nextSlide(); // RTL: left arrow goes next
            startAutoSlide();
        } else if (e.key === 'ArrowRight') {
            prevSlide(); // RTL: right arrow goes prev
            startAutoSlide();
        }
    });
    
    // Start the slider
    startAutoSlide();
})();

/**
 * ============================================
 * ANIMATED LAPTOP COMPONENT
 * Uses Intersection Observer to trigger animation when element comes into view
 * ============================================
 */

(function() {
    'use strict';
    
    // Get all required elements
    const laptopContainer = document.querySelector('.laptop-container');
    const laptopScreen = document.querySelector('.laptop-screen');
    const typingText = document.getElementById('typing-text');
    const cursor = document.getElementById('typing-cursor');
    const screenContent = document.querySelector('.screen-content');
    
    // Welcome text from current language (set in blade)
    const text = (screenContent && screenContent.getAttribute('data-welcome')) || 'مرحباً بك في تقنيات القمّة';
    const isRtl = screenContent && screenContent.getAttribute('data-rtl') === '1';
    if (typingText) {
        typingText.style.direction = isRtl ? 'rtl' : 'ltr';
        typingText.style.textAlign = isRtl ? 'right' : 'left';
    }
    
    // Flag to ensure animation runs only once
    let hasAnimated = false;
    
    // Check if all required elements exist
    if (!laptopContainer || !laptopScreen || !typingText || !cursor) {
        console.warn('Laptop component elements not found');
        return;
    }
    
    /**
     * Function to open the laptop screen
     * Adds 'open' class which triggers CSS animation
     */
    function openLaptop() {
        laptopScreen.classList.add('open');
    }
    
    /**
     * Function to start typing effect
     * Types each character one by one with a delay
     */
    function startTyping() {
        let index = 0;
        typingText.textContent = '';
        cursor.style.display = 'inline';
        
        /**
         * Recursive function to type each character
         * Types one character, then calls itself for the next character
         */
        function typeCharacter() {
            if (index < text.length) {
                // Add current character to the text
                typingText.textContent += text[index];
                index++;
                // Call next character after delay (80ms = fast typing speed)
                setTimeout(typeCharacter, 80);
            } else {
                // Typing complete - keep cursor blinking
                cursor.style.display = 'inline';
            }
        }
        
        // Start typing
        typeCharacter();
    }
    
    /**
     * Main animation function
     * Opens laptop first, then starts typing after laptop is fully open
     */
    function triggerAnimation() {
        // Prevent multiple animations
        if (hasAnimated) return;
        hasAnimated = true;
        
        // Step 1: Open laptop screen (triggers CSS animation)
        openLaptop();
        
        // Step 2: Start typing after laptop is fully opened
        // Wait for CSS animation to complete (1.5s) + small buffer (100ms)
        setTimeout(function() {
            startTyping();
        }, 1600);
    }
    
    /**
     * Intersection Observer Configuration
     * Detects when laptop container enters the viewport
     */
    const observerOptions = {
        // Trigger when 30% of the element is visible
        threshold: 0.3,
        // Start observing slightly before element enters viewport
        rootMargin: '0px'
    };
    
    /**
     * Intersection Observer Callback
     * Called when element enters or leaves viewport
     */
    function handleIntersection(entries, observer) {
        entries.forEach(function(entry) {
            // Check if element is intersecting (visible in viewport)
            if (entry.isIntersecting && !hasAnimated) {
                // Trigger animation
                triggerAnimation();
                // Stop observing after animation starts (no need to continue)
                observer.unobserve(laptopContainer);
            }
        });
    }
    
    /**
     * Create and start Intersection Observer
     * Checks if browser supports Intersection Observer
     */
    if ('IntersectionObserver' in window) {
        // Modern browsers - use Intersection Observer
        const observer = new IntersectionObserver(handleIntersection, observerOptions);
        observer.observe(laptopContainer);
    } else {
        // Fallback for older browsers - trigger on page load
        window.addEventListener('load', function() {
            setTimeout(triggerAnimation, 500);
        });
    }
})();
</script>
@endpush
@endsection
