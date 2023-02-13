<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('male_pigs.show') }}
        </h2>
    </x-slot>
    <!-- header - end -->
    
    <!-- message -->
    <x-error-validation :errors="$errors" />
    <x-flash-msg :message="session('notice')" />

    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <!-- base_information - start -->
        <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
            <div class="flex flex-col items-center gap-4 md:gap-6">
                <!-- base - start -->
                <div class="flex justify-center items-center">
                    <div class="text-xl text-sky-800">
                        <i class="fa-solid fa-mars"></i>&ensp;
                    </div>
                    <div class="text-3xl text-gray-500">
                        {{ $malePig->individual_num }}
                    </div>
                </div>
                <div class="flex max-w-md text-gray-600 lg:text-lg text-center">
                    <div class="mx-2">
                        {{ $malePig->add_day }}
                    </div>
                    <div class="mx-2">
                        {{ $malePig->age }}歳
                    </div>
                    <div>
                        <form action="{{ route('male_pigs.updateFlag', $malePig) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="warn_flag" id=""
                                value="{{ $malePig->warn_flag == 0 ? 1 : 0 }}">
                            <button type="submit">
                                @if ($malePig->warn_flag == 0)
                                    <div class="text-gray-100">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    </div>
                                @else
                                    <div class="text-red-600">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    </div>
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
                <div class="mx-2">
                    交配成功率:{{ $malePig->mix_probability }} %
                </div>
                <!-- base - end -->

                <!-- border - start -->
                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-center border-t text-xs text-gray-900 uppercase">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    <i class="fa-solid fa-venus"></i>NO.
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    交配回数
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    成功回数
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    交配成功率
                                </th>
                            </tr>
                        </thead>
                        <tbody class="border-t border-b">
                            @foreach ($malePig->individual_mix_infos as $info)
                                <tr class="bg-white">
                                    <th scope="row"
                                        class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap">
                                        <div>
                                            @if ($info['female'])
                                                <a href="{{ route('female_pigs.show', $info['female']) }}"
                                                    class="text-blue-600 after:content-['_↗'] transition-colors bg-transparent hover:underline">
                                                    {{ $info['female']->individual_num }}
                                                </a>
                                            @endif
                                            <p class="line-through">
                                                {{ $info['delete_female'] }}
                                            </p>
                                        </div>
                                    </th>
                                    <td class="text-center py-3 px-6">
                                        {{ $info['mix_all'] }} 回
                                    </td>
                                    <td class="text-center py-3 px-6">
                                        {{ $info['mix_noTrouble'] }} 回
                                    </td>
                                    <td class="text-center py-3 px-6">
                                        {{ $info['mix_probability'] }} %
                                    </td>
                                </tr>
                            @endforeach
                    </table>
                </div>
                <!-- border - end -->

                <a href="{{ route('male_pigs.index') }}"
                    class="py-1.5 px-4 transition-colors bg-transparent active:bg-gray-200 font-medium text-slate-600 rounded-lg hover:bg-gray-100 disabled:opacity-50">
                    <i class="fa-solid fa-arrow-left"></i>
                    戻る
                </a>
            </div>
        </div>
        <!-- base_information - end -->
    </div>
</x-app-layout>
