<x-app-layout>
    <x-slot name="header">
        <h2 class="">
            {{ __('female_pigs.index') }}
        </h2>
    </x-slot>
    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <div class="max-w-screen-xl px-4 md:px-8 mx-auto">
            <h2 class="text-gray-800 text-2xl lg:text-3xl font-bold text-center mb-8 md:mb-12">
                femalePigs 一覧
            </h2>
            <x-flash-msg :message="session('notice')" />

            <div class="grid sm:grid-cols-5 lg:grid-cols-5 gap-y-10 sm:gap-y-12 lg:divide-x">
                <!-- quote - start -->
                @foreach ($femalePigs as $femalePig)
                    {{-- <div class="flex flex-col items-center gap-4 md:gap-6 sm:px-4 lg:px-8"> --}}
                    <div class="flex flex-col items-center gap-2 md:gap-4 sm:px-4 lg:px-8">
                        <div class="flex text-gray-600 text-xl text-center">
                            <div class="mx-2">
                                @if ($femalePig->warn_flag == 1)
                                    <div class="text-red-500">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('female_pigs.show', $femalePig) }}">
                                {{ $femalePig->individual_num }}
                            </a>
                        </div>
                        <div class="flex flex-col sm:flex-row items-center gap-2 md:gap-3">
                            <div class="text-center text-gray-500 text-sm md:text-sm sm:text-left">
                                {{ $femalePig->age }} 歳
                            </div>
                            <div class="text-indigo-500 text-base md:text-base font-bold text-center sm:text-center">
                                {{ $femalePig->status }}
                            </div>
                        </div>
                        @if ($femalePig->status == '観察中')
                        {{-- @if ($femalePig->mix_infos->last()->recurrence_first_schedule) --}}
                        {{-- <span class="text-red-400 font-bold">{{ date('Y-m-d H:i:s', strtotime('-1 day')) < $post->created_at ? 'NEW' : '' }}</span> --}}
                        {{-- <span class="text-red-400 font-bold">{{ date('Y-m-d', strtotime('-1 day')) < $femalePig->mix_infos->last()->recurrence_first_schedule ? 'NEW' : '' }}</span> --}}
                        {{-- <span class="text-red-400 font-bold">{{ date('2022-7-1', strtotime('-1 day')) < $femalePig->mix_infos->last()->recurrence_first_schedule ? 'NEW' : '' }}</span> --}}
                        <span class="text-red-400 font-bold">{{ date('2022-07-08', strtotime('7 day')) > $femalePig->mix_infos->last()->delivery_schedule && $femalePig->mix_infos->last()->delivery_schedule > date('2022-07-01') ? 'もうすぐ再発確認日' : '' }}</span>
                            
                        {{-- @endif --}}
                        @endif

                        <div class="text-sm">
                            @if ($femalePig->status == '観察中')
                                <p>再発予定1:{{ $femalePig->mix_infos->last()->recurrence_first_schedule }}
                                </p>
                                <p>再発予定2:{{ $femalePig->mix_infos->last()->recurrence_second_schedule }}
                                </p>
                                <p>出産予定:{{ $femalePig->mix_infos->last()->delivery_schedule }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
                {{-- @foreach ($mixInfos as $mixInfo)
                                <p class="text-rose-600 text-sm md:text-sm text-center sm:text-left">
                                    {{ $mixInfo->recurrence_first_schedule }}11-11は再発予定日です(確認したら、非表示になる)
                                </p>
                                @endforeach --}}
                <!-- quote - end -->
            </div>
        </div>
    </div>
</x-app-layout>
