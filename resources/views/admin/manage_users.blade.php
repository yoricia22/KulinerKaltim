<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Sireta Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans" x-data="userManagement()">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed h-full">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-8">
                    <img src="{{ asset('images/Sireta logo.png') }}" alt="Sireta Logo" class="w-10 h-10 object-contain">
                    <div>
                        <h1 class="font-bold text-lg leading-tight">SIRETA</h1>
                        <p class="text-xs text-gray-500">Jelajahi Cita Rasa Kaltim</p>
                    </div>
                </div>

                <nav class="space-y-1">
                    <a href="{{ route('dashboard.admin') }}"
                        class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.kuliner.manage') }}"
                        class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Manajemen Kuliner
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                            </path>
                        </svg>
                        Moderasi Ulasan
                    </a>
                    <a href="{{ route('admin.users') }}"
                        class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        User Management
                    </a>

                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Riwayat Aktivitas
                    </a>
                    <a href="#"
                        class="flex items-center gap-3 px-3 py-2 text-gray-600 hover:bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Settings & Guidelines
                    </a>
                </nav>
            </div>

            <div class="mt-auto p-6 border-t border-gray-200">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold">
                        A</div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Admin</p>
                        <p class="text-xs text-gray-500">admin@kuliner.id</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="ml-64 flex-1 p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
                <p class="text-gray-500 mt-1">View all user data and manage user access</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase font-medium border-b border-gray-200">
                            <th class="px-6 py-4">Username</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Jumlah Ulasan</th>
                            <th class="px-6 py-4">Join Date</th>
                            <th class="px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium {{ $user->is_banned ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ $user->is_banned ? 'Banned' : 'Active' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-900 font-medium">-</td>
                                <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('d F Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <!-- View Detail -->
                                        <button @click="openDetail({{ $user->id }})"
                                            class="text-orange-500 hover:text-orange-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>

                                        <!-- Ban/Unban -->
                                        <button
                                            @click="openBan({{ $user->id }}, {{ $user->is_banned ? 'true' : 'false' }}, '{{ $user->name }}')"
                                            class="text-red-500 hover:text-red-600 transition-colors">
                                            @if ($user->is_banned)
                                                <!-- Unban Icon (Check User) -->
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <!-- Ban Icon (User Remove/Block) -->
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6">
                                                    </path>
                                                </svg>
                                            @endif
                                        </button>

                                        <!-- Activity Log -->
                                        <button @click="openLogs({{ $user->id }})"
                                            class="text-gray-400 hover:text-gray-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- User Detail Modal -->
    <div x-show="showDetail" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showDetail" @click="showDetail = false"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showDetail"
                class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">User Details</h3>
                            <div class="mt-4 space-y-3">
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="text-sm font-medium text-gray-500">Name</div>
                                    <div class="col-span-2 text-sm text-gray-900" x-text="selectedUser.name"></div>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="text-sm font-medium text-gray-500">Email</div>
                                    <div class="col-span-2 text-sm text-gray-900" x-text="selectedUser.email"></div>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="text-sm font-medium text-gray-500">Joined</div>
                                    <div class="col-span-2 text-sm text-gray-900" x-text="selectedUser.joined_at">
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="text-sm font-medium text-gray-500">Reviews</div>
                                    <div class="col-span-2 text-sm text-gray-900" x-text="selectedUser.review_count">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="showDetail = false"
                        class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Ban Confirmation Modal -->
    <div x-show="showBan" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showBan" @click="showBan = false"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showBan"
                class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                            :class="isBanning ? 'bg-red-100' : 'bg-green-100'">
                            <svg x-show="isBanning" class="h-6 w-6 text-red-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            <svg x-show="!isBanning" class="h-6 w-6 text-green-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900"
                                x-text="isBanning ? 'Ban User' : 'Unban User'"></h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500"
                                    x-text="isBanning ? 'Are you sure you want to ban ' + targetUserName + '? They will no longer be able to log in.' : 'Are you sure you want to unban ' + targetUserName + '? They will regain access to the platform.'">
                                </p>
                                <div class="mt-4" x-show="isBanning">
                                    <label for="banReason" class="block text-sm font-medium text-gray-700">Reason</label>
                                    <textarea id="banReason" x-model="banReason" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm" placeholder="Enter reason for banning..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="confirmBan()"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none sm:ml-3 sm:w-auto sm:text-sm"
                        :class="isBanning ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'"
                        x-text="isBanning ? 'Ban User' : 'Unban User'"></button>
                    <button type="button" @click="showBan = false"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log Modal -->
    <div x-show="showLogs" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showLogs" @click="showLogs = false"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showLogs"
                class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">User Activity Logs</h3>
                            <div class="mt-4 max-h-96 overflow-y-auto">
                                <template x-if="logs.length === 0">
                                    <p class="text-sm text-gray-500 italic">No activity logs found for this user.</p>
                                </template>
                                <ul class="divide-y divide-gray-200">
                                    <template x-for="log in logs" :key="log.created_at">
                                        <li class="py-3">
                                            <div class="flex space-x-3">
                                                <div class="flex-1 space-y-1">
                                                    <div class="flex items-center justify-between">
                                                        <h3 class="text-sm font-medium"
                                                            x-text="log.action.replace('_', ' ').toUpperCase()"></h3>
                                                        <p class="text-sm text-gray-500" x-text="log.created_at"></p>
                                                    </div>
                                                    <p class="text-sm text-gray-500" x-text="log.description"></p>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="showLogs = false"
                        class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function userManagement() {
            return {
                showDetail: false,
                showBan: false,
                showLogs: false,
                isBanning: true,
                targetUserId: null,
                targetUserName: '',
                banReason: '',
                selectedUser: {
                    name: '',
                    email: '',
                    joined_at: '',
                    review_count: ''
                },
                logs: [],

                openDetail(userId) {
                    fetch(`/dashboard/admin/users/${userId}/detail`)
                        .then(res => res.json())
                        .then(data => {
                            this.selectedUser = {
                                name: data.user.name,
                                email: data.user.email,
                                joined_at: data.joined_at,
                                review_count: data.review_count
                            };
                            this.showDetail = true;
                        });
                },

                openBan(userId, isBanned, userName) {
                    this.targetUserId = userId;
                    this.isBanning = !isBanned; // If currently banned, we want to unban (so isBanning = false)
                    this.targetUserName = userName;
                    this.banReason = '';
                    this.showBan = true;
                },

                confirmBan() {
                    fetch(`/dashboard/admin/users/${this.targetUserId}/toggle-ban`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                reason: this.banReason
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                window.location.reload();
                            }
                        });
                },

                openLogs(userId) {
                    this.logs = []; // Clear previous
                    fetch(`/dashboard/admin/users/${userId}/logs`)
                        .then(res => res.json())
                        .then(data => {
                            this.logs = data.logs;
                            this.showLogs = true;
                        });
                }
            }
        }
    </script>
</body>

</html>
