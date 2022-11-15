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

    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <div class="max-w-screen-xl px-4 md:px-8 mx-auto">
            <!-- title -->
            <h2 class="text-gray-800 text-2xl lg:text-3xl font-bold text-center mb-8 md:mb-12">
                femalePigs 一覧
            </h2>

            <div class="grid sm:grid-cols-5 lg:grid-cols-5 gap-y-10 sm:gap-y-12 lg:divide-x">
                @foreach ($femalePigs as $femalePig)
                    {{-- <div class="flex flex-col items-center gap-4 md:gap-6 sm:px-4 lg:px-8"> --}}
                    <div class="flex flex-col items-center gap-2 md:gap-4 sm:px-4 lg:px-8">
                        <!-- individual_num & flag - start -->
                        <div class="flex text-gray-600 text-xl text-center">
                            <div class="mx-2">
                                @if ($femalePig->warn_flag == 1)
                                    <div class="text-red-500">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    </div>
                                @endif
                            </div>
                            {{-- <a class="after:content-['_↗']" href="{{ route('female_pigs.show', $femalePig) }}"> --}}
                            <a href="{{ route('female_pigs.show', $femalePig) }}">
                                {{ $femalePig->individual_num }}
                            </a>
                        </div>
                        <!-- individual_num & flag - end -->

                        <!-- age & status - start -->
                        <div class="flex flex-col sm:flex-row items-center gap-2 md:gap-3">
                            <div class="text-center text-gray-500 text-sm md:text-sm sm:text-left">
                                {{ $femalePig->age }} 歳
                            </div>
                            @if ($femalePig->status == '観察中')
                                {{-- <div class="text-gray-500 line-through decoration-8 decoration-sky-500/30 text-base md:text-base font-bold text-center sm:text-center"> --}}
                                {{-- <div class="text-gray-500 underline decoration-6 text-base md:text-base font-bold text-center sm:text-center"> --}}
                                {{-- <div class="text-gray-500 underline decoration-4 decoration-sky-500/30 text-base md:text-base font-bold text-center sm:text-center"> --}}
                                <div
                                    class="text-gray-500 underline decoration-8 decoration-sky-500/30 text-base md:text-base font-bold text-center sm:text-center">
                                    {{ $femalePig->status }}
                                </div>
                            @endif
                            @if ($femalePig->status == '待機中')
                                <div
                                    class="text-gray-500 underline decoration-8 decoration-lime-500/30 text-base md:text-base font-bold text-center sm:text-center">
                                    {{-- <div class="text-gray-500 underline decoration-lime-400 decoration-double text-base md:text-base font-bold text-center sm:text-center"> --}}
                                    {{ $femalePig->status }}
                                </div>
                            @endif
                            @if ($femalePig->status == '保育中')
                                <div
                                    class="text-gray-500 underline decoration-8 decoration-pink-500/30 text-base md:text-base font-bold text-center sm:text-center">
                                    {{-- <div class="text-gray-500 underline decoration-pink-400 decoration-double text-base md:text-base font-bold text-center sm:text-center"> --}}
                                    {{ $femalePig->status }}
                                </div>
                            @endif
                        </div>
                        <!-- age & status - end -->

                        <!-- alert - start -->
                        @if ($femalePig->status == '観察中')
                            @if (date('Y-m-d', strtotime('+3 day')) > $femalePig->mix_infos->last()->first_recurrence_schedule &&
                                $femalePig->mix_infos->last()->first_recurrence == 0)
                                <p class="text-red-600">再発確認</p>
                            @endif
                            @if (date('Y-m-d', strtotime('+3 day')) > $femalePig->mix_infos->last()->second_recurrence_schedule &&
                                $femalePig->mix_infos->last()->second_recurrence == 0)
                                <p class="text-red-600">再発確認</p>
                            @endif

                            {{-- 仮設定 --}}
                            {{-- @if (date('2022-08-07', strtotime('7 day')) > $femalePig->mix_infos->last()->delivery_schedule && $femalePig->mix_infos->last()->first_recurrence == 0)
                                <p class="text-red-600">再発確認</p>
                            @endif --}}
                        @endif
                        <!-- alert - end -->

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
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
