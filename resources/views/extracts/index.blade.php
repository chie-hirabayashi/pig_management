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
                <div class="text-3xl text-gray-500 active:text-gray-600 transition duration-100">
                    <div class="w-auto h-6 sm:h-8" width="173" height="39" viewBox="0 0 173 39" fill="currentColor">
                        抽出条件
                    </div>
                </div>
                <div class="flex max-w-md text-gray-600 lg:text-lg text-center">
                    <div class="mx-2">
                        回転数:1.8未満
                    </div>
                    <div class="mx-2">
                        産子数:8未満
                    </div>
                    <div class="mx-2">
                        その他
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
                                        {{ $extract->rotate }}回
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $extract->born_num }}頭
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
                                    {{-- 別ルートを経由してリダイレクトしてみる --}}
                                        <a href="{{ route('female_pigs.show', $extract->female_pig) }}">ぼたん</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- border - end -->

                {{-- <!-- edit&delete - start -->
                <div class="flex flex-row text-center my-4">
                    @can('update', $post)
                    <a href="{{ route('female_pigs.edit', $femalePig) }}"
                    class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">
                    編 集
                    </a>
                    @endcan
                    @can('delete', $post)
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
                </div> --}}
                <!-- quote - end -->
            </div>
        </div>
        <!-- base_information - end -->
    </div>

</x-app-layout>
