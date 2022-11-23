<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('extracts.index') }}
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
                <div class="text-2xl text-gray-500 active:text-gray-600 transition duration-100">
                    <div class="w-auto h-6 sm:h-8" width="173" height="39" viewBox="0 0 173 39" fill="currentColor">
                        抽出条件
                    </div>
                </div>
                <div>抽出方法</div>
                @if ($conditions['condition'] == 1)
                    <div>{{ __('condition_1') }}</div>
                    <div class="flex max-w-lg text-gray-600 lg:text-lg text-center">
                        <div class="mx-2">
                            直前の出産・・・
                        </div>
                        <div class="mx-2">
                            回転数:{{ $conditions['first_rotate'] }}以下
                        </div>
                        <div class="mx-2 text-sm">
                            または
                        </div>
                        <div class="mx-2">
                            産子数:{{ $conditions['first_num'] }}以下
                        </div>
                    </div>
                    <div class="flex max-w-lg text-gray-600 lg:text-lg text-center">
                        <div class="mx-2">
                            前回の出産・・・
                        </div>
                        <div class="mx-2">
                            回転数:{{ $conditions['second_rotate'] }}以下
                        </div>
                        <div class="mx-2 text-sm">
                            または
                        </div>
                        <div class="mx-2">
                            産子数:{{ $conditions['second_num'] }}以下
                        </div>
                    </div>
                @endif
                @if ($conditions['condition'] == 2)
                    <div>{{ __('condition_2') }}</div>
                    <div class="flex max-w-lg text-gray-600 lg:text-lg text-center">
                        <div class="mx-2">
                            直前の出産・・・
                        </div>
                        <div class="mx-2">
                            回転数:{{ $conditions['first_rotate'] }}以下
                        </div>
                        <div class="mx-2 text-sm">
                            または
                        </div>
                        <div class="mx-2">
                            産子数:{{ $conditions['first_num'] }}以下
                        </div>
                    </div>
                    <div class="flex max-w-lg text-gray-600 lg:text-lg text-center">
                        <div class="mx-2">
                            前回の出産・・・
                        </div>
                        <div class="mx-2">
                            回転数:{{ $conditions['second_rotate'] }}以下
                        </div>
                        <div class="mx-2 text-sm">
                            または
                        </div>
                        <div class="mx-2">
                            産子数:{{ $conditions['second_num'] }}以下
                        </div>
                    </div>
                    <div class="flex max-w-lg text-gray-600 lg:text-lg text-center">
                        <div class="mx-2">
                            母豚条件・・・
                        </div>
                        <div class="mx-2">
                            年齢:{{ $conditions['female_age'] }}歳以上
                        </div>
                        <div class="mx-2 text-sm">
                            {{ $conditions['option_operator'] == 1 ? 'かつ' : 'または' }}
                        </div>
                        <div class="mx-2 text-sm">
                            再発、流産の回数:{{ $conditions['trouble_num'] }}以上
                        </div>
                    </div>
                @endif
                @if ($conditions['condition'] == 3)
                    <div>{{ __('condition_3') }}</div>
                    <div class="flex max-w-lg text-gray-600 lg:text-lg text-center">
                        <div class="mx-2">
                            直前の出産・・・
                        </div>
                        <div class="mx-2">
                            回転数:{{ $conditions['first_rotate'] }}以下
                        </div>
                        <div class="mx-2">
                            かつ
                        </div>
                        <div class="mx-2">
                            産子数:{{ $conditions['first_num'] }}以下
                        </div>
                    </div>
                @endif
                @if ($conditions['condition'] == 4)
                    <div>{{ __('condition_4') }}</div>
                    <div class="flex max-w-lg text-gray-600 lg:text-lg text-center">
                        <div class="mx-2">
                            直前の出産・・・
                        </div>
                        <div class="mx-2">
                            回転数:{{ $conditions['first_rotate'] }}以下
                        </div>
                        <div class="mx-2">
                            かつ
                        </div>
                        <div class="mx-2">
                            産子数:{{ $conditions['first_num'] }}以下
                        </div>
                    </div>
                    <div class="flex max-w-lg text-gray-600 lg:text-lg text-center">
                        <div class="mx-2">
                            母豚条件・・・
                        </div>
                        <div class="mx-2">
                            年齢:{{ $conditions['female_age'] }}歳以上
                        </div>
                        <div class="mx-2">
                            {{ $conditions['option_operator'] == 1 ? 'かつ' : 'または' }}
                        </div>
                        <div class="mx-2 text-sm">
                            再発、流産の回数:{{ $conditions['trouble_num'] }}以上
                        </div>
                    </div>
                @endif
                <!-- base - end -->
            </div>
        </div>
    </div>

    <div class="overflow-x-auto relative shadow-md my-8">
        <!-- born_table - start -->
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="border-b whitespace-nowrap">
                    <th scope="col" class="py-3 px-6">
                        メス個体番号
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
                    <th scope="col" class="py-3 px-6">
                        オス1
                    </th>
                    <th scope="col" class="py-3">
                        オス2
                    </th>
                    <th scope="col" class="py-3">
                        再発、流産
                    </th>
                    <th scope="col" class="py-3"></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($extracts as $extract)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 whitespace-nowrap">
                        <td class="py-4 px-6">
                            {{ $extract->female_pig->individual_num }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-red-500">
                                {{ $extract->female_pig->age >= $conditions['female_age'] ? $extract->female_pig->age . '歳' : '' }}
                            </span>
                            {{ $extract->female_pig->age >= $conditions['female_age'] ? '' : $extract->female_pig->age . '歳' }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-red-500">
                                {{ $extract->rotate <= $conditions['first_rotate'] ? $extract->rotate . '回' : '' }}
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
                            {{ $extract->first_delete_male }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $extract->second_male }}
                            {{ $extract->second_delete_male }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-red-500">
                                {{ $extract->troubles >= $conditions['trouble_num'] ? $extract->troubles . '回' : '' }}
                            </span>
                            {{ $extract->troubles >= $conditions['trouble_num'] ? '' : $extract->troubles . '回' }}
                        </td>
                        <td class="py-4 px-6">
                            <a href="{{ route('female_pigs.show', $extract->female_pig) }}">詳細確認</a>
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
            戻る
        </a>
    </div>
</x-app-layout>
