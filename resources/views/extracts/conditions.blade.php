<x-app-layout>
    <x-slot name="header">
        <h2 class="">
            {{ __('extracts.conditions') }}
        </h2>
    </x-slot>

    <section
        class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-10 px-8 py-4 bg-white rounded shadow-md dark:bg-gray-800">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">抽出条件の設定</h2>

        <x-error-validation :errors="$errors" />

        <form action="{{ route('extracts.index') }}" method="POST" class="rounded pt-3 mb-4">
            @csrf
            <div class="grid max-w-lg grid-cols-1 gap-6 sm:grid-cols-1">
                <div class="grid grid-cols-3 mb-1">
                    <div class="mt-4">
                        <label class="text-gray-700 dark:text-gray-200" for="">直近の回転数</label>
                        <div class="flex mt-2">
                            <input id="first_rotate" type="number" name="first_rotate"
                                value="{{ 1.8, old('first_rotate') }}" step="0.1" min="1.0" max="2.5"
                                class="px-3 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                            <p class="mt-5 ml-2 text-sm text-gray-700">以下</p>
                        </div>
                    </div>
                    <div class="mt-16 ml-4 text-gray-700">
                        <div class="flex">
                            <input type="radio" name="first_operator" id="first_operator"
                                value="{{ 1 }}" {{ old('first_operator') }}
                                class="block rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required onclick="checkedAnd()">
                            <p class="text-sm">かつ</p>
                        </div>
                        <div class="flex">
                            <input type="radio" name="first_operator" id="first_operator"
                                value="{{ 2 }}" {{ old('first_operator') }}
                                class="block rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required checked onclick="checkedOr()">
                            <p class="text-sm">または</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="text-gray-700 dark:text-gray-200" for="">直近の産子数</label>
                        <div class="flex mt-2">
                            <input id="first_born_num" type="number" name="first_born_num"
                                value="{{ 8, old('first_born_num') }}" min="1" max="10"
                                class="px-3 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                            <p class="mt-5 ml-2 text-sm text-gray-700">匹以下</p>
                        </div>
                    </div>
                </div>

                <div class="max-w-lg ml-4">
                    <div class="text-gray-700">
                        <label class="block text-gray-700 text-sm mb-2" for="mix_day"></label>
                        <input type="radio" name="operator" value="{{ 1 }}" {{ old('operator') }}
                            class="mr-2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required checked>かつ
                        <input type="radio" name="operator" value="{{ 2 }}" {{ old('operator') }}
                            class="mr-2 ml-4 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required>または
                    </div>
                </div>

                <div class="grid grid-cols-3 mb-1">
                    <div class="mt-4">
                        <label class="text-gray-700 dark:text-gray-200" for="">前回の回転数</label>
                        <div class="flex mt-2">
                            <input id="second_rotate" type="number" name="second_rotate"
                                value="{{ 1.8, old('second_rotate') }}" step="0.1" min="1.0" max="2.5"
                                class="block px-3 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                            <p class="mt-5 ml-2 text-sm text-gray-700">以下</p>
                        </div>
                    </div>
                    <div class="mt-16 ml-4 text-gray-700">
                        <div class="flex">
                            <input type="radio" name="second_operator" value="{{ 1 }}"
                                {{ old('second_operator') }}
                                class="block rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                            <p class="text-sm">かつ</p>
                        </div>
                        <div class="flex">
                            <input type="radio" name="second_operator" value="{{ 2 }}"
                                {{ old('second_operator') }}
                                class="block rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required checked>
                            <p class="text-sm">または</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="text-gray-700 dark:text-gray-200" for="">前回の産子数</label>
                        <div class="flex mt-2">
                            <input id="second_born_num" type="number" name="second_born_num"
                                value="{{ 8, old('second_born_num') }}" min="1" max="10"
                                class="block px-3 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                            <p class="mt-5 ml-2 text-sm text-gray-700">匹以下</p>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="flex justify-end mt-4">
                <input type="submit" value="抽 出"
                    class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-indigo-500 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-gray-600">
            </div>

        </form>
        <a href="{{ route('female_pigs.index') }}"
            class="py-1.5 px-4 transition-colors bg-transparent active:bg-gray-200 font-medium text-blue-600 rounded-lg hover:bg-gray-100 disabled:opacity-50">
            戻る
        </a>
    </section>

    <script>
        let rotate1 = document.getElementById('first_rotate');
        let rotate2 = document.getElementById('second_rotate');
        let bornNum1 = document.getElementById('first_born_num');
        let bornNum2 = document.getElementById('second_born_num');
        let radio1 = document.getElementsByName('first_operator');
        let radio2 = document.getElementsByName('second_operator');


        rotate1.onmouseup = function() {
            console.log(rotate1.value);
            rotate2.setAttribute('value', rotate1.value);
        }

        bornNum1.onmouseup = function() {
            console.log(bornNum1.value);
            bornNum2.setAttribute('value', bornNum1.value);
        }

        function checkedAnd() {
            if (radio1[0].checked) {
                console.log(radio1[0].value);
                radio2[0].checked = true;
            }
        }

        function checkedOr() {
            if (radio1[1].checked) {
                console.log(radio1[1].value);
                radio2[1].checked = true;
            }
        }
    </script>
</x-app-layout>