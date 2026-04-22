{{-- Resources/views/Caterer/browse.blade.php --}}
{{-- Using modern Blade component layout with slots --}}
<x-layouts.app :title="'Browse Caterers in Tagum City'">

<!-- Navbar -->
<nav class="navbar">
    <a href="{{ route('home') }}" class="navbar-brand">
        <div class="logo-icon"><i class="fas fa-utensils"></i></div>
        <div><div>PLATEPAL</div><div class="navbar-sub">Tagum City Edition</div></div>
    </a>
    <div class="navbar-nav">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('browse') }}" class="active">Browse Caterers</a>
    </div>
    <div class="navbar-actions">
        <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Sign In</a>
        <a href="{{ route('caterer.register') }}" class="btn btn-dark btn-sm">For Caterers</a>
    </div>
</nav>

<div class="section">
    <h1 style="font-size:28px;font-weight:800;margin-bottom:6px;">Browse Caterers in Tagum City</h1>
    <p class="text-muted fs-sm mb-3">Discover trusted local caterers for your special events</p>

    <div class="search-bar">
        <div class="search-input-wrap">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search caterers or specialties..." id="searchInput">
        </div>
        <button class="btn btn-outline btn-sm"><i class="fas fa-sliders-h"></i> Filters</button>
        <button class="btn btn-primary">Search</button>
    </div>

    <div class="browse-layout">
        <!-- Filter Sidebar -->
        <div class="filter-sidebar">
            <h3>Filter Results</h3>

            <div class="filter-group">
                <label>Location</label>
                <input type="text" class="form-control" placeholder="Enter barangay...">
            </div>

            <div class="filter-group">
                <label>Price Range</label>
                @foreach(['All Prices','Budget (₱200-400)','Mid-Range (₱400-600)','Premium (₱600+)'] as $price)
                <label class="filter-option">
                    <input type="radio" name="price" {{ $loop->first ? 'checked' : '' }}> {{ $price }}
                </label>
                @endforeach
            </div>

            <div class="filter-group">
                <label>Cuisine Type</label>
                @foreach(['Filipino','Native Chicken','Seafood','Fusion','Budget Meals'] as $cuisine)
                <label class="filter-option">
                    <input type="checkbox"> {{ $cuisine }}
                </label>
                @endforeach
            </div>

            <div class="filter-group">
                <label>Minimum Rating</label>
                @foreach(['4.5+ Stars','4+ Stars','3.5+ Stars','All Ratings'] as $rating)
                <label class="filter-option">
                    <input type="radio" name="rating" {{ $loop->first ? 'checked' : '' }}> {{ $rating }}
                </label>
                @endforeach
            </div>

            <button class="filter-clear">Clear All Filters</button>
        </div>

        <!-- Results -->
        <div class="browse-results">
            <p class="results-count">Showing {{ count($caterers ?? []) ?: 6 }} caterers</p>
            <div class="caterer-grid-wide">
                @php
                $staticCaterers = [
                    ['name'=>'Lola Maria\'s Kitchen','loc'=>'Magugpo Poblacion','cuisine'=>'Authentic Tagum Native Chicken','rating'=>'4.8','reviews'=>'127','price'=>'300–500','img'=>'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400&h=250&fit=crop','featured'=>true,'id'=>1],
                    ['name'=>'Kusina ni Aling Nena','loc'=>'Apokon','cuisine'=>'Mindanao Fusion Cuisine','rating'=>'4.9','reviews'=>'96','price'=>'400–600','img'=>'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&h=250&fit=crop','featured'=>true,'id'=>2],
                    ['name'=>'TasteBuds Catering','loc'=>'Visayan Village','cuisine'=>'Party Packages & Event Buffet','rating'=>'4.7','reviews'=>'155','price'=>'350–550','img'=>'https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?w=400&h=250&fit=crop','featured'=>false,'id'=>3],
                    ['name'=>'Mama\'s Best Catering','loc'=>'Nueva Fuerza','cuisine'=>'Home-style Filipino Comfort Food','rating'=>'4.6','reviews'=>'59','price'=>'250–400','img'=>'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&h=250&fit=crop','featured'=>false,'id'=>4],
                    ['name'=>'Fiesta Foods Catering','loc'=>'Mankilam','cuisine'=>'Large Event Specialist','rating'=>'4.8','reviews'=>'203','price'=>'400–700','img'=>'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=400&h=250&fit=crop','featured'=>true,'id'=>5],
                    ['name'=>'Chef Marco\'s Kitchen','loc'=>'Magugpo Poblacion','cuisine'=>'Italian & Mediterranean Cuisine','rating'=>'4.9','reviews'=>'142','price'=>'600–900','img'=>'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=400&h=250&fit=crop','featured'=>false,'id'=>6],
                ];
                $list = $caterers ?? $staticCaterers;
                @endphp

                @foreach($list as $c)
                @php
                    $isArr = is_array($c);
                    $name = $isArr ? $c['name'] : $c->business_name;
                    $loc = $isArr ? $c['loc'] : $c->barangay;
                    $cuisine = $isArr ? $c['cuisine'] : $c->cuisine_type;
                    $rating = $isArr ? $c['rating'] : number_format($c->avg_rating, 1);
                    $reviews = $isArr ? $c['reviews'] : $c->reviews_count;
                    $price = $isArr ? $c['price'] : ($c->price_min.'–'.$c->price_max);
                    $img = $isArr ? $c['img'] : ($c->cover_photo ?? 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400&h=250&fit=crop');
                    $featured = $isArr ? $c['featured'] : $c->is_featured;
                    $id = $isArr ? $c['id'] : $c->id;
                @endphp
                <div class="caterer-card">
                    <div class="caterer-card-image">
                        <img src="{{ $img }}" alt="{{ $name }}">
                        @if($featured)<span class="caterer-card-badge featured">⭐ Featured</span>@endif
                        <button class="caterer-card-fav"><i class="far fa-heart"></i></button>
                        <span class="price-tag">₱{{ $price }}/head</span>
                    </div>
                    <div class="caterer-card-body">
                        <div class="d-flex justify-between align-center">
                            <div class="caterer-card-name">{{ $name }}</div>
                            <div class="rating">
                                <div class="stars"><i class="fas fa-star"></i></div>
                                {{ $rating }}
                                <span class="count">({{ $reviews }})</span>
                            </div>
                        </div>
                        <div class="caterer-card-location"><i class="fas fa-map-marker-alt"></i> {{ $loc }}</div>
                        <div class="caterer-card-cuisine">{{ $cuisine }}</div>
                    </div>
                    <div class="caterer-card-footer">
                        <a href="{{ route('caterer.show', $id) }}" class="btn btn-primary btn-sm">View Details</a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button class="page-btn"><i class="fas fa-chevron-left"></i></button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>

</x-layouts.app>
