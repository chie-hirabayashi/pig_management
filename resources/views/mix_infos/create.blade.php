<x-app-layout>
    <x-slot name="header">
        <h2 class="">
            {{ __('mix_infos.create') }}
        </h2>
    </x-slot>

    {{-- <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-white shadow-md">
        <h2 class="text-center text-lg font-bold pt-6 tracking-widest">交配記録の登録</h2>

        <x-error-validation :errors="$errors" />

        <div class="mb-4">
            <label class="block text-gray-700 text-sm mb-2" for="mix_day">
                メスの個体番号
            </label>
            <input type="text" name=""
                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                value="{{ $femalePig->individual_num }}" readonly>
        </div>

        <form action="{{ route('female_pigs.mix_infos.store', $femalePig) }}" method="POST"
            class="rounded pt-3 pb-8 mb-4">
            @csrf
            <div class="flex">
                <div class="mb-4 mr-4 flex-none">
                    <label class="block text-gray-700 text-sm mb-2" for="">
                        オス1の個体番号
                    </label>
                    <select name="first_male_id" id="select1" required
                        class="px-8 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option hidden>選択してください</option>
                        @foreach ($malePigs as $malePig)
                            <option value="{{ $malePig->id }}">
                                {{ $malePig->individual_num }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4 mr-4 flex-none">
                    <label class="block text-gray-700 text-sm mb-2" for="">
                        オス2の個体番号
                    </label>
                    <select name="second_male_id" id="select2"
                        class="px-6 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="{{ null }}">選択してください</option>
                        @foreach ($malePigs as $malePig)
                            <option value="{{ $malePig->id }}">
                                {{ $malePig->individual_num }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="sample" class="mb-4">
                <div class="hidden" id="malePigs">{{ $malePigs }}</div>
                <input type="button" id="check" value="有効日の確認"
                    class="text-gray-700 text-sm dark:text-blue-500 hover:underline">
                <div id="box" class="text-red-700 text-sm"></div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="mix_day">
                    交配日
                </label>
                <input type="date" name="mix_day"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    required placeholder="交配日" value="{{ old('mix_day') }}">
            </div>
            <input type="submit" value="登録"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>
        <div>
            <a href="{{ route('female_pigs.show', $femalePig) }}"
                class="relative px-4 py-3 font-bold text-black group">
                <span
                    class="absolute inset-0 w-full h-full transition duration-300 ease-out transform -translate-x-2 -translate-y-2 bg-red-300 group-hover:translate-x-0 group-hover:translate-y-0"></span>
                <span class="absolute inset-0 w-full h-full border-4 border-black"></span>
                <span class="relative">戻 る</span>
            </a>
        </div>
    </div> --}}

    <section
        class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-10 px-8 py-4 bg-white rounded shadow-md dark:bg-gray-800">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">交配記録の登録 --MixInfo settings--</h2>

        <x-error-validation :errors="$errors" />

        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div class="mb-1">
                <label class="text-gray-700 dark:text-gray-200" for="individual_num">メスの個体番号</label>
                <input id="" type="text" name="individual_num" readonly
                    value="{{ $femalePig->individual_num }}"
                    class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
            </div>
        </div>

        <form action="{{ route('female_pigs.mix_infos.store', $femalePig) }}" method="POST" class="rounded pt-3 mb-4">
            @csrf
            <div class="block grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <div class="flex">
                    <div class="mb-4 mr-4 flex-none">
                        <label class="text-gray-700 dark:text-gray-200" for="">
                            オス1の個体番号</label>
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
                            オス2の個体番号</label>
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

                <div id="sample" class="mb-4">
                    <div class="hidden" id="malePigs">{{ $malePigs }}</div>
                    <input type="button" id="check" value="有効日の確認"
                        class="text-indigo-700 text-sm dark:text-blue-500 hover:underline">
                    <div id="box" class="text-red-700 text-sm"></div>
                </div>

                <div class="">
                    <label class="text-gray-700 dark:text-gray-200" for="mix_day">交配日</label>
                    <input type="date" name="mix_day" required
                        class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
                        value="{{ old('mix_day') }}">
                </div>

            </div>

            <div class="flex justify-end mt-4">
                <input type="submit" value="登 録"
                    class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-indigo-500 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-gray-600">
            </div>
        </form>
        <a href="{{ route('female_pigs.show', $femalePig) }}"
            class="py-1.5 px-4 transition-colors bg-transparent active:bg-gray-200 font-medium text-blue-600 rounded-lg hover:bg-gray-100 disabled:opacity-50">
            戻る
        </a>
    </section>

    <script>
        var femalePigAddDay = new Date(@json($femalePig).add_day);
        var malePigs = @json($malePigs);
        let selectId1 = document.getElementById('select1');
        let selectId2 = document.getElementById('select2');
        let check = document.getElementById('check');
        let box = document.getElementById('box');

        // // オス1のadd_day
        // selectId1.onchange = function() {
        //     let selectId1 = this.value;

        //     malePigs.forEach(malePig => {
        //         if (malePig.id == selectId1) {
        //             let firstAddDay = new Date(malePig.add_day);
        //             console.log(firstAddDay);
        //         }
        //     });
        // }

        // // オス2のadd_day
        // selectId2.onchange = function() {
        //     let selectId2 = this.value;

        //     malePigs.forEach(malePig => {
        //         if (malePig.id == selectId2) {
        //             let secondAddDay = new Date(malePig.add_day);
        //             console.log(secondAddDay);
        //         }
        //     });
        //     // console.log(secondAddDay);
        // }

        // 日付の比較
        // check.onmousedown = function() {
        check.onclick = function() {

            malePigs.forEach(malePig => {
                if (malePig.id == selectId1.value) {
                    firstAddDay = new Date(malePig.add_day);
                }
            });

            malePigs.forEach(malePig => {
                if (malePig.id == selectId2.value) {
                    secondAddDay = new Date(malePig.add_day);
                }
                secondAddDay = femalePigAddDay;
            });

            try {

                if (femalePigAddDay >= firstAddDay &&
                    femalePigAddDay >= secondAddDay) {
                    effectiveDate = femalePigAddDay.toJSON().substr(0, 10);
                }
                if (firstAddDay >= secondAddDay &&
                    firstAddDay >= femalePigAddDay) {
                    effectiveDate = firstAddDay.toJSON().substr(0, 10);
                }
                if (secondAddDay >= femalePigAddDay &&
                    secondAddDay >= firstAddDay) {
                    effectiveDate = secondAddDay.toJSON().substr(0, 10);
                }
                var message = '交配日は' + effectiveDate + '以降です';
                // document.getElementById('box').textContent = '交配日は' + message + '以降です';
            } catch (error) {
                var message = '個体番号を選択してください';
                // document.getElementById('box').textContent = '個体番号を選択してください';

            }
            // console.log(femalePigAddDay.toJSON().substr(0, 10));
            // console.log(firstAddDay.toJSON().substr(0, 10));
            // console.log(secondAddDay.toJSON().substr(0, 10));
            document.getElementById('box').textContent = message;

        }
    </script>
    {{-- <script src="{{ mix('js/information.js') }}"></script> --}}
</x-app-layout>
