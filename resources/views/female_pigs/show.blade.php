<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('female_pigs.show') }}
        </h2>
    </x-slot>
    <!-- header - end -->

    <!-- validation - start -->
    <x-error-validation :errors="$errors" />
    <x-flash-msg :message="session('notice')" />
    <!-- validation - end -->

    <!-- body - start -->
    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <!-- base_information - start -->
        <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
            <div class="flex flex-col items-center gap-4 md:gap-6">
                <!-- base - start -->
                <div class="text-3xl text-gray-500 active:text-gray-600 transition duration-100">
                    <div class="w-auto h-6 sm:h-8" width="173" height="39" viewBox="0 0 173 39" fill="currentColor">
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
                        {{-- {{ $femalePig->warn_flag }} --}}
                        @if ($femalePig->warn_flag == 0)
                            <div class="text-gray-100">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                        @else
                            <div class="text-red-500">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                {{-- <i class="fa-solid fa-circle-exclamation"></i> --}}
                                {{-- <i class="fa-solid fa-piggy-bank"></i> --}}
                            </div>
                        @endif
                    </div>
                    <div>
                        <form action="{{ route('female_pigs.updateFlag', $femalePig) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="warn_flag" id=""
                                value="{{ $femalePig->warn_flag == 0 ? 1 : 0 }}">
                            <input type="submit" value="フラグ">
                        </form>
                    </div>
                </div>
                <div>
                    <h2>予定</h2>
                    @if ( $mixInfo && empty($mixInfo->born_day))
                        <div class="flex">
                            <div class="mr-4">再発予定日1 : {{ $mixInfo->first_recurrence_schedule }}
                            </div>
                            <div>
                                {{-- 再発予定3日前から表示 --}}
                                {{-- @if (date('Y-m-d H:i:s', strtotime('+3 day')) > $mixInfo->first_recurrence_schedule && --}}
                                @if (date('Y-m-d', strtotime('+3 day')) > $mixInfo->delivery_schedule &&
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
                            <div class="mr-4">再発予定日2 : {{ $mixInfo->second_recurrence_schedule }}
                            </div>
                            <div>
                                {{-- 再発予定3日前から表示 --}}
                                {{-- @if (date('Y-m-d H:i:s', strtotime('+3 day')) > $mixInfo->second_recurrence_schedule && --}}
                                @if (date('Y-m-d', strtotime('+3 day')) > $mixInfo->delivery_schedule &&
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
                        <p>出産予定日&ensp; : {{ $mixInfo->delivery_schedule }}</p>
                    @endif
                </div>
                <!-- base - end -->

                <!-- border - start -->
                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="border-t text-xs text-gray-900 uppercase dark:text-gray-400">
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
                                <td class="py-3 px-6">
                                    @if ($born_info)
                                        @if ($born_info->rotate !== null)
                                            {{ $born_info->rotate }}
                                        @else
                                            -
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-3 px-6">
                                    @if ($born_info_last_time)
                                        {{ $born_info_last_time->rotate }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-3 px-6">
                                    @if ($born_info)
                                        @if ($born_info->av_rotate !== null)
                                            {{ $born_info->av_rotate }}
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
                                <td class="py-3 px-6">
                                    @if ($born_info)
                                        {{ $born_info->born_num }} 匹
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-3 px-6">
                                    @if ($born_info_last_time)
                                        {{ $born_info_last_time->born_num }} 匹
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-3 px-6">
                                    @if ($born_info)
                                        {{ $born_info->av_born_num }} 匹
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        <thead class="text-xs text-gray-900 uppercase dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">

                                </th>
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
                                <td class="py-3 px-6">
                                    @if ($born_info)
                                        {{ $born_info->count_lastY_born }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                                <td class="py-3 px-6">
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
                                <td class="py-3 px-6">
                                    @if ($mixInfo)
                                        {{ $mixInfo->lastYsum_recurrences }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                                <td class="py-3 px-6">
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
                                <td class="py-3 px-6">
                                    @if ($mixInfo)
                                        {{ $mixInfo->lastYsum_abortions }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                                <td class="py-3 px-6">
                                    @if ($mixInfo)
                                        {{ $mixInfo->sum_abortion }} 回
                                    @else
                                        0 回
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        <thead class="text-xs text-gray-900 uppercase dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">

                                </th>
                                <th scope="col" class="py-3 px-6">
                                    NO.1
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    NO.2
                                </th>
                            </tr>
                        </thead>
                        <tbody class="border-t border-b">
                            <tr class="bg-white dark:bg-gray-800">
                                <th scope="row"
                                    class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    良い組み合わせ
                                </th>
                                <td class="py-3 px-6">
                                    100-0
                                </td>
                                <td class="py-3 px-6">
                                    102-0
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-gray-800">
                                <th scope="row"
                                    class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    悪い組み合わせ
                                </th>
                                <td class="py-3 px-6">
                                    100-0
                                </td>
                                <td class="py-3 px-6">
                                    102-0
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- border - end -->

                <!-- edit&delete - start -->
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
                <!-- edit&delete - end -->

                <!-- quote - start -->
                <div class="flex flex-col sm:flex-row items-center gap-2 md:gap-3">
                    <div>
                        <div class="text-indigo-500 text-sm md:text-base font-bold text-center sm:text-left">John
                            McCulling</div>
                        <p class="text-gray-500 text-sm md:text-sm text-center sm:text-left">CEO / Datadrift</p>
                    </div>
                </div>
                <!-- quote - end -->
            </div>
        </div>
        <!-- base_information - end -->
    </div>


    <div class="overflow-x-auto relative shadow-md sm:rounded-lg my-8">
        <!-- born_table - start -->
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-stone-400 border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                    <th scope="col" class="text-xl text-white p-3 px-8">出産情報</th>
                    <th scope="col" class="py-3 px-6"></th>
                    <th scope="col" class="py-3 px-6"></th>
                    <th scope="col" class="py-3 px-6"></th>
                    <th scope="col" class="py-3 px-6"></th>
                    <td class="items-center text-center py-4 px-6 space-x-3">
                        {{-- @can('update', $post) --}}
                        @if ($mixInfo)
                            <a href="{{ route('born_infos.create', $mixInfo) }}"
                                class="text-base text-white dark:text-blue-500 hover:underline">新規登録</a>
                        @endif
                        {{-- @endcan --}}
                    </td>
                </tr>
                <tr class="border-b whitespace-nowrap">
                    <th scope="col" class="py-3 px-6">
                        出産日
                    </th>
                    <th scope="col" class="py-3 px-6">
                        出産子数
                    </th>
                    <th scope="col" class="py-3 px-6">
                        オス1
                    </th>
                    <th scope="col" class="py-3 px-6">
                        オス2
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
                            {{ $born_info->born_num }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $born_info->first_male }}
                            {{ $born_info->first_delete_male }}
                        </td>
                        <td class="py-4 px-6">
                            @if ($born_info->second_male == null && $born_info->second_delete_male == null)
                                -
                            @else
                                {{ $born_info->second_male }}
                                {{ $born_info->second_delete_male }}
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            {{ $born_info->rotate }}
                        </td>
                        <td class="flex items-center py-4 px-6 space-x-3">
                            <a href="{{ route('born_infos.edit', $born_info) }}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">編 集</a>
                            <form action="{{ route('born_infos.destroy', $born_info) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <input type="submit" value="削 除"
                                    onclick="if(!confirm('出産情報を削除しますか？')){return false};"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- born_table - end -->
    </div>
    <p class="text-blue-600">グラフ</p>
    再発確認テーブルを追加boolean再発日が近づいたら確認項目表示、確認済み1になったら非表示
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-8">
        <!-- mix_table - start -->
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-stone-400 border-b dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
                    <th scope="col" class="text-xl text-white p-3 px-8">交配記録</th>
                    <th scope="col" class="py-3 px-6"></th>
                    <th scope="col" class="py-3 px-6"></th>
                    <th scope="col" class="py-3 px-6"></th>
                    <th scope="col" class="py-3 px-6"></th>
                    <th scope="col" class="py-3 px-6"></th>
                    <th scope="col" class="py-3 px-6"></th>
                    <td class="items-center text-center py-4 px-6 space-x-3">
                        {{-- @can('update', $post) --}}
                        <a href="{{ route('female_pigs.mix_infos.create', $femalePig) }}"
                            class="text-base text-white dark:text-blue-500 hover:underline whitespace-nowrap">新規登録</a>
                        {{-- @endcan --}}
                    </td>
                </tr>
                <tr class="whitespace-nowrap">
                    <th scope="col" class="py-3 px-6">
                        交配日
                    </th>
                    <th scope="col" class="py-3 px-6">
                        オス1
                    </th>
                    <th scope="col" class="py-3 px-6">
                        オス2
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
                        経過
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
                                {{ $mixInfo->first_delete_male }}
                            </td>
                            <td class="py-4 px-6">
                                @if ($mixInfo->second_male == null && $mixInfo->second_delete_male == null)
                                    -
                                @else
                                    {{ $mixInfo->second_male }}
                                    {{ $mixInfo->second_delete_male }}
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
                            <td class="flex items-center py-4 px-6 space-x-3">
                                {{-- <a href="{{ route('mix_infos.flag', $mixInfo) }}"
                                    class="font-medium text-green-600 dark:text-blue-500 hover:underline">再発・流産</a> --}}
                                <a href="{{ route('female_pigs.mix_infos.edit', [$femalePig, $mixInfo]) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">編 集</a>
                                <form action="{{ route('female_pigs.mix_infos.destroy', [$femalePig, $mixInfo]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="削 除"
                                        onclick="if(!confirm('交配記録を削除しますか？')){return false};"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <!-- mix_table - end -->
    </div>
    <div class="mt-4 mx-6 my-6 text-gray-700 text-right">
        <p>再発、流産の記録は編集から記録できます</p>
    </div>
    <div class="text-right">TODO:抽出画面に戻るボタンフラグ作業後に1回で戻る
        <a href="#" onclick="history.back(-1);return false;">back-1戻る</a>
        <a href="#" onclick="history.back();return false;">back戻る</a>
        <a href="javascript:history.back()">前に戻る</a>
        <a href="{{ route('extracts.index') }}">route戻るNG</a>
        <button onclick="location.href='/extracts'">location戻るNG</button>
        <input value="前に戻る" onclick="history.back();" type="button">
        <input type="button" value="リファラ表示" onclick="alert( document.referrer );" />
        <input type="button" value="referrer戻るNG" onclick="location.href=document.referrer" />
        <button id="btn--back" class="rounded-md bg-gray-800 text-white px-4 py-2">戻る</button>
    </div>

    <script>
        // var len = history.length;
        // var ref = document.referrer;
        // document.write("履歴の長さ: <em>" + len + "<\/em>\n");

        // getItemメソッドでlocalStorageからデータを取得
        let n = localStorage.getItem('count');
        //データの値を判定
        if (n === null) {
            //データが何もない場合「1」を代入
            n = 1;
        } else {
            //データがある場合「1」をプラス
            n++;
        }
        //setItemメソッドでlocalStorageにデータを保存
        localStorage.setItem('count', n);
        //コンソールで値を表示
        console.log(n);

        localStorage.clear();

        const back = document.getElementById('btn--back');
        back.addEventListener('click', (e) => {
            history.back();
            return false;
        });
    </script>
    <!-- body - end -->
</x-app-layout>
