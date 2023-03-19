<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('management.index') }}
        </h2>
    </x-slot>
    <!-- header - end -->


    <div class="bg-white py-4 sm:py-6 lg:py-10">
        <!-- base_information - start -->
        <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
            <!-- title -->
            <h2 class="MplusRound text-gray-700 text-2xl lg:text-3xl text-center">
                <span class="text-sky-800">
                    <i class="fa-solid fa-venus-mars"></i>
                </span>
                管理簿
            </h2>
        </div>
    </div>

    <div class="overflow-x-auto relative shadow-md mb-8">
        <!-- mix_table - start -->
        <table class="w-full text-sm text-left text-gray-500 border-t border-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr class="border-b whitespace-nowrap">
                    <th scope="col" class="py-3 pr-4 pl-8 w-1/6">
                        交配日
                    </th>
                    <th scope="col" class="py-3 px-6 w-1/12 text-center">
                        <span class="text-rose-800">
                            <i class="fa-solid fa-venus"></i>
                        </span>NO.
                    </th>
                    <th scope="col" class="py-3 px-6 w-1/12 text-center">
                        <span class="text-sky-800">
                            <i class="fa-solid fa-mars"></i>
                        </span>1_NO.
                    </th>
                    <th scope="col" class="py-3 px-6 w-1/12 text-center">
                        <span class="text-sky-800">
                            <i class="fa-solid fa-mars"></i>
                        </span>2_NO.
                    </th>
                    <th scope="col" class="py-3 px-6 w-1/6 text-center">
                        再発予定日1
                    </th>
                    <th scope="col" class="py-3 px-6 w-1/6 text-center">
                        再発予定日2
                    </th>
                    <th scope="col" class="py-3 px-6 w-1/6 text-center">
                        出産予定日
                    </th>
                    <th scope="col" class="py-3 pr-4 pl-8 w-1/12">
                        経 過
                    </th>
                    <th scope="col" class="py-3 pr-4 pl-8 w-1/6">
                        出産日
                    </th>
                    <th scope="col" class="py-3 px-4 w-1/12 text-center">
                        出産子数
                    </th>
                    <th scope="col" class="py-3 px-4 w-1/12 text-center">
                        回転数
                    </th>
                    <th scope="col" class="py-3 px-4 w-1/6 text-center">
                        離乳日
                    </th>
                    <th colspan="3" scope="col" class="py-3 pl-6 pr-4">
                        離乳子数
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($mixInfos)
                    @foreach ($mixInfos as $mixInfo)
                        <tr class="bg-white border-b hover:bg-gray-50 whitespace-nowrap">
                            <td class="py-4 px-6">
                                {{ $mixInfo->mix_day }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ $mixInfo->female_pig_with_trashed->individual_num }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ $mixInfo->first_male_pig_with_trashed->individual_num }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ $mixInfo->second_male_pig_with_trashed->individual_num }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ $mixInfo->first_recurrence_schedule }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ $mixInfo->second_recurrence_schedule }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ $mixInfo->delivery_schedule }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                {{ $mixInfo->trouble_id == 2 ? '再発' : ($mixInfo->trouble_id == 3 ? '流産' : '') }}
                            </td>
                            <td class="py-4 pr-4 pl-6 w-1/6">
                                {{ $mixInfo->born_day }}
                            </td>
                            <td class="py-4 px-4 w-1/12 text-center">
                                {{ empty($mixInfo->born_num) ? '' : $mixInfo->born_num . '匹' }}
                            </td>
                            <td class="py-4 px-4 w-1/12 text-center">
                                {{ empty($mixInfo->rotate) ? '' : $mixInfo->rotate . '回' }}
                            </td>
                            <td class="py-4 px-4 w-1/6 text-center">
                                {{ $mixInfo->weaning_day }}
                            </td>
                            <td class="py-4 px-4 w-1/12 text-center">
                                {{ empty($mixInfo->weaning_num) ? '' : $mixInfo->weaning_num . '匹' }}
                            </td>
                    @endforeach
                @endif
            </tbody>
        </table>
        <!-- mix_table - end -->
    </div>
        {{ $mixInfos->links() }}
</x-app-layout>

