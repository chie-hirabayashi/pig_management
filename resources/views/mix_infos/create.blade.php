<x-app-layout>
    <x-slot name="header">
        <h2 class="">
            {{ __('mix_infos.create') }}
        </h2>
    </x-slot>

    <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-white shadow-md">
        <h2 class="text-center text-lg font-bold pt-6 tracking-widest">出産情報の登録</h2>

        <x-error-validation :errors="$errors" />

        <div class="mb-4">
            <label class="block text-gray-700 text-sm mb-2" for="mix_day">
                メス豚の個体番号
            </label>
            <input type="text" name=""
                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                value="{{ $femalePig->individual_num }}" readonly>
        </div>

        <form action="{{ route('female_pigs.mix_infos.store', $femalePig) }}" method="POST"
            class="rounded pt-3 pb-8 mb-4">
            @csrf
            <div class="flex">
                <div class="mb-4 mr-4 flex-none">
                    <label class="block text-gray-700 text-sm mb-2" for="">
                        オス豚の個体番号1
                    </label>
                    <select name="male_first_id" id="" required
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option hidden>選択してください</option>
                        @foreach ($malePigs as $malePig)
                            <option value="{{ $malePig->id }}">
                                {{ $malePig->individual_num }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4 flex-auto">
                    <label class="block text-gray-700 text-sm mb-2" for="">
                        オス豚の個体番号2
                    </label>
                    <select name="male_second_id" id="" required
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option hidden>選択してください</option>
                        @foreach ($malePigs as $malePig)
                            <option value="{{ $malePig->id }}">
                                {{ $malePig->individual_num }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="mix_day">
                    交配日
                </label>
                <input type="date" name="mix_day"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    required placeholder="交配日" value="{{ old('mix_day') }}">
            </div>
            <input type="submit" value="登録"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>
    </div>
</x-app-layout>
