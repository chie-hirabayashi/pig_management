<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('male_pigs.index') }}
        </h2>
    </x-slot>
    <!-- header - end -->

    <!-- message -->
    <x-flash-msg :message="session('notice')" />

    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <div class="max-w-screen-xl px-4 md:px-8 mx-auto">
            <!-- title -->
            <h2 class="MplusRound text-gray-700 text-2xl lg:text-3xl text-center mb-8 md:mb-12">
                {{-- <span class="text-indigo-400"> --}}
                <span class="text-sky-800">
                    <i class="fa-solid fa-mars"></i>
                </span>
                一覧
            </h2>

            <!-- femalePig_data - start -->
            <div class="grid sm:grid-cols-3 xl:grid-cols-5 gap-2 md:gap-4">
                @foreach ($malePigs as $malePig)
                    <div class="flex flex-col border rounded-lg p-4 md:p-6">
                        <div class="flex flex-col items-center gap-2 md:gap-4">
                            <!-- individual_num & flag - start -->
                            <div class="flex h-10 text-center">
                                <div class="mx-2">
                                    @if ($malePig->warn_flag == 1)
                                        <div class="text-red-600 leading-10">
                                            <i class="fa-solid fa-triangle-exclamation"></i>
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('male_pigs.show', $malePig) }}"
                                    class="text-gray-700 text-base leading-10 after:content-['_↗'] transition-colors bg-transparent hover:underline hover:text-sky-700">
                                    No.
                                    <span class="text-xl">
                                        {{ $malePig->individual_num }}
                                    </span>
                                </a>
                            </div>
                            <!-- individual_num & flag - end -->

                            <!-- age & status - start -->
                            <div>
                                <div class="text-gray-500 text-center text-sm font-semibold">
                                    導入日
                                </div>
                                <div class="flex flex-col sm:flex-row items-center gap-2 md:gap-3">
                                    <div class="mx-2 text-gray-500">
                                        {{ $malePig->add_day }}
                                    </div>
                                    <div class="text-center text-gray-500 sm:text-left">
                                        :&ensp;{{ $malePig->age }} 歳
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="text-gray-500 text-center text-sm font-semibold">
                                    交配実績
                                </div>
                                <div class="text-gray-500 text-left">
                                    {{-- <div class="text-gray-500"> --}}
                                    回&emsp;数&ensp;:&ensp;{{ $malePig->all_mixes }} 回
                                </div>
                                <div class="text-gray-500">
                                    成功率&ensp;:&ensp;{{ $malePig->mix_probability }} %
                                </div>
                            </div>

                            <!-- edit & delete - start -->
                            <div class="flex flex-row text-center my-4 mx-2">
                                {{-- @can('update', $post) --}}
                                {{-- <a href="{{ route('male_pigs.edit', $malePig) }}"
                                    class="bg-blue-400 hover:bg-blue-600 text-sm text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline w-16 mr-2">
                                    編 集
                                </a> --}}
                                {{-- @endcan --}}
                                {{-- @can('delete', $post) --}}
                                {{-- <form action="{{ route('male_pigs.destroy', $malePig) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="廃 用"
                                        onclick="if(!confirm('廃用にしますか？')){return false};"
                                        class="bg-pink-400 hover:bg-pink-600 text-sm text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline w-16 mr-2">
                                </form> --}}

                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    {{-- <button type="button" --}}
                                    <a href="{{ route('male_pigs.edit', $malePig) }}"
                                            {{-- class="py-1 px-3 text-sm font-medium text-gray-900 bg-white rounded-l-lg border border-gray-200 hover:bg-blue-200 hover:text-blue-800 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"> --}}
                                        {{-- class="py-1 px-3 text-sm font-medium transition-colors bg-gray-50 border active:bg-red-800 font-medium border-gray-200 hover:text-white text-red-600 hover:border-red-700 rounded-l-md hover:bg-red-700 disabled:opacity-50"> --}}
                                        class="py-1 px-3 text-sm font-medium transition-colors bg-gray-50 border active:bg-cyan-800 font-medium border-gray-200 hover:text-white text-cyan-600 hover:border-cyan-700 rounded-l-lg hover:bg-cyan-700 disabled:opacity-50">
                                        編 集
                                    </a>
                                    {{-- </button> --}}
                                    <form action="{{ route('male_pigs.destroy', $malePig) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="if(!confirm('廃用にしますか？')){return false};"
                                            {{-- class="py-1 px-3 text-sm font-medium text-gray-900 bg-white rounded-r-md border border-gray-200 hover:bg-red-200 hover:text-red-800 focus:z-10 focus:ring-2 focus:ring-red-700 focus:text-red-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"> --}}
                                        class="py-1 px-3 text-sm font-medium transition-colors bg-gray-50 border active:bg-red-800 font-medium border-gray-200 hover:text-white text-red-600 hover:border-red-700 rounded-r-lg hover:bg-red-700 disabled:opacity-50">
                                            廃 用
                                        </button>
                                    </form>
                                </div>

                            </div>
                            <!-- edit & delete - end -->
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- malePig_data - end -->
</x-app-layout>
