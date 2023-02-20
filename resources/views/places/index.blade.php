

<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('places.index') }}
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

                <!-- border - start -->
                <div class="grid sm:grid-cols-2 xl:grid-cols-2 gap-4 md:gap-2">
                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-center border-t text-xs text-gray-900 uppercase">
                                <tr>
                                    <th scope="col" class="py-3 px-6">
                                        個体番号
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        場所NO.
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="border-t border-b">
                                @for ($i = 30; $i < 60; $i++)
                                    <tr class="bg-white">
                                        <th class="py-3 px-6 text-center font-medium whitespace-nowrap">
                                            {{ $places[$i]->female_pig->individual_num }}
                                        </th>
                                        <td class="text-center py-3 px-6">
                                            <div>
                                                <p class="font-medium text-gray-900">
                                                    {{ $places[$i]->place_num }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endfor
                        </table>
                    </div>
                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-center border-t text-xs text-gray-900 uppercase">
                                <tr>
                                    <th class="py-3 px-6">
                                        場所NO.
                                    </th>
                                    <th class="py-3 px-6">
                                        個体番号
                                    </th>
                                    <th class="py-3 px-6">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="border-t border-b">
                                @for ($i = 0; $i < 30; $i++)
                                    <tr class="bg-white">
                                        <th class="py-3 px-6 text-center font-medium text-gray-900 whitespace-nowrap">
                                            <div>
                                                <p class="">
                                                    {{ $places[$i]->place_num }}
                                                </p>
                                            </div>
                                        </th>
                                        <td class="text-center py-3 px-6">
                                            {{ $places[$i]->female_pig->individual_num }}
                                            {{-- FIXME:livewireへ --}}
                                            {{-- <form action="{{ route('places.put', $places[$i]) }}" method="POST"
                                                id="put">
                                                @csrf
                                                @method('PATCH')
                                                <select name="female_id" required
                                                    class="block pl-6 pr-8 py-2 mt-2 text-gray-700 bg-white focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 focus:outline-none focus:ring">
                                                    <option hidden>選択してください</option>
                                                    @foreach ($femalePigs as $femalePig)
                                                        <option value="{{ $femalePig->id }}">
                                                            {{ $femalePig->individual_num }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form> --}}
                                        </td>
                                        <td class="text-center py-3 pl-6 pr-3">
                                            <form action="{{ route('places.update', $places[$i]) }}" method="POST" id="out">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="female_id" value="">
                                                <input type="submit" value="退室" class="">
                                            </form>
                                        </td>
                                        <td class="text-center py-3 pl-3 pr-6">
                                            {{-- <input form="put" type="submit" value="入室" class=""> --}}
                                            入室livewire
                                        </td>
                                    </tr>
                                @endfor
                        </table>
                    </div>
                </div>
                <!-- border - end -->

                <!-- border - start -->
                <div class="grid sm:grid-cols-2 xl:grid-cols-2 gap-4 md:gap-2">
                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-center border-t text-xs text-gray-900 uppercase">
                                <tr>
                                    <th scope="col" class="py-3 px-6">
                                        個体番号
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        場所NO.
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="border-t border-b">
                                @for ($i = 60; $i < 80; $i++)
                                    @if ($i % 2 != 0)
                                        <tr class="bg-white">
                                            <th class="py-3 px-6 text-center font-medium whitespace-nowrap">
                                                {{ $places[$i]->female_pig->individual_num }}
                                            </th>
                                            <td class="text-center py-3 px-6">
                                                <div>
                                                    <p class="font-medium text-gray-900">
                                                        {{ $places[$i]->place_num }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endfor
                        </table>
                    </div>
                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-center border-t text-xs text-gray-900 uppercase">
                                <tr>
                                    <th scope="col" class="py-3 px-6">
                                        場所NO.
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        個体番号
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="border-t border-b">
                                @for ($i = 60; $i < 80; $i++)
                                    @if ($i % 2 == 0)
                                        <tr class="bg-white">
                                            <th
                                                class="py-3 px-6 text-center font-medium text-gray-900 whitespace-nowrap">
                                                <div>
                                                    <p class="">
                                                        {{ $places[$i]->place_num }}
                                                    </p>
                                                </div>
                                            </th>
                                            <td class="text-center py-3 px-6">
                                                {{ $places[$i]->female_pig->individual_num }}
                                            </td>
                                        </tr>
                                    @endif
                                @endfor
                        </table>
                    </div>
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

