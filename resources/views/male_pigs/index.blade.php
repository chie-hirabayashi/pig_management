<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight"> --}}
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('male_pigs.index') }}
        </h2>
    </x-slot>

    <div class="container max-w-7xl mx-auto px-4 md:px-12 pb-3 mt-3">
        <x-flash-msg :message="session('notice')" />
    </div>

    {{-- <div class=" rounded container lg:w-1/2 md:w-4/5 w-11/12 mx-auto mt-8 px-8 bg-white shadow-md"> --}}
    <div class=" rounded container lg:w-1/2 md:w-4/5 w-full mx-auto mt-8 px-0 bg-white shadow-md">
        <table class="w-full">
            <thead class="table-header-group">
                <tr class="table-row border">
                    <th class="table-cell text-center">個体番号</th>
                    <th class="table-cell text-left">年齢</th>
                    <th class="">フラグ</th>
                    <th class="">更新</th>
                    <th class="">廃用</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($malePigs as $malePig)
                    <tr>
                        <td class="table-cell text-center">
                                {{-- <h2 class="font-bold font-sans break-normal text-gray-600 pt-6 pb-1 text-sm md:text-xl"> --}}
                            {{ $malePig->individual_num }}
                        </td>
                        <td class="table-cell text-center">
                            {{ $malePig->age }}歳
                        </td>
                        <td class="table-cell text-center">
                            フラグ
                        </td>
                        <td class="table-cell text-center">
                            {{-- <div class="flex flex-row text-center my-4"> --}}
                            <a href="{{ route('male_pigs.edit', $malePig) }}"
                                class="relative px-4 py-3 font-bold text-black group">
                                <span
                                    class="absolute inset-0 w-full h-full transition duration-300 ease-out transform -translate-x-2 -translate-y-2 bg-red-300 group-hover:translate-x-0 group-hover:translate-y-0"></span>
                                <span class="absolute inset-0 w-full h-full border-4 border-black"></span>
                                <span class="relative">更　新</span>
                            </a>
                            {{-- <a href="{{ route('male_pigs.edit', $malePig) }}"
                                    class="bg-stone-400 hover:bg-blue-600 text-white font-bold py-2 px-3 rounded focus:outline-none focus:shadow-outline w-20 mr-2">更
                                    新</a> --}}
                        </td>
                        <td class="table-cell text-center">
                            <form action="{{ route('male_pigs.destroy', $malePig) }}" method="POST" id="delete"
                                {{-- class="relative px-6 py-3 font-bold text-black group"> --}}
                                class="relative py-2">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" form="delete">
                                <button type="submit" onclick="if(!confirm('廃用にしますか？')){return false};"
                                    class="px-5 py-2.5 relative rounded group font-medium text-white font-medium inline-block">
                                    <span
                                        class="absolute top-0 left-0 w-full h-full rounded opacity-50 filter blur-sm bg-gradient-to-br from-purple-600 to-blue-500"></span>
                                    <span
                                        class="h-full w-full inset-0 absolute mt-0.5 ml-0.5 bg-gradient-to-br filter group-active:opacity-0 rounded opacity-50 from-purple-600 to-blue-500"></span>
                                    <span
                                        class="absolute inset-0 w-full h-full transition-all duration-200 ease-out rounded shadow-xl bg-gradient-to-br filter group-active:opacity-0 group-hover:blur-sm from-purple-600 to-blue-500"></span>
                                    <span
                                        class="absolute inset-0 w-full h-full transition duration-200 ease-out rounded bg-gradient-to-br to-purple-600 from-blue-500"></span>
                                    <span class="relative">廃 用</span>
                                </button>
                            </form>
                            {{-- <form action="{{ route('male_pigs.destroy', $malePig) }}" method="POST"> --}}
                            {{-- <input type="submit" value="廃 用" onclick="if(!confirm('廃用にしますか？')){return false};"
                                    class="bg-stone-400 hover:bg-pink-600 text-white font-bold py-2 px-3 rounded focus:outline-none focus:shadow-outline w-20"> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
