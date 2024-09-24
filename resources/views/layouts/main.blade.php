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
    <title>Srikandi.EP</title>
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
        <nav class="bg-gradient-to-br from-amber-500 to-amber-200 no-print py-2">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex gap-1 items-center justify-between">
                    <div class="w-9">
                        <a href="{{ route('home') }}" class="loading-spinner">
                            <img src="{{ asset('images/icons/icon-96x96.png') }}" alt="" srcset="" class="size-8 rounded-full overflow-hidden">
                        </a>
                    </div>

                    {{-- PENCARIAN ITEM --}}
                    <div class="flex-auto">
                        <div class="flex gap-1 items-center bg-white text-xs text-slate-400 rounded-lg border-slate-300 border-2 pl-1">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </div>
                            <div class="grow">
                                <input type="text" name="longname" id="search-longname" oninput="searchItem(this, 'search-result')" class="border-none w-full p-1 rounded" placeholder="nama barang/item...">
                            </div>
                        </div>
                    </div>
                    {{-- END - PENCARIAN ITEM --}}

                    <div class="flex gap-2 items-center">
                        @auth
                            <a href="{{ route('choose_action') }}" class="loading-spinner size-7 rounded-full bg-amber-500 flex justify-center items-center font-bold text-white text-2xl">+</a>
                        @endauth
                        {{-- <button type="button"
                            class="rounded-full bg-rose-200 p-1 text-gray-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button> --}}
    
                        @if (Auth::user())
                            <a class="loading-spinner" href="{{ route('carts.index', Auth::user()->id) }}">
                                <div class="text-amber-700 relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                    </svg>
                                    @if ($cart)
                                        <div
                                            class="flex absolute left-4 -top-2 size-4 rounded-full bg-red-400 text-white justify-center items-center text-xs">
                                            {{ count($cart->cart_items) }}</div>
                                    @endif
                                </div>
                            </a>
                        @endif
    
                        <!-- Profile dropdown -->
                        <div class="relative">
                            <div>
                                @if (Auth::user())
                                    @if (Auth::user()->profile_picture)
                                        <button type="button"
                                            class="flex max-w-xs items-center rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                            id="user-menu-button" aria-expanded="false" aria-haspopup="true"
                                            onclick="toggleMenu('profile-menu', 'menu-close-layer')">
                                            <span class="sr-only">Open user menu</span>
                                            <img class="h-8 w-8 rounded-full"
                                                src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
                                                alt="Profile Picture">
                                        </button>
                                    @else
                                        <button
                                            class="text-white bg-amber-500 rounded-full overflow-hidden w-8 h-8 flex justify-center items-center"
                                            id="user-menu-button" aria-expanded="false" aria-haspopup="true"
                                            onclick="toggleMenu('profile-menu', 'menu-close-layer')">
                                            @if (Auth::user()->profile_picture_path)
                                                <img src="{{ asset('storage/' . Auth::user()->profile_picture_path) }}" alt="">
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                                </svg>
                                            @endif
                                        </button>
                                    @endif
                                @else
                                    <button
                                        class="text-amber-100 bg-amber-300 border-2 border-amber-100 rounded-full w-8 h-8 flex justify-center items-center"
                                        id="user-menu-button" aria-expanded="false" aria-haspopup="true"
                                        onclick="toggleMenu('profile-menu', 'menu-close-layer')">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                            </svg>
                                    </button>
                                @endif
                            </div>
                            <div id="profile-menu"
                                class="hidden absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">
                                
                                @auth
                                <a href="{{ route('users.show', $user->id) }}" class="loading-spinner block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200" role="menuitem" tabindex="-1">Profile</a>
                                <a href="{{ route('transactions.rincian_transaksi', $user->id) }}" class="loading-spinner block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200" role="menuitem" tabindex="-1">Rincian Transaksi</a>
                                @endauth
                                <a href="{{ route('users.index') }}" class="loading-spinner block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200" role="menuitem" tabindex="-1">Daftar User</a>
                                <a href="{{ route('pelanggans.index') }}" class="loading-spinner block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200" role="menuitem" tabindex="-1">Daftar Pelanggan</a>
                                <a href="{{ route('surat_pembelian.index') }}" class="loading-spinner block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200" role="menuitem" tabindex="-1">Surat Pembelian</a>
                                <a href="{{ route('cashflow.index') }}" class="loading-spinner block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200" role="menuitem" tabindex="-1">Cash Flow</a>
                                @if (!$user)
                                <a href="{{ route('login') }}" class="loading-spinner" role="menuitem" tabindex="-1">
                                    <button class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 flex gap-2 items-center">
                                        <span>Log In</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                        </svg>
                                    </button>
                                </a>
                                @endif
                                @auth
                                @if ($user->clearance_level >= 6)
                                <a href="{{ route('artisans.index') }}" class="loading-spinner block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200" role="menuitem" tabindex="-1">Artisan Commands</a>
                                @endif
                                <a href="{{ route('attributes.index') }}" class="loading-spinner block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200" role="menuitem" tabindex="-1">Attribute Setting</a>
                                <form action="{{ route('logout') }}" method="POST" class="loading-spinner block">
                                    @csrf
                                    <button type="submit" class="py-2 text-sm text-left pl-4 text-gray-600 hover:bg-gray-200 w-full flex">
                                        <span>Log Out</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                        </svg>
                                    </button>
                                </form>
                                @endauth
    
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            {{-- MOBILE MENU --}}
            <div class="hidden" id="mobile-menu">
                <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    {{-- @foreach ($menus as $menu)
                        <a href="#"
                            class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">{{ $menu['name'] }}</a>
                    @endforeach --}}
                    {{-- <a href="#" class="bg-gray-900 text-white block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Dashboard</a>
              <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Team</a>
              <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Projects</a>
              <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Calendar</a>
              <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Reports</a> --}}
                </div>
                {{-- <div class="border-t border-gray-700 pb-3 pt-4">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full"
                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt="">
                        </div>
                        <div class="ml-3">
                            @if (Auth::user())
                                <div class="text-base font-medium leading-none text-white">{{ Auth::user()->nama }}
                                </div>
                                <div class="text-sm font-medium leading-none text-gray-400">
                                    {{ Auth::user()->username }}</div>
                            @else
                                <div class="text-base font-medium leading-none text-white">Tom Cook</div>
                                <div class="text-sm font-medium leading-none text-gray-400">tom@example.com</div>
                            @endif
                        </div>
                        <button type="button"
                            class="ml-auto flex-shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-3 space-y-1 px-2">
                        @if (Auth::user())
                            <div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="rounded-md w-full text-start py-2 px-3 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Sign
                                        out</button>
                                </form>
                            </div>
                        @else
                            <a href="#"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Your
                                Profile</a>
                            <a href="#"
                                class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Settings</a>
                            <a href="{{ route('login') }}"
                                class="loading-spinner block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Log
                                in</a>
                        @endif
                    </div>
                </div> --}}
            </div>
            {{-- END - MOBILE MENU --}}
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

<script>
    function showDropdown(button, dropdown) {
        $selectedDiv = $(`#${dropdown}`);
        $selectedDiv.toggle(400);

        let toggle_button = document.getElementById(button);
        setTimeout(() => {
            // console.log($selectedDiv.css("display"));
            // console.log(`$selectedDiv.css("display") = ${$selectedDiv.css("display")}`);
            // if ($selectedDiv.css("display") === "block" || $selectedDiv.css("display") === "table-row") {
            //     $(`#${button}` + " img").attr("src", "/img/icons/dropup.svg");
            // } else {
            //     $(`#${button}` + " img").attr("src", "/img/icons/dropdown.svg");
            // }
            if ($selectedDiv.css("display") === "block" || $selectedDiv.css("display") === "table-row" ||
                $selectedDiv.css("display") === "table-cell" || $selectedDiv.css("display") === "table") {
                toggle_button.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                </svg>
                `;
            } else {
                toggle_button.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>`;
            }
        }, 450);
    }

    function showLoadingSpinner() {
        $('#loading-animation-layer').show();
        setTimeout(() => {
            $('#loading-animation-layer').hide();
        }, 3000);
    }

    function hideLoadingSpinner(params) {
        $('#loading-animation-layer').hide();
    }

    let elem_with_loading_spinner = document.querySelectorAll('.loading-spinner');
    elem_with_loading_spinner.forEach(element => {
        element.addEventListener('click', () => {
            // console.log('clicked');
            showLoadingSpinner();
        })
    });

    // Filter Pencarian Item
    const all_items_x_photos = {!! json_encode($all_items_x_photos, JSON_HEX_TAG) !!};

    // console.log(window.location.href);
    // console.log(window.location.protocol);
    // console.log(window.location.host);
    // console.log(window.location.pathname);
    const window_main_url = window.location.protocol + '//' + window.location.host + '/';
    try {
    } catch (error) {
        console.error(error);        
    }
    // console.log(window_main_url);
    function searchItem(input, result_id) {
        if (input.value.trim()) {
            const filtered = all_items_x_photos.filter(function (item) {
            if (item.longname.toLowerCase().includes(input.value.trim().toLowerCase()) && this.count < 10) {
                this.count++;
                return true;
            }
            return false;
            }, {count:0});
        // console.log(filtered);
        let html_result = `<div class="absolute bg-white shadow drop-shadow p-1 text-xs font-bold z-10">`;
        
        filtered.forEach(item => {
            html_photo = `<div class="col-span-3 bg-indigo-100 text-indigo-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                </div>`;
            if (item.photo_path) {
                html_photo = `<div class="col-span-3">
                    <img class="w-full" src="${window_main_url}storage/${item.photo_path}">
                    </div>`;
            }
            html_result += `<a href="${window_main_url}items/${item.id}/show"><div class="loading-spinner border-b hover:cursor-pointer hover:bg-slate-100 grid grid-cols-12 gap-2 items-center">
                ${html_photo}
                <div class="col-span-9">${item.longname}</div>
                </div></a>`;
        });
        html_result += '</div>';

        document.getElementById(result_id).innerHTML = html_result;
        } else {
            document.getElementById(result_id).innerHTML = '';

        }
        
    }
    // END - Filter Pencarian Item
</script>

</html>
