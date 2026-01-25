<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Sireta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <nav class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-xl font-bold text-gray-800">User Dashboard</span>
                    </div>
                    <div class="flex items-center">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <main class="flex-grow p-6">
            <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow">
                <h1 class="text-2xl font-bold mb-4">Welcome, User!</h1>
                <p>This is the user dashboard.</p>
            </div>
        </main>
    </div>
</body>
</html>
