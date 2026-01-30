<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jelajahi Kuliner - Sireta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('landing') }}" class="flex-shrink-0 flex items-center">
                        <img class="h-10 w-auto" src="{{ asset('images/Sireta logo.png') }}" alt="Sireta Logo">
                        <span class="ml-3 text-xl font-bold text-gray-800">SIRETA</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('guest.favorites') }}" class="text-gray-600 hover:text-orange-500 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Favorit
                        <span id="favCount" class="ml-1 bg-orange-500 text-white text-xs px-2 py-0.5 rounded-full hidden">0</span>
                    </a>
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('dashboard.admin') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-orange-500 text-white hover:bg-orange-600 px-4 py-2 rounded-md text-sm font-medium">Logout</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section -->
        <div class="text-center mb-10">
            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl">
                <span class="block">Jelajahi Cita Rasa</span>
                <span class="block text-orange-500">Kalimantan Timur</span>
            </h1>
            <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                Temukan kelezatan kuliner tradisional Kalimantan Timur bersama Sireta. Rasa Nusantara dari Timur.
            </p>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white p-4 rounded-lg shadow-md mb-8">
            <form action="{{ route('landing') }}" method="GET" class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari kuliner atau asal daerah..."
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <div class="w-full md:w-1/4">
                    <select name="category"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500"
                        onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->nama_kategori }}"
                                {{ request('category') == $category->nama_kategori ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-1/4">
                    <select name="status"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500"
                        onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="halal" {{ request('status') == 'halal' ? 'selected' : '' }}>Halal</option>
                        <option value="non-halal" {{ request('status') == 'non-halal' ? 'selected' : '' }}>Non-Halal</option>
                        <option value="vegetarian" {{ request('status') == 'vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                    </select>
                </div>
                <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition">Cari</button>
                @if (request('search') || request('category') || request('status'))
                    <a href="{{ route('landing') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition flex items-center justify-center">Reset</a>
                @endif
            </form>
        </div>

        <!-- Kuliner Cards Grid -->
        @if ($kuliners->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                    </path>
                </svg>
                <p class="text-xl text-gray-600 font-medium">Belum ada data kuliner.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($kuliners as $kuliner)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 cursor-pointer"
                        onclick="openKulinerModal({{ $kuliner->id }})">
                        <!-- Image with Badges -->
                        <div class="relative h-48 bg-gray-200">
                            @php
                                $imgSrc = 'https://via.placeholder.com/640x360?text=No+Image';
                                if ($kuliner->external_image_url) {
                                    $imgSrc = $kuliner->external_image_url;
                                } elseif ($kuliner->gambar) {
                                    $imgSrc = asset('storage/' . $kuliner->gambar);
                                }
                            @endphp
                            <img src="{{ $imgSrc }}" alt="{{ $kuliner->nama_kuliner }}"
                                class="w-full h-full object-cover"
                                onerror="this.onerror=null;this.src='https://via.placeholder.com/640x360?text=No+Image';">

                            <!-- Halal/Non-Halal Badge -->
                            @if ($kuliner->is_halal)
                                <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full font-semibold shadow">Halal</span>
                            @else
                                <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-semibold shadow">Non-Halal</span>
                            @endif

                            <!-- Vegetarian Badge -->
                            @if ($kuliner->is_vegetarian)
                                <span class="absolute top-10 right-2 bg-green-400 text-white text-xs px-2 py-1 rounded-full font-semibold shadow">Vegetarian</span>
                            @endif

                            <!-- Rating Badge -->
                            <div class="absolute bottom-2 left-2 bg-white bg-opacity-95 px-2 py-1 rounded-lg shadow flex items-center">
                                <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <span class="text-sm font-bold text-gray-800">{{ number_format($kuliner->average_rating, 1) }}</span>
                            </div>

                            <!-- Favorite indicator -->
                            <div class="absolute bottom-2 right-2 favorite-indicator" data-id="{{ $kuliner->id }}" style="display: none;">
                                <span class="bg-red-500 text-white p-1.5 rounded-full shadow">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-800 line-clamp-1 mb-1">{{ $kuliner->nama_kuliner }}</h3>
                            <p class="text-sm text-orange-600 font-medium mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $kuliner->asal_daerah }}
                            </p>
                            <p class="text-gray-600 text-sm line-clamp-2 mb-3">{{ $kuliner->deskripsi }}</p>

                            <!-- Categories -->
                            <div class="flex flex-wrap gap-1 mb-3">
                                @foreach ($kuliner->categories as $cat)
                                    <span class="bg-orange-100 text-orange-700 text-xs px-2 py-1 rounded-full">{{ $cat->nama_kategori }}</span>
                                @endforeach
                            </div>

                            <!-- Place Name -->
                            @if ($kuliner->place)
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    {{ $kuliner->place->nama_tempat }}
                                </div>
                            @endif

                            <!-- Maps Button -->
                            @if ($kuliner->google_maps_url)
                                <div class="mt-3">
                                    <a href="{{ $kuliner->google_maps_url }}" target="_blank" onclick="event.stopPropagation()"
                                        class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                        </svg>
                                        Maps
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" onclick="closeModal(event)">
        <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
            <!-- Loading State -->
            <div id="modalLoading" class="flex items-center justify-center py-20">
                <svg class="animate-spin h-10 w-10 text-orange-500" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <!-- Content -->
            <div id="modalContent" class="hidden">
                <div class="relative">
                    <img id="modalImage" src="" alt="" class="w-full h-72 object-cover">
                    <button onclick="closeDetailModal()" class="absolute top-4 right-4 bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-75 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <!-- Favorite Button -->
                    <button id="btnFavorite" onclick="toggleFavorite()" class="absolute bottom-4 right-4 bg-white p-3 rounded-full shadow-lg text-gray-400 hover:scale-110 transition duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </button>

                    <!-- Maps Button in Modal -->
                    <a id="modalMapsBtn" href="#" target="_blank" class="absolute bottom-4 left-4 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="p-6 md:p-8">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 id="modalTitle" class="text-3xl font-bold text-gray-900 mb-2"></h2>
                            <p id="modalOrigin" class="text-lg text-orange-600 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="text"></span>
                            </p>
                        </div>
                        <div class="text-center bg-gray-50 px-4 py-2 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900 flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span id="modalAvgRating">0.0</span>
                            </div>
                            <span class="text-xs text-gray-500">Rata-rata</span>
                        </div>
                    </div>

                    <div id="modalBadges" class="flex flex-wrap gap-2 mb-6"></div>

                    <p id="modalDesc" class="text-gray-700 leading-relaxed mb-8"></p>

                    <!-- Place Info -->
                    <div id="modalPlace" class="bg-gray-50 rounded-lg p-4 mb-6 hidden">
                        <h4 class="font-semibold text-gray-900 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span id="modalPlaceName"></span>
                        </h4>
                    </div>

                    <!-- Rating Section -->
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Berikan Rating</h3>
                        <div class="flex items-center space-x-2">
                            <div class="flex space-x-1" id="starRating">
                                @for($i = 1; $i <= 5; $i++)
                                    <button onclick="submitRating({{ $i }})" class="star-btn w-8 h-8 text-gray-300 hover:text-yellow-400 focus:outline-none transition" data-value="{{ $i }}">
                                        <svg fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    </button>
                                @endfor
                            </div>
                            <span id="userRatingText" class="text-sm text-gray-500 ml-2"></span>
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ulasan (<span id="reviewCount">0</span>)</h3>

                        <!-- Write Review -->
                        <div class="mb-6">
                            <textarea id="reviewInput" rows="3" class="w-full rounded-lg border border-gray-300 focus:ring-orange-500 focus:border-orange-500 p-3 text-sm" placeholder="Tulis pengalaman kulinermu disini... (Ulasan akan ditampilkan sebagai Anonymous)"></textarea>
                            <div class="mt-2 text-right">
                                <button onclick="submitReview()" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition text-sm font-medium">Kirim Ulasan</button>
                            </div>
                        </div>

                        <!-- Review List -->
                        <div id="reviewList" class="space-y-4">
                            <!-- Reviews will be injected here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Floating Button -->
    <button onclick="openFeedbackModal()" class="fixed bottom-6 right-6 bg-orange-600 text-white p-4 rounded-full shadow-lg hover:bg-orange-700 hover:scale-105 transition z-40 group flex items-center space-x-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
        <span class="max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-300 ease-in-out whitespace-nowrap">Beri Masukan</span>
    </button>

    <!-- Feedback Modal -->
    <div id="feedbackModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden items-center justify-center z-50 p-4 transition-opacity duration-300" onclick="closeFeedbackModal(event)">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all scale-95 opacity-0 duration-300 ease-out" id="feedbackModalContent" onclick="event.stopPropagation()">
            <!-- Header -->
            <div class="bg-gradient-to-r from-orange-500 to-red-500 p-5 rounded-t-2xl relative overflow-hidden">
                <!-- Decorative Circle -->
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-16 h-16 bg-white opacity-10 rounded-full"></div>
                
                <div class="flex justify-between items-center relative z-10">
                    <div>
                        <h3 class="text-xl font-bold text-white">Kirim Masukan</h3>
                        <p class="text-orange-100 text-xs mt-1">Bantu kami menjadi lebih baik</p>
                    </div>
                    <button onclick="closeFeedbackModal()" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-1.5 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
            
            <form id="feedbackForm" onsubmit="submitFeedback(event)" class="p-5 space-y-4">
                <!-- Category -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Kategori Masukan</label>
                    <div class="relative">
                        <select name="category" required class="w-full pl-3 pr-8 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent block transition duration-200 hover:bg-white appearance-none">
                            <option value="General">👋 Umum</option>
                            <option value="Bug">🐛 Laporan Bug</option>
                            <option value="Feature Request">✨ Request Fitur</option>
                            <option value="Content">📝 Masalah Konten</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                
                <!-- Subject -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Subjek <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="text" name="subject" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent block transition duration-200 hover:bg-white placeholder-gray-400" placeholder="Contoh: Tampilan di HP kurang rapi">
                </div>

                <!-- Message -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Pesan Anda</label>
                    <textarea name="message" rows="3" required class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent block transition duration-200 hover:bg-white placeholder-gray-400 resize-none" placeholder="Ceritakan detail masukan atau pengalaman Anda..."></textarea>
                </div>

                <!-- Name -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Nama <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input type="text" name="sender_name" class="w-full pl-9 pr-3 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent block transition duration-200 hover:bg-white placeholder-gray-400" placeholder="Nama Anda (atau biarkan kosong untuk anonim)">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full text-white bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 focus:ring-4 focus:ring-orange-300 font-bold rounded-xl text-sm px-5 py-3 text-center shadow-lg shadow-orange-500/30 transform hover:-translate-y-0.5 transition duration-200 flex justify-center items-center group">
                    <span>Kirim Masukan</span>
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentKulinerId = null;

        // Initialize favorites from localStorage
        function getFavorites() {
            return JSON.parse(localStorage.getItem('favorites') || '[]');
        }

        function saveFavorites(favorites) {
            localStorage.setItem('favorites', JSON.stringify(favorites));
        }

        // Update favorite count in nav
        function updateFavCount() {
            const count = getFavorites().length;
            const badge = document.getElementById('favCount');
            if (count > 0) {
                badge.textContent = count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }

        // Update favorite indicators on cards
        function updateFavoriteIndicators() {
            const favorites = getFavorites();
            document.querySelectorAll('.favorite-indicator').forEach(el => {
                const id = parseInt(el.dataset.id);
                if (favorites.includes(id)) {
                    el.style.display = 'block';
                } else {
                    el.style.display = 'none';
                }
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateFavCount();
            updateFavoriteIndicators();
        });

        function openKulinerModal(id) {
            currentKulinerId = id;
            const modal = document.getElementById('detailModal');
            const modalContent = document.getElementById('modalContent');
            const modalLoading = document.getElementById('modalLoading');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modalContent.classList.add('hidden');
            modalLoading.classList.remove('hidden');

            fetch(`/api/kuliner/${id}`)
                .then(res => {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json();
                })
                .then(data => {
                    populateModal(data);
                    modalLoading.classList.add('hidden');
                    modalContent.classList.remove('hidden');
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal memuat data kuliner');
                    closeDetailModal();
                });
        }

        function populateModal(data) {
            const k = data.kuliner;

            // Image Logic
            let imageUrl = '';
            if (k.external_image_url) {
                imageUrl = k.external_image_url;
            } else if (k.gambar) {
                imageUrl = `{{ asset('storage') }}/${k.gambar}`;
            } else {
                imageUrl = 'https://via.placeholder.com/640x360?text=No+Image';
            }

            const imgEl = document.getElementById('modalImage');
            imgEl.src = imageUrl;
            imgEl.onerror = function() {
                this.onerror = null;
                this.src = 'https://via.placeholder.com/640x360?text=No+Image';
            };

            document.getElementById('modalTitle').textContent = k.nama_kuliner;
            document.querySelector('#modalOrigin .text').textContent = k.asal_daerah;
            document.getElementById('modalDesc').textContent = k.deskripsi;
            document.getElementById('modalAvgRating').textContent = parseFloat(data.average_rating).toFixed(1);

            // Maps Button
            const mapsBtn = document.getElementById('modalMapsBtn');
            if (k.google_maps_url) {
                mapsBtn.href = k.google_maps_url;
                mapsBtn.classList.remove('hidden');
            } else {
                mapsBtn.classList.add('hidden');
            }

            // Place Info
            const placeDiv = document.getElementById('modalPlace');
            if (k.place) {
                document.getElementById('modalPlaceName').textContent = k.place.nama_tempat;
                placeDiv.classList.remove('hidden');
            } else {
                placeDiv.classList.add('hidden');
            }

            // Badges
            let badgesHtml = '';
            if (k.is_halal) badgesHtml += '<span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">Halal</span>';
            else badgesHtml += '<span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-medium">Non-Halal</span>';
            if (k.is_vegetarian) badgesHtml += '<span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-medium">Vegetarian</span>';

            k.categories.forEach(cat => {
                badgesHtml += `<span class="bg-orange-100 text-orange-800 text-xs px-3 py-1 rounded-full font-medium">${cat.nama_kategori}</span>`;
            });
            document.getElementById('modalBadges').innerHTML = badgesHtml;

            // Favorite Button State (from localStorage)
            const favorites = getFavorites();
            updateFavoriteBtn(favorites.includes(currentKulinerId));

            // User Rating State
            updateStarDisplay(data.user_rating);

            // Reviews
            renderReviews(data.reviews);
        }

        function updateFavoriteBtn(isFavorited) {
            const btn = document.getElementById('btnFavorite');
            if (isFavorited) {
                btn.classList.add('text-red-500');
                btn.classList.remove('text-gray-400');
                btn.querySelector('svg').classList.add('fill-current');
            } else {
                btn.classList.remove('text-red-500');
                btn.classList.add('text-gray-400');
                btn.querySelector('svg').classList.remove('fill-current');
            }
        }

        function toggleFavorite() {
            if (!currentKulinerId) return;

            let favorites = getFavorites();
            const index = favorites.indexOf(currentKulinerId);
            
            if (index > -1) {
                favorites.splice(index, 1);
                updateFavoriteBtn(false);
            } else {
                favorites.push(currentKulinerId);
                updateFavoriteBtn(true);
            }
            
            saveFavorites(favorites);
            updateFavCount();
            updateFavoriteIndicators();

            // Sync with server
            fetch(`/guest/kuliner/${currentKulinerId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            }).catch(err => console.error(err));
        }

        function submitRating(rating) {
            if (!currentKulinerId) return;

            fetch(`/guest/kuliner/${currentKulinerId}/rate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ rating: rating })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    updateStarDisplay(data.rating);
                    document.getElementById('modalAvgRating').textContent = parseFloat(data.average_rating).toFixed(1);
                }
            })
            .catch(err => console.error(err));
        }

        function updateStarDisplay(rating) {
            const stars = document.querySelectorAll('.star-btn');
            stars.forEach(btn => {
                const val = parseInt(btn.dataset.value);
                if (val <= rating) {
                    btn.classList.remove('text-gray-300');
                    btn.classList.add('text-yellow-400');
                } else {
                    btn.classList.add('text-gray-300');
                    btn.classList.remove('text-yellow-400');
                }
            });
            const text = rating > 0 ? `Anda memberi rating ${rating}/5` : '';
            document.getElementById('userRatingText').textContent = text;
        }

        function submitReview() {
            const input = document.getElementById('reviewInput');
            const ulasan = input.value.trim();
            if (!ulasan || !currentKulinerId) return;

            fetch(`/guest/kuliner/${currentKulinerId}/review`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ ulasan: ulasan })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    input.value = '';
                    openKulinerModal(currentKulinerId);
                }
            })
            .catch(err => console.error(err));
        }

        function renderReviews(reviews) {
            const container = document.getElementById('reviewList');
            document.getElementById('reviewCount').textContent = reviews.length;

            if (reviews.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-center py-4">Belum ada ulasan.</p>';
                return;
            }

            container.innerHTML = reviews.map(r => `
                <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-sm font-bold text-gray-900">Anonymous</h4>
                                <span class="text-xs text-gray-500">${new Date(r.created_at).toLocaleDateString('id-ID')}</span>
                            </div>
                            <p class="text-sm text-gray-700">${r.ulasan}</p>
                        </div>
                        <div class="flex items-center mt-1 text-xs text-gray-500">
                            <button onclick="toggleReviewLike(${r.id})" class="flex items-center hover:text-orange-500 transition">
                                <svg class="w-4 h-4 mr-1 ${r.is_liked ? 'text-orange-500 fill-current' : ''}" id="likeIcon-${r.id}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                </svg>
                                <span id="likeCount-${r.id}">${r.likes_count}</span> Suka
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function toggleReviewLike(reviewId) {
            fetch(`/guest/review/${reviewId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(res => res.json())
            .then(data => {
                const icon = document.getElementById(`likeIcon-${reviewId}`);
                const count = document.getElementById(`likeCount-${reviewId}`);

                count.textContent = data.likes_count;
                if (data.status === 'added') {
                    icon.classList.add('text-orange-500', 'fill-current');
                } else {
                    icon.classList.remove('text-orange-500', 'fill-current');
                }
            })
            .catch(err => console.error(err));
        }

        function closeModal(event) {
            if (event.target.id === 'detailModal') {
                closeDetailModal();
            }
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            currentKulinerId = null;
        }

        // Escape key to close modal
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDetailModal();
                closeFeedbackModal();
            }
        });

        // Feedback Logic
        function openFeedbackModal() {
            const modal = document.getElementById('feedbackModal');
            const content = document.getElementById('feedbackModalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Trigger reflow
            void modal.offsetWidth;
            
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }

        function closeFeedbackModal(event) {
            // If called via event (click on backdrop), check target
            if (event && event.target.id !== 'feedbackModal') return;
            
            const modal = document.getElementById('feedbackModal');
            const content = document.getElementById('feedbackModalContent');
            
            modal.classList.add('opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function submitFeedback(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            fetch('/guest/feedback', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    alert('Terima kasih! Masukan Anda telah terkirim.');
                    form.reset();
                    closeFeedbackModal();
                }
            })
            .catch(err => {
                console.error(err);
                alert('Gagal mengirim masukan.');
            });
        }
    </script>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} SIRETA - Sistem Informasi Kuliner Kalimantan Timur</p>
                <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-300 text-sm mt-2 md:mt-0">Admin</a>
            </div>
        </div>
    </footer>
</body>
</html>
