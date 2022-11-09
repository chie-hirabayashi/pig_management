<x-app-layout>
    <x-slot name="header">
        <h2 class="">
            {{ __('male_pigs.create') }}
        </h2>
    </x-slot>

    <section
        class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-10 px-8 py-4 bg-white rounded shadow-md dark:bg-gray-800">
        <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">父豚登録 --MalePig settings--</h2>

        <x-error-validation :errors="$errors" />


        <form action="{{ route('male_pigs.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <div class="mb-4">
                    <label class="text-gray-700 dark:text-gray-200" for="individual_num">個体番号</label>
                    <input id="username" type="text" name="individual_num" required placeholder="99-99"
                        value="{{ old('individual_num') }}"
                        class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                </div>

                <div>
                    <label class="text-gray-700 dark:text-gray-200" for="add_day">導入日</label>
                    <input id="emailAddress" type="date" name="add_day"
                        class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <input type="submit" value="登 録"
                    class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">
            </div>
        </form>
    </section>
</x-app-layout>
