<x-app-layout>
交配日の確認ボタン
    <x-slot name="header">
        <h2 class="">
            {{ __('born_infos.create') }}
        </h2>
    </x-slot>

    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-stone-50 rounded shadow-md">
        <h2 class="text-center text-lg font-bold pt-6 tracking-widest">出産情報の登録</h2>

        <x-error-validation :errors="$errors" />

        <form action="{{ route('born_infos.store', $mixInfo) }}" method="POST" class="rounded pt-3 pb-8 mb-4">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="individual_num">
                    個体番号
                </label>
                {{-- <input type="hidden" value="{{ $mixInfo->female_pig->id }}" name="female_id"> --}}
                <input type="text" name="individual_num"
                    {{-- class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" --}}
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="" value="{{ $mixInfo->female_pig->individual_num }}" readonly>
            </div>
            <div class="mb-4">
                <input type="hidden" name="mix_day" class="rounded-md border-gray-300"
                    required value="{{ $mixInfo->mix_day }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="born_day">
                    出産日
                </label>
                <input type="date" name="born_day" class="rounded-md border-gray-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="individual_num">
                    出産子数
                </label>
                <input type="number" name="born_num"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    required placeholder="匹" value="{{ old('born_num') }}" min="1" max="20">
            <div class="mt-4">
                <input type="button" id="check" value="交配日の確認"
                    class="text-gray-700 text-sm dark:text-blue-500 hover:underline">
                <div id="box" class="text-red-700 text-sm"></div>
            </div>
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
</x-app-layout>
