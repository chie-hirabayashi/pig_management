<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('male_pigs.create') }}
        </h2>
    </x-slot>
    <!-- header - end -->

    <section
        class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-10 px-8 py-4 bg-white border rounded shadow-md dark:bg-gray-800">
        <!-- title -->
        <h2 class="text-2xl MplusRound text-gray-700 capitalize dark:text-white">父豚登録</h2>

        <!-- message -->
        <x-error-validation :errors="$errors" />

        <!-- form - start -->
        <form action="{{ route('male_pigs.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <!-- individual_num - start -->
                <div class="mb-4">
                    <label class="text-sm text-gray-700 dark:text-gray-200" for="individual_num">
                    <span class="text-sky-800">
                            <i class="fa-solid fa-mars"></i>
                        </span>
                        &ensp;:&ensp;NO.
                    </label>
                    <input id="username" type="text" name="individual_num" required placeholder="個体番号を入力"
                        value="{{ old('individual_num') }}"
                        class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                </div>
                <!-- individual_num - end -->

                <!-- add_day - start -->
                <div>
                    <label class="text-sm text-gray-700 dark:text-gray-200" for="add_day">導入日</label>
                    <input id="emailAddress" type="date" name="add_day"
                        class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                </div>
                <!-- add_day - end -->
            </div>

            <!-- button - start -->
            <div class="flex justify-end mt-6">
                <input type="submit" value="登 録"
                    class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-cyan-500 font-medium border-gray-200 hover:text-white text-cyan-600 hover:border-cyan-600 rounded-lg hover:bg-cyan-500 disabled:opacity-50">
            </div>
            <!-- button - end -->
        </form>
        <!-- form - end -->
        <a href="{{ route('male_pigs.index') }}"
            class="py-1.5 px-4 transition-colors bg-transparent active:bg-gray-200 font-medium text-blue-600 rounded-lg hover:bg-gray-100 disabled:opacity-50">
            <i class="fa-solid fa-arrow-left"></i>
            戻る
        </a>
    </section>
</x-app-layout>
