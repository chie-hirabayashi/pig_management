<div>

    @if ($isOpen)
        @include('livewire.place-edit')
    @endif

    <!-- message -->
    <x-error-validation :errors="$errors" />
    <x-flash-msg :message="session('notice')" />

    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
            <div class="grid lg:grid-cols-2 gap-4 md:gap-6">
                <!-- bredding - start -->
                <div class="mb-10 items-center">
                    <h2 class="MplusRound text-gray-700 text-2xl lg:text-3xl text-center mb-4">繁殖室</h2>

                    <!-- guide - start -->
                    <div class="my-4">
                        <div class="MplusRound px-8 py-2 text-gray-700">凡例</div>
                        <div class="w-full grid grid-cols-2 xl:grid-cols-3 items-center gap-2 xl:gap-1">
                            <p class="border py-2 px-8 text-sm lg:text-xs text-gray-700 text-left bg-red-200">
                                再発確認1
                            </p>
                            <p class="border py-2 px-8 text-sm lg:text-xs text-gray-700 text-left bg-red-300">
                                再発確認2
                            </p>
                            <p class="border py-2 px-8 text-sm lg:text-xs text-gray-700 text-left bg-red-50">
                                再発確認3以降
                            </p>
                            <p class="border py-2 px-8 text-sm lg:text-xs text-gray-700 text-left bg-amber-100">
                                待機中
                            </p>
                            <p class="border py-2 px-8 text-sm lg:text-xs text-gray-700 text-left bg-blue-200">
                                出産予定14日前
                            </p>
                            <p class="border py-2 px-8 text-sm lg:text-xs text-gray-700 text-left bg-blue-300">
                                出産予定7日前
                            </p>
                            <p class="border py-2 px-8 text-sm lg:text-xs text-gray-700 text-right">
                                <span class="text-xs ml-2">
                                    &raquo;&nbsp;交配からの経過日数
                                </span>
                            </p>
                        </div>
                    </div>
                    <!-- guide - end -->

                    <div class="grid sm:grid-cols-2 gap-4 sm:gap-2 xl:gap-3">
                        <!-- breeding1 - start -->
                        <div class="overflow-x-auto relative w-full mx-auto">
                            <table class="w-full text-sm text-left text-gray-700 border-2 border-gray-300">
                                <thead class="text-center text-xs text-gray-900 uppercase">
                                    <tr>
                                        <th class="border bg-gray-50 py-2 px-1 w-2/12">
                                            部屋番
                                        </th>
                                        <th class="border bg-gray-50 py-2 px-2 w-6/12">
                                            個体番号
                                        </th>
                                        @auth
                                            <th class="border bg-gray-50 py-2 px-2 w-4/12">入退室</th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 30; $i < 60; $i++)
                                        <tr class="bg-white">
                                            <td class="border text-center py-3 px-5 lg:px-4">
                                                <div>
                                                    <p class="font-medium text-gray-900">
                                                        {{ $places[$i]->place_num }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td
                                                class="border py-3 px-8 md:px-4 lg:px-2 text-center font-medium whitespace-nowrap
                                                @if (!empty($places[$i]->female_pig->mix_infos->last()->id) && $places[$i]->female_pig->status == '観察中') {{-- 再発1確認 --}}
                                                    {{-- 再発1確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->first_recurrence_schedule &&
                                                            date('Y-m-d', strtotime('-4 day')) < $places[$i]->female_pig->mix_infos->last()->first_recurrence_schedule)
                                                        bg-red-200 @endif
                                                    {{-- 再発2確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule &&
                                                            date('Y-m-d', strtotime('-4 day')) < $places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule) bg-red-300 @endif
                                                    {{-- 出産予定14日前 --}}
                                                    @if (date('Y-m-d', strtotime('+14 day')) > $places[$i]->female_pig->mix_infos->last()->delivery_schedule &&
                                                            date('Y-m-d', strtotime('+7 day')) < $places[$i]->female_pig->mix_infos->last()->delivery_schedule) bg-blue-200 @endif
                                                    {{-- 出産予定7日前 --}}
                                                    @if (date('Y-m-d', strtotime('+7 day')) >= $places[$i]->female_pig->mix_infos->last()->delivery_schedule) bg-blue-300 @endif
                                                    {{-- 再発3確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) >
                                                            date(
                                                                'Y-m-d',
                                                                strtotime('+21day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule))) &&
                                                            date('Y-m-d', strtotime('-4 day')) <
                                                                date(
                                                                    'Y-m-d',
                                                                    strtotime('+21day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)))) bg-red-50 @endif
                                                    {{-- 再発4確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) >
                                                            date(
                                                                'Y-m-d',
                                                                strtotime('+42day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule))) &&
                                                            date('Y-m-d', strtotime('-4 day')) <
                                                                date(
                                                                    'Y-m-d',
                                                                    strtotime('+42day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)))) bg-red-50 @endif
                                                    {{-- 再発5確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) >
                                                            date(
                                                                'Y-m-d',
                                                                strtotime('+63day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule))) &&
                                                            date('Y-m-d', strtotime('-4 day')) <
                                                                date(
                                                                    'Y-m-d',
                                                                    strtotime('+63day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)))) bg-red-50 @endif
                                                @endif
                                                @if (!empty($places[$i]->female_pig->id) && $places[$i]->female_pig->status == '待機中') {{-- 待機中 --}}
                                                    bg-amber-100 @endif
                                            ">
                                                <div class="flex justify-between items-center">
                                                    @if ($places[$i]->female_pig->id)
                                                        <a class="flex justify-between items-center"
                                                            href="{{ route('female_pigs.show', $places[$i]->female_pig->id) }}">
                                                            {{ $places[$i]->female_pig->individual_num }}
                                                            @if ($places[$i]->female_pig->well_flag == 1)
                                                                <span class="text-amber-300 text-xs ml-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" fill="currentColor"
                                                                        class="w-4 h-4">
                                                                        <path fill-rule="evenodd"
                                                                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 00-.189.866c0 .298.059.605.189.866.108.215.395.634.936.634.54 0 .828-.419.936-.634.13-.26.189-.568.189-.866 0-.298-.059-.605-.189-.866-.108-.215-.395-.634-.936-.634zm4.314.634c.108-.215.395-.634.936-.634.54 0 .828.419.936.634.13.26.189.568.189.866 0 .298-.059.605-.189.866-.108.215-.395.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 01-.189-.866c0-.298.059-.605.189-.866zm2.023 6.828a.75.75 0 10-1.06-1.06 3.75 3.75 0 01-5.304 0 .75.75 0 00-1.06 1.06 5.25 5.25 0 007.424 0z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </span>
                                                            @endif
                                                            @if ($places[$i]->female_pig->unwell_flag == 1)
                                                                <span class="text-cyan-600 text-xs ml-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" fill="currentColor"
                                                                        class="w-4 h-4">
                                                                        <path fill-rule="evenodd"
                                                                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 00-.189.866c0 .298.059.605.189.866.108.215.395.634.936.634.54 0 .828-.419.936-.634.13-.26.189-.568.189-.866 0-.298-.059-.605-.189-.866-.108-.215-.395-.634-.936-.634zm4.314.634c.108-.215.395-.634.936-.634.54 0 .828.419.936.634.13.26.189.568.189.866 0 .298-.059.605-.189.866-.108.215-.395.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 01-.189-.866c0-.298.059-.605.189-.866zm-4.34 7.964a.75.75 0 01-1.061-1.06 5.236 5.236 0 013.73-1.538 5.236 5.236 0 013.695 1.538.75.75 0 11-1.061 1.06 3.736 3.736 0 00-2.639-1.098 3.736 3.736 0 00-2.664 1.098z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </span>
                                                            @endif
                                                            @if ($places[$i]->female_pig->warn_flag == 1)
                                                                <span class="text-red-600 text-xs ml-1">
                                                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                                                </span>
                                                            @endif
                                                            @if ($places[$i]->female_pig->recurrence_flag == 1)
                                                                <span class="text-red-600 text-xs ml-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" fill="currentColor"
                                                                        class="w-4 h-4">
                                                                        <path
                                                                            d="M13.5 4.06c0-1.336-1.616-2.005-2.56-1.06l-4.5 4.5H4.508c-1.141 0-2.318.664-2.66 1.905A9.76 9.76 0 001.5 12c0 .898.121 1.768.35 2.595.341 1.24 1.518 1.905 2.659 1.905h1.93l4.5 4.5c.945.945 2.561.276 2.561-1.06V4.06zM18.584 5.106a.75.75 0 011.06 0c3.808 3.807 3.808 9.98 0 13.788a.75.75 0 11-1.06-1.06 8.25 8.25 0 000-11.668.75.75 0 010-1.06z" />
                                                                        <path
                                                                            d="M15.932 7.757a.75.75 0 011.061 0 6 6 0 010 8.486.75.75 0 01-1.06-1.061 4.5 4.5 0 000-6.364.75.75 0 010-1.06z" />
                                                                    </svg>
                                                                </span>
                                                            @endif
                                                        </a>
                                                    @endif
                                                    @if (count($places[$i]->female_pig->mix_infos) != 0 &&
                                                            $places[$i]->female_pig->mix_infos->last()->trouble_id == 1 &&
                                                            $places[$i]->female_pig->mix_infos->last()->born_day == null)
                                                        <div class="text-xs ml-2">
                                                            &raquo;&nbsp;{{ $places[$i]->female_pig->mix_infos->last()->elapsed_days }}日
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            @auth
                                                <td class="border text-center px-1 py-0">
                                                    @if (empty($places[$i]->female_pig->individual_num))
                                                        <button wire:click="placeIn({{ $places[$i]->id }})"
                                                            class="basis-1/2 font-medium lg:text-xs xl:text-sm text-cyan-800 hover:underline hover:font-bold">
                                                            入室
                                                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                                        </button>
                                                    @endif
                                                    @if (!empty($places[$i]->female_pig->individual_num))
                                                        <button wire:click="placeOut({{ $places[$i]->id }})"
                                                            class="basis-1/2 font-medium lg:text-xs xl:text-sm text-red-600 hover:underline hover:font-bold">
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
                        <!-- breeding1 - end -->

                        <!-- breeding2 - start -->
                        <div class="overflow-x-auto relative w-full mx-auto">
                            <table class="w-full text-sm text-left text-gray-700 border-2 border-gray-300">
                                <thead class="text-center text-xs text-gray-900 uppercase">
                                    <tr>
                                        <th class="border bg-gray-50 py-2 px-1 w-2/12">
                                            部屋番
                                        </th>
                                        <th class="border bg-gray-50 py-2 px-2 w-6/12">
                                            個体番号
                                        </th>
                                        @auth
                                            <th class="border bg-gray-50 py-2 px-2 w-4/12">入退室</th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < 30; $i++)
                                        <tr class="bg-white">
                                            <td class="border text-center py-3 px-5 lg:px-4">
                                                <div>
                                                    <p class="font-medium text-gray-900">
                                                        {{ $places[$i]->place_num }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td
                                                class="border py-3 px-8 md:px-4 lg:px-2 text-center font-medium whitespace-nowrap
                                                @if (!empty($places[$i]->female_pig->mix_infos->last()->id) && $places[$i]->female_pig->status == '観察中') {{-- 再発1確認 --}}
                                                    {{-- 再発1確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->first_recurrence_schedule &&
                                                            date('Y-m-d', strtotime('-4 day')) < $places[$i]->female_pig->mix_infos->last()->first_recurrence_schedule)
                                                        bg-red-200 @endif
                                                    {{-- 再発2確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule &&
                                                            date('Y-m-d', strtotime('-4 day')) < $places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule) bg-red-300 @endif
                                                    {{-- 出産予定14日前 --}}
                                                    @if (date('Y-m-d', strtotime('+14 day')) > $places[$i]->female_pig->mix_infos->last()->delivery_schedule &&
                                                            date('Y-m-d', strtotime('+7 day')) < $places[$i]->female_pig->mix_infos->last()->delivery_schedule) bg-blue-200 @endif
                                                    {{-- 出産予定7日前 --}}
                                                    @if (date('Y-m-d', strtotime('+7 day')) >= $places[$i]->female_pig->mix_infos->last()->delivery_schedule) bg-blue-300 @endif
                                                    {{-- 再発3確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) >
                                                            date(
                                                                'Y-m-d',
                                                                strtotime('+21day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule))) &&
                                                            date('Y-m-d', strtotime('-4 day')) <
                                                                date(
                                                                    'Y-m-d',
                                                                    strtotime('+21day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)))) bg-red-50 @endif
                                                    {{-- 再発4確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) >
                                                            date(
                                                                'Y-m-d',
                                                                strtotime('+42day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule))) &&
                                                            date('Y-m-d', strtotime('-4 day')) <
                                                                date(
                                                                    'Y-m-d',
                                                                    strtotime('+42day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)))) bg-red-50 @endif
                                                    {{-- 再発5確認 --}}
                                                    @if (date('Y-m-d', strtotime('+3 day')) >
                                                            date(
                                                                'Y-m-d',
                                                                strtotime('+63day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule))) &&
                                                            date('Y-m-d', strtotime('-4 day')) <
                                                                date(
                                                                    'Y-m-d',
                                                                    strtotime('+63day', strtotime($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)))) bg-red-50 @endif
                                                @endif
                                                @if (!empty($places[$i]->female_pig->id) && $places[$i]->female_pig->status == '待機中') {{-- 待機中 --}}
                                                    bg-amber-100 @endif
                                            ">
                                                <div class="flex justify-between items-center">
                                                    @if ($places[$i]->female_pig->id)
                                                        <a class="flex justify-between items-center"
                                                            href="{{ route('female_pigs.show', $places[$i]->female_pig->id) }}">
                                                            {{ $places[$i]->female_pig->individual_num }}
                                                            @if ($places[$i]->female_pig->well_flag == 1)
                                                                <span class="text-amber-300 text-xs ml-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" fill="currentColor"
                                                                        class="w-4 h-4">
                                                                        <path fill-rule="evenodd"
                                                                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 00-.189.866c0 .298.059.605.189.866.108.215.395.634.936.634.54 0 .828-.419.936-.634.13-.26.189-.568.189-.866 0-.298-.059-.605-.189-.866-.108-.215-.395-.634-.936-.634zm4.314.634c.108-.215.395-.634.936-.634.54 0 .828.419.936.634.13.26.189.568.189.866 0 .298-.059.605-.189.866-.108.215-.395.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 01-.189-.866c0-.298.059-.605.189-.866zm2.023 6.828a.75.75 0 10-1.06-1.06 3.75 3.75 0 01-5.304 0 .75.75 0 00-1.06 1.06 5.25 5.25 0 007.424 0z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </span>
                                                            @endif
                                                            @if ($places[$i]->female_pig->unwell_flag == 1)
                                                                <span class="text-cyan-600 text-xs ml-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" fill="currentColor"
                                                                        class="w-4 h-4">
                                                                        <path fill-rule="evenodd"
                                                                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 00-.189.866c0 .298.059.605.189.866.108.215.395.634.936.634.54 0 .828-.419.936-.634.13-.26.189-.568.189-.866 0-.298-.059-.605-.189-.866-.108-.215-.395-.634-.936-.634zm4.314.634c.108-.215.395-.634.936-.634.54 0 .828.419.936.634.13.26.189.568.189.866 0 .298-.059.605-.189.866-.108.215-.395.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 01-.189-.866c0-.298.059-.605.189-.866zm-4.34 7.964a.75.75 0 01-1.061-1.06 5.236 5.236 0 013.73-1.538 5.236 5.236 0 013.695 1.538.75.75 0 11-1.061 1.06 3.736 3.736 0 00-2.639-1.098 3.736 3.736 0 00-2.664 1.098z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </span>
                                                            @endif
                                                            @if ($places[$i]->female_pig->warn_flag == 1)
                                                                <span class="text-red-600 text-xs ml-1">
                                                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                                                </span>
                                                            @endif
                                                            @if ($places[$i]->female_pig->recurrence_flag == 1)
                                                                <span class="text-red-600 text-xs ml-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 24 24" fill="currentColor"
                                                                        class="w-4 h-4">
                                                                        <path
                                                                            d="M13.5 4.06c0-1.336-1.616-2.005-2.56-1.06l-4.5 4.5H4.508c-1.141 0-2.318.664-2.66 1.905A9.76 9.76 0 001.5 12c0 .898.121 1.768.35 2.595.341 1.24 1.518 1.905 2.659 1.905h1.93l4.5 4.5c.945.945 2.561.276 2.561-1.06V4.06zM18.584 5.106a.75.75 0 011.06 0c3.808 3.807 3.808 9.98 0 13.788a.75.75 0 11-1.06-1.06 8.25 8.25 0 000-11.668.75.75 0 010-1.06z" />
                                                                        <path
                                                                            d="M15.932 7.757a.75.75 0 011.061 0 6 6 0 010 8.486.75.75 0 01-1.06-1.061 4.5 4.5 0 000-6.364.75.75 0 010-1.06z" />
                                                                    </svg>
                                                                </span>
                                                            @endif
                                                        </a>
                                                    @endif
                                                    @if (count($places[$i]->female_pig->mix_infos) != 0 &&
                                                            $places[$i]->female_pig->mix_infos->last()->trouble_id == 1 &&
                                                            $places[$i]->female_pig->mix_infos->last()->born_day == null)
                                                        <div class="text-xs ml-2">
                                                            &raquo;&nbsp;{{ $places[$i]->female_pig->mix_infos->last()->elapsed_days }}日
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            @auth
                                                <td class="border text-center px-1 py-0">
                                                    @if (empty($places[$i]->female_pig->individual_num))
                                                        <button wire:click="placeIn({{ $places[$i]->id }})"
                                                            class="basis-1/2 font-medium lg:text-xs xl:text-sm text-cyan-800 hover:underline hover:font-bold">
                                                            入室
                                                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                                        </button>
                                                    @endif
                                                    @if (!empty($places[$i]->female_pig->individual_num))
                                                        <button wire:click="placeOut({{ $places[$i]->id }})"
                                                            class="basis-1/2 font-medium lg:text-xs xl:text-sm text-red-600 hover:underline hover:font-bold">
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
                        <!-- breeding2 - end -->
                    </div>
                </div>
                <!-- breeding - end -->

                <!-- delivery - start -->
                <div>
                    <h2 class="MplusRound text-gray-700 text-2xl lg:text-3xl text-center mb-4">分娩室</h2>

                    <!-- guide - start -->
                    <div class="my-4">
                        <div class="MplusRound px-8 py-2 text-gray-700">凡例</div>
                        <div class="w-full grid grid-cols-2 xl:grid-cols-3 items-center gap-2 xl:gap-1">
                            <p class="border py-2 px-8 text-sm lg:text-xs text-gray-700 text-left bg-blue-200">
                                出産前
                            </p>
                            <p class="border py-2 px-8 text-sm lg:text-xs text-gray-700 text-left bg-amber-50">
                                出産後
                            </p>
                            <p class="border py-2 px-8 text-sm lg:text-xs text-gray-700 text-right">
                                <span class="text-xs ml-2">
                                    &raquo;&nbsp;分娩予定日、分娩日
                                </span>
                            </p>
                        </div>
                    </div>
                    <!-- guide - end -->

                    <div class="grid sm:grid-cols-2 gap-4 sm:gap-2 xl:gap-3">
                        <!-- delivery1 - start -->
                        <div class="overflow-x-auto relative w-full mx-auto">
                            <table class="w-full text-sm text-left text-gray-700 border-2 border-gray-300">
                                <thead class="text-center text-xs text-gray-900 uppercase">
                                    <tr>
                                        <th class="border bg-gray-50 py-2 px-2 w-2/12">
                                            部屋番
                                        </th>
                                        <th class="border bg-gray-50 py-2 px-2 w-6/12">
                                            個体番号
                                        </th>
                                        @auth
                                            <th class="border bg-gray-50 py-2 px-6 w-4/12">入退室</th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 60; $i < 80; $i++)
                                        @if ($i % 2 != 0)
                                            <tr class="bg-white">
                                                <td class="border text-center py-3 px-5 lg:px-4">
                                                    {{-- <td class="border text-center py-3 px-6"> --}}
                                                    <div>
                                                        <p class="font-medium text-gray-900">
                                                            {{ $places[$i]->place_num }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td
                                                    class="border py-3 px-8 md:px-4 lg:px-2 text-center font-medium whitespace-nowrap
                                                    @if ($places[$i]->female_pig->id) {{-- 出産前 --}}
                                                        @if (count($places[$i]->female_pig->mix_infos) != 0 &&
                                                                $places[$i]->female_pig->mix_infos->last()->trouble_id == 1 &&
                                                                $places[$i]->female_pig->mix_infos->last()->born_day == null)
                                                        bg-blue-200 @endif
                                                        {{-- 出産後 --}}
                                                        @if (count($places[$i]->female_pig->mix_infos) != 0 &&
                                                                $places[$i]->female_pig->mix_infos->last()->trouble_id == 1 &&
                                                                $places[$i]->female_pig->mix_infos->last()->born_day != null) bg-amber-50 @endif
                                                    @endif
                                                ">
                                                    <div class="flex justify-between items-center">
                                                        @if ($places[$i]->female_pig->id)
                                                            <a
                                                                href="{{ route('female_pigs.show', $places[$i]->female_pig->id) }}">
                                                                {{ $places[$i]->female_pig->individual_num }}
                                                                @if ($places[$i]->female_pig->warn_flag == 1)
                                                                    <span class="text-red-600 text-xs ml-1">
                                                                        <i
                                                                            class="fa-solid fa-triangle-exclamation"></i>
                                                                    </span>
                                                                @endif
                                                            </a>
                                                        @endif
                                                        @if (count($places[$i]->female_pig->mix_infos) != 0 &&
                                                                $places[$i]->female_pig->mix_infos->last()->trouble_id == 1 &&
                                                                $places[$i]->female_pig->mix_infos->last()->born_day == null)
                                                            <div class="text-xs ml-2">
                                                                &raquo;&nbsp;{{ $places[$i]->female_pig->mix_infos->last()->delivery_date }}日
                                                            </div>
                                                        @endif
                                                        @if (count($places[$i]->female_pig->mix_infos) != 0 &&
                                                                $places[$i]->female_pig->mix_infos->last()->trouble_id == 1 &&
                                                                $places[$i]->female_pig->mix_infos->last()->born_day != null)
                                                            <div class="text-xs ml-2">
                                                                &raquo;&nbsp;{{ $places[$i]->female_pig->mix_infos->last()->born_date }}日
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                @auth
                                                    <td class="border text-center px-1 py-0">
                                                        @if (empty($places[$i]->female_pig->individual_num))
                                                            <button wire:click="placeIn({{ $places[$i]->id }})"
                                                                class="basis-1/2 font-medium lg:text-xs xl:text-sm text-cyan-800 hover:underline hover:font-bold">
                                                                入室
                                                                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                                            </button>
                                                        @endif
                                                        @if (!empty($places[$i]->female_pig->individual_num))
                                                            <button wire:click="placeOut({{ $places[$i]->id }})"
                                                                class="basis-1/2 font-medium lg:text-xs xl:text-sm text-red-600 hover:underline hover:font-bold">
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
                        <!-- delivery1 - end -->

                        <!-- delivery2 - start -->
                        <div class="overflow-x-auto relative w-full mx-auto">
                            <table class="w-full text-sm text-left text-gray-700 border-2 border-gray-300">
                                <thead class="text-center text-xs text-gray-900 uppercase">
                                    <tr>
                                        <th class="border bg-gray-50 py-2 px-2 w-2/12">
                                            部屋番
                                        </th>
                                        <th class="border bg-gray-50 py-2 px-2 w-6/12">
                                            個体番号
                                        </th>
                                        @auth
                                            <th class="border bg-gray-50 py-2 px-6 w-4/12">入退室</th>
                                        @endauth
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 60; $i < 80; $i++)
                                        @if ($i % 2 == 0)
                                            <tr class="bg-white">
                                                <td class="border text-center py-3 px-5 lg:px-4">
                                                    <div>
                                                        <p class="font-medium text-gray-900">
                                                            {{ $places[$i]->place_num }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td
                                                    class="border py-3 px-8 md:px-4 lg:px-2 text-center font-medium whitespace-nowrap
                                                    @if ($places[$i]->female_pig->id) {{-- 出産前 --}}
                                                        @if (count($places[$i]->female_pig->mix_infos) != 0 &&
                                                                $places[$i]->female_pig->mix_infos->last()->trouble_id == 1 &&
                                                                $places[$i]->female_pig->mix_infos->last()->born_day == null)
                                                        bg-blue-200 @endif
                                                        {{-- 出産後 --}}
                                                        @if (count($places[$i]->female_pig->mix_infos) != 0 &&
                                                                $places[$i]->female_pig->mix_infos->last()->trouble_id == 1 &&
                                                                $places[$i]->female_pig->mix_infos->last()->born_day != null) bg-amber-50 @endif
                                                    @endif
                                                ">
                                                    <div class="flex justify-between items-center">
                                                        @if ($places[$i]->female_pig->id)
                                                            <a
                                                                href="{{ route('female_pigs.show', $places[$i]->female_pig->id) }}">
                                                                {{ $places[$i]->female_pig->individual_num }}
                                                                @if ($places[$i]->female_pig->warn_flag == 1)
                                                                    <span class="text-red-600 text-xs ml-1">
                                                                        <i
                                                                            class="fa-solid fa-triangle-exclamation"></i>
                                                                    </span>
                                                                @endif
                                                            </a>
                                                        @endif
                                                        @if (count($places[$i]->female_pig->mix_infos) != 0 &&
                                                                $places[$i]->female_pig->mix_infos->last()->trouble_id == 1 &&
                                                                $places[$i]->female_pig->mix_infos->last()->born_day == null)
                                                            <div class="text-xs ml-2">
                                                                &raquo;&nbsp;{{ $places[$i]->female_pig->mix_infos->last()->delivery_date }}日
                                                            </div>
                                                        @endif
                                                        @if (count($places[$i]->female_pig->mix_infos) != 0 &&
                                                                $places[$i]->female_pig->mix_infos->last()->trouble_id == 1 &&
                                                                $places[$i]->female_pig->mix_infos->last()->born_day != null)
                                                            <div class="text-xs ml-2">
                                                                &raquo;&nbsp;{{ $places[$i]->female_pig->mix_infos->last()->born_date }}日
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                @auth
                                                    <td class="border text-center px-1 py-0">
                                                        @if (empty($places[$i]->female_pig->individual_num))
                                                            <button wire:click="placeIn({{ $places[$i]->id }})"
                                                                class="basis-1/2 font-medium lg:text-xs xl:text-sm text-cyan-800 hover:underline hover:font-bold">
                                                                入室
                                                                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                                            </button>
                                                        @endif
                                                        @if (!empty($places[$i]->female_pig->individual_num))
                                                            <button wire:click="placeOut({{ $places[$i]->id }})"
                                                                class="basis-1/2 font-medium lg:text-xs xl:text-sm text-red-600 hover:underline hover:font-bold">
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
                        <!-- delivery2 - end -->
                    </div>
                </div>
                <!-- delivery - end -->
            </div>
        </div>
    </div>
    @livewireScripts
</div>
