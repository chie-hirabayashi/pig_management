<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('female_pigs.show') }}
        </h2>
    </x-slot>
    <!-- header - end -->


    <div class="bg-white py-4 sm:py-6 lg:py-10">
        <!-- base_information - start -->
        <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
            <!-- message -->
            <x-error-validation :errors="$errors" />
            <x-flash-msg :message="session('notice')" />
            <div class="flex flex-col items-center gap-4 md:gap-6">
                <!-- base - start -->
                <div class="flex items-center mt-6">
                    <div class="text-xl text-rose-800">
                        <i class="fa-solid fa-venus"></i>&ensp;
                    </div>
                    <div class="text-3xl text-gray-500">
                        {{ $femalePig->individual_num }}
                    </div>
                </div>
                <div class="flex max-w-md text-gray-600 lg:text-lg text-center">
                    <div class="mx-2">
                        {{ $femalePig->add_day }}
                    </div>
                    <div class="mx-2">
                        {{ $femalePig->age }}歳
                    </div>
                    <div class="mx-2">
                        @if ($born_infos)
                            @if ($born_infos->last()->rotate_prediction <= 1.8)
                                <span
                                    class="text-red-600 text-base font-medium inline-flex items-center px-2.5 py-0.5 rounded">
                                @elseif ($born_infos->last()->rotate_prediction > 1.8)
                                    <span
                                        class="text-gray-800 text-base font-medium inline-flex items-center px-2.5 py-0.5 rounded">
                            @endif
                        @endif
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                            <path
                                d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                            <path fill-rule="evenodd"
                                d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                        </svg>
                        <div class="ml-2">
                            @if ($born_infos)
                                {{ $born_infos->last()->rotate_prediction }}
                            @endif
                        </div>
                        </span>
                    </div>
                    <div>
                        <form action="{{ route('female_pigs.updateFlag', $femalePig) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="warn_flag" id=""
                                value="{{ $femalePig->warn_flag == 0 ? 1 : 0 }}">
                            <button type="submit">
                                @if ($femalePig->warn_flag == 0)
                                    <div class="text-gray-100">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    </div>
                                @else
                                    <div class="text-red-600">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    </div>
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
                <!-- base - end -->

                <!-- schedule - start -->
                <div class="text-gray-600">
                    <h2 class="text-center">予 定</h2>
                    {{-- @if ($mixInfo_last && empty($mixInfo_last->born_day) && $mixInfo_last->trouble_id == 1) --}}
                    @if ($mixInfos->isNotEmpty())
                        @if ($mixInfos->last()->born_day == null && $mixInfos->last()->trouble_id == 1)
                            <div class="flex">
                                <div class="mr-4">
                                    再発予定日1 : {{ $mixInfos->last()->first_recurrence_schedule }}
                                </div>
                                <div>
                                    {{-- 再発予定3日前から表示 --}}
                                    @if (date('Y-m-d H:i:s', strtotime('+3 day')) > $mixInfos->last()->first_recurrence_schedule &&
                                        $mixInfos->last()->first_recurrence == 0)
                                        <form action="{{ route('female_pigs.updateRecurrence', $femalePig) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="first_recurrence" id=""
                                                value="{{ 1 }}">
                                            <button class="text-red-500" type="submit"
                                                onclick="if(!confirm('再発の確認をしました')){return false};">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <div class="flex">
                                <div class="mr-4">
                                    再発予定日2 : {{ $mixInfos->last()->second_recurrence_schedule }}
                                </div>
                                <div>
                                    {{-- 再発予定3日前から表示 --}}
                                    @if (date('Y-m-d H:i:s', strtotime('+3 day')) > $mixInfos->last()->second_recurrence_schedule &&
                                        $mixInfos->last()->second_recurrence == 0)
                                        <form action="{{ route('female_pigs.updateRecurrence', $femalePig) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="second_recurrence" id=""
                                                value="{{ 1 }}">
                                            <button class="text-red-500" type="submit"
                                                onclick="if(!confirm('再発の確認をしました')){return false};">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <div>出産予定日&ensp; : {{ $mixInfos->last()->delivery_schedule }}</div>
                        @endif
                    @endif
                </div>
                <!-- schedule - end -->

                <!-- border - start -->
                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-center text-xs text-gray-900 uppercase">
                            <tr class="whitespace-nowrap">
                                <th scope="col" class="py-3 px-4 lg:px-6"></th>
                                <th scope="col" class="py-3 px-4 lg:px-6">
                                    直近
                                </th>
                                <th scope="col" class="py-3 px-4 lg:px-6">
                                    前回
                                </th>
                                <th scope="col" class="py-3 px-4 lg:px-6">
                                    平均
                                </th>
                            </tr>
                        </thead>
                        <tbody class="border-t border-b">
                            <tr class="bg-white">
                                <th scope="row"
                                    class="py-3 px-4 lg:px-6 font-medium text-gray-900 whitespace-nowrap">
                                    回転数
                                </th>
                                <td class="text-center py-3 px-4 lg:px-6">
                                    @if ($born_infos && !empty($born_infos->last()->rotate))
                                        {{ $born_infos->last()->rotate }} 回
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center py-3 px-4 lg:px-6">
                                    @if ($born_infos && !empty($born_infos[count($born_infos) - 2]))
                                        {{ $born_infos[count($born_infos) - 2]->rotate }} 回
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center py-3 px-4 lg:px-6">
                                    @if ($born_infos && !empty($born_infos->last()->rotate))
                                        {{ round($born_infos->avg('rotate'), 2) }} 回
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <th scope="row"
                                    class="py-3 px-4 lg:px-6 font-medium text-gray-900 whitespace-nowrap">
                                    産子数
                                </th>
                                <td class="text-center py-3 px-4 lg:px-6">
                                    @if ($born_infos && !empty($born_infos->last()))
                                        {{ $born_infos->last()->born_num }} 匹
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center py-3 px-4 lg:px-6">
                                    @if ($born_infos && !empty($born_infos[count($born_infos) - 2]))
                                        {{ $born_infos[count($born_infos) - 2]->born_num }} 匹
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center py-3 px-4 lg:px-6">
                                    @if ($born_infos && !empty($born_infos->last()))
                                        {{ round($born_infos->avg('born_num'), 2) }} 匹
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-center text-xs text-gray-900 uppercase">
                            <tr>
                                <th scope="col" class="py-3 px-4 lg:px-6"></th>
                                <th scope="col" class="py-3 px-4 lg:px-6">
                                    過去1年
                                </th>
                                <th scope="col" class="py-3 px-4 lg:px-6">
                                    合計
                                </th>
                                <th scope="col" class="py-3 px-8 lg:px-12">
                                    &emsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody class="border-t border-b">
                            <tr class="bg-white">
                                <th scope="row"
                                    class="py-3 px-4 lg:px-6 font-medium text-gray-900 whitespace-nowrap">
                                    出産回数
                                </th>
                                <td class="text-center py-3 px-4 lg:px-6">
                                    @if ($born_infos && !empty($born_infos->last()))
                                        {{ $born_infos->last()->count_lastYearBorn }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                                <td class="text-center py-3 px-4 lg:px-6">
                                    @if ($born_infos && !empty($born_infos->last()))
                                        {{ $born_infos->last()->count_allBorn }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                                <td class="text-center py-3 px-8 lg:px-12">
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <th scope="row"
                                    class="py-3 px-4 lg:px-6 font-medium text-gray-900 whitespace-nowrap">
                                    再発回数
                                </th>
                                <td class="text-center py-3 px-4 lg:px-6">
                                    @if ($mixInfos->isNotEmpty())
                                        {{ $mixInfos->last()->count_lastYear_recurrences }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                                <td class="text-center py-3 px-4 lg:px-6">
                                    @if ($mixInfos->isNotEmpty())
                                        {{ $mixInfos->last()->count_recurrences }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                                <td class="text-center py-3 px-8 lg:px-12">
                                </td>
                            </tr>
                            <tr class="bg-white">
                                <th scope="row"
                                    class="py-3 px-4 lg:px-6 font-medium text-gray-900 whitespace-nowrap">
                                    流産回数
                                </th>
                                <td class="text-center py-3 px-4 lg:px-6">
                                    @if ($mixInfos->isNotEmpty())
                                        {{ $mixInfos->last()->count_lastYear_abortions }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                                <td class="text-center py-3 px-4 lg:px-6">
                                    @if ($mixInfos->isNotEmpty())
                                        {{ $mixInfos->last()->count_abortions }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                                <td class="text-center py-3 px-8 lg:px-12">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="overflow-x-auto relative">
                    <table class="table w-full text-sm text-left text-gray-500">
                        <thead class="text-center text-xs text-gray-900 uppercase">
                            <tr>
                                <th scope="col" class="py-3 px-4 lg:px-6">
                                    交配実績
                                </th>
                                <th scope="col" class="py-3 px-4 lg:px-6">
                                    <i class="fa-solid fa-mars"></i>
                                    NO.
                                </th>
                                <th scope="col" class="py-3 px-4 lg:px-6">
                                    交配回数
                                </th>
                                <th scope="col" class="py-3 px-4 lg:px-6">
                                    交配成功率
                                </th>
                            </tr>
                        </thead>
                        <tbody class="border-t border-b">
                            @foreach ($mix_ranking as $item)
                                <tr class="bg-white">
                                    <th scope="row"
                                        class="py-3 px-4 lg:px-6 font-medium text-gray-900 whitespace-nowrap">
                                    </th>
                                    <td class="py-3 px-4 lg:px-6">
                                        {{ $item['male'] }}
                                    </td>
                                    <td class="py-3 px-4 lg:px-6">
                                        {{ $item['mix_all'] }} 回
                                    </td>
                                    <td class="py-3 px-4 lg:px-6">
                                        ({{ $item['mix_probability'] }} %)
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- border - end -->

                <!-- edit & delete - start -->
                <div class="flex flex-row text-center my-4">
                    {{-- @can('update', $post) --}}
                    <a href="{{ route('female_pigs.edit', $femalePig) }}" {{-- class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2"> --}} {{-- class="bg-cyan-800 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2"> --}}
                        class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-cyan-800 font-medium border-gray-200 hover:text-white text-cyan-600 hover:border-cyan-700 rounded-lg hover:bg-cyan-700 disabled:opacity-50">
                        編 集
                    </a>
                    {{-- @endcan --}}
                    {{-- @can('delete', $post) --}}
                    <form action="{{ route('female_pigs.destroy', $femalePig) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="廃 用" onclick="if(!confirm('廃用にしますか？')){return false};"
                            class="py-1.5 px-4 transition-colors bg-gray-50 border active:bg-red-700 font-medium border-gray-200 hover:text-white text-red-600 hover:border-red-600 rounded-lg hover:bg-red-600 disabled:opacity-50">
                    </form>
                </div>
                <!-- edit & delete - end -->
            </div>
        </div>
        <!-- base_information - end -->
    </div>


    <!-- born_information - start -->
    <div class="overflow-x-auto relative shadow-md my-8">
        <div class="flex h-10 whitespace-nowrap justify-between">
            <div class="flex h-10 whitespace-nowrap">
                <div class="MplusRound text-xl font-medium text-gray-600 py-1 px-8">出 産 情 報</div>
                <div class="px-4 leading-10">
                    {{-- @can('update', $post) --}}
                    @if ($mixInfos->isNotEmpty())
                        @if ($born_infos->isEmpty() || $mixInfos->last()->id !== $born_infos->last()->mix_id)
                            <a href="{{ route('born_infos.create', $mixInfos->last()) }}"
                                class="text-sky-700 after:content-['_↗'] text-base px-3 transition-colors bg-transparent rounded-lg hover:underline hover:font-bold">
                                出産登録
                            </a>
                        @endif
                    @endif
                    {{-- @endcan --}}
                </div>
            </div>
            <div class="mx-6 text-sm text-gray-700 leading-10">
                <p>離乳記録は
                    <span class="font-semibold text-cyan-800 ">
                        編 集
                    </span>
                から記録します。</p>
            </div>
        </div>
        <!-- born_table - start -->
        <table class="w-full text-sm text-left text-gray-500 border-t border-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr class="border-b whitespace-nowrap">
                    <th scope="col" class="py-3 pr-4 pl-8 w-1/6">
                        出産日
                    </th>
                    <th scope="col" class="py-3 px-4 w-1/12 text-center">
                        出産子数
                    </th>
                    <th scope="col" class="py-3 px-4 w-1/12 text-center">
                        <i class="fa-solid fa-mars"></i>1_NO.
                    </th>
                    <th scope="col" class="py-3 px-4 w-1/12 text-center">
                        <i class="fa-solid fa-mars"></i>2_NO.
                    </th>
                    <th scope="col" class="py-3 px-4 w-1/12 text-center">
                        回転数
                    </th>
                    <th scope="col" class="py-3 px-4 w-1/6 text-center">
                        離乳日
                    </th>
                    <th colspan="3" scope="col" class="py-3 pl-6 pr-4">
                        離乳子数
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($born_infos as $born_info)
                    @if ($born_info->born_num)
                    <tr class="bg-white border-b hover:bg-gray-50 whitespace-nowrap">
                        <td class="py-4 pr-4 pl-6 w-1/6">
                            {{ $born_info->born_day }}
                        </td>
                        <td class="py-4 px-4 w-1/12 text-center">
                            {{ empty($born_info->born_num) ? '' : $born_info->born_num . '匹' }}
                        </td>
                        <td class="py-4 px-4 w-1/12 text-center">
                            {{ $born_info->first_male }}
                            <p class="line-through">
                                {{ $born_info->first_delete_male }}
                            </p>
                        </td>
                        <td class="py-4 px-4 w-1/12 text-center">
                            @if ($born_info->second_male == null && $born_info->second_delete_male == null)
                                -
                            @else
                                {{ $born_info->second_male }}
                                <p class="line-through">
                                    {{ $born_info->second_delete_male }}
                                </p>
                            @endif
                        </td>
                        <td class="py-4 px-4 w-1/12 text-center">
                            {{ empty($born_info->rotate) ? '' : $born_info->rotate . '回' }}
                        </td>
                        <td class="py-4 px-4 w-1/6 text-center">
                            {{ $born_info->weaning_day }}
                        </td>
                        <td class="py-4 px-4 w-1/12 text-center">
                            {{ empty($born_info->weaning_num) ? '' : $born_info->weaning_num . '匹' }}
                        </td>
                        <td class="text-center py-4 px-4 w-1/12">
                            <a href="{{ route('born_infos.edit', $born_info) }}"
                                class="text-center basis-1/2 font-medium text-cyan-800 hover:underline hover:font-bold">
                                編 集
                            </a>
                        </td>
                        <td class="py-4 pr-6 w-1/12">
                            <form action="{{ route('born_infos.destroy', $born_info) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <input type="submit" value="削 除"
                                    onclick="if(!confirm('出産情報を削除しますか？')){return false};"
                                    class="basis-1/2 font-medium text-red-600 hover:underline hover:font-bold">
                            </form>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <!-- born_table - end -->
    </div>
    <!-- born_information - end -->

    <div class="container lg:w-3/4 md:w-4/5 w-full mx-auto my-10 lg:px-8 lg:py-4">
        <canvas id="myChart"></canvas>
    </div>

    <div class="overflow-x-auto relative shadow-md my-8">
        <div class="flex h-10 whitespace-nowrap justify-between">
            <div class="flex h-10 whitespace-nowrap">
                <div class="MplusRound text-xl font-medium text-gray-600 py-1 px-8">交 配 記 録</div>
                <div class="px-4 leading-10">
                    {{-- @can('update', $post) --}}
                    <a href="{{ route('female_pigs.mix_infos.create', $femalePig) }}"
                        class="text-sky-700 after:content-['_↗'] text-base py-1 px-3 transition-colors bg-transparent rounded-lg hover:underline hover:font-bold">
                        交配登録
                    </a>
                    {{-- @endcan --}}
                </div>
            </div>
            <div class="mx-6 text-sm text-gray-700 leading-10">
                <p>再発、流産は
                    <span class="font-semibold text-cyan-800 ">
                        編 集
                    </span>
                から記録します。</p>
            </div>
        </div>

        <!-- mix_table - start -->
        <table class="w-full text-sm text-left text-gray-500 border-t border-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr class="border-b whitespace-nowrap">
                    <th scope="col" class="py-3 pr-4 pl-8 w-1/6">
                        交配日
                    </th>
                    <th scope="col" class="py-3 px-6 w-1/12 text-center">
                        <i class="fa-solid fa-mars"></i>1_NO.
                    </th>
                    <th scope="col" class="py-3 px-6 w-1/12 text-center">
                        <i class="fa-solid fa-mars"></i>2_NO.
                    </th>
                    <th scope="col" class="py-3 px-6 w-1/6 text-center">
                        再発予定日1
                    </th>
                    <th scope="col" class="py-3 px-6 w-1/6 text-center">
                        再発予定日2
                    </th>
                    <th scope="col" class="py-3 px-6 w-1/6 text-center">
                        出産予定日
                    </th>
                    <th colspan="3" scope="col" class="py-3 pr-4 pl-8 w-1/12">
                        経 過
                    </th>
                    {{-- <th scope="col" class="py-3 px-6"></th> --}}
                </tr>
            </thead>
            <tbody>
                @if ($mixInfos)
                    @foreach ($mixInfos as $mixInfo)
                        <tr
                            class="bg-white border-b hover:bg-gray-50 whitespace-nowrap">
                            <td class="py-4 px-6">
                                {{ $mixInfo->mix_day }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ $mixInfo->first_male }}
                                <p class="line-through">
                                    {{ $mixInfo->first_delete_male }}
                                </p>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if ($mixInfo->second_male == null && $mixInfo->second_delete_male == null)
                                    -
                                @else
                                    {{ $mixInfo->second_male }}
                                    <p class="line-through">
                                        {{ $mixInfo->second_delete_male }}
                                    </p>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ $mixInfo->first_recurrence_schedule }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ $mixInfo->second_recurrence_schedule }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ $mixInfo->delivery_schedule }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ $mixInfo->trouble_id == 2 ? '再発' : ($mixInfo->trouble_id == 3 ? '流産' : '') }}
                            </td>
                            @if ($mixInfo->first_delete_male == null && $mixInfo->second_delete_male == null)
                                <td class="flex flex-row items-center py-4 px-6">
                                    <a href="{{ route('female_pigs.mix_infos.edit', [$femalePig, $mixInfo]) }}"
                                        class="mr-2 basis-1/2 font-medium text-cyan-800 hover:underline hover:font-bold">
                                        編 集
                                    </a>
                                    <form
                                        action="{{ route('female_pigs.mix_infos.destroy', [$femalePig, $mixInfo]) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="削 除"
                                            onclick="if(!confirm('交配記録を削除しますか？')){return false};"
                                            class="basis-1/2 font-medium text-red-600 hover:underline hover:font-bold">
                                    </form>
                                </td>
                            @else
                                <td class="flex flex-row items-center py-4 px-6">
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <!-- mix_table - end -->
    </div>
    <div class="flex flex-col items-center gap-4 md:gap-6">
        <a href="javascript:history.back()"
            class="py-1.5 px-4 mb-10 transition-colors bg-transparent active:bg-gray-200 font-medium text-slate-600 rounded-lg hover:bg-gray-100 disabled:opacity-50">
            <i class="fa-solid fa-arrow-left"></i>
            戻る
        </a>
    </div>
    {{-- <div class="text-right">TODO:抽出画面に戻るボタンフラグ作業後に1回で戻る
        <a href="#" onclick="history.back(-1);return false;">back-1戻る</a>
        <a href="#" onclick="history.back();return false;">back戻る</a>
        <a href="javascript:history.back()"
            class="py-1.5 px-4 transition-colors bg-transparent active:bg-gray-200 font-medium text-blue-600 rounded-lg hover:bg-gray-100 disabled:opacity-50">
            前に戻る
        </a>
        <a href="{{ route('extracts.index') }}">route戻るNG</a>
        <button onclick="location.href='/extracts'">location戻るNG</button>
        <input value="前に戻る" onclick="history.back();" type="button">
        <input type="button" value="リファラ表示" onclick="alert( document.referrer );" />
        <input type="button" value="referrer戻るNG" onclick="location.href=document.referrer" />
        <button id="btn--back" class="rounded-md bg-gray-800 text-white px-4 py-2">戻る</button>
    </div> --}}

    <!-- script - start -->
    <script>
        window.Laravel = {};
        window.Laravel.bornInfos = @json($born_infos);
        window.Laravel.mixInfos = @json($mixInfos);

        Data = [];
        // for (var i = 0; i < window.Laravel.bornInfos.length; i++) {
        for (var i = 0; i < window.Laravel.mixInfos.length; i++) {
            Data[i] = {
                x: window.Laravel.mixInfos[i].trouble_day,
                y: window.Laravel.mixInfos[i].trouble_id
            };
        }
        console.log(Data);
    </script>
    {{-- <script src="{{ mix('js/chartjs.js') }}"></script> --}}
    <script src="{{ asset('js/chartjs.js') }}"></script>
    <!-- script - end -->
</x-app-layout>
