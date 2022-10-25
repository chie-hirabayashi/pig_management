<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight"> --}}
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('male_pigs.edit') }}
        </h2>
    </x-slot>

    <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-white shadow-md">
        <h2 class="text-center text-lg font-bold pt-6 tracking-widest">登録情報の編集</h2>

        <x-error-validation :errors="$errors" />

        <form action="{{ route('male_pigs.update', $malePig) }}" method="POST" class="rounded pt-3 pb-8 mb-4">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="individual_num">
                    {{ '父豚の個体番号' }}
                </label>
                <input type="text" name="individual_num"
                    {{-- class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" --}}
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    required placeholder="個体番号" value="{{ old('individual_num', $malePig->individual_num) }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="add_day">
                    導入日
                </label>
                <input type="date" name="add_day" class="rounded-md border-gray-300"
                    required value="{{ old('add_day', $malePig->add_day) }}">
            </div>
            <input type="submit" value="編　集"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>
    </div>
</x-app-layout>
