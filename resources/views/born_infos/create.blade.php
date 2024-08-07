<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('born_infos.create') }}
        </h2>
    </x-slot>
    <!-- header - end -->

    <section
        class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-10 px-8 py-4 bg-gray-100 border rounded shadow-md">
        <!-- title -->
        <h2 class="text-2xl MplusRound text-gray-700 capitalize">出産情報の登録</h2>

        <!-- message -->
        <x-error-validation :errors="$errors" />

        <!-- form - start -->
        <form action="{{ route('born_infos.store', $mixInfo) }}" method="POST" class="rounded pt-3 mb-4">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-4">
                <!-- female - start -->
                <div class="mb-4 mx-auto">
                    <label class="text-sm text-gray-700" for="individual_num">
                        <span class="text-rose-400">
                            <i class="fa-solid fa-venus"></i>
                        </span>
                        NO.
                    </label>
                    <input id="" type="text" name="individual_num" readonly
                        value="{{ $mixInfo->female_pig->individual_num }}"
                        class="block w-20 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring">
                </div>
                <!-- female - end -->

                <!-- born_day - start -->
                <div class="mb-4 mx-auto">
                    <label class="text-sm text-gray-700" for="born_day">出産日</label>
                    <input type="date" name="born_day" required
                        class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring"
                        value="{{ old('born_day') }}">
                </div>
                <!-- born_day - end -->

                <!-- born_num - start -->
                <div class="mb-4 mx-auto">
                    <label class="text-sm text-gray-700" for="born_day">生存数</label>
                    <input type="number" name="born_num" required
                        class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring"
                        placeholder="匹" value="{{ old('born_num') }}" min="1" max="20">
                </div>
                <!-- born_num - end -->

                <!-- stillbirth_num - start -->
                <div class="mb-4 mx-auto">
                    <label class="text-sm text-gray-700" for="born_day">死産数</label>
                    <input type="number" name="stillbirtn_num" required
                        class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring"
                        placeholder="匹" value="{{ old('stillbirth_num') }}" min="0" max="20">
                </div>
                <!-- stillbirth_num - end -->

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
                    class="mr-2 py-1.5 px-4 transition-colors text-gray-600 bg-white border font-medium border-gray-200 rounded-lg hover:bg-gray-100 disabled:opacity-50">
            </div>
            <!-- button - end -->
        </form>
        <!-- form - end -->
        <div class="flex flex-col">
            <a href="{{ route('female_pigs.show', $femalePig) }}"
                class="py-1.5 px-4 mb-4 transition-colors bg-transparent font-medium text-slate-600 rounded-lg disabled:opacity-50 transform hover:-translate-x-1">
                <i class="fa-solid fa-arrow-left"></i>
                戻る
            </a>
        </div>
    </section>
    <div>&emsp;</div>
</x-app-layout>
