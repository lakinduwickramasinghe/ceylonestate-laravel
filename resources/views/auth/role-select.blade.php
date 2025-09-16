<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Login - Ceylon Estate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen font-sans">

    
    <div class="bg-white rounded-3xl shadow-2xl p-12 max-w-xl w-full text-center">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-4">Welcome Back!</h1>
        <p class="text-gray-500 mb-10">Select your role to login</p>

        <div class="grid gap-6 sm:grid-cols-2">
            <!-- Admin Login Card -->
            <a href="{{route('login.admin')}}">
                <div class="flex flex-col items-center justify-center bg-purple-600 hover:bg-purple-700 text-white py-5 rounded-xl shadow-lg transform transition-transform hover:scale-105 cursor-pointer">
                    <i class="fas fa-user-shield text-5xl mb-3"></i>
                    <span class="font-semibold text-lg">Admin Login</span>
                </div>
            </a>

            <!-- Member Login Card -->
            <a href="{{route('login.member')}}">
            <div class="flex flex-col items-center justify-center bg-green-500 hover:bg-green-600 text-white py-5 rounded-xl shadow-lg transform transition-transform hover:scale-105 cursor-pointer">
                <i class="fas fa-user-friends text-5xl mb-3"></i>
                <span class="font-semibold text-lg">Member Login</span>
            </div>
            </a>
        </div>

        <p class="mt-10 text-gray-400 text-sm">Not sure? Contact your administrator</p>
    </div>

</body>
</html>
