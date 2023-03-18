<div>

    @if ($isOpen)
        @include('livewire.place-edit')
    @endif

    <!-- message -->
    <x-error-validation :errors="$errors" />
    <x-flash-msg :message="session('notice')" />

    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">

            <!-- border - start -->
            <div class="grid lg:grid-cols-2 gap-4 md:gap-6">
                <div class="mb-10 items-center">
                    <h2 class="MplusRound text-gray-700 text-2xl lg:text-3xl text-center mb-4">繁殖室</h2>

                    <div class="my-4">
                        <div class="MplusRound px-8 py-2 text-gray-700">凡例</div>
                        <div class="w-full grid grid-cols-2 xl:grid-cols-3 items-center gap-2 xl:gap-1">
                            <p class="border py-2 px-3 text-sm lg:text-xs text-gray-700 text-center bg-red-200">
                                再発確認1
                                <span class="text-xs ml-2">
                                &raquo;&nbsp;経過日数
                                </span>
                            </p>
                            <p class="border py-2 px-3 text-sm lg:text-xs text-gray-700 text-center bg-red-300">
                                再発確認2
                                <span class="text-xs ml-2">
                                &raquo;&nbsp;経過日数
                                </span>
                            </p>
                            <p class="border py-2 px-3 text-sm lg:text-xs text-gray-700 text-center bg-blue-200">
                                出産予定14日前
                                <span class="text-xs ml-2">
                                &raquo;&nbsp;経過日数
                                </span>
                            </p>
                            <p class="border py-2 px-3 text-sm lg:text-xs text-gray-700 text-center bg-blue-300">
                                出産予定7日前
                                <span class="text-xs ml-2">
                                &raquo;&nbsp;経過日数
                                </span>
                            </p>
                            <p class="border py-2 px-3 text-sm lg:text-xs text-gray-700 text-center bg-amber-100">待機中
                            <p class="border py-2 px-3 text-sm lg:text-xs text-gray-700 text-center bg-red-50">
                                再発確認3以降
                                <span class="text-xs ml-2">
                                &raquo;&nbsp;経過日数
                                </span>
                            </p>
                            </p>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4 sm:gap-2">
                        <div class="overflow-x-auto relative w-full xl:w-64 mx-auto">
                            <table class="w-full text-sm text-left text-gray-700">
                                <thead class="text-center text-xs text-gray-900 uppercase">
                                    <tr>
                                        <th class="border py-3 px-2 w-3/12">
                                            場所NO.
                                        </th>
                                        <th class="border py-3 px-2 w-5/12">
                                            個体番号
                                        </th>
                                        @auth
                                            <th class="border py-3 px-6 w-4/12"></th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 30; $i < 60; $i++)
                                        <tr class="bg-white">
                                            <td class="border text-center py-3 px-6">
                                                <div>
                                                    <p class="font-medium text-gray-900">
                                                        {{ $places[$i]->place_num }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td
                                                class="border py-3 px-2 text-center font-medium whitespace-nowrap
                                                @if (!empty($places[$i]->female_pig->mix_infos->last()->id) && $places[$i]->female_pig->status == '観察中') {{-- 再発1確認 --}}
                                                    {{-- 再発1確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->first_recurrence_schedule &&
                                                            date('Y-m-d', strtotime('-4 day')) < $places[$i]->female_pig->mix_infos->last()->first_recurrence_schedule)
                                                        bg-red-200 @endif
                                                    {{-- 再発2確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule &&
                                                            date('Y-m-d', strtotime('-4 day')) < $places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule) bg-red-300 @endif
                                                    {{-- 再発3確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) > date('Y-m-d', strtotime('+21day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule))) &&
                                                            date('Y-m-d', strtotime('-4 day')) < date('Y-m-d', strtotime('+21day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)))) bg-red-50 @endif
                                                    {{-- 再発4確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) > date('Y-m-d', strtotime('+42day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule))) &&
                                                            date('Y-m-d', strtotime('-4 day')) < date('Y-m-d', strtotime('+42day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)))) bg-red-50 @endif
                                                    {{-- 再発5確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) > date('Y-m-d', strtotime('+63day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule))) &&
                                                            date('Y-m-d', strtotime('-4 day')) < date('Y-m-d', strtotime('+63day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)))) bg-red-50 @endif
                                                    {{-- 出産予定14日前 --}}
                                                    @if (date('Y-m-d', strtotime('+14 day')) > $places[$i]->female_pig->mix_infos->last()->delivery_schedule &&
                                                            date('Y-m-d', strtotime('+7 day')) < $places[$i]->female_pig->mix_infos->last()->delivery_schedule) bg-blue-200 @endif
                                                    {{-- 出産予定7日前 --}}
                                                    @if (date('Y-m-d', strtotime('+7 day')) >= $places[$i]->female_pig->mix_infos->last()->delivery_schedule) bg-blue-300 @endif
                                                @endif
                                                @if (!empty($places[$i]->female_pig->id) && $places[$i]->female_pig->status == '待機中') {{-- 待機中 --}}
                                                    bg-amber-100 @endif
                                            ">
                                                <div class="flex justify-center items-center">
                                                    @if ($places[$i]->female_pig->warn_flag == 1)
                                                            <div class="text-red-600 mr-2">
                                                                <i class="fa-solid fa-triangle-exclamation"></i>
                                                            </div>
                                                    @endif
                                                    @if ($places[$i]->female_pig->id)
                                                            <a
                                                                href="{{ route('female_pigs.show', $places[$i]->female_pig->id) }}">
                                                                {{ $places[$i]->female_pig->individual_num }}
                                                            </a>
                                                    @endif
                                                    @if (count($places[$i]->female_pig->mix_infos) != 0 && $places[$i]->female_pig->mix_infos->last()->trouble_id == 1 && $places[$i]->female_pig->mix_infos->last()->born_day == null)
                                                            <div class="text-xs ml-2">
                                                                &raquo;&nbsp;{{ $places[$i]->female_pig->mix_infos->last()->elapsed_days }}日
                                                            </div>
                                                    @endif
                                                </div>
                                            </td>
                                            @auth
                                                <td class="border text-center px-2 py-0">
                                                    @if (empty($places[$i]->female_pig->individual_num))
                                                        <button wire:click="placeIn({{ $places[$i]->id }})"
                                                            class="basis-1/2 font-medium text-cyan-800 hover:underline hover:font-bold">
                                                            入室
                                                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                                        </button>
                                                    @endif
                                                    @if (!empty($places[$i]->female_pig->individual_num))
                                                        <button wire:click="placeOut({{ $places[$i]->id }})"
                                                            class="basis-1/2 font-medium text-red-600 hover:underline hover:font-bold">
                                                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                                            退室
                                                        </button>
                                                    @endif
                                                </td>
                                            @endauth
                                        </tr>
                                    @endfor
                            </table>
                        </div>
                        <div class="overflow-x-auto relative w-full xl:w-64 mx-auto">
                            <table class="w-full text-sm text-left text-gray-700">
                                <thead class="text-center text-xs text-gray-900 uppercase">
                                    <tr>
                                        <th class="border py-3 px-2 w-3/12">
                                            場所NO.
                                        </th>
                                        <th class="border py-3 px-2 w-5/12">
                                            個体番号
                                        </th>
                                        @auth
                                            <th class="border py-3 px-6 w-4/12"></th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < 30; $i++)
                                        <tr class="bg-white">
                                            <td
                                                class="border py-3 px-6 text-center font-medium text-gray-900 whitespace-nowrap">
                                                <div>
                                                    <p class="">
                                                        {{ $places[$i]->place_num }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td
                                                class="border py-3 px-2 text-center font-medium whitespace-nowrap
                                                @if (!empty($places[$i]->female_pig->mix_infos->last()->id) && $places[$i]->female_pig->status == '観察中') {{-- 再発1確認 --}}
                                                    {{-- 再発1確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->first_recurrence_schedule &&
                                                            date('Y-m-d', strtotime('-4 day')) < $places[$i]->female_pig->mix_infos->last()->first_recurrence_schedule)
                                                        bg-red-200 @endif
                                                    {{-- 再発2確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule &&
                                                            date('Y-m-d', strtotime('-4 day')) < $places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule) bg-red-300 @endif
                                                    {{-- 再発3確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) > date('Y-m-d', strtotime('+21day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule))) &&
                                                            date('Y-m-d', strtotime('-4 day')) < date('Y-m-d', strtotime('+21day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)))) bg-red-50 @endif
                                                    {{-- 再発4確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) > date('Y-m-d', strtotime('+42day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule))) &&
                                                            date('Y-m-d', strtotime('-4 day')) < date('Y-m-d', strtotime('+42day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)))) bg-red-50 @endif
                                                    {{-- 再発5確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) > date('Y-m-d', strtotime('+63day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule))) &&
                                                            date('Y-m-d', strtotime('-4 day')) < date('Y-m-d', strtotime('+63day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)))) bg-red-50 @endif
                                                    {{-- 出産予定14日前 --}}
                                                    @if (date('Y-m-d', strtotime('+14 day')) > $places[$i]->female_pig->mix_infos->last()->delivery_schedule &&
                                                            date('Y-m-d', strtotime('+7 day')) < $places[$i]->female_pig->mix_infos->last()->delivery_schedule) bg-blue-200 @endif
                                                    {{-- 出産予定7日前 --}}
                                                    @if (date('Y-m-d', strtotime('+7 day')) >= $places[$i]->female_pig->mix_infos->last()->delivery_schedule) bg-blue-300 @endif
                                                @endif
                                                @if (!empty($places[$i]->female_pig->id) && $places[$i]->female_pig->status == '待機中') {{-- 待機中 --}}
                                                    bg-amber-100 @endif
                                            ">
                                            <div class="flex justify-center items-center">
                                                @if ($places[$i]->female_pig->warn_flag == 1)
                                                        <div class="text-red-600 mr-2">
                                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                                        </div>
                                                @endif
                                                @if ($places[$i]->female_pig->id)
                                                    <a
                                                        href="{{ route('female_pigs.show', $places[$i]->female_pig->id) }}">
                                                        {{ $places[$i]->female_pig->individual_num }}
                                                    </a>
                                                @endif
                                                @if (count($places[$i]->female_pig->mix_infos) != 0 && $places[$i]->female_pig->mix_infos->last()->trouble_id == 1 && $places[$i]->female_pig->mix_infos->last()->born_day == null)
                                                        <div class="text-xs ml-2">
                                                            &raquo;&nbsp;{{ $places[$i]->female_pig->mix_infos->last()->elapsed_days }}日
                                                        </div>
                                                @endif
                                            </div>
                                            </td>
                                            @auth
                                                <td class="border text-center px-2 py-0">
                                                    @if (empty($places[$i]->female_pig->individual_num))
                                                        <button wire:click="placeIn({{ $places[$i]->id }})"
                                                            class="basis-1/2 font-medium text-cyan-800 hover:underline hover:font-bold">
                                                            入室
                                                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                                        </button>
                                                    @endif
                                                    @if (!empty($places[$i]->female_pig->individual_num))
                                                        <button wire:click="placeOut({{ $places[$i]->id }})"
                                                            class="basis-1/2 font-medium text-red-600 hover:underline hover:font-bold">
                                                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                                            退室
                                                        </button>
                                                    @endif
                                                </td>
                                            @endauth
                                        </tr>
                                    @endfor
                            </table>
                        </div>
                    </div>
                    <!-- border - end -->
                </div>


                <div>
                    <!-- border - start -->
                    <h2 class="MplusRound text-gray-700 text-2xl lg:text-3xl text-center mb-6">分娩室</h2>
                    <div class="grid sm:grid-cols-2 xl:grid-cols-2 gap-4 md:gap-2">
                        <div class="overflow-x-auto relative w-full xl:w-64 mx-auto">
                            <table class="w-full text-sm text-left text-gray-700">
                                <thead class="text-center text-xs text-gray-900 uppercase">
                                    <tr>
                                        <th class="border py-3 px-2 w-3/12">
                                            場所NO.
                                        </th>
                                        <th class="border py-3 px-2 w-5/12">
                                            個体番号
                                        </th>
                                        @auth
                                            <th class="border py-3 px-6 w-4/12"></th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 60; $i < 80; $i++)
                                        @if ($i % 2 != 0)
                                            <tr class="bg-white">
                                                <td class="border text-center py-3 px-6">
                                                    <div>
                                                        <p class="font-medium text-gray-900">
                                                            {{ $places[$i]->place_num }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="border py-3 px-2 text-center font-medium whitespace-nowrap">
                                                    @if ($places[$i]->female_pig->id)
                                                        <a
                                                            href="{{ route('female_pigs.show', $places[$i]->female_pig->id) }}">
                                                            {{ $places[$i]->female_pig->individual_num }}
                                                        </a>
                                                    @endif
                                                </td>
                                                @auth
                                                    <td class="border text-center px-2 py-0">
                                                        @if (empty($places[$i]->female_pig->individual_num))
                                                            <button wire:click="placeIn({{ $places[$i]->id }})"
                                                                class="basis-1/2 font-medium text-cyan-800 hover:underline hover:font-bold">
                                                                入室
                                                                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                                            </button>
                                                        @endif
                                                        @if (!empty($places[$i]->female_pig->individual_num))
                                                            <button wire:click="placeOut({{ $places[$i]->id }})"
                                                                class="basis-1/2 font-medium text-red-600 hover:underline hover:font-bold">
                                                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                                                退室
                                                            </button>
                                                        @endif
                                                    </td>
                                                @endauth
                                            </tr>
                                        @endif
                                    @endfor
                            </table>
                        </div>
                        <div class="overflow-x-auto relative w-full xl:w-64 mx-auto">
                            <table class="w-full text-sm text-left text-gray-700">
                                <thead class="text-center border-t text-xs text-gray-900 uppercase">
                                    <tr>
                                        <th class="border py-3 px-2 w-3/12">
                                            場所NO.
                                        </th>
                                        <th class="border py-3 px-2 w-5/12">
                                            個体番号
                                        </th>
                                        @auth
                                            <th class="border py-3 px-6 w-4/12"></th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 60; $i < 80; $i++)
                                        @if ($i % 2 == 0)
                                            <tr class="bg-white">
                                                <td
                                                    class="border py-3 px-6 text-center font-medium text-gray-900 whitespace-nowrap">
                                                    <div>
                                                        <p class="">
                                                            {{ $places[$i]->place_num }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="border py-3 px-2 text-center font-medium whitespace-nowrap">
                                                    @if ($places[$i]->female_pig->id)
                                                        <a
                                                            href="{{ route('female_pigs.show', $places[$i]->female_pig->id) }}">
                                                            {{ $places[$i]->female_pig->individual_num }}
                                                        </a>
                                                    @endif
                                                </td>
                                                @auth
                                                    <td class="border text-center px-2 py-0">
                                                        @if (empty($places[$i]->female_pig->individual_num))
                                                            <button wire:click="placeIn({{ $places[$i]->id }})"
                                                                class="basis-1/2 font-medium text-cyan-800 hover:underline hover:font-bold">
                                                                入室
                                                                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                                            </button>
                                                        @endif
                                                        @if (!empty($places[$i]->female_pig->individual_num))
                                                            <button wire:click="placeOut({{ $places[$i]->id }})"
                                                                class="basis-1/2 font-medium text-red-600 hover:underline hover:font-bold">
                                                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                                                退室
                                                            </button>
                                                        @endif
                                                    </td>
                                                @endauth
                                            </tr>
                                        @endif
                                    @endfor
                            </table>
                        </div>
                    </div>
                    <!-- border - end -->
                </div>
            </div>

        </div>
        <!-- base_information - end -->
    </div>
    @livewireScripts
</div>
