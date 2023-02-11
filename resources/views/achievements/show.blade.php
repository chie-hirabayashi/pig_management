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
                {{ $achievement['year'] }}年実績表
            </h2>

            <!-- border - start -->
            <div class="overflow-x-auto relative">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-center border-t-2 text-xs text-gray-900 uppercase dark:text-gray-400">
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
                                回転数
                            </th>
                        </tr>
                    </thead>
                    <tbody class="border-t border-b-2">
                        @foreach ($achievements_by_age as $achievement_by_age)
                            <tr class="bg-white dark:bg-gray-800">
                                <th class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                    {{ $achievement_by_age['age'] }} 年
                                </th>
                                <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                    {{ $achievement_by_age['count_workingPigs'] }} 匹
                                </td>
                                <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                    {{ $achievement_by_age['count_mixes_byAge_total'] }} 匹
                                </td>
                                <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                    {{ $achievement_by_age['count_borns_byAge_total'] }} 匹
                                </td>
                                <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                    {{ $achievement_by_age['count_bornPigs_byAge_total'] }} 匹
                                </td>
                                <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                    {{ $achievement_by_age['count_weaningPigs_byAge_total'] }} 匹
                                </td>
                                <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                    {{ $achievement_by_age['success_mix'] }}
                                </td>
                                <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                    {{ $achievement_by_age['bornPigs_by_borns'] }}
                                </td>
                                <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                    {{ $achievement_by_age['rotates'] }}
                                </td>
                            </tr>
                        @endforeach
                            <tr class="border-t bg-white dark:bg-gray-800">
                                <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                    合計
                                </td>
                                <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                    {{ count($femalePigs) }}匹
                                </td>
                                <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                    {{ $achievement['count_mixes'] }}匹
                                </td>
                                <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                    {{ $achievement['count_borns'] }}匹
                                </td>
                                <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                    {{ $achievement['count_bornPigs'] }}匹
                                </td>
                                <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                    {{ $achievement['count_weaningPigs'] }}匹
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
                            </tr>
                </table>
            </div>
                <p>稼働母豚:当該年内に存在した個体(交配実績の無い個体も含む)</p>
            <!-- border - end -->

            <div class="container lg:w-3/4 md:w-4/5 w-full mx-auto my-10 lg:px-8 lg:py-4">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>

    <!-- script - start -->
    <script>
        window.Laravel = {};
        window.Laravel.achievements = @json($achievements_by_age);

        Data = [];
        for (var i = 0; i < window.Laravel.achievements.length; i++) {
            Data[i] = {
                x: window.Laravel.achievements[i]['age'],
                y: window.Laravel.achievements[i]['count_workingPigs']
            };
        }
        var ages = [];
        // for (var i = 0; i < window.Laravel.achievements.length; i++) {
        //     ages[i] = window.Laravel.achievements[i]['age'];
        // }
        // window.Laravel.achievements.forEach(element => {
        //     console.log(element['age']);
        //     // ages.push(element['rotates']);
        // });
        window.Laravel.achievements.forEach(function(index) {
            console.log(index);
        });

        // console.log(ages);
    </script>
    <script src="{{ mix('js/chartjs2.js') }}"></script>
    <!-- script - end -->

</x-app-layout>
