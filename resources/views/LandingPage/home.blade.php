<x-layouts.app :title="'Find Authentic Home Cooking'">

<!-- Navbar -->
<nav class="navbar">
    <a href="{{ route('home') }}" class="navbar-brand">
        <div class="logo-icon"><i class="fas fa-utensils"></i></div>
        <div>
            <div>PLATEPAL</div>
            <div class="navbar-sub">Tagum City Edition</div>
        </div>
    </a>
    <div class="navbar-nav">
        <a href="{{ route('browse') }}">Browse Caterers</a>
        <a href="{{ route('client.messages') }}">Messages</a>
        <a href="#">How It Works</a>
        <a href="#">For Caterers</a>
    </div>
    <div class="navbar-actions">
        <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Sign In</a>
        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Get Started</a>
    </div>
</nav>

<!-- Hero -->
<section class="hero">
    <div class="hero-eyebrow">🍽️ Tagum City's Home Kitchen Marketplace</div>
    <h1>Find <span>authentic</span> home cooking for your next event</h1>
    <p>Connect with talented home-based caterers right in your barangay — real food kept on simple ingredients.</p>

    <div class="hero-search">
        <div class="search-group">
            <label>What are you looking for?</label>
            <input type="text" placeholder="Search chicken, lechon, kare-kare...">
        </div>
        <div class="search-divider"></div>
        <div class="search-group">
            <label>📍 Location</label>
            <select>
                <option>Tagum City</option>
                <option>Magugpo Poblacion</option>
                <option>Apokon</option>
                <option>Visayan Village</option>
                <option>Nueva Fuerza</option>
            </select>
        </div>
        <a href="{{ route('login') }}" class="btn btn-primary">Find Caterers</a>
    </div>

    <div class="hero-stats">
        <div class="stat-item">
            <div class="stat-number">48+</div>
            <div class="stat-label">Home Caterers</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">12</div>
            <div class="stat-label">Barangays Covered</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">320+</div>
            <div class="stat-label">Events Served</div>
        </div>
    </div>
</section>

<!-- Featured Caterers -->
<section class="section" style="background: linear-gradient(#F1DEC5 45%, #FFFFFF 100%)">
    <div class="section-header">
        <h2 class="section-title">Featured Local Caterers</h2>
        <a href="{{ route('login') }}" class="section-link">View All →</a>
    </div>
    <div class="caterer-grid">
        @php
            // Determine which collection to use
            $displayCaterers = collect();
            if (isset($caterers) && $caterers instanceof \Illuminate\Support\Collection && $caterers->isNotEmpty()) {
                $displayCaterers = $caterers;
            } elseif (isset($featuredCaterers) && $featuredCaterers instanceof \Illuminate\Support\Collection && $featuredCaterers->isNotEmpty()) {
                $displayCaterers = $featuredCaterers;
            }
        @endphp

        @if($displayCaterers->isEmpty())
            {{-- Fallback static caterers --}}
            @foreach([
                ['name'=>"Lola Maria's Kitchen",'loc'=>'Magugpo Poblacion','cuisine'=>'Authentic Tagum Native Chicken','rating'=>'4.8','reviews'=>'127','price'=>'300–500','img'=>'Pusit.jpg'],
                ['name'=>"Kusina ni Aling Nena",'loc'=>'Apokon','cuisine'=>'Mindanao Fusion Cuisine','rating'=>'4.9','reviews'=>'96','price'=>'400–600','img'=>'Kusina ni Aling Nena.jpg'],
                ['name'=>'TasteBuds Catering','loc'=>'Visayan Village','cuisine'=>'Party Packages & Event Buffet','rating'=>'4.7','reviews'=>'155','price'=>'350–550','img'=>'TasteBuds Catering.jpg'],
                ['name'=>'Bahay Kubo Kitchen','loc'=>'8 Barangays','cuisine'=>'Decent Farm-to-Table Dishes','rating'=>'4.8','reviews'=>'88','price'=>'250–450','img'=>'Bahay Kubo Kitchen.jpg'],
                ['name'=>'Sarap Pinoy Express','loc'=>'9 New Balandiran','cuisine'=>'Mindanao Party Trays','rating'=>'4.5','reviews'=>'61','price'=>'200–380','img'=>'Sarap Pinoy Express.jpg'],
                ['name'=>'DeliciaMaus Catering','loc'=>'9 Pagsabangan','cuisine'=>'Premium Seafood Flavors','rating'=>'4.8','reviews'=>'73','price'=>'400–700','img'=>'DeliciaHaus Catering.jpg'],
            ] as $c)
            <div class="caterer-card">
                <div class="caterer-card-image">
                    <img src="{{ asset('Assets/'.$c['img']) }}" alt="{{ $c['name'] }}">
                    <span class="caterer-card-badge featured">⭐ Featured</span>
                    <button class="caterer-card-fav"><i class="far fa-heart"></i></button>
                    <span class="price-tag">₱{{ $c['price'] }}/head</span>
                </div>
                <div class="caterer-card-body">
                    <div class="d-flex justify-between align-center">
                        <div class="caterer-card-name">{{ $c['name'] }}</div>
                        <div class="rating">
                            <div class="stars"><i class="fas fa-star"></i></div>
                            {{ $c['rating'] }}
                            <span class="count">({{ $c['reviews'] }})</span>
                        </div>
                    </div>
                    <div class="caterer-card-location"><i class="fas fa-map-marker-alt"></i> {{ $c['loc'] }}</div>
                    <div class="caterer-card-cuisine">{{ $c['cuisine'] }}</div>
                </div>
            </div>
            @endforeach
        @else
            @foreach($displayCaterers as $caterer)
            <div class="caterer-card">
                <div class="caterer-card-image">
                    <img src="{{ $caterer->cover_photo ?? asset('Assets/Pusit.jpg') }}" alt="{{ $caterer->business_name }}">
                    @if($caterer->is_featured ?? false)
                    <span class="caterer-card-badge featured">⭐ Featured</span>
                    @endif
                    <button class="caterer-card-fav"><i class="far fa-heart"></i></button>
                    <span class="price-tag">₱{{ $caterer->price_min ?? '300' }}–{{ $caterer->price_max ?? '500' }}/head</span>
                </div>
                <div class="caterer-card-body">
                    <div class="d-flex justify-between align-center">
                        <div class="caterer-card-name">{{ $caterer->business_name }}</div>
                        <div class="rating">
                            <div class="stars"><i class="fas fa-star"></i></div>
                            {{ number_format($caterer->avg_rating ?? 4.8, 1) }}
                            <span class="count">({{ $caterer->reviews_count ?? 127 }})</span>
                        </div>
                    </div>
                    <div class="caterer-card-location"><i class="fas fa-map-marker-alt"></i> {{ $caterer->barangay ?? 'Tagum City' }}</div>
                    <div class="caterer-card-cuisine">{{ $caterer->cuisine_type ?? 'Filipino Cuisine' }}</div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="footer-grid">
        <div>
            <div class="footer-brand"><i class="fas fa-utensils"></i> PLATEPAL</div>
            <p class="footer-desc">Connecting Tagum City's best home-based caterers with the community since 2024.</p>
        </div>
        <div class="footer-col">
            <h4>For Clients</h4>
            <ul>
                <li><a href="{{ route('browse') }}">Browse Caterers</a></li>
                <li><a href="#">How It Works</a></li>
                <li><a href="{{ route('login') }}">My Events</a></li>
                <li><a href="#">Client Reviews</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>For Caterers</h4>
            <ul>
                <li><a href="{{ route('caterer.register') }}">Join as Caterer</a></li>
                <li><a href="#">Pricing</a></li>
                <li><a href="#">Success Stories</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2026 PlatePal Tagum City. All rights reserved.</p>
    </div>
</footer>

</x-layouts.app>
