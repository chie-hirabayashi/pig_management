<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('mix_infos.create') }}
        </h2>
    </x-slot>
    <!-- header - end -->

    <section
        class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-10 px-8 py-4 bg-white border rounded shadow-md dark:bg-gray-800">
        <!-- title -->
        <h2 class="text-2xl MplusRound text-gray-700 capitalize dark:text-white">交配記録の登録</h2>

        <!-- message -->
        <x-error-validation :errors="$errors" />

        <!-- female - start -->
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div class="mb-1">
                <label class="text-gray-700 dark:text-gray-200" for="individual_num">
                    <span class="text-rose-400">
                        <i class="fa-solid fa-venus"></i>
                    </span>
                    &ensp;:&ensp;NO.
                </label>
                <input id="" type="text" name="individual_num" readonly
                    value="{{ $femalePig->individual_num }}"
                    class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
            </div>
        </div>
        <!-- female - end -->

        {{-- <div id="codeDate">{{ $femalePig->mix_infos->last()->born_day }}</div> --}}

        <!-- form - start -->
        <form action="{{ route('female_pigs.mix_infos.store', $femalePig) }}" method="POST" class="rounded pt-3 mb-4">
            @csrf
            <div class="block grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <!-- male - start -->
                <div class="flex">
                    <div class="mb-4 mr-4 flex-none">
                        <label class="text-gray-700 dark:text-gray-200" for="">
                            <span class="text-indigo-400">
                                <i class="fa-solid fa-mars"></i>
                            </span>
                            &ensp;:&ensp;1_NO.
                        </label>
                        <select name="first_male_id" id="select1" required
                            class="block px-8 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                            <option hidden>選択してください</option>
                            @foreach ($malePigs as $malePig)
                                <option value="{{ $malePig->id }}">
                                    {{ $malePig->individual_num }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4 mr-4 flex-none">
                        <label class="text-gray-700 dark:text-gray-200" for="">
                            <span class="text-indigo-400">
                                <i class="fa-solid fa-mars"></i>
                            </span>
                            &ensp;:&ensp;2_NO.
                        </label>
                        <select name="second_male_id" id="select2"
                            class="block px-8 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                            <option value="{{ null }}">選択してください</option>
                            @foreach ($malePigs as $malePig)
                                <option value="{{ $malePig->id }}">
                                    {{ $malePig->individual_num }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- male - end -->

                <!-- day_check - start -->
                <div id="sample" class="mb-4">
                    <div class="hidden" id="malePigs">{{ $malePigs }}</div>
                    <input type="button" id="check" value="有効日の確認"
                        class="text-indigo-700 text-sm dark:text-blue-500 hover:underline">
                    <div id="box" class="text-red-700 text-sm"></div>
                </div>
                <!-- day_check - end -->

                <!-- mix_day - start -->
                <div class="">
                    <label class="text-gray-700 dark:text-gray-200" for="mix_day">交配日</label>
                    <input type="date" name="mix_day" required
                        class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
                        value="{{ old('mix_day') }}">
                </div>
                <!-- mix_day - end -->
            </div>

            <!-- button - start -->
            <div class="flex justify-end mt-4">
                <input type="submit" value="登 録"
                    class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-indigo-500 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-gray-600">
            </div>
            <!-- button - end -->
        </form>
        <!-- form - end -->
        <a href="{{ route('female_pigs.show', $femalePig) }}"
            {{-- class="py-1.5 px-4 transition-colors bg-transparent active:bg-gray-200 font-medium text-blue-600 rounded-lg hover:bg-gradient-to-bl from-red-200 via-red-300 to-yellow-200 hover:text-white disabled:opacity-50"> --}}
            class="py-1.5 px-4 transition-colors bg-transparent active:bg-gray-200 font-medium text-blue-600 rounded-lg hover:bg-gray-100 disabled:opacity-50">
            戻る
        </a>
    </section>
    <div>&emsp;</div>

    <!-- script - start -->
    <script>
        var femalePigAddDay = @json($femalePig).add_day;
        var malePigs = @json($malePigs);
        var lastRecode = @json($femalePig->mix_infos->last());
        var lastRecodeDay = femalePigAddDay; // 交配記録がない場合は母豚導入日

        let selectId1 = document.getElementById('select1');
        let selectId2 = document.getElementById('select2');
        let check = document.getElementById('check');
        let box = document.getElementById('box');

        // 直前の出産or再発or流産の日付をセット
        if (lastRecode) {
            lastRecodeDay = lastRecode.born_day;
            if (lastRecodeDay == null) {
                lastRecodeDay = lastRecode.trouble_day;
            }
        }

        // 日付の比較
        // check.onmousedown = function() {
        check.onclick = function() {
            malePigs.forEach(malePig => {
                if (malePig.id == selectId1.value) {
                    firstAddDay = malePig.add_day;
                }
            });

            switch (selectId2.value == '') {
                case true:
                    secondAddDay = femalePigAddDay;
                    break;

                case false:
                    malePigs.forEach(malePig => {
                        if (malePig.id == selectId2.value) {
                            secondAddDay = malePig.add_day;
                        }
                    });
                    break;

                default:
                    break;
            }

            try {
                if (lastRecodeDay >= firstAddDay &&
                    lastRecodeDay >= secondAddDay) {
                    effectiveDate = lastRecodeDay;
                }
                if (firstAddDay >= secondAddDay &&
                    firstAddDay >= lastRecodeDay) {
                    effectiveDate = firstAddDay;
                }
                if (secondAddDay >= lastRecodeDay &&
                    secondAddDay >= firstAddDay) {
                    effectiveDate = secondAddDay;
                }
                var message = '登録可能な交配日は' + effectiveDate + '以降です';
            } catch (error) {
                var message = '個体番号を選択してください';
            }

            document.getElementById('box').textContent = message;

        }
    </script>
    <!-- script - end -->
    {{-- <script src="{{ mix('js/information.js') }}"></script> --}}
</x-app-layout>
