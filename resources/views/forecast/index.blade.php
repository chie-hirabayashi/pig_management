<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('forecast.index') }}
        </h2>
    </x-slot>
    <!-- header - end -->

    <!-- message -->
    <x-flash-msg :message="session('notice')" />

    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <div class="max-w-screen-xl px-4 md:px-8 mx-auto">
            <!-- title -->
            <h2 class="MplusRound text-gray-700 text-2xl lg:text-3xl text-center mb-8 md:mb-12">
                <span class="text-sky-800">
                    <i class="fa-solid fa-feather-pointed"></i>
                </span>
                出荷予測
            </h2>

            <!-- border - start -->
            <div class="overflow-x-auto relative">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-center border-t text-xs text-gray-900 uppercase">
                        <tr>
                            <th scope="col" class="py-3 px-4 lx:px-6 whitespace-nowrap">
                                月
                            </th>
                            <th scope="col" class="py-3 px-4 lx:px-6 whitespace-nowrap">
                                予測 出荷頭数
                            </th>
                            <th scope="col" class="py-3 px-4 lx:px-6 whitespace-nowrap">
                                実績 出荷頭数
                            </th>
                            <th scope="col" class="py-3 px-4 lx:px-6 whitespace-nowrap">
                                実績登録
                            </th>
                            <th scope="col" class="py-3 px-4 lx:px-6 whitespace-nowrap">
                                実績編集
                            </th>
                        </tr>
                    </thead>
                    <tbody class="border-t border-b">
                        @foreach ($forecast_num as $date => $num)
                        <tr class="bg-white">
                            <th scope="row"
                                class="py-3 px-4 lx:px-6 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $date }}
                            </th>
                            <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                            <div>
                                {{ $num }} 匹
                            </div>
                            </td>
                            <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                                <p>
                                匹
                                </p>
                            </td>
                            <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                            </td>
                            <td class="text-center py-3 px-4 lx:px-6 whitespace-nowrap">
                            </td>
                        </tr>
                        @endforeach
                </table>
            </div>
            <!-- border - end -->
        </div>
    </div>
    
</x-app-layout>
