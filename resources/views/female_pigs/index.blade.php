<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('female_pigs.index') }}
        </h2>
    </x-slot>
    <!-- header - end -->

    <nav x-data="{ isOpen: false }" class="relative bg-white shadow dark:bg-gray-800">
        {{-- <nav x-data="{ isOpen: false }" class="relative"> --}}
        <div class="container px-6 py-2 mx-auto md:flex">
            <div class="">

                <!-- Mobile menu button -->
                <div class="flex h-8 mr-4 lg:hidden">
                    <button x-cloak @click="isOpen = !isOpen" type="button"
                        class="leading-8 text-gray-500 dark:text-gray-200 hover:text-gray-600 dark:hover:text-gray-400 focus:outline-none focus:text-gray-600 dark:focus:text-gray-400"
                        aria-label="toggle menu">
                        <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                        </svg>

                        <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
            <div x-cloak :class="[isOpen ? 'translate-x-0 opacity-100 ' : 'opacity-0 -translate-x-full']"
                class="absolute inset-x-0 z-20 w-full px-4 py-3 transition-all duration-300 ease-in-out bg-white dark:bg-gray-800 md:mt-0 md:p-0 md:top-0 md:relative md:opacity-100 md:translate-x-0 md:flex md:items-center md:justify-between">

                <div class="relative mt-4 md:mt-0">
                    <div class="flex">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                        </span>
                        <form action="{{ route('female_pigs.index') }}" method="GET">
                            <select name="search" id=""
                                class="py-1 pl-10 pr-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-opacity-40 focus:ring-blue-300">
                                <option value=""></option>
                                @foreach ($searchItems as $searchItem)
                                    <option value="{{ $searchItem->id }}">
                                        {{ $searchItem->individual_num }}
                                    </option>
                                @endforeach
                            </select>
                            {{-- <input type="search" placeholder="個体番号を入力" name="search" value="{{ old('search') }}"> --}}
                            <input type="submit" value="検索">
                        </form>
                    </div>
                </div>

                <div class="relative mt-4 md:mt-0">
                    <div class="flex">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                                <path
                                    d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                        </span>
                    </div>
                    <form action="{{ route('female_pigs.index') }}" method="GET">
                        {{-- <label for="search_age">年齢検索</label> --}}
                        <input type="number" name="search_age" min=1 max=10 value="{{ 'search_age' }}"
                            class="w-25 py-1 pl-10 pr-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-opacity-40 focus:ring-blue-300">
                        <input type="submit" value="年齢検索">
                    </form>
                </div>

                <div class="relative mt-4 md:mt-0">
                    <form action="{{ route('female_pigs.index') }}" method="GET">
                        <input type="hidden" name="search_flag" value="1">
                        <input type="submit" value="要注意個体">
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- message -->
    <x-flash-msg :message="session('notice')" />

    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <div class="max-w-screen-xl px-2 md:px-4 mx-auto">
            <!-- title -->
            <h2 class="MplusRound text-gray-700 text-2xl lg:text-3xl text-center mb-8 md:mb-12">
                <span class="text-rose-400">
                    <i class="fa-solid fa-venus"></i>
                </span>
                一覧
            </h2>

            <!-- femalePig_data - start -->
            <div class="grid sm:grid-cols-3 xl:grid-cols-5 gap-2 md:gap-4">
                @foreach ($femalePigs as $femalePig)
                    <div class="flex flex-col border rounded-lg p-4 md:p-6">
                        <div class="flex flex-col items-center gap-2 md:gap-4">
                            <!-- individual_num & flag - start -->
                            <div class="flex text-center">
                                <div class="mx-2">
                                    @if ($femalePig->warn_flag == 1)
                                        <div class="text-red-500">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('female_pigs.show', $femalePig) }}"
                                    class="text-gray-700 text-base after:content-['_↗'] transition-colors bg-transparent hover:underline hover:text-blue-500">
                                    No.
                                    <span class="text-xl">
                                        {{ $femalePig->individual_num }}
                                    </span>
                                </a>
                            </div>
                            <!-- individual_num & flag - end -->

                            <!-- age & status - start -->
                            <div class="flex flex-col sm:flex-row items-center gap-2 md:gap-3">
                                <div class="text-center text-gray-500 text-sm md:text-sm sm:text-left">
                                    {{ $femalePig->age }} 歳
                                </div>
                                @if ($femalePig->status == '観察中')
                                    {{-- <div
                                        class="text-gray-500 underline decoration-8 decoration-sky-500/30 text-base md:text-base font-bold text-center sm:text-center">
                                        {{ $femalePig->status }}
                                    </div> --}}
                                    <div
                                        class="text-base MplusRound italic text-center before:block before:absolute before:-inset-1 before:-skew-y-3 before:bg-sky-500/50 relative inline-block">
                                        <span class="relative text-white">{{ $femalePig->status }}</span>
                                    </div>
                                @endif
                                @if ($femalePig->status == '待機中')
                                    {{-- <div
                                        class="text-gray-500 underline decoration-8 decoration-lime-500/30 text-base md:text-base font-bold text-center sm:text-center">
                                        {{ $femalePig->status }}
                                    </div> --}}
                                    <div
                                        class="text-base MplusRound italic text-center before:block before:absolute before:-inset-1 before:-skew-y-3 before:bg-lime-500/50 relative inline-block">
                                        <span class="relative text-white">{{ $femalePig->status }}</span>
                                    </div>
                                @endif
                                @if ($femalePig->status == '保育中')
                                    {{-- <div
                                        class="text-gray-500 underline decoration-8 decoration-pink-500/30 text-base md:text-base font-bold text-center sm:text-center">
                                        {{ $femalePig->status }}
                                    </div> --}}
                                    <div
                                        class="text-base MplusRound italic text-center before:block before:absolute before:-inset-1 before:-skew-y-3 before:bg-pink-500/50 relative inline-block">
                                        <span class="relative text-white">{{ $femalePig->status }}</span>
                                    </div>
                                @endif
                            </div>
                            {{-- <div
                                class="text-base MplusRound italic text-center before:block before:absolute before:-inset-1 before:-skew-y-3 before:bg-pink-500/50 relative inline-block">
                                <span class="relative text-white">保育中</span>
                            </div> --}}
                            <!-- age & status - end -->

                            <!-- schedule - start -->
                            <div class="text-sm text-gray-500">
                                @if ($femalePig->status == '観察中')
                                    <p>再発予定1 :{{ $femalePig->mix_infos->last()->first_recurrence_schedule }}
                                    </p>
                                    <p>再発予定2 : {{ $femalePig->mix_infos->last()->second_recurrence_schedule }}
                                    </p>
                                    <p>出産予定 : {{ $femalePig->mix_infos->last()->delivery_schedule }}</p>
                                @endif
                            </div>
                            <!-- schedule - end -->

                            <!-- alert - start -->
                            @if ($femalePig->status == '観察中')
                                @if (date('Y-m-d', strtotime('+3 day')) > $femalePig->mix_infos->last()->first_recurrence_schedule &&
                                    $femalePig->mix_infos->last()->first_recurrence == 0)
                                    {{-- <p class="text-sm text-red-600">再発確認！</p> --}}
                                    <span
                                        class="bg-red-100 text-red-800 text-sm font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-800">
                                        <svg aria-hidden="true" class="mr-1 w-3 h-3" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        再発確認時期
                                    </span>
                                @endif
                                @if (date('Y-m-d', strtotime('+3 day')) > $femalePig->mix_infos->last()->second_recurrence_schedule &&
                                    $femalePig->mix_infos->last()->second_recurrence == 0)
                                    {{-- <p class="text-sm text-red-600">再発確認！</p> --}}
                                    <span
                                        class="bg-red-100 text-red-800 text-sm font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-800">
                                        <svg aria-hidden="true" class="mr-1 w-3 h-3" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        再発確認時期
                                    </span>
                                @endif
                            @endif
                            <!-- alert - end -->
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- femalePig_data - end -->
</x-app-layout>
