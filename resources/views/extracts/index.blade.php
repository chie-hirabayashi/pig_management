<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('extracts.index') }}
        </h2>
    </x-slot>
    <!-- header - end -->
    
    <!-- body - start -->
    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <!-- base_information - start -->
        <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
            <div class="flex flex-col items-center gap-4 md:gap-6">
                <!-- base - start -->
                <div class="text-2xl text-gray-500 active:text-gray-600 transition duration-100">
                    <h2 class="text-2xl MplusRound text-gray-700 capitalize dark:text-white">抽出条件</h2>
                </div>

                <div class="items-left">
                    @if ($conditions['condition'] == 1)
                        <div class="flex h-8 max-w-lg text-gray-600">
                            <div class="mx-2 font-semibold leading-8">
                                抽出方法&emsp;&ensp;:
                            </div>
                            <div class="mx-1 leading-8">
                                {{ __('condition_1') }}
                            </div>
                        </div>
                        <div class="flex h-8 max-w-lg text-gray-600">
                            <div class="mx-2 font-semibold leading-8">
                                直前の出産&ensp;:
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                回転数:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['first_rotate'] }}回
                                </span>
                                以下
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                かつ
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                産子数:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['first_num'] }}匹
                                </span>
                                以下
                            </div>
                        </div>
                    @endif
                    @if ($conditions['condition'] == 2)
                        <div class="flex h-8 max-w-lg text-gray-600">
                            <div class="mx-2 font-semibold leading-8">
                                抽出方法&emsp;&ensp;:
                            </div>
                            <div class="mx-1 leading-8">
                                {{ __('condition_2') }}
                            </div>
                        </div>
                        <div class="flex h-8 max-w-lg text-gray-600">
                            <div class="mx-2 font-semibold leading-8">
                                直前の出産&ensp;:
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                回転数:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['first_rotate'] }}回
                                </span>
                                以下
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                かつ
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                産子数:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['first_num'] }}匹
                                </span>
                                以下
                            </div>
                        </div>
                        <div class="flex h-8 max-w-lg text-gray-600">
                            <div class="mx-2 font-semibold leading-8">
                                母豚の条件&ensp;:
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                年齢:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['female_age'] }}歳
                                </span>
                                以上
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                {{ $conditions['option_operator'] == 1 ? 'かつ' : 'または' }}
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                再発等の回数:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['trouble_num'] }}回
                                </span>
                                以上
                            </div>
                        </div>
                    @endif
                    @if ($conditions['condition'] == 3)
                        <div class="flex h-8 max-w-lg text-gray-600">
                            <div class="mx-2 font-semibold leading-8">
                                抽出方法&emsp;&ensp;:
                            </div>
                            <div class="mx-1 leading-8">
                                {{ __('condition_3') }}
                            </div>
                        </div>
                        <div class="flex h-8 max-w-lg text-gray-600">
                            <div class="mx-2 font-semibold leading-8">
                                直前の出産&ensp;:
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                回転数:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['first_rotate'] }}回
                                </span>
                                以下
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                または
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                産子数:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['first_num'] }}匹
                                </span>
                                以下
                            </div>
                        </div>
                        <div class="flex h-8 max-w-lg text-gray-600">
                            <div class="mx-2 font-semibold leading-8">
                                前回の出産&ensp;:
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                回転数:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['second_rotate'] }}回
                                </span>
                                以下
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                または
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                産子数:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['second_num'] }}匹
                                </span>
                                以下
                            </div>
                        </div>
                    @endif
                    @if ($conditions['condition'] == 4)
                        <div class="flex h-8 max-w-lg text-gray-600">
                            <div class="mx-2 font-semibold leading-8">
                                抽出方法&emsp;&ensp;:
                            </div>
                            <div class="mx-1 leading-8">
                                {{ __('condition_4') }}
                            </div>
                        </div>
                        <div class="flex h-8 max-w-lg text-gray-600">
                            <div class="mx-2 font-semibold leading-8">
                                直前の出産&ensp;:
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                回転数:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['first_rotate'] }}回
                                </span>
                                以下
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                または
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                産子数:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['first_num'] }}匹
                                </span>
                                以下
                            </div>
                        </div>
                        <div class="flex h-8 max-w-lg text-gray-600">
                            <div class="mx-2 font-semibold leading-8">
                                前回の出産&ensp;:
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                回転数:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['second_rotate'] }}回
                                </span>
                                以下
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                または
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                産子数:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['second_num'] }}匹
                                </span>
                                以下
                            </div>
                        </div>
                        <div class="flex h-8 max-w-lg text-gray-600">
                            <div class="mx-2 font-semibold leading-8">
                                母豚の条件&ensp;:
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                年齢:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['female_age'] }}歳
                                </span>
                                以上
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                {{ $conditions['option_operator'] == 1 ? 'かつ' : 'または' }}
                            </div>
                            <div class="mx-1 text-sm leading-8">
                                再発等の回数:
                                <span class="text-red-500 text-lg">
                                    {{ $conditions['trouble_num'] }}回
                                </span>
                                以上
                            </div>
                        </div>
                    @endif
                    <div class="flex h-8 max-w-lg text-gray-600">
                        <div class="mx-2 font-semibold leading-8">
                            その他条件&ensp;:
                        </div>
                        <div class="mx-1 text-sm leading-8">
                            予測回転数:
                            <span class="text-red-500 text-lg">
                                1.8回
                            </span>
                            以下
                        </div>
                    </div>
                </div>

                <!-- base - end -->
            </div>
        </div>
    </div>

    <div class="overflow-x-auto relative shadow-md my-8">
        <div class="bg-gray-100 border-b border-gray-400 dark:bg-gray-800 dark:border-gray-700 whitespace-nowrap">
            <div class="MplusRound text-xl text-gray-600 py-2 px-8">抽 出 個 体 一 覧</div>
        </div>
        <!-- born_table - start -->
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="border-b whitespace-nowrap">
                    <th scope="col" class="py-3 px-6">
                        <i class="fa-solid fa-venus"></i>NO.
                    </th>
                    <th scope="col" class="py-3 px-6">
                        年齢
                    </th>
                    <th scope="col" class="py-3 px-6">
                        回転数
                    </th>
                    <th scope="col" class="py-3 px-6">
                        産子数
                    </th>
                    <th scope="col" class="py-3">
                        <i class="fa-solid fa-mars"></i>1_NO.
                    </th>
                    <th scope="col" class="py-3">
                        <i class="fa-solid fa-mars"></i>2_NO.
                    </th>
                    <th scope="col" class="py-3">
                        再発、流産
                    </th>
                    <th scope="col" class="py-3">
                        予測回転数
                    </th>
                </tr>
            </thead>
{{-- {{ dd($extracts) }} --}}
            <tbody>
                @foreach ($extracts as $extract)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 whitespace-nowrap">
                        <td class="py-4 px-6">
                            <a href="{{ route('female_pigs.show', $extract->female_pig) }}"
                                class="text-blue-600 after:content-['_↗'] dark:text-blue-500 transition-colors bg-transparent hover:underline">
                                {{ $extract->female_pig->individual_num }}
                            </a>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-red-500">
                                {{-- {{ $extract->mix_info->female_pig->age >= $conditions['female_age'] ? $extract->mix_info->female_pig->age . '歳' : '' }} --}}
                    <!-- これ -->
                                {{ $extract->female_pig->age >= $conditions['female_age'] ? $extract->female_pig->age . '歳' : '' }}
                            </span>
                            {{-- {{ $extract->mix_info->female_pig->age >= $conditions['female_age'] ? '' : $extract->mix_info->female_pig->age . '歳' }} --}}
                            {{ $extract->female_pig->age >= $conditions['female_age'] ? '' : $extract->female_pig->age . '歳' }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-red-500">
                                {{ $extract->rotate && $extract->rotate <= $conditions['first_rotate'] ? $extract->rotate . '回' : '' }}
                            </span>
                            {{ $extract->rotate <= $conditions['first_rotate'] ? '' : $extract->rotate . '回' }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-red-500">
                                {{ $extract->born_num <= $conditions['first_num'] ? $extract->born_num . '匹' : '' }}
                            </span>
                            {{ $extract->born_num <= $conditions['first_num'] ? '' : $extract->born_num . '匹' }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $extract->first_male }}
                            <p class="line-through">
                                {{ $extract->first_delete_male }}
                            </p>
                        </td>
                        <td class="py-4 px-6">
                            {{ $extract->second_male }}
                            <p class="line-through">
                                {{ $extract->second_delete_male }}
                            </p>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-red-500">
                                {{ $extract->troubles >= $conditions['trouble_num'] ? $extract->troubles . '回' : '' }}
                            </span>
                            {{ $extract->troubles >= $conditions['trouble_num'] ? '' : $extract->troubles . '回' }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-red-500">
                                {{ $extract->rotate_prediction && $extract->rotate_prediction <= 1.8 ? $extract->rotate_prediction . '回' : '' }}
                            </span>
                            {{ $extract->rotate_prediction <= 1.8 ? '' : $extract->rotate_prediction . '回' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- born_table - end -->
    </div>

    <div class="items-center text-center my-4">
        <a href="{{ route('extracts.conditions') }}"
            class="py-1.5 px-4 transition-colors bg-transparent active:bg-gray-200 font-medium text-blue-600 rounded-lg hover:bg-gray-100 disabled:opacity-50">
            <i class="fa-solid fa-arrow-left"></i>
            戻る
        </a>
    </div>
</x-app-layout>
