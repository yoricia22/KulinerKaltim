@extends('layouts.user')

@section('title', 'Dashboard User')

@section('content')
    <div class="mb-6 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Jelajahi Kuliner</h2>
            <p class="text-gray-600">Temukan cita rasa terbaik Kalimantan Timur.</p>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <form action="{{ route('dashboard.user') }}" method="GET"
            class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4">
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
            <button type="submit"
                class="px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition">Cari</button>
            @if (request('search') || request('category') || request('status'))
                <a href="{{ route('dashboard.user') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition flex items-center justify-center">Reset</a>
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
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 flex flex-col h-full cursor-pointer"
                    onclick="openKulinerModal({{ $kuliner->id }})">
                    <!-- Image -->
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

                        <!-- Rating Badge -->
                        <div class="absolute top-2 right-2 bg-white bg-opacity-90 px-2 py-1 rounded-lg shadow-sm flex items-center">
                            <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-sm font-bold text-gray-800">{{ number_format($kuliner->average_rating, 1) }}</span>
                        </div>
                        <!-- Status Badges -->
                        <div class="absolute top-2 left-2 flex flex-col space-y-1">
                            @if ($kuliner->is_halal)
                                <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full shadow-sm">Halal</span>
                            @else
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full shadow-sm">Non-Halal</span>
                            @endif
                            @if ($kuliner->is_vegetarian)
                                <span class="bg-green-600 text-white text-xs px-2 py-1 rounded-full shadow-sm">Vegetarian</span>
                            @endif
                        </div>
                    </div>

                    <div class="p-4 flex-1 flex flex-col">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 line-clamp-1 mb-1">{{ $kuliner->nama_kuliner }}</h3>
                            <p class="text-sm text-orange-600 font-medium mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $kuliner->asal_daerah }}
                            </p>
                            <p class="text-gray-600 text-sm line-clamp-2 mb-3">{{ $kuliner->deskripsi }}</p>

                            <div class="flex flex-wrap gap-1">
                                @foreach ($kuliner->categories as $cat)
                                    <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">{{ $cat->nama_kategori }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            @php
                                $mapsUrl = $kuliner->google_maps_url;
                                if (!$mapsUrl && $kuliner->place && $kuliner->place->latitude && $kuliner->place->longitude) {
                                    $mapsUrl = 'https://www.google.com/maps?q=' . $kuliner->place->latitude . ',' . $kuliner->place->longitude;
                                }
                            @endphp
                            @if ($mapsUrl)
                                <a href="{{ $mapsUrl }}" target="_blank" onclick="event.stopPropagation()"
                                   class="inline-flex items-center px-3 py-2 bg-blue-500 text-white text-xs rounded-lg hover:bg-blue-600 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 7m0 13V7"></path>
                                    </svg>
                                    Maps
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" onclick="closeModal(event)">
        <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
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
                    <img id="modalImage" src="" alt="" class="w-full h-80 object-cover">
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

                    <div id="modalLocation" class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Lokasi</h3>
                        <p id="modalPlaceName" class="text-sm text-gray-600 mb-3"></p>
                        <a id="modalMapsBtn" href="#" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 7m0 13V7"></path>
                            </svg>
                            Lihat di Google Maps
                        </a>
                    </div>

                    <!-- User Rating Section -->
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
                            <textarea id="reviewInput" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 p-3 text-sm" placeholder="Tulis pengalaman kulinermu disini..."></textarea>
                            <div class="mt-2 text-right">
                                <button onclick="submitReview()" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition text-sm font-medium">Kirim Ulasan</button>
                            </div>
                        </div>

                        <!-- Review List -->
                        <div id="reviewList" class="space-y-6">
                            <!-- Reviews will be injected here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentKulinerId = null;

        function openKulinerModal(id) {
            currentKulinerId = id;
            const modal = document.getElementById('detailModal');
            const modalContent = document.getElementById('modalContent');
            const modalLoading = document.getElementById('modalLoading');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modalContent.classList.add('hidden');
            modalLoading.classList.remove('hidden');

            fetch(`/dashboard/user/kuliner/${id}`)
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

            // Badges
            let badgesHtml = '';
            if (k.is_halal) badgesHtml += '<span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-medium">Halal</span>';
            else badgesHtml += '<span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-medium">Non-Halal</span>';
            if (k.is_vegetarian) badgesHtml += '<span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-medium ml-2">Vegetarian</span>';

            k.categories.forEach(cat => {
                badgesHtml += `<span class="bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full font-medium ml-2">${cat.nama_kategori}</span>`;
            });
            document.getElementById('modalBadges').innerHTML = badgesHtml;

            // Location & Maps button
            const placeName = k.place && k.place.nama_tempat ? k.place.nama_tempat : '';
            document.getElementById('modalPlaceName').textContent = placeName;
            let mapsUrl = k.google_maps_url || '';
            if (!mapsUrl && k.place && k.place.latitude && k.place.longitude) {
                mapsUrl = `https://www.google.com/maps?q=${k.place.latitude},${k.place.longitude}`;
            }
            const mapsBtn = document.getElementById('modalMapsBtn');
            if (mapsUrl) {
                mapsBtn.href = mapsUrl;
                mapsBtn.classList.remove('pointer-events-none', 'opacity-50');
            } else {
                mapsBtn.href = '#';
                mapsBtn.classList.add('pointer-events-none', 'opacity-50');
            }

            // Favorite Button State
            updateFavoriteBtn(data.is_favorited);

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

            fetch(`/dashboard/user/kuliner/${currentKulinerId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(res => res.json())
            .then(data => {
                updateFavoriteBtn(data.status === 'added');
            })
            .catch(err => console.error(err));
        }

        function submitRating(rating) {
            if (!currentKulinerId) return;

            fetch(`/dashboard/user/kuliner/${currentKulinerId}/rate`, {
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
            const text = rating > 0 ? `Anda memberi rating ${rating}/5` : 'Belum ada rating';
            document.getElementById('userRatingText').textContent = text;
        }

        function submitReview() {
            const input = document.getElementById('reviewInput');
            const ulasan = input.value.trim();
            if (!ulasan || !currentKulinerId) return;

            fetch(`/dashboard/user/kuliner/${currentKulinerId}/review`, {
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
                    // Reload reviews - simplistic approach: fetch modal data again or prepend
                    // For simplicity, let's prepend manually or re-fetch.
                    // Let's just re-fetch the modal data to be safe and consistent
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
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold">
                            ${r.user.name.charAt(0)}
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-sm font-bold text-gray-900">${r.user.name}</h4>
                                <span class="text-xs text-gray-500">${new Date(r.created_at).toLocaleDateString('id-ID')}</span>
                            </div>
                            <p class="text-sm text-gray-700">${r.ulasan}</p>
                        </div>
                        <div class="flex items-center mt-1 space-x-4">
                            <button onclick="toggleReviewLike(${r.id})" class="flex items-center text-xs text-gray-500 hover:text-orange-500 transition group">
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
            fetch(`/dashboard/user/review/${reviewId}/like`, {
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
            }
        });
    </script>
@endsection
