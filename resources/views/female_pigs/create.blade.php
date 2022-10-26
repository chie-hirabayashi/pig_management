<x-app-layout>
    <x-slot name="header">
        <h2 class="">
            {{ __('female_pigs.create') }}
        </h2>
    </x-slot>

    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-stone-200 rounded shadow-md">
        <h2 class="text-center text-lg font-bold pt-6 tracking-widest">母豚の新規登録</h2>

        <x-error-validation :errors="$errors" />

        <form action="{{ route('female_pigs.store') }}" method="POST" class="rounded pt-3 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="individual_num">
                    個体番号
                </label>
                <input type="text" name="individual_num"
                    {{-- class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 py-2 px-3" --}}
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    required placeholder="個体番号" value="{{ old('individual_num') }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="add_day">
                    導入日
                </label>
                <input type="date" name="add_day" class="rounded-md border-gray-300">
            </div>
            <input type="submit" value="登録"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>
    </div>
</x-app-layout>
