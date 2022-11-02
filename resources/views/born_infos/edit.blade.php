<x-app-layout>
    <x-slot name="header">
        <h2 class="">
            {{ __('born_infos.create') }}
        </h2>
    </x-slot>

    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-stone-50 rounded shadow-md">
        <h2 class="text-center text-lg font-bold pt-6 tracking-widest">出産情報の修正</h2>

        <x-error-validation :errors="$errors" />

        <form action="{{ route('mix_infos.born_infos.update', [$mixInfo, $bornInfo]) }}" method="POST" class="rounded pt-3 pb-8 mb-4">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="individual_num">
                    個体番号
                </label>
                <input type="hidden" value="{{ $mixInfo->female_pig->id }}" name="female_id">
                <input type="text" name="individual_num"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="" value="{{ $mixInfo->female_pig->individual_num }}" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="born_day">
                    出産日
                </label>
                <input type="date" name="born_day" class="rounded-md border-gray-300"
                    required value="{{ old('born_day', $bornInfo->born_day) }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="individual_num">
                    出産子数
                </label>
                <input type="number" name="born_num"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    required placeholder="匹" value="{{ old('born_num', $bornInfo->born_num) }}" min="1" max="20">
            </div>
            <input type="submit" value="修 正"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>
    </div>
</x-app-layout>
