<x-app-layout>
変更箇所は赤色にホバー
    <x-slot name="header">
        <h2 class="">
            {{ __('mix_infos.edit') }}
        </h2>
    </x-slot>

    <div class="container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-white shadow-md">
        <h2 class="text-center text-lg font-bold pt-6 tracking-widest">交配記録の修正</h2>

        <x-error-validation :errors="$errors" />

        <form action="{{ route('female_pigs.mix_infos.update', [$femalePig, $mixInfo]) }}" method="POST"
            class="rounded pt-3 pb-8 mb-4">
            @csrf
            @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-2" for="mix_day">
                        メスの個体番号
                    </label>
                    <select name="female_id" id="" required
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="{{ $femalePig->id }}">{{ $femalePig->individual_num }}</option>
                        @foreach ($femalePigs as $femalePig)
                            <option value="{{ $femalePig->id }}">
                                {{ $femalePig->individual_num }}
                            </option>
                        @endforeach
                    </select>
                </div>

            <div class="flex">
                <div class="mb-4 mr-4 flex-none">
                    <label class="block text-gray-700 text-sm mb-2" for="">
                        オス1の個体番号
                    </label>
                    <select name="male_first_id" id="" required
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="{{ $mixInfo->male_first_id }}">{{ $mixInfo->first_male_pig->individual_num }}</option>
                        @foreach ($malePigs as $malePig)
                            <option value="{{ $malePig->id }}">
                                {{ $malePig->individual_num }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4 flex-auto">
                    <label class="block text-gray-700 text-sm mb-2" for="">
                        オス2の個体番号
                    </label>
                    <select name="male_second_id" id="" required
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="{{ $mixInfo->male_second_id }}">{{ $mixInfo->second_male_pig->individual_num }}</option>
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
                    required placeholder="交配日" value="{{ old('mix_day', $mixInfo->mix_day) }}">
            </div>
            <input type="submit" value="修 正"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        </form>
    </div>
</x-app-layout>
