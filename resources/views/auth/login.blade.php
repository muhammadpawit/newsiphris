<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name') }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Animasi Loader Spin */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loader {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #4285F4; /* Warna Google Blue */
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: none; /* Sembunyi di awal */
        }
        
        /* State saat tombol diklik */
        .loading .btn-content { display: none; }
        .loading .loader { display: block; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md text-center">
        <div class="mb-6">
            <img src="{{ asset('logo-label.svg') }}" alt="Logo Aplikasi" class="mx-auto w-32 h-32 object-contain">
            <h1 class="text-2xl font-bold text-gray-800 mt-4">{{ config('app.name', 'Nama Aplikasi') }}</h1>
            <p class="text-gray-500 text-sm">Selamat datang, silakan masuk ke akun Anda</p>

            @if ($errors->any())
                <div class="mt-4 p-3 bg-red-100 text-red-700 rounded">
                    {{ $errors->first() }}
                </div>
            @endif
        </div>
        <form action="{{ route('google.login') }}" method="GET" id="loginForm">
            @csrf
            <button type="submit" id="googleBtn" 
                class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition-all duration-200 shadow-sm">
                
                <div class="flex items-center gap-3 btn-content">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google Logo" class="w-5 h-5">
                    <span class="text-gray-700 font-medium">Masuk dengan Google</span>
                </div>
                <div class="loader"></div>
            </button>
            <p class="mt-3 text-xs text-gray-500">
                Gunakan Akun Gsuite Paramadina Untuk Login
            </p>
        </form>
        <div class="mt-8">
            <p class="text-xs text-gray-400 mt-1">
                Version {{ config('app.version') }}
            </p>
        </div>
    </div>
    <script>
        const loginForm = document.getElementById('loginForm');
        const googleBtn = document.getElementById('googleBtn');
        loginForm.addEventListener('submit', function() {
            // Tambahkan class loading ke tombol
            googleBtn.classList.add('loading');
            // Disable tombol agar tidak diklik berkali-kali
            googleBtn.style.pointerEvents = 'none';
            googleBtn.classList.add('opacity-80');
        });
    </script>
</body>
</html>