<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Sistem BAP</title>

    <link rel="shortcut icon" href="{{ asset('img/logo_imigrasi.png') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100">

    <div class="absolute top-4 left-4">
        <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        
        <div class="mb-6">
            <a href="{{ url('/') }}">
                <img src="{{ asset('img/logo_imigrasi.png') }}" alt="Logo Imigrasi" class="h-24 w-auto drop-shadow-md">
            </a>
        </div>

        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
            
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-gray-800">Selamat Datang</h2>
                <p class="text-sm text-gray-500 mt-1">Silakan masuk dengan akun Anda.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-2 px-3 border" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="email@contoh.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
                </div>

                <div class="mb-4">
                    <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                    <input id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-2 px-3 border" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
                </div>

                <div class="flex items-center justify-between mt-4 mb-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('password.request') }}">
                            {{ __('Lupa password?') }}
                        </a>
                    @endif
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition duration-150 mb-4">
                    {{ __('Masuk') }}
                </button>

                <div class="text-center space-y-2">
                    <div class="text-sm text-gray-600">
                        Belum punya akun?
                        <a class="underline text-blue-600 hover:text-blue-900 font-semibold" href="{{ route('register') }}">
                            Daftar di sini
                        </a>
                    </div>
                    
                    <div class="border-t pt-2">
                        <a href="{{ url('/') }}" class="text-xs text-gray-400 hover:text-gray-600">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Halaman Utama
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-6 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} Kantor Imigrasi Kelas I TPI.
        </div>
    </div>
</body>
</html>