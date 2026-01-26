@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
    <h2 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Overview</h2>
    <p class="text-gray-600 mb-8">Ringkasan aktivitas dan statistik sistem</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total User -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <span class="text-gray-500">Total User</span>
                <div class="bg-blue-100 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">3</h3>
            <p class="text-sm text-gray-500 mt-1">1 Banned</p>
        </div>

        <!-- Total Kuliner -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
             <div class="flex justify-between items-start mb-4">
                <span class="text-gray-500">Total Kuliner</span>
                <div class="bg-green-100 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">6</h3>
            <p class="text-sm text-gray-500 mt-1">Published</p>
        </div>

        <!-- Total Ulasan Aktif -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
             <div class="flex justify-between items-start mb-4">
                <span class="text-gray-500">Total Ulasan Aktif</span>
                <div class="bg-purple-100 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-800">4</h3>
            <p class="text-sm text-gray-500 mt-1">Active Reviews</p>
        </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Average Rating Global -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                <h3 class="font-semibold text-gray-800">Average Rating Global</h3>
            </div>
            <p class="text-4xl font-bold text-gray-800">4.6</p>
            <p class="text-sm text-gray-500 mt-1">Dari 4 ulasan aktif</p>
        </div>

        <!-- Top Reported Content -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
             <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <h3 class="font-semibold text-gray-800">Top Reported Content</h3>
            </div>
            <p class="text-4xl font-bold text-gray-800">1</p>
            <p class="text-sm text-gray-500 mt-1">Ulasan dengan laporan</p>
        </div>
    </div>

    <!-- Charts Placeholders (Visual Only) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4">Distribusi Rating (1-5)</h3>
            <div class="h-40 flex items-end justify-between space-x-2">
                 <!-- Placeholder Bars -->
                 <div class="w-1/5 bg-gray-200 h-10 rounded-t"></div>
                 <div class="w-1/5 bg-gray-200 h-20 rounded-t"></div>
                 <div class="w-1/5 bg-orange-300 h-16 rounded-t"></div>
                 <div class="w-1/5 bg-orange-400 h-32 rounded-t"></div>
                 <div class="w-1/5 bg-orange-500 h-24 rounded-t"></div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h3 class="font-semibold text-gray-800 mb-4">Trend Ulasan per Bulan</h3>
            <div class="h-40 flex items-end">
                <!-- Placeholder Line -->
                <svg class="w-full h-full text-green-400" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 L20 80 L40 85 L60 60 L80 50 L100 20" stroke="currentColor" stroke-width="2" fill="none" />
                </svg>
            </div>
        </div>
    </div>
@endsection
