<x-app-layout>
    変更箇所は赤色にホバー、再発、流産は非表示javascripteで表示
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
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="mix_day">
                    メスの個体番号
                </label>
                <select name="female_id" id="" required
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="{{ $femalePig->id }}">{{ $femalePig->individual_num }}</option>
                    @foreach ($femalePigs as $female_pig)
                        <option value="{{ $female_pig->id }}">
                            {{ $female_pig->individual_num }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex">
                <div class="mb-4 mr-4 flex-none">
                    <label class="block text-gray-700 text-sm mb-2" for="">
                        オス1の個体番号
                    </label>
                    <select name="first_male_id" id="" required
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="{{ $mixInfo->first_male_id }}">
                            {{ $mixInfo->first_male }}
                            {{ $mixInfo->first_delete_male }}
                        </option>
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
                    <select name="second_male_id" id=""
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="{{ $mixInfo->second_male_id }}">
                            {{ $mixInfo->second_male }}
                            {{ $mixInfo->second_delete_male }}
                        </option>
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
                    required value="{{ old('mix_day', $mixInfo->mix_day) }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="mix_day">
                    再発または流産の日付
                </label>
                <input type="date" name="trouble_day"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="日付" value="{{ old('trouble_day', $mixInfo->trouble_day) }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-2" for="mix_day">
                    種類
                </label>
                @foreach ($troubleCategories as $troubleCategory)
                    <input type="radio" name="trouble_id" value="{{ $troubleCategory->id }}"
                        {{ old('trouble_id', $mixInfo->trouble_id) == $troubleCategory->id ? 'checked' : '' }}
                        class="mr-2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        required>{{ $troubleCategory->trouble_name }}
                @endforeach
            </div>
            <input type="submit" value="修 正"
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
