<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('male_pigs.edit') }}
        </h2>
    </x-slot>
    <!-- header - end -->

    <section class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-10 px-8 py-4 bg-white border rounded shadow-md">
        <!-- title -->
        <h2 class="text-2xl MplusRound text-gray-700 capitalize">
            <span class="text-sky-800">
                <i class="fa-solid fa-mars"></i>&ensp;
            </span>
            Pig登録内容修正
        </h2>

        <!-- message -->
        <x-error-validation :errors="$errors" />

        <!-- form - start -->
        <form action="{{ route('male_pigs.update', $malePig) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <!-- individual_num - start -->
                <div class="mb-4 mx-auto">
                    <label class="text-sm text-gray-700" for="individual_num">
                        <span class="text-sky-800">
                            <i class="fa-solid fa-mars"></i>&ensp;
                        </span>
                        NO.
                    </label>
                    <input id="" type="text" name="individual_num" required
                        value="{{ old('individual_num', $malePig->individual_num) }}"
                        class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring">
                </div>
                <!-- individual_num - end -->

                <!-- add_day - start -->
                <div class="mb-4 mx-auto">
                    <label class="text-sm text-gray-700" for="add_day">導入日</label>
                    <input id="" type="date" name="add_day"
                        class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring"
                        value="{{ old('add_day', $malePig->add_day) }}">
                </div>
                <!-- add_day - end -->
            </div>

            <!-- button - start -->
            <div class="flex justify-end mt-6">
                <input type="submit" value="更 新"
                    class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-cyan-800 font-medium border-gray-200 hover:text-white text-cyan-600 hover:border-cyan-700 rounded-lg hover:bg-cyan-700 disabled:opacity-50">
            </div>
            <!-- button - end -->
        </form>
        <!-- form - end -->
        <div class="flex flex-col">
            <a href="{{ route('male_pigs.index') }}"
                class="py-1.5 px-4 mb-4 transition-colors bg-transparent font-medium text-slate-600 rounded-lg disabled:opacity-50 transform hover:-translate-x-1">
                <i class="fa-solid fa-arrow-left"></i>
                戻る
            </a>
        </div>
    </section>
</x-app-layout>
