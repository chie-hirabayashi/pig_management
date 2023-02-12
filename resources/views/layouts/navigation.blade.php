<nav x-data="{ open: false }" class="bg-white shadow border-b border-gray-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-6">
        <div class="flex justify-between">
            <div class="flex">
                <!-- Logo -->
                {{-- <div class="shrink-0 flex items-center">
                    <a href="{{ route('female_pigs.index') }}">
                        <x-application-logo class="" />
                    </a>
                </div> --}}

                <nav x-data="{ isOpen: false }" class="relative bg-white">
                    <div class="container items-center justify-center pl-4 pr-20 md:px-6 py-6 mx-auto md:flex md:justify-between md:items-center">
                        <div class="">

                            <!-- Mobile menu button -->
                            <div class="flex md:hidden">
                                <button x-cloak @click="isOpen = !isOpen" type="button"
                                    class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600"
                                    aria-label="toggle menu">
                                    {{-- <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                                    </svg> --}}
                                    <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                    </svg>

                                    <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
                        <div x-cloak :class="[isOpen ? 'block translate-x-0 opacity-100' : 'opacity-0 -translate-x-full']"
                            class="absolute inset-x-0 z-20 w-full px-4 py-3 transition-all duration-300 ease-in-out bg-gray-100 md:bg-white border rounded-lg md:border-hidden md:mt-0 md:p-0 md:top-0 md:relative md:opacity-100 md:translate-x-0 md:flex md:items-center md:justify-between">
                            <div class="flex flex-col md:flex-row md:mx-6">
                                <!-- femalePigs Links -->
                                <div class="items-center ms:flex">
                                    <x-nav-link :href="route('female_pigs.index')">
                                        <div class="text-sm text-rose-800">
                                            <i class="fa-solid fa-venus"></i>&ensp;
                                        </div>
                                        {{ __('一覧') }}
                                    </x-nav-link>
                                </div>

                                <!-- malePigs Links -->
                                <div class="items-center md:flex">
                                    <span class="invisible md:visible mx-5 text-gray-500">
                                        /
                                    </span>
                                    <x-nav-link :href="route('male_pigs.index')">
                                        <div class="text-sm text-sky-800">
                                            <i class="fa-solid fa-mars"></i>&ensp;
                                        </div>
                                        {{ __('一覧') }}
                                    </x-nav-link>
                                </div>

                                <!-- extracts Links -->
                                <div class="items-center md:flex">
                                    <span class="invisible md:visible mx-5 text-gray-500">
                                        /
                                    </span>
                                    <x-nav-link :href="route('extracts.conditions')">
                                        <div class="text-sm text-gray-600">
                                            <i class="fa-solid fa-magnifying-glass"></i></i>&ensp;
                                        </div>
                                        {{ __('抽 出') }}
                                    </x-nav-link>
                                </div>

                                <!-- extracts Links -->
                                <div class="items-center md:flex">
                                    <span class="invisible md:visible mx-5 text-gray-500">
                                        /
                                    </span>
                                    <x-nav-link :href="route('achievements.index')">
                                        {{ __('総合実績表') }}
                                    </x-nav-link>
                                </div>

                                <!-- Navigation Links -->
                                <div class="items-center md:flex">
                                    <span class="invisible md:visible mx-5 text-gray-500">
                                        /
                                    </span>
                                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                        {{ __('取扱説明書') }}
                                    </x-nav-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- femalePigs Links -->
                {{-- <div class="hidden items-center sm:flex">
                    <x-nav-link :href="route('female_pigs.index')">
                        <div class="text-sm text-rose-800">
                            <i class="fa-solid fa-venus"></i>&ensp;
                        </div>
                        {{ __('Pigs') }}
                    </x-nav-link>
                </div> --}}

                <!-- malePigs Links -->
                {{-- <div class="hidden items-center sm:flex">
                    <span class="mx-5 text-gray-500">
                        /
                    </span>
                    <x-nav-link :href="route('male_pigs.index')">
                        <div class="text-sm text-sky-800">
                            <i class="fa-solid fa-mars"></i>&ensp;
                        </div>
                        {{ __('Pigs') }}
                    </x-nav-link>
                </div> --}}

                <!-- extracts Links -->
                {{-- <div class="hidden items-center sm:flex">
                    <span class="mx-5 text-gray-500">
                        /
                    </span>
                    <x-nav-link :href="route('extracts.conditions')">
                        {{ __('抽出') }}
                    </x-nav-link>
                </div> --}}

                <!-- extracts Links -->
                {{-- <div class="hidden items-center sm:flex">
                    <span class="mx-5 text-gray-500">
                        /
                    </span>
                    <x-nav-link :href="route('achievements.index')">
                        {{ __('総合実績表') }}
                    </x-nav-link>
                </div> --}}

                <!-- Navigation Links -->
                {{-- <div class="hidden items-center sm:flex">
                    <span class="mx-5 text-gray-500 ">
                        /
                    </span>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('取扱説明書') }}
                    </x-nav-link>
                </div> --}}
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            @auth
                                <div>{{ Auth::user()->name }}</div>
                            @else
                                <div>ゲスト</div>
                            @endauth

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        @else
                            <x-dropdown-link :href="route('register')">
                                {{ __('Sign Up') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('login')">
                                {{ __('Log In') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('imports_exports.form')">
                                {{ __('インポート/エクスポート') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('female_pigs.create')">
                                <div class="inline-flex">
                                    <div class="text-sm text-rose-800">
                                        New&ensp;<i class="fa-solid fa-venus"></i>&ensp;
                                    </div>
                                    <div>
                                        {{ __('Pig登録') }}
                                    </div>
                                </div>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('male_pigs.create')">
                                <div class="inline-flex">
                                    <div class="text-sm text-sky-800">
                                        New&ensp;
                                    </div>
                                    <div class="text-sm text-sky-800">
                                        <i class="fa-solid fa-mars"></i>&ensp;
                                    </div>
                                    <div>
                                        {{ __('Pig登録') }}
                                    </div>
                                </div>
                            </x-dropdown-link>
                        @endauth
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">guest</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Sign Up') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log In') }}
                    </x-responsive-nav-link>
                    <x-dropdown-link :href="route('imports_exports.form')">
                        {{ __('インポート/エクスポート') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('female_pigs.create')">
                        {{ __('母豚登録') }}
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('male_pigs.create')">
                        {{ __('父豚登録') }}
                    </x-dropdown-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
