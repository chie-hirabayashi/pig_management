<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    @if ($isOpen)
        @include('livewire.place-edit')
    @endif


    <!-- message -->
    <x-error-validation :errors="$errors" />
    <x-flash-msg :message="session('notice')" />

    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <!-- base_information - start -->
        <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
            {{-- <div class="flex flex-col items-center gap-4 md:gap-6"> --}}
            {{-- <div> --}}
            @if ($isOpen)
                @include('livewire.place-edit')
            @endif

            <!-- border - start -->
            <div class="grid lg:grid-cols-3 gap-4 md:gap-6">
                <div class="col-span-2">
                    <h2>繁殖室</h2>
                    <div class="grid sm:grid-cols-2 xl:grid-cols-2 gap-4 md:gap-2">
                        <div class="overflow-x-auto relative">
                            <table class="w-80 text-sm text-left text-gray-500">
                                <thead class="text-center border-t text-xs text-gray-900 uppercase">
                                    <tr>
                                        <th class="border py-3 px-6 w-4/12">
                                        </th>
                                        <th class="border py-3 px-2 w-5/12">
                                            個体番号
                                        </th>
                                        <th class="border py-3 px-2 w-3/12">
                                            場所NO.
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="border-t border-b">
                                    @for ($i = 30; $i < 60; $i++)
                                        <tr class="bg-white">
                                            <td class="border text-center px-2 py-0">
                                                @if (empty($places[$i]->female_pig->individual_num))
                                                    <button wire:click="placeIn({{ $places[$i]->id }})"
                                                        class="basis-1/2 font-medium text-cyan-800 hover:underline hover:font-bold">
                                                        入室
                                                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                                    </button>
                                                @endif
                                                @if (!empty($places[$i]->female_pig->individual_num))
                                                    <button wire:click="placeOut({{ $places[$i]->id }})"
                                                        class="basis-1/2 font-medium text-red-600 hover:underline hover:font-bold">
                                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                                        退室
                                                    </button>
                                                @endif
                                            </td>
                                            @if (!empty($places[$i]->female_pig->mix_infos->last()->first_recurrence_schedule))
                                                @if (date('Y-m-d', strtotime('+3 day')) >=
                                                        ($places[$i]->female_pig->mix_infos->last()->first_recurrence_schedule ||
                                                            $places[$i]->female_pig->mix_infos->last()->first_recurrence == 1) &&
                                                        ($places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule ||
                                                            $places[$i]->female_pig->mix_infos->last()->second_recurrence == 1))
                                                    <th
                                                        class="border py-3 px-2 text-center font-medium whitespace-nowrap">
                                                    @else
                                                    <th
                                                        class="border py-3 px-2 text-center font-medium whitespace-nowrap bg-pink-100">
                                                @endif
                                            @else
                                                <th class="border py-3 px-2 text-center font-medium whitespace-nowrap">
                                            @endif
                                            @if ($places[$i]->female_pig->id)
                                                <a href="{{ route('female_pigs.show', $places[$i]->female_pig->id) }}">
                                                    {{ $places[$i]->female_pig->individual_num }}
                                                </a>
                                            @endif
                                            </th>
                                            <td class="border text-center py-3 px-6">
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
                            <table class="w-80 text-sm text-left text-gray-500">
                                <thead class="text-center border-t text-xs text-gray-900 uppercase">
                                    <tr>
                                        <th class="border py-3 px-2 w-3/12">
                                            場所NO.
                                        </th>
                                        <th class="border py-3 px-2 w-5/12">
                                            個体番号
                                        </th>
                                        <th class="border py-3 px-6 w-4/12">
                                            &emsp;
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="border-t border-b">
                                    @for ($i = 0; $i < 30; $i++)
                                        <tr class="bg-white">
                                            <th
                                                class="border py-3 px-6 text-center font-medium text-gray-900 whitespace-nowrap">
                                                <div>
                                                    <p class="">
                                                        {{ $places[$i]->place_num }}
                                                    </p>
                                                </div>
                                            </th>
                                            {{-- @if ($places[$i]->female_pig->status == '観察中') --}}
                                            @if (!empty($places[$i]->female_pig->mix_infos->last()->id))
                                                @if (
                                                    !empty($places[$i]->female_pig->mix_infos->last()->mix_day) &&
                                                        empty($places[$i]->female_pig->mix_infos->last()->born_day) &&
                                                        $places[$i]->female_pig->mix_infos->last()->trouble_id == 1)

                                                    @if (date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->first_recurrence_schedule ||
                                                            date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)
                                                        @if (
                                                            $places[$i]->female_pig->mix_infos->last()->first_recurrence == 0 ||
                                                                $places[$i]->female_pig->mix_infos->last()->second_recurrence == 0)
                                                            <th
                                                                class="border py-3 px-2 text-center font-medium whitespace-nowrap bg-pink-100">
                                                            @else
                                                            <th
                                                                class="border py-3 px-2 text-center font-medium whitespace-nowrap">
                                                        @endif
                                                    @else
                                                        <th
                                                            class="border py-3 px-2 text-center font-medium whitespace-nowrap">
                                                    @endif
                                                @else
                                                    <th
                                                        class="border py-3 px-2 text-center font-medium whitespace-nowrap">
                                                @endif
                                            @else
                                                <th class="border py-3 px-2 text-center font-medium whitespace-nowrap">
                                            @endif
                                            {{-- @endif --}}
                                            @if ($places[$i]->female_pig->id)
                                                <a href="{{ route('female_pigs.show', $places[$i]->female_pig->id) }}">
                                                    {{ $places[$i]->female_pig->individual_num }}
                                                </a>
                                            @endif
                                            </td>
                                            <td class="border text-center px-2 py-0">
                                                @if (empty($places[$i]->female_pig->individual_num))
                                                    <button wire:click="placeIn({{ $places[$i]->id }})"
                                                        class="basis-1/2 font-medium text-cyan-800 hover:underline hover:font-bold">
                                                        入室
                                                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                                    </button>
                                                @endif
                                                @if (!empty($places[$i]->female_pig->individual_num))
                                                    <button wire:click="placeOut({{ $places[$i]->id }})"
                                                        class="basis-1/2 font-medium text-red-600 hover:underline hover:font-bold">
                                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                                        退室
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endfor
                            </table>
                        </div>
                    </div>
                    <!-- border - end -->
                </div>


                <div>
                    <!-- border - start -->
                    <h2>分娩室</h2>
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
                </div>
            </div>

            <a href="{{ route('male_pigs.index') }}"
                class="py-1.5 px-4 transition-colors bg-transparent active:bg-gray-200 font-medium text-slate-600 rounded-lg hover:bg-gray-100 disabled:opacity-50">
                <i class="fa-solid fa-arrow-left"></i>
                戻る
            </a>
            {{-- </div> --}}
        </div>
        <!-- base_information - end -->
    </div>
    @livewireScripts
</div>
{{-- </x-app-layout> --}}
