<x-app-layout>
    <x-slot name="header">
        <h2 class="">
            {{ __('mix_infos.create') }}
        </h2>
    </x-slot>

    <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-white shadow-md">
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
                    <select name="male_first_id" id="select1" required
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
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
                    <select name="male_second_id" id="select2"
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        {{-- <option hidden>選択してください</option> --}}
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
    </div>

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
