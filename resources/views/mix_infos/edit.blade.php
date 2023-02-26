<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('mix_infos.edit') }}
        </h2>
    </x-slot>
    <!-- header - end -->
    TODO:複数のバグを確認 <br>
    1:オスの重複に対するバリデーションをなしにするか <br>
    2:再発、流産の日付のrequireは他のバリデーションで使用するので必須だが、初期データが空の場合がある <br>
    3:廃用したオスのIDは取得できない=エラーで修正できない。バリデーションを設定するか、最初からedit画面に遷移させない。 <br>
    <section class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-10 px-8 py-4 bg-white border rounded shadow-md">
        <!-- title -->
        <h2 class="text-2xl MplusRound text-gray-700 capitalize">交配記録の修正</h2>

        <!-- message -->
        <x-error-validation :errors="$errors" />

        {{-- <div id="codeDate">{{ $femalePig->mix_infos->last()->born_day }}</div> --}}

        <!-- form - start -->
        <form action="{{ route('female_pigs.mix_infos.update', [$femalePig, $mixInfo]) }}" method="POST"
            class="rounded pt-3 mb-4">
            @csrf
            @method('PATCH')

            {{-- <div class="block grid-cols-1 gap-6 mt-4 sm:grid-cols-2"> --}}
            <div class="block gap-6 mt-4">
                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-3">
                    <!-- female - start -->
                    <div class="mb-6">
                        <label class="text-gray-700" for="individual_num">
                            <span class="text-rose-400">
                                <i class="fa-solid fa-venus"></i>
                            </span>
                            NO.
                        </label>
                        <select name="female_id" id="" required {{-- class="block px-8 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring"> --}}
                            class="block py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring">
                            <option value="{{ $femalePig->id }}">{{ $femalePig->individual_num }}</option>
                            @foreach ($femalePigs as $female_pig)
                                <option value="{{ $female_pig->id }}">
                                    {{ $female_pig->individual_num }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- female - end -->

                    <!-- male - start -->
                    <div class="mb-6">
                        <label class="text-gray-700" for="">
                            <span class="text-indigo-400">
                                <i class="fa-solid fa-mars"></i>
                            </span>
                            1_NO.
                        </label>
                        <select name="first_male_id" id="select1" required
                            class="block px-8 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring">
                            <option value="{{ $mixInfo->first_male_id }}">
                                {{ $mixInfo->first_male_pig->individual_num }}
                                {{-- {{ $mixInfo->first_delete_male }} --}}
                            </option>
                            @foreach ($malePigs as $malePig)
                                <option value="{{ $malePig->id }}">
                                    {{ $malePig->individual_num }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="text-gray-700" for="">
                            <span class="text-indigo-400">
                                <i class="fa-solid fa-mars"></i>
                            </span>
                            2_NO.
                        </label>
                        <select name="second_male_id" id="select2"
                            class="block px-8 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring">
                            @if ($mixInfo->second_male_id)
                                <option value="{{ $mixInfo->second_male_id }}">
                                    {{ $mixInfo->second_male_pig->individual_num }}
                                    {{-- {{ $mixInfo->second_delete_male }} --}}
                                </option>
                            @else
                                <option value="{{ null }}">-</option>
                            @endif
                            <option value="{{ null }}">-</option>
                            @foreach ($malePigs as $malePig)
                                <option value="{{ $malePig->id }}">
                                    {{ $malePig->individual_num }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- male - end -->

                <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
                    <!-- mix_day - start -->
                    <div class="mb-6">
                        <label class="text-gray-700" for="mix_day">交配日</label>
                        <input type="date" name="mix_day" required
                            class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring"
                            value="{{ old('mix_day', $mixInfo->mix_day) }}">
                    </div>
                    <!-- mix_day - end -->

                    <div></div>

                    <!-- trouble_day - start -->
                    <div class="mb-4">
                        <label class="text-gray-700" for="trouble_day">再発または流産の日付</label>
                        <input type="date" name="trouble_day"
                            class="block px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring"
                            value="{{ old('trouble_day', $mixInfo->trouble_day) }}">
                    </div>
                    <!-- trouble_day - end -->

                    <!-- trouble_type - start -->
                    <div class="mb-4">
                        <label class="block mb-1 text-gray-700" for="trouble_type">種類</label>
                        @foreach ($troubleCategories as $troubleCategory)
                            <input type="radio" name="trouble_id" value="{{ $troubleCategory->id }}"
                                {{ old('trouble_id', $mixInfo->trouble_id) == $troubleCategory->id ? 'checked' : '' }}
                                class="text-sm mr-2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>{{ $troubleCategory->trouble_name }}
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- trouble_type - end -->

            <!-- button - start -->
            <div class="flex justify-end mt-6">
                <input type="submit" value="更 新"
                    class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-cyan-800 font-medium border-gray-200 hover:text-white text-cyan-600 hover:border-cyan-700 rounded-lg hover:bg-cyan-700 disabled:opacity-50">
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
