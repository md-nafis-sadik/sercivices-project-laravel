<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-600 via-blue-500 to-blue-400 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white shadow-md rounded-md px-6 pt-6 pb-8">
        <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">Admin Login</h1>

        <!-- Login Form -->
        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email Input -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email"
                    class="mt-1 block w-full border border-gray-300 rounded-sm shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter your email" required>
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password"
                    class="mt-1 block w-full border border-gray-300 rounded-sm shadow-sm px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter your password" required>
            </div>

            <!-- Submit Button -->
            <div>
            <button type="submit"
    class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white font-medium py-2 px-4 rounded-sm hover:bg-gradient-to-r hover:from-blue-700 hover:to-blue-600 transition-all duration-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 mt-3">
    Login
</button>


            </div>
        </form>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mt-4 bg-red-50 border-l-4 border-red-400 p-4 text-red-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</body>
</html>
