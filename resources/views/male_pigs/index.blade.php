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
            <h2 class="text-gray-800 text-2xl lg:text-3xl font-bold text-center mb-8 md:mb-12">
                malePigs 一覧
            </h2>

            <div class="grid sm:grid-cols-5 lg:grid-cols-5 gap-y-10 sm:gap-y-12 lg:divide-x">
                @foreach ($malePigs as $malePig)
                    <div class="flex flex-col items-center gap-2 md:gap-4 sm:px-4 lg:px-8">
                        <!-- individual_num & flag - start -->
                        <div class="flex text-gray-600 text-xl text-center">
                            <div class="mx-2">
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
                                            <div class="text-red-500">
                                                <i class="fa-solid fa-triangle-exclamation"></i>
                                            </div>
                                        @endif
                                    </button>
                                </form>
                            </div>
                            <div class="">
                                {{ $malePig->individual_num }}
                            </div>
                        </div>
                        <!-- individual_num & flag - end -->

                        <!-- age & status - start -->
                        <div class="flex flex-col sm:flex-row items-center gap-2 md:gap-3">
                            <div class="mx-2 text-gray-500">
                                {{ $malePig->add_day }}
                            </div>
                            <div class="text-center text-gray-500 md:text-sm sm:text-left">
                                {{ $malePig->age }} 歳
                            </div>
                        </div>
                        <!-- age & status - end -->

                        <!-- edit & delete - start -->
                        <div class="flex flex-row text-center my-4 mx-2">
                        {{-- <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2"> --}}
                            {{-- @can('update', $post) --}}
                            {{-- <div> --}}
                            <a href="{{ route('male_pigs.edit', $malePig) }}"
                                class="bg-blue-400 hover:bg-blue-600 text-sm text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline w-16 mr-2">
                                編 集
                            </a>
                            {{-- </div> --}}
                            {{-- @endcan --}}
                            {{-- @can('delete', $post) --}}
                            {{-- <div> --}}
                            <form action="{{ route('male_pigs.destroy', $malePig) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="廃 用" onclick="if(!confirm('廃用にしますか？')){return false};"
                                    class="bg-pink-400 hover:bg-pink-600 text-sm text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline w-16 mr-2">
                            </form>
                            {{-- </div> --}}
                        </div>
                        <!-- edit & delete - end -->

                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
