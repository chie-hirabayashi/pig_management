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
            {{-- <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg"> --}}

                {{-- <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"> --}}
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-center border-t text-xs text-gray-900 uppercase">
                        <tr>
                            <th scope="col" class="py-3 px-4 lx:px-6 whitespace-nowrap">
                                年
                            </th>
                            <th scope="col" class="py-3 px-4 lx:px-6 whitespace-nowrap">
                                稼働母豚
                            </th>
                            <th scope="col" class="py-3 px-4 lx:px-6 whitespace-nowrap">
                                交配頭数
                            </th>
                            <th scope="col" class="py-3 px-4 lx:px-6 whitespace-nowrap">
                                分娩腹数
                            </th>
                            <th scope="col" class="py-3 px-4 lx:px-6 whitespace-nowrap">
                                開始子豚
                            </th>
                            <th scope="col" class="py-3 px-4 lx:px-6 whitespace-nowrap">
                                離乳子豚
                            </th>
                            <th scope="col" class="py-3 px-4 lx:px-6 whitespace-nowrap">
                                交配率
                            </th>
                            <th scope="col" class="py-3 px-4 lx:px-6 whitespace-nowrap">
                                一腹産数
                            </th>
                            <th scope="col" class="py-3 px-4 lx:px-6 whitespace-nowrap">
                                産子数
                            </th>
                            <th scope="col" class="py-3 px-4 lx:px-6 whitespace-nowrap">
                                廃用頭数
                            </th>
                        </tr>
                    </thead>
                    <tbody class="border-t border-b">
                        @foreach ($achievements as $achievement)
                        <tr class="bg-white">
                            <th scope="row"
                                class="py-3 px-4 lx:px-6 font-medium text-gray-900 whitespace-nowrap">
                                <a href="{{ route('achievements.show', $achievement) }}"
                                    class="text-blue-600 after:content-['_↗'] transition-colors bg-transparent hover:underline">
                                    {{ $achievement['year'] }} 年
                                </a>
                            </th>
                            <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                            <div>
                                {{ $achievement['count_workingPigs'] }} 匹
                            </div>
                            </td>
                            <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                <p>
                                {{ $achievement['count_mixes'] }} 匹
                                </p>
                            </td>
                            <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                {{ $achievement['count_borns'] }} 匹
                            </td>
                            <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                {{ $achievement['count_bornPigs'] }} 匹
                            </td>
                            <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                {{ $achievement['count_weaningPigs'] }} 匹
                            </td>
                            <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                {{ $achievement['success_mix'] }}
                            </td>
                            <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                {{ $achievement['bornPigs_by_borns'] }}
                            </td>
                            <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                {{ $achievement['rotates'] }}
                            </td>
                            <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                {{ $achievement['count_leftPigs'] }} 匹
                            </td>
                        </tr>
                        @endforeach
                </table>
            </div>
            {{-- </div>
            </div> --}}
                <p>稼働母豚:当該年内に交配した個体</p>
            <!-- border - end -->
        </div>
    </div>
    
</x-app-layout>
