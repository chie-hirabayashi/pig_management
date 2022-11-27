<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('female_pigs.show') }}
        </h2>
    </x-slot>
    <!-- header - end -->
TODO:相性機能
    <!-- message -->
    <x-error-validation :errors="$errors" />
    <x-flash-msg :message="session('notice')" />

    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <!-- base_information - start -->
        <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
            <div class="flex flex-col items-center gap-4 md:gap-6">
                <!-- base - start -->
                <div class="flex items-center">
                    <div class="text-xl text-rose-400">
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
                                    <div class="text-red-500">
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
                    @if ($mixInfo && empty($mixInfo->born_day) && $mixInfo->trouble_id == 1)
                        <div class="flex">
                            <div class="mr-4">
                                再発予定日1 : {{ $mixInfo->first_recurrence_schedule }}
                            </div>
                            <div>
                                {{-- 再発予定3日前から表示 --}}
                                @if (date('Y-m-d H:i:s', strtotime('+3 day')) > $mixInfo->first_recurrence_schedule &&
                                    $mixInfo->first_recurrence == 0)
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
                                再発予定日2 : {{ $mixInfo->second_recurrence_schedule }}
                            </div>
                            <div>
                                {{-- 再発予定3日前から表示 --}}
                                @if (date('Y-m-d H:i:s', strtotime('+3 day')) > $mixInfo->second_recurrence_schedule &&
                                    $mixInfo->second_recurrence == 0)
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
                        <div>出産予定日&ensp; : {{ $mixInfo->delivery_schedule }}</div>
                    @endif
                </div>
                <!-- schedule - end -->

                <!-- border - start -->
                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-center border-t text-xs text-gray-900 uppercase dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6"></th>
                                <th scope="col" class="py-3 px-6">
                                    直近
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    前回
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    平均
                                </th>
                            </tr>
                        </thead>
                        <tbody class="border-t border-b">
                            <tr class="bg-white dark:bg-gray-800">
                                <th scope="row"
                                    class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    回転数
                                </th>
                                <td class="text-center py-3 px-6">
                                    @if ($born_info)
                                        @if ($born_info->rotate !== null)
                                            {{ $born_info->rotate }} 回
                                        @else
                                            -
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center py-3 px-6">
                                    @if ($born_info_last_time)
                                        {{ $born_info_last_time->rotate }} 回
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center py-3 px-6">
                                    @if ($born_info)
                                        @if ($born_info->av_rotate !== null)
                                            {{ $born_info->av_rotate }} 回
                                        @else
                                            -
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-gray-800">
                                <th scope="row"
                                    class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    産子数
                                </th>
                                <td class="text-center py-3 px-6">
                                    @if ($born_info)
                                        {{ $born_info->born_num }} 匹
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center py-3 px-6">
                                    @if ($born_info_last_time)
                                        {{ $born_info_last_time->born_num }} 匹
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center py-3 px-6">
                                    @if ($born_info)
                                        {{ $born_info->av_born_num }} 匹
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        <thead class="text-center text-xs text-gray-900 uppercase dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6"></th>
                                <th scope="col" class="py-3 px-6">
                                    過去1年
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    合計
                                </th>
                            </tr>
                        </thead>
                        <tbody class="border-t border-b">
                            <tr class="bg-white dark:bg-gray-800">
                                <th scope="row"
                                    class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    出産回数
                                </th>
                                <td class="text-center py-3 px-6">
                                    @if ($born_info)
                                        {{ $born_info->count_lastY_born }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                                <td class="text-center py-3 px-6">
                                    @if ($born_info)
                                        {{ $born_info->count_born }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-gray-800">
                                <th scope="row"
                                    class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    再発回数
                                </th>
                                <td class="text-center py-3 px-6">
                                    @if ($mixInfo)
                                        {{ $mixInfo->lastYsum_recurrences }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                                <td class="text-center py-3 px-6">
                                    @if ($mixInfo)
                                        {{ $mixInfo->sum_recurrence }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-gray-800">
                                <th scope="row"
                                    class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    流産回数
                                </th>
                                <td class="text-center py-3 px-6">
                                    @if ($mixInfo)
                                        {{ $mixInfo->lastYsum_abortions }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                                <td class="text-center py-3 px-6">
                                    @if ($mixInfo)
                                        {{ $mixInfo->sum_abortion }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        <thead class="text-center text-xs text-gray-900 uppercase dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    組み合わせ
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    NO.1
                                    <i class="fa-solid fa-mars"></i>
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    NO.2
                                    <i class="fa-solid fa-mars"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="border-t border-b">
                            <tr class="bg-white dark:bg-gray-800">
                                <th scope="row"
                                    class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Good
                                </th>
                                <td class="py-3 px-6">
                                    {{ $good_oders[0]['male'] }}
                                    ({{ $good_oders[0]['mix_probability'] }}%)
                                </td>
                                <td class="py-3 px-6">
                                    {{ $good_oders[1]['male'] }}
                                    ({{ $good_oders[1]['mix_probability'] }}%)
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-gray-800">
                                <th scope="row"
                                    class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Bad
                                </th>
                                <td class="py-3 px-6">
                                    {{ $bad_oders[0]['male'] }}
                                    ({{ $bad_oders[0]['mix_probability'] }}%)
                                </td>
                                <td class="py-3 px-6">
                                    {{ $bad_oders[1]['male'] }}
                                    ({{ $bad_oders[1]['mix_probability'] }}%)
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- border - end -->

                <!-- edit & delete - start -->
                <div class="flex flex-row text-center my-4">
                    {{-- @can('update', $post) --}}
                    <a href="{{ route('female_pigs.edit', $femalePig) }}"
                        class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">
                        編 集
                    </a>
                    {{-- @endcan --}}
                    {{-- @can('delete', $post) --}}
                    <form action="{{ route('female_pigs.destroy', $femalePig) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="廃 用" onclick="if(!confirm('廃用にしますか？')){return false};"
                            class="bg-pink-400 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">
                    </form>
                </div>
                <!-- edit & delete - end -->
            </div>
        </div>
        <!-- base_information - end -->
    </div>


    {{-- <div class="overflow-x-auto relative shadow-md sm:rounded-lg my-8"> --}}
    <!-- ranking - start -->
    <div class="overflow-x-auto relative shadow-md my-8">
        <div
            class="flex h-10 bg-gray-100 border-b border-gray-400 dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
            <div class="MplusRound text-xl font-medium text-gray-600 py-2 px-8">交 配 実 績</div>
        </div>
        <!-- table - start -->
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="border-b whitespace-nowrap">
                    <th scope="col" class="py-3 px-6">
                        <i class="fa-solid fa-mars"></i>NO.
                    </th>
                    <th scope="col" class="py-3 px-6">
                        交配回数
                    </th>
                    <th scope="col" class="py-3">
                        交配成功率
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($good_oders as $oder)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 whitespace-nowrap">
                        <td class="py-4 px-6">
                            {{ $oder['male'] }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $oder['mix_all'] }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $oder['mix_probability'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- born_table - end -->
    </div>
    <!-- ranking_information - end -->

    <!-- born_information - start -->
    <div class="overflow-x-auto relative shadow-md my-8">
        <div
            class="flex h-10 bg-gray-100 border-b border-gray-400 dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
            <div class="MplusRound text-xl font-medium text-gray-600 py-2 px-8">出 産 情 報</div>
            <div class="px-4 leading-10">
                {{-- @can('update', $post) --}}
                @if ($mixInfo)
                    <a href="{{ route('born_infos.create', $mixInfo) }}"
                        class="text-blue-600 after:content-['_↗'] text-base dark:text-blue-500 py-1 px-3 transition-colors bg-transparent rounded-lg hover:bg-white">
                        新規登録
                    </a>
                @endif
                {{-- @endcan --}}
            </div>
        </div>
        <!-- born_table - start -->
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="border-b whitespace-nowrap">
                    <th scope="col" class="py-3 px-6">
                        出産日
                    </th>
                    <th scope="col" class="py-3 px-6">
                        出産子数
                    </th>
                    <th scope="col" class="py-3 px-6">
                        <i class="fa-solid fa-mars"></i>1_NO.
                    </th>
                    <th scope="col" class="py-3 px-6">
                        <i class="fa-solid fa-mars"></i>2_NO.
                    </th>
                    <th scope="col" class="py-3 px-6">
                        回転数
                    </th>
                    <th scope="col" class="py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($born_infos as $born_info)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 whitespace-nowrap">
                        <td class="py-4 px-6">
                            {{ $born_info->born_day }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $born_info->born_num }} 匹
                        </td>
                        <td class="py-4 px-6">
                            {{ $born_info->first_male }}
                            <p class="line-through">
                                {{ $born_info->first_delete_male }}
                            </p>
                        </td>
                        <td class="py-4 px-6">
                            @if ($born_info->second_male == null && $born_info->second_delete_male == null)
                                -
                            @else
                                {{ $born_info->second_male }}
                                <p class="line-through">
                                    {{ $born_info->second_delete_male }}
                                </p>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            {{ $born_info->rotate }} 回
                        </td>
                        {{-- <td class="flex flex-row items-center py-4 px-6 space-x-3"> --}}
                        <td class="flex flex-row items-center py-4 px-6">
                            <a href="{{ route('born_infos.edit', $born_info) }}"
                                class="basis-1/2 font-medium text-blue-600 dark:text-blue-500 hover:underline">編 集</a>
                            <form action="{{ route('born_infos.destroy', $born_info) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <input type="submit" value="削 除"
                                    onclick="if(!confirm('出産情報を削除しますか？')){return false};"
                                    class="basis-1/2 font-medium text-red-600 dark:text-red-500 hover:underline">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- born_table - end -->
    </div>
    <!-- born_information - end -->

    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-10 px-8 py-4 dark:bg-gray-800">
        <canvas id="myChart"></canvas>
    </div>

    <div class="overflow-x-auto relative shadow-md my-8">
        <div
            class="flex h-10 bg-gray-100 border-b border-gray-400 dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
            <div class="MplusRound text-xl font-medium text-gray-600 py-2 px-8">交 配 記 録</div>
            <div class="px-4 leading-10">
                {{-- @can('update', $post) --}}
                @if ($mixInfo)
                    <a href="{{ route('female_pigs.mix_infos.create', $femalePig) }}"
                        class="text-blue-600 after:content-['_↗'] text-base dark:text-blue-500 py-1 px-3 transition-colors bg-transparent rounded-lg hover:bg-white">
                        新規登録
                    </a>
                @endif
                {{-- @endcan --}}
            </div>
        </div>
        {{-- <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-8"> --}}
        <!-- mix_table - start -->
        {{-- <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400"> --}}
        {{-- <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"> --}}
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="border-b whitespace-nowrap">
                    <th scope="col" class="py-3 px-6">
                        交配日
                    </th>
                    <th scope="col" class="py-3 px-6">
                        <i class="fa-solid fa-mars"></i>1_NO.
                    </th>
                    <th scope="col" class="py-3 px-6">
                        <i class="fa-solid fa-mars"></i>2_NO.
                    </th>
                    <th scope="col" class="py-3 px-6">
                        再発予定日1
                    </th>
                    <th scope="col" class="py-3 px-6">
                        再発予定日2
                    </th>
                    <th scope="col" class="py-3 px-6">
                        出産予定日
                    </th>
                    <th scope="col" class="py-3 px-6">
                        経 過
                    </th>
                    <th scope="col" class="py-3 px-6"></th>
                </tr>
            </thead>
            <tbody>
                @if ($mixInfos)
                    @foreach ($mixInfos as $mixInfo)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 whitespace-nowrap">
                            <td class="py-4 px-6">
                                {{ $mixInfo->mix_day }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $mixInfo->first_male }}
                                <p class="line-through">
                                    {{ $mixInfo->first_delete_male }}
                                </p>
                            </td>
                            <td class="py-4 px-6">
                                @if ($mixInfo->second_male == null && $mixInfo->second_delete_male == null)
                                    -
                                @else
                                    {{ $mixInfo->second_male }}
                                    <p class="line-through">
                                        {{ $mixInfo->second_delete_male }}
                                    </p>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                {{ $mixInfo->first_recurrence_schedule }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $mixInfo->second_recurrence_schedule }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $mixInfo->delivery_schedule }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $mixInfo->trouble_id == 2 ? '再発' : ($mixInfo->trouble_id == 3 ? '流産' : '') }}
                            </td>
                            <td class="flex flex-row items-center py-4 px-6">
                                @if ($mixInfo->first_delete_male == null && $mixInfo->second_delete_male == null)
                                    <a href="{{ route('female_pigs.mix_infos.edit', [$femalePig, $mixInfo]) }}"
                                        {{-- class="font-medium text-blue-600 dark:text-blue-500 hover:underline">編 集</a> --}}
                                        class="basis-1/2 font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        編 集
                                    </a>
                                    <form
                                        action="{{ route('female_pigs.mix_infos.destroy', [$femalePig, $mixInfo]) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="削 除"
                                            onclick="if(!confirm('交配記録を削除しますか？')){return false};"
                                            class="basis-1/2 font-medium text-red-600 dark:text-red-500 hover:underline">
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <!-- mix_table - end -->
    </div>
    <div class="mt-2 mx-6 my-6 text-gray-700 text-right">
        <p>再発、流産は編集から記録できます。交配オスが廃用になった交配記録は修正、削除できません。</p>
    </div>
    <div class="text-right">TODO:抽出画面に戻るボタンフラグ作業後に1回で戻る
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
    </div>

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
    <script src="{{ mix('js/chartjs.js') }}"></script>
    <!-- script - end -->
</x-app-layout>
