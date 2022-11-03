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
                        “{{ $femalePig->add_day }}”
                    </div>
                    <div class="mx-2">
                        {{ $femalePig->age }}歳
                    </div>
                    <div class="mx-2">
                        フラグ
                    </div>
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
                                    過去1年平均
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
                                        {{ $born_info->rotate }}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="py-3 px-6">
                                    @if ($born_info)
                                        {{ $born_info->lastYav_rotate }}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="py-3 px-6">
                                    @if ($born_info)
                                        {{ $born_info->av_rotate }}
                                    @else
                                        0
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
                                        0
                                    @endif
                                </td>
                                <td class="py-3 px-6">
                                    @if ($born_info)
                                        {{ $born_info->lastYav_born_num }} 匹
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="py-3 px-6">
                                    @if ($born_info)
                                        {{ $born_info->av_born_num }} 匹
                                    @else
                                        0
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
                            {{ $born_info->first_male_pig->individual_num }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $born_info->second_male_pig->individual_num }}
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
                        再発日
                    </th>
                    <th scope="col" class="py-3 px-6">
                        フラグ
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
                                {{ $mixInfo->first_male_pig->individual_num }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $mixInfo->second_male_pig->individual_num }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $mixInfo->recurrence_first_schedule }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $mixInfo->recurrence_second_schedule }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $mixInfo->trouble_day }}
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
        <div class="mt-4 mx-6 text-gray-700 text-right">
            <p>再発、流産の記録は編集から記録できます</p>
        </div>
    </div>
    <p class="text-pink-600">グラフ</p>
    <!-- body - end -->
</x-app-layout>
