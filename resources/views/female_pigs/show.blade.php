<x-app-layout>
    <x-slot name="header">
        <h2 class="">
            {{ __('female_pigs.show') }}
        </h2>
    </x-slot>

    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
            <!-- quote - start -->
            <div class="flex flex-col items-center gap-4 md:gap-6">
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
                        フラグ</div>
                </div>


                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="border-t text-xs text-gray-900 uppercase dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">

                                </th>
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
                                    @if ($bornInfo)
                                        {{ $bornInfo->rotate }}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="py-3 px-6">
                                    @if ($bornInfo)
                                        {{ $bornInfo->lastYav_rotate }}
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="py-3 px-6">
                                    @if ($bornInfo)
                                        {{ $bornInfo->av_rotate }}
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
                                    @if ($bornInfo)
                                        {{ $bornInfo->born_num }} 匹
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="py-3 px-6">
                                    @if ($bornInfo)
                                        {{ $bornInfo->lastYav_born_num }} 匹
                                    @else
                                        0
                                    @endif
                                </td>
                                <td class="py-3 px-6">
                                    @if ($bornInfo)
                                        {{ $bornInfo->av_born_num }} 匹
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


                <div class="flex flex-col sm:flex-row items-center gap-2 md:gap-3">
                    {{-- <div class="w-12 md:w-14 h-12 md:h-14 bg-gray-100 rounded-full overflow-hidden shadow-lg">
                        <img src="https://images.unsplash.com/photo-1567515004624-219c11d31f2e??auto=format&q=75&fit=crop&w=112"
                            loading="lazy" alt="Photo by Radu Florin"
                            class="w-full h-full object-cover object-center" />
                    </div> --}}

                    <div>
                        <div class="text-indigo-500 text-sm md:text-base font-bold text-center sm:text-left">John
                            McCulling</div>
                        <p class="text-gray-500 text-sm md:text-sm text-center sm:text-left">CEO / Datadrift</p>
                    </div>
                </div>
            </div>
            <!-- quote - end -->
        </div>
    </div>

    <x-error-validation :errors="$errors" />
    <x-flash-msg :message="session('notice')" />

    {{-- <div class="overflow-x-auto relative shadow-md sm:rounded-lg my-8"> --}}
    <div class="overflow-x-auto relative shadow-md my-8">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-stone-400 border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="col" class="text-xl text-white p-3 px-8">出産情報</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <td class="items-center text-center py-4 px-6 space-x-3">
                        {{-- @can('update', $post) --}}
                        @if ($mixInfo)
                            <a href="{{ route('mix_infos.born_infos.create', $mixInfo) }}"
                                class="text-base text-white dark:text-blue-500 hover:underline">新規登録</a>
                        @endif
                        {{-- @endcan --}}
                    </td>
                </tr>
                <tr class="border-b">
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
                    <th scope="col" class="py-3 px-6">

                    </th>
                    <th scope="col" class="py-3 px-6">

                    </th>
                    <th scope="col" class="py-3 px-6"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bornInfos as $bornInfo)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        {{-- <td scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"> --}}
                        <td class="py-4 px-6">
                            {{ $bornInfo->born_day }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $bornInfo->born_num }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $bornInfo->mix_info->first_male_pig->individual_num }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $bornInfo->mix_info->second_male_pig->individual_num }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $bornInfo->rotate }}
                        </td>
                        <td class="py-4 px-6">

                        </td>
                        <td class="py-4 px-6">

                        </td>
                        <td class="flex items-center py-4 px-6 space-x-3">
                            <a href="{{ route('female_pigs.mix_infos.edit', [$femalePig, $mixInfo]) }}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">編 集</a>
                            <form action="{{ route('female_pigs.mix_infos.destroy', [$femalePig, $mixInfo]) }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="削 除" onclick="if(!confirm('削除しますか？')){return false};"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <p class="text-blue-600">グラフ</p>

    <div class="overflow-x-auto relative shadow-md">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-stone-400 border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="col" class="text-xl text-white p-3 px-8">交配記録</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <td class="items-center text-center py-4 px-6 space-x-3">
                        {{-- @can('update', $post) --}}
                        <a href="{{ route('female_pigs.mix_infos.create', $femalePig) }}"
                            class="text-base text-white dark:text-blue-500 hover:underline">新規登録</a>
                        {{-- @endcan --}}
                    </td>
                </tr>
                <tr>
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
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            {{-- <td scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"> --}}
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
                                {{ $mixInfo->recurrence_day }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $mixInfo->recurrence_flag, $mixInfo->abortion_flag }}
                            </td>
                            <td class="flex items-center py-4 px-6 space-x-3">
                                <a href="{{ route('female_pigs.mix_infos.edit', [$femalePig, $mixInfo]) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">編 集</a>
                                <form action="{{ route('female_pigs.mix_infos.destroy', [$femalePig, $mixInfo]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="削 除"
                                        onclick="if(!confirm('削除しますか？')){return false};"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div>
        <p class="text-pink-600">グラフ</p>
    </div>
</x-app-layout>
