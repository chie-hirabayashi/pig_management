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
    条件、年齢、再発
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
                <div class="flex max-w-lg text-gray-600 lg:text-lg text-center">
                    <div class="mx-2">
                        直前の出産・・・
                    </div>
                    <div class="mx-2">
                        回転数:{{ $conditions['first_rotate'] }}以下
                    </div>
                    <div class="mx-2">
                        {{ $conditions['operator'] == 1 ? 'かつ' : 'または' }}
                    </div>
                    <div class="mx-2">
                        産子数:{{ $conditions['first_num'] }}以下
                    </div>
                </div>
                {{-- <div class="flex max-w-lg text-gray-600 lg:text-lg text-center">
                    <div class="mx-2">
                        {{ $conditions['operator'] == 1 ? 'かつ' : 'または' }}
                    </div>
                </div> --}}
                <div class="flex max-w-lg text-gray-600 lg:text-lg text-center">
                    <div class="mx-2">
                        前回の出産・・・
                    </div>
                    <div class="mx-2">
                        回転数:{{ $conditions['second_rotate'] }}以下
                    </div>
                    <div class="mx-2">
                        {{ $conditions['operator'] == 1 ? 'かつ' : 'または' }}
                    </div>
                    <div class="mx-2">
                        産子数:{{ $conditions['second_num'] }}以下
                    </div>
                </div>
                <!-- base - end -->

                <!-- border - start -->
                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="border-t text-xs text-gray-900 uppercase dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    メス個体番号
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
                                <th scope="col" class="py-3 px-6">
                                    オス2
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    再発、流産
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    詳細確認
                                </th>
                            </tr>
                        </thead>
                        <tbody class="border-t border-b">
                            @foreach ($extracts as $extract)
                                <tr class="bg-white dark:bg-gray-800">
                                    <th scope="row"
                                        class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $extract->female_pig->individual_num }}
                                    </th>
                                    <td class="py-3 px-6">
                                        <span class="text-red-500">
                                            {{ $extract->rotate <= $conditions['first_rotate'] ? $extract->rotate . '回' : '' }}
                                        </span>
                                        {{ $extract->rotate <= $conditions['first_rotate'] ? '' : $extract->rotate . '回' }}
                                    </td>
                                    <td class="py-3 px-6">
                                        <span class="text-red-500">
                                            {{ $extract->born_num <= $conditions['first_num'] ? $extract->born_num . '匹' : '' }}
                                        </span>
                                            {{ $extract->born_num <= $conditions['first_num'] ? '' : $extract->born_num . '匹'}}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{-- 論理削除は呼び出せない --}}
                                        {{-- {{ $extract->first_male_pig->individual_num }} --}}
                                        {{ $extract->first_male }}
                                        {{ $extract->first_delete_male }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{-- nllがあって表示できない --}}
                                        {{ $extract->second_male }}
                                        {{ $extract->second_delete_male }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $extract->troubles }} 回
                                        
                                    </td>
                                    <td class="py-3 px-6">
                                        <a href="{{ route('female_pigs.show', $extract->female_pig) }}">ぼたん</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- border - end -->
                <div class="flex flex-row text-center my-4">
                    {{-- @can('update', $post) --}}
                    <a href="{{ route('extracts.conditions') }}"
                        class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">
                        条件
                    </a>
                </div>
            </div>
        </div>
        <!-- base_information - end -->
    </div>

</x-app-layout>
