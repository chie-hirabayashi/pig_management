<x-app-layout>
    <x-slot name="header">
        <h2 class="">
            {{ __('extracts.conditions') }}
        </h2>
    </x-slot>
    
    <section
        class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-10 px-8 py-4 bg-white border rounded shadow-md">
        <h2 class="text-2xl MplusRound text-gray-700 capitalize">母豚の抽出条件</h2>

        <x-error-validation :errors="$errors" />

        <form action="{{ route('extracts.index') }}" method="POST" class="rounded pt-3 mb-4">
            @csrf
            <div class="text-gray-700 mb-2" for="">
                <i class="fa-solid fa-pen-to-square"></i>
                抽出方法
            </div>
            <div class="grid max-w-lg grid-cols-1 gap-6 sm:grid-cols-1">
                <select name="condition" id="box" onchange="change();"
                    class="px-3 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring">
                    <option value="1">{{ __('condition_1') }}</option>
                    <option value="2">{{ __('condition_2') }}</option>
                    <option value="3">{{ __('condition_3') }}</option>
                    <option value="4">{{ __('condition_4') }}</option>
                </select>

                <!-- first_condition - start -->
                <div class="grid grid-cols-3 mb-1">
                    <div class="mt-4">
                        <label class="text-gray-700" for="">
                            <i class="fa-solid fa-pen-to-square"></i>
                            直近の回転数
                        </label>
                        <div class="flex mt-2">
                            <input id="first_rotate" type="number" name="first_rotate"
                                {{-- value="{{ 1.8, old('first_rotate') }}" step="0.1" min="1.0" max="2.5" --}}
                                value="{{ old('first_rotate', 1.8) }}" step="0.1" min="1.0" max="2.5"
                                class="px-3 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring">
                            <p class="mt-5 ml-2 text-sm text-gray-700">以下</p>
                        </div>
                    </div>
                    <!-- first_operator - start -->
                    <div id="first_condition" style="display: " class="mt-16 ml-4 text-gray-700">
                        <p class="text-sm">かつ</p>
                    </div>
                    <!-- first_operator - end -->
                    <!-- second_operator - start -->
                    <div id="second_operator" style="display: none" class="mt-16 ml-4 text-gray-700">
                        <p class="text-sm">または</p>
                    </div>
                    <!-- second_operator - end -->
                    <div class="mt-4">
                        <label class="text-gray-700" for="">
                            <i class="fa-solid fa-pen-to-square"></i>
                            直近の産子数
                        </label>
                        <div class="flex mt-2">
                            <input id="first_born_num" type="number" name="first_born_num"
                                value="{{ old('first_born_num', 8) }}" min="1" max="10"
                                class="px-3 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring">
                            <p class="mt-5 ml-2 text-sm text-gray-700">匹以下</p>
                        </div>
                    </div>
                </div>
                <!-- first_condition - start -->

                <!-- second_condition - start -->
                <div id="second_condition" style="display: none" class="grid grid-cols-3 mb-1">
                    <div class="mt-4">
                        <label class="text-gray-700" for="">
                            <i class="fa-solid fa-pen-to-square"></i>
                            前回の回転数
                        </label>
                        <div class="flex mt-2">
                            <input id="second_rotate" type="number" name="second_rotate"
                                value="{{ old('second_rotate', 1.8) }}" step="0.1" min="1.0" max="2.5"
                                class="block px-3 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring">
                            <p class="mt-5 ml-2 text-sm text-gray-700">以下</p>
                        </div>
                    </div>
                    <div class="mt-16 ml-4 text-gray-700">
                        <p class="text-sm">または</p>
                    </div>
                    <div class="mt-4">
                        <label class="text-gray-700" for="">
                            <i class="fa-solid fa-pen-to-square"></i>
                            前回の産子数
                        </label>
                        <div class="flex mt-2">
                            <input id="second_born_num" type="number" name="second_born_num"
                                value="{{ old('second_born_num', 8) }}" min="1" max="10"
                                class="block px-3 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring">
                            <p class="mt-5 ml-2 text-sm text-gray-700">匹以下</p>
                        </div>
                    </div>
                </div>
                <!-- second_condition - end -->

                <!-- option_condition - start -->
                <div id="option_condition" style="display: none" class="grid grid-cols-3 mb-1">
                    <div class="mt-4">
                        <label class="text-gray-700" for="">
                            <i class="fa-solid fa-pen-to-square"></i>
                            母豚の年齢
                        </label>
                        <div class="flex mt-2">
                            <input id="female_age" type="number" name="female_age" value="{{ old('female_age', 4) }}"
                                min="1" max="10"
                                class="px-3 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring">
                            <p class="mt-5 ml-2 text-sm text-gray-700">以上</p>
                        </div>
                    </div>
                    <div class="mt-16 ml-4 text-gray-700">
                        <div class="flex">
                            <input type="radio" name="option_operator" id="option_operator"
                                value="{{ 1 }}" {{ old('option_operator') }}
                                class="block rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required checked>
                            <p class="text-sm">かつ</p>
                        </div>
                        <div class="flex">
                            <input type="radio" name="option_operator" id="option_operator"
                                value="{{ 2 }}" {{ old('option_operator') }}
                                class="block rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                            <p class="text-sm">または</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="text-gray-700" for="">
                            <i class="fa-solid fa-pen-to-square"></i>
                            再発・流産の回数
                        </label>
                        <div class="flex mt-2">
                            <input id="trouble_num" type="number" name="trouble_num"
                                value="{{ old('trouble_num', 1) }}" min="1" max="10"
                                class="px-3 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring">
                            <p class="mt-5 ml-2 text-sm text-gray-700">回以上</p>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="text-gray-700">
                        <i class="fa-solid fa-pen-to-square"></i>
                        予測回転数1.8以下
                    </p>
                </div>
                <!-- option_condition - end -->
            </div>

            <div class="flex justify-end mt-4">
                <input type="submit" value="抽 出"
                    class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-slate-700 font-medium border-gray-200 hover:text-white text-slate-700 hover:border-slate-700 rounded-lg hover:bg-slate-700 disabled:opacity-50">
            </div>

        </form>
        <a href="{{ route('female_pigs.index') }}"
            class="py-1.5 px-4 mb-10 transition-colors bg-transparent active:bg-gray-200 font-medium text-slate-600 rounded-lg disabled:opacity-50 transform hover:-translate-x-1">
            <i class="fa-solid fa-arrow-left"></i>
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

        let condition = document.getElementsByName('condition');
        let firstCondition = document.getElementById('first_condition');
        let secondCondition = document.getElementById('second_condition');
        let optionCondition = document.getElementById('option_condition');
        let secondOperator = document.getElementById('second_operator');

        let box = document.getElementById("box");

        function change() {
            boxValue = box.value;
            if (boxValue == "1") {
                firstCondition.style.display = "";
                secondCondition.style.display = "none";
                optionCondition.style.display = "none";
                secondOperator.style.display = "none";
            }
            if (boxValue == "2") {
                firstCondition.style.display = "";
                secondCondition.style.display = "none";
                optionCondition.style.display = "";
                secondOperator.style.display = "none";
            }
            if (boxValue == "3") {
                firstCondition.style.display = "none";
                secondCondition.style.display = "";
                optionCondition.style.display = "none";
                secondOperator.style.display = "";
            }
            if (boxValue == "4") {
                firstCondition.style.display = "none";
                secondCondition.style.display = "";
                optionCondition.style.display = "";
                secondOperator.style.display = "";
            }
        }

        function changeFirstCondition() {
            if (condition[0].checked) {
                console.log(condition[0].value);
                firstCondition.style.display = "";
                secondCondition.style.display = "none";
                secondOperator.style.display = "none";
            }
        }

        function changeSecondCondition() {
            if (condition[1].checked) {
                console.log(condition[1].value);
                firstCondition.style.display = "none";
                secondCondition.style.display = "";
                secondOperator.style.display = "";
            }
        }

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
