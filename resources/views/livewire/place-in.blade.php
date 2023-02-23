<div>

    @if ($isOpen)
        @include('livewire.place-edit')
    @endif

    <!-- message -->
    <x-error-validation :errors="$errors" />
    <x-flash-msg :message="session('notice')" />

    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <!-- base_information - start -->
        <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
            @if ($isOpen)
                @include('livewire.place-edit')
            @endif

            <!-- border - start -->
            <div class="grid xl:grid-cols-2 gap-4 md:gap-6">
                {{-- <div class="col-span-2"> --}}
                <div class="mb-10">
                    <h2 class="MplusRound text-gray-700 text-2xl lg:text-3xl text-center mb-6">繁殖室</h2>
                    <div class="grid sm:grid-cols-2 xl:grid-cols-2 gap-4 md:gap-2">
                        <div class="overflow-x-auto relative w-full xl:w-64 mx-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-center text-xs text-gray-900 uppercase">
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
                                <tbody>
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
                                            <td
                                                class="border py-3 px-2 text-center font-medium whitespace-nowrap
                                                @if (!empty($places[$i]->female_pig->mix_infos->last()->id)) @if ($places[$i]->female_pig->status == '観察中')
                                                        @if (date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->first_recurrence_schedule ||
                                                                date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)
                                                            @if (
                                                                $places[$i]->female_pig->mix_infos->last()->first_recurrence == 0 ||
                                                                    $places[$i]->female_pig->mix_infos->last()->second_recurrence == 0)
                                                                bg-pink-100 @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            ">
                                                @if ($places[$i]->female_pig->id)
                                                    <a
                                                        href="{{ route('female_pigs.show', $places[$i]->female_pig->id) }}">
                                                        {{ $places[$i]->female_pig->individual_num }}
                                                    </a>
                                                @endif
                                            </td>
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
                        <div class="overflow-x-auto relative w-full xl:w-64 mx-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-center text-xs text-gray-900 uppercase">
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
                                <tbody>
                                    @for ($i = 0; $i < 30; $i++)
                                        <tr class="bg-white">
                                            <td
                                                class="border py-3 px-6 text-center font-medium text-gray-900 whitespace-nowrap">
                                                <div>
                                                    <p class="">
                                                        {{ $places[$i]->place_num }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td
                                                class="border py-3 px-2 text-center font-medium whitespace-nowrap
                                                @if (!empty($places[$i]->female_pig->mix_infos->last()->id)) @if ($places[$i]->female_pig->status == '観察中')
                                                        @if (date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->first_recurrence_schedule ||
                                                                date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)
                                                            @if (
                                                                $places[$i]->female_pig->mix_infos->last()->first_recurrence == 0 ||
                                                                    $places[$i]->female_pig->mix_infos->last()->second_recurrence == 0)
                                                                    bg-pink-100 @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            ">
                                                @if ($places[$i]->female_pig->id)
                                                    <a
                                                        href="{{ route('female_pigs.show', $places[$i]->female_pig->id) }}">
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
                    <h2 class="MplusRound text-gray-700 text-2xl lg:text-3xl text-center mb-6">分娩室</h2>
                    <div class="grid sm:grid-cols-2 xl:grid-cols-2 gap-4 md:gap-2">
                        <div class="overflow-x-auto relative w-full xl:w-64 mx-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-center text-xs text-gray-900 uppercase">
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
                                <tbody>
                                    @for ($i = 60; $i < 80; $i++)
                                        @if ($i % 2 != 0)
                                            <tr class="bg-white">
                                                <td
                                                    class="border py-3 px-2 text-center font-medium whitespace-nowrap
                                                @if (!empty($places[$i]->female_pig->mix_infos->last()->id)) @if ($places[$i]->female_pig->status == '観察中')
                                                        @if (date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->first_recurrence_schedule ||
                                                                date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)
                                                            @if (
                                                                $places[$i]->female_pig->mix_infos->last()->first_recurrence == 0 ||
                                                                    $places[$i]->female_pig->mix_infos->last()->second_recurrence == 0)
                                                                bg-pink-100 @endif
                                                        @endif
                                                    @endif
                                                @endif
                                                ">
                                                    @if ($places[$i]->female_pig->id)
                                                        <a
                                                            href="{{ route('female_pigs.show', $places[$i]->female_pig->id) }}">
                                                            {{ $places[$i]->female_pig->individual_num }}
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="border text-center py-3 px-6">
                                                    <div>
                                                        <p class="font-medium text-gray-900">
                                                            {{ $places[$i]->place_num }}
                                                        </p>
                                                    </div>
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
                                        @endif
                                    @endfor
                            </table>
                        </div>
                        <div class="overflow-x-auto relative w-full xl:w-64 mx-auto">
                            <table class="w-full text-sm text-left text-gray-500">
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
                                <tbody>
                                    @for ($i = 60; $i < 80; $i++)
                                        @if ($i % 2 == 0)
                                            <tr class="bg-white">
                                                <td
                                                    class="border py-3 px-6 text-center font-medium text-gray-900 whitespace-nowrap">
                                                    <div>
                                                        <p class="">
                                                            {{ $places[$i]->place_num }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td
                                                    class="border py-3 px-2 text-center font-medium whitespace-nowrap
                                                @if (!empty($places[$i]->female_pig->mix_infos->last()->id)) @if ($places[$i]->female_pig->status == '観察中')
                                                        @if (date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->first_recurrence_schedule ||
                                                                date('Y-m-d', strtotime('+3 day')) > $places[$i]->female_pig->mix_infos->last()->second_recurrence_schedule)
                                                            @if (
                                                                $places[$i]->female_pig->mix_infos->last()->first_recurrence == 0 ||
                                                                    $places[$i]->female_pig->mix_infos->last()->second_recurrence == 0)
                                                                    bg-pink-100 @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            ">
                                                    @if ($places[$i]->female_pig->id)
                                                        <a
                                                            href="{{ route('female_pigs.show', $places[$i]->female_pig->id) }}">
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
                                        @endif
                                    @endfor
                            </table>
                        </div>
                    </div>
                    <!-- border - end -->
                </div>
            </div>

        </div>
        <!-- base_information - end -->
    </div>
    @livewireScripts
</div>
