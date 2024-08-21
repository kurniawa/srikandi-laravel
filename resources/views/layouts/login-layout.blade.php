<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    {{-- <link rel="shortcut icon" href="{{ asset('images/logo-mc-bg_removed.png') }}" type="image/x-icon"> --}}
    <link rel="stylesheet" href="{{ asset('js/jquery-ui-1.12.1/jquery-ui.css') }}">
    <script src="{{ asset('js/jquery-ui-1.12.1/jquery-ui.js') }}"></script>
    {{-- <script src="{{ asset('js/jquery.table2excel.js') }}"></script> --}}
    <script src="{{ asset('js/functions.js') }}"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: Figtree, sans-serif;
            font-feature-settings: normal;
        }
    </style>
    <title>Srikandi</title>
    @laravelPWA

</head>

<body class="relative">
    <div id="menu-close-layer" class="absolute w-screen h-screen hidden z-30"
        onclick="hideMenuCloseLayer('profile-menu','menu-close-layer')"></div>
    <div id="loading-animation-layer" class="hidden fixed w-screen h-screen z-30 bg-slate-300 opacity-35">
        <div role="status" class="fixed left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
            <svg aria-hidden="true"
                class="inline w-16 h-16 text-gray-200 animate-spin dark:text-gray-600 fill-purple-600"
                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                    fill="currentColor" />
                <path
                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                    fill="currentFill" />
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="min-h-full">
        <nav class="bg-emerald-100 no-print py-2">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="w-9">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/icons/icon-96x96.png') }}" alt="" srcset="" class="size-8 rounded-full overflow-hidden">
                        </a>
                    </div>
                        
                </div>

            </div>


        </nav>
        <div id="search-result" class="relative w-full"></div>

        @yield('content')

        <div class="mt-16 mx-2 mb-16 p-2 rounded border-2 border-emerald-300 text-gray-400 no-print">
            @if (Auth::user())
                <div class="text-center">
                    <span>Welcome, {{ Auth::user()->username }}!</span>
                    @if (Auth::user()->clearance_level < 3)
                        <div class="bg-rose-400 text-white text-xs font-bold p-1 my-2 rounded">-Anda tidak
                            dapat mengakses sistem ini-</div>
                    @endif
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <div class="flex justify-center">
                        <button type="submit"
                            class="loading-spinner relative z-10 rounded-md border-2 border-yellow-400 bg-yellow-200 py-1 px-2 font-medium hover:bg-gray-700 hover:text-white flex gap-1 items-center">
                            <span>Log out</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center">
                    <p>
                        User not logged in.
                        <a href="{{ route('login') }}"
                            class="loading-spinner font-bold text-blue-400 hover:bg-gray-700 hover:text-white">Log
                            in</a>
                    </p>
                </div>
            @endif
        </div>

        {{-- ATTRIBUTION --}}
        <div class="no-print">
            <div class="mt-5 ml-4">
                <h3 class="text-slate-400 font-bold">Attribution</h3>
            </div>
            <div class="grid grid-cols-2 items-center p-2 m-2 border-4 rounded-lg mt-1 border-sky-200">
                <div class="w-1/2">
                    <img src="{{ asset('img/icons-simbol-toko/diamond.png') }}" alt="" class="w-full">
                </div>
                <a class="text-xs text-sky-400 font-bold bg-sky-100 rounded-lg p-1"
                    href="https://www.flaticon.com/free-icons/diamond" title="diamond icons">Diamond icons created by
                    Iconic Panda - Flaticon</a>
                <div class="w-1/2">
                    <img src="{{ asset('img/icons-simbol-toko/medal.png') }}" alt="" class="w-full">
                </div>
                <a class="text-xs text-sky-400 font-bold bg-sky-100 rounded-lg p-1"
                    href="https://www.flaticon.com/free-icons/medal" title="medal icons">Medal icons created by
                    Handicon - Flaticon</a>
                <div class="w-1/2">
                    <img src="{{ asset('img/icons-simbol-toko/wreath.png') }}" alt="" class="w-full">
                </div>
                <a class="text-xs text-sky-400 font-bold bg-sky-100 rounded-lg p-1"
                    href="https://www.flaticon.com/free-icons/trophy" title="trophy icons">Trophy icons created by
                    Freepik - Flaticon</a>
                <div class="w-1/2">
                    <img src="{{ asset('img/icons-simbol-toko/coin.png') }}" alt="" class="w-full">
                </div>
                <a class="text-xs text-sky-400 font-bold bg-sky-100 rounded-lg p-1"
                    href="https://www.flaticon.com/free-icons/coin" title="coin icons">Coin icons created by amonrat
                    rungreangfangsai - Flaticon</a>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>
