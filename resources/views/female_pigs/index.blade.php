<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('female_pigs.index') }}
        </h2>
    </x-slot>
    <!-- header - end -->

    <!-- message -->
    <x-flash-msg :message="session('notice')" />

    {{-- TODO:メモ機能,出産予定日のアラート,離乳後一定期間交配していないアラート--}}

    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <div class="max-w-screen-xl px-2 md:px-4 mx-auto">
            <!-- title -->
            <h2 class="MplusRound text-gray-700 text-2xl lg:text-3xl text-center mb-6">
                {{-- <span class="text-rose-400"> --}}
                <span class="text-rose-800">
                    <i class="fa-solid fa-venus"></i>
                </span>
                一覧
            </h2>

            <!-- nav - start -->
            <nav x-data="{ isOpen: false }" class="relative bg-white">
                <div class="container px-6 py-2 mx-auto md:flex">
                    <div class="">
                        <!-- Mobile menu button -->
                        <div class="flex h-8 mr-4 md:hidden">
                            <button x-cloak @click="isOpen = !isOpen" type="button"
                                class="leading-8 text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600"
                                aria-label="toggle menu">
                                {{-- <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                                </svg> --}}
                                <div x-show="!isOpen" class="inline-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 p-2 rounded-md bg-white hover:bg-gray-100" fill="currentColor"
                                        viewBox="0 0 512 512" stroke="currentColor" stroke-width="2">
                                        <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352c79.5 0 144-64.5 144-144s-64.5-144-144-144S64 128.5 64 208s64.5 144 144 144z"/>
                                    </svg>
                                    <div>search</div>
                                </div>

                                <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
                    <div x-cloak :class="[isOpen ? 'translate-x-0 opacity-100 ' : 'opacity-0 -translate-x-full']"
                        class="absolute inset-x-0 z-20 w-full px-4 py-3 transition-all duration-300 ease-in-out bg-white md:mt-0 md:p-0 md:top-0 md:relative md:opacity-100 md:translate-x-0 md:flex md:items-center md:justify-between">

                        <div class="relative mt-4 md:mt-0">
                            <div class="">
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
                                        class="py-1 pl-10 pr-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:outline-none focus:ring focus:ring-opacity-40 focus:ring-blue-300">
                                        <option value=""></option>
                                        @foreach ($searchItems as $searchItem)
                                            <option value="{{ $searchItem->id }}">
                                                {{ $searchItem->individual_num }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                        class="text-sky-700 text-sm py-1 transition-colors bg-transparent rounded-lg hover:underline hover:font-semibold">
                                        <i class="fa-solid fa-hand-point-left"></i>
                                        個体検索
                                    </button>
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
                                <input type="number" name="search_age" min=1 max=10 value="{{ 'search_age' }}"
                                    class="w-25 py-1 pl-10 pr-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:outline-none focus:ring focus:ring-opacity-40 focus:ring-blue-300">
                                <button type="submit"
                                    class="text-sky-700 text-sm py-1 transition-colors bg-transparent rounded-lg hover:underline hover:font-semibold">
                                    <i class="fa-solid fa-hand-point-left"></i>
                                    年齢検索
                                </button>
                            </form>
                        </div>

                        <div class="relative mt-4 md:mt-0">
                            <form action="{{ route('female_pigs.index') }}" method="GET">
                                <input type="hidden" name="search_flag" value="1">
                                <input type="submit" value="要注意Pig"
                                    class="mr-2 py-1.5 px-4 text-sm transition-colors bg-gray-50 border active:bg-sky-700 font-medium border-gray-200 hover:text-white text-sky-700 hover:border-sky-800 rounded-lg hover:bg-sky-700 disabled:opacity-50">
                            </form>
                        </div>

                        <div class="relative mt-4 md:mt-0">
                            <form action="{{ route('female_pigs.index') }}" method="GET">
                                <input type="hidden" name="search_rotate" value="1">
                                <input type="submit" value="回転数低下Pig"
                                    class="mr-2 py-1.5 px-4 text-sm transition-colors bg-gray-50 border active:bg-sky-700 font-medium border-gray-200 hover:text-white text-sky-700 hover:border-sky-800 rounded-lg hover:bg-sky-700 disabled:opacity-50">
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- nav - end -->

            <!-- femalePig_data - start -->
            <div class="grid sm:grid-cols-3 xl:grid-cols-5 gap-2 md:gap-4">
                @foreach ($femalePigs as $femalePig)
                    <div class="flex flex-col border rounded-lg p-4 md:p-6">
                        <div class="flex flex-col items-center gap-2 md:gap-4">
                            <!-- individual_num & flag - start -->
                            <div class="flex h-10 text-center">
                                <div class="mx-2">
                                    @if ($femalePig->warn_flag == 1)
                                        <div class="text-red-600 leading-10">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('female_pigs.show', $femalePig) }}"
                                    class="text-gray-700 text-base leading-10 after:content-['_↗'] transition-colors bg-transparent hover:underline hover:text-sky-700">
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
                                    <div
                                        class="text-base MplusRound italic text-center before:block before:absolute before:-inset-1 before:-skew-y-3 before:bg-sky-500/50 relative inline-block">
                                        <span class="relative text-white">{{ $femalePig->status }}</span>
                                    </div>
                                @endif
                                @if ($femalePig->status == '待機中')
                                    <div
                                        class="text-base MplusRound italic text-center before:block before:absolute before:-inset-1 before:-skew-y-3 before:bg-lime-500/50 relative inline-block">
                                        <span class="relative text-white">{{ $femalePig->status }}</span>
                                    </div>
                                @endif
                                @if ($femalePig->status == '保育中')
                                    <div
                                        class="text-base MplusRound italic text-center before:block before:absolute before:-inset-1 before:-skew-y-3 before:bg-pink-500/50 relative inline-block">
                                        <span class="relative text-white">{{ $femalePig->status }}</span>
                                    </div>
                                @endif
                            </div>
                            <!-- age & status - end -->

                            <!-- prediction rotate - start -->
                            @if ($femalePig->rotate_prediction !== null && $femalePig->rotate_prediction <= 2.0)
                                <span
                                    class="text-red-600 text-base font-medium inline-flex items-center px-2.5 py-0.5 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                        <path
                                            d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                        <path fill-rule="evenodd"
                                            d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                                    </svg>
                                    <div class="ml-2">
                                        {{ $femalePig->rotate_prediction }}
                                    </div>
                                </span>
                            @endif
                            <!-- prediction rotate - end -->

                            <!-- schedule - start -->
                            <div class="text-sm text-gray-500">
                                @if ($femalePig->status == '観察中')
                                    <p>再発予定１: {{ $femalePig->mix_infos->last()->first_recurrence_schedule }}
                                    </p>
                                    <p>再発予定２: {{ $femalePig->mix_infos->last()->second_recurrence_schedule }}
                                    </p>
                                    <p>出産予定&emsp;: {{ $femalePig->mix_infos->last()->delivery_schedule }}</p>
                                @endif
                            </div>
                            <!-- schedule - end -->

                            <!-- alert - start -->
                            @if ($femalePig->status == '観察中')
                                @if (date('Y-m-d', strtotime('+3 day')) > $femalePig->mix_infos->last()->first_recurrence_schedule &&
                                    $femalePig->mix_infos->last()->first_recurrence == 0)
                                    {{-- <p class="text-sm text-red-600">再発確認！</p> --}}
                                    <span {{-- class="bg-red-100 text-red-800 text-sm font-medium inline-flex items-center px-2.5 py-0.5 rounded"> --}}
                                        class="text-red-700 text-sm font-medium inline-flex items-center px-2.5 py-0.5 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-calendar-check-fill"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708z" />
                                        </svg>
                                        <div class="ml-2">
                                            再発確認1
                                        </div>
                                    </span>
                                @endif
                                @if (date('Y-m-d', strtotime('+3 day')) > $femalePig->mix_infos->last()->second_recurrence_schedule &&
                                    $femalePig->mix_infos->last()->second_recurrence == 0)
                                    {{-- <p class="text-sm text-red-600">再発確認！</p> --}}
                                    <span
                                        class="text-red-700 text-sm font-medium inline-flex items-center px-2.5 py-0.5 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-calendar-check-fill"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708z" />
                                        </svg>
                                        <div class="ml-2">
                                            再発確認2
                                        </div>
                                    </span>
                                @endif
                                @if (date('Y-m-d', strtotime('+3 day')) > $femalePig->mix_infos->last()->delivery_schedule &&
                                    $femalePig->mix_infos->last()->born_day == null)
                                    <span
                                        class="text-sky-700 text-sm font-medium inline-flex items-center px-2.5 py-0.5 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-calendar-check-fill"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708z" />
                                        </svg>
                                        <div class="ml-2">
                                            出産予定
                                        </div>
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
