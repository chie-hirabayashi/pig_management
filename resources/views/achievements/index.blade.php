<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('male_pigs.index') }}
        </h2>
    </x-slot>
    <!-- header - end -->

    <!-- message -->
    <x-flash-msg :message="session('notice')" />

    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <div class="max-w-screen-xl px-4 md:px-8 mx-auto">
            <!-- title -->
            <h2 class="MplusRound text-gray-700 text-2xl lg:text-3xl text-center mb-8 md:mb-12">
                <span class="text-sky-800">
                    <i class="fa-solid fa-feather-pointed"></i>
                </span>
                総合実績表
            </h2>

            <!-- border - start -->
            <div class="overflow-x-auto relative">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-center border-t text-xs text-gray-900 uppercase dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                年
                            </th>
                            <th scope="col" class="py-3 px-6">
                                稼働母豚
                            </th>
                            <th scope="col" class="py-3 px-6">
                                交配頭数
                            </th>
                            <th scope="col" class="py-3 px-6">
                                分娩腹数
                            </th>
                            <th scope="col" class="py-3 px-6">
                                開始子豚
                            </th>
                            <th scope="col" class="py-3 px-6">
                                離乳子豚
                            </th>
                            <th scope="col" class="py-3 px-6">
                                交配率
                            </th>
                            <th scope="col" class="py-3 px-6">
                                一腹産数
                            </th>
                            <th scope="col" class="py-3 px-6">
                                産子数
                            </th>
                        </tr>
                    </thead>
                    <tbody class="border-t border-b">
                        @foreach ($achievements as $achievement)
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row"
                                class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <a href="{{ route('achievements.show', $achievement) }}"
                                    class="text-blue-600 after:content-['_↗'] dark:text-blue-500 transition-colors bg-transparent hover:underline">
                                    {{ $achievement['year'] }} 年
                                </a>
                            </th>
                            <td class="text-center py-3 px-6">
                                {{ $achievement['count_workingPigs'] }} 匹
                            </td>
                            <td class="text-center py-3 px-6">
                                {{ $achievement['count_mixes'] }} 匹
                            </td>
                            <td class="text-center py-3 px-6">
                                {{ $achievement['count_borns'] }} 匹
                            </td>
                            <td class="text-center py-3 px-6">
                                {{ $achievement['count_bornPigs'] }} 匹
                            </td>
                            <td class="text-center py-3 px-6">
                                {{ $achievement['count_weaningPigs'] }} 匹
                            </td>
                            <td class="text-center py-3 px-6">
                                {{ $achievement['success_mix'] }}
                            </td>
                            <td class="text-center py-3 px-6">
                                {{ $achievement['bornPigs_by_borns'] }}
                            </td>
                            <td class="text-center py-3 px-6">
                                {{ $achievement['rotates'] }}
                            </td>
                        </tr>
                        @endforeach
                </table>
            </div>
            <!-- border - end -->
</x-app-layout>
