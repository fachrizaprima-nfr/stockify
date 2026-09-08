<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Stockify Inventaris</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Memastikan teks yang diketik atau dari autofill selalu berwarna gelap/terbaca */
        input,
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: #111827 !important;
            color: #111827 !important;
        }
    </style>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen px-4 py-8">
    <div class="w-full max-w-md bg-gray-800 rounded-2xl shadow-2xl border border-gray-700/80 p-8 sm:p-10">
        
        <!-- Header & Logo -->
        <div class="text-center pt-2 pb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-600 text-white mb-4 shadow-lg shadow-blue-500/30">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold tracking-tight text-white">Stockify</h1>
            <p class="text-sm text-gray-400 mt-2">Sistem Manajemen Inventaris & Mutasi Gudang</p>
        </div>

        @if (session('success'))
            <div class="p-4 mb-6 text-sm text-green-400 rounded-xl bg-gray-700 border border-green-500/40">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-6 text-sm text-red-400 rounded-xl bg-gray-700 border border-red-500/40">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.perform') }}" method="POST" class="space-y-5">
            @csrf
            
            <!-- Kolom Email -->
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-200">Email Pengguna</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3 placeholder-gray-500 transition" 
                    placeholder="admin@stockify.com" required autofocus>
            </div>

            <!-- Kolom Password -->
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-200">Kata Sandi</label>
                <input type="password" name="password" id="password" 
                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3 placeholder-gray-500 transition" 
                    placeholder="••••••••" required>
            </div>

            <!-- Ingat Saya -->
            <div class="flex items-center pt-2 pb-1">
                <input id="remember" name="remember" type="checkbox" 
                    class="w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-600 focus:ring-offset-gray-800 focus:ring-2 cursor-pointer">
                <label for="remember" class="ml-3 text-sm font-normal text-gray-300 cursor-pointer select-none">
                    Ingat Saya
                </label>
            </div>

            <!-- Tombol Masuk -->
            <div class="pt-2">
                <button type="submit" 
                    class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-800 font-semibold rounded-xl text-sm px-5 py-3.5 text-center shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 transition">
                    Masuk ke Sistem
                </button>
            </div>
        </form>
    </div>
</body>
</html>