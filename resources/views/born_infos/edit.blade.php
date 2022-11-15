<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('born_infos.edit') }}
        </h2>
    </x-slot>
    <!-- header - end -->

    <section
        class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-10 px-8 py-4 bg-white rounded shadow-md dark:bg-gray-800">
        <!-- title -->
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">出産情報の修正 --BornInfo editings--</h2>

        <!-- message -->
        <x-error-validation :errors="$errors" />

        <!-- form - start -->
        <form action="{{ route('born_infos.update', $mixInfo) }}" method="POST" class="rounded pt-3 mb-4">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-3">
                <!-- female - start -->
                <div class="mb-4">
                    <label class="text-sm text-gray-700 dark:text-gray-200" for="individual_num">個体番号</label>
                    <input type="hidden" value="{{ $mixInfo->female_pig->id }}" name="female_id">
                    <input id="" type="text" name="individual_num" readonly
                        value="{{ $mixInfo->female_pig->individual_num }}"
                        class="block w-20 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                </div>
                <!-- female - end -->

                <!-- born_day - start -->
                <div class="mb-4">
                    <label class="text-sm text-gray-700 dark:text-gray-200" for="born_day">出産日</label>
                    <input type="date" name="born_day" required
                        class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
                        value="{{ old('born_day', $mixInfo->born_day) }}">
                </div>
                <!-- born_day - end -->

                <!-- born_num - start -->
                <div class="mb-4">
                    <label class="text-sm text-gray-700 dark:text-gray-200" for="born_day">産子数</label>
                    <input type="number" name="born_num" required
                        class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring"
                        placeholder="匹" value="{{ old('born_num', $mixInfo->born_num) }}" min="1" max="20">
                </div>
                <!-- born_num - end -->

                <!-- mix_day - start -->
                <div class="">
                    <input type="hidden" name="mix_day" class="rounded-md border-gray-300" required
                        value="{{ $mixInfo->mix_day }}">
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
            class="py-1.5 px-4 transition-colors bg-transparent active:bg-gray-200 font-medium text-blue-600 rounded-lg hover:bg-gray-100 disabled:opacity-50">
            戻る
        </a>
    </section>
    <div>&emsp;</div>
</x-app-layout>
