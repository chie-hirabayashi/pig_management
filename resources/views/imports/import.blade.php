<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('imports.import') }}
        </h2>
    </x-slot>
    <!-- header - end -->

    <!-- validation - start -->
    <x-error-validation :errors="$errors" />
    <x-flash-msg :message="session('notice')" />
    <!-- validation - end -->

    <!-- body - start -->
    

    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <!-- base_information - start -->
        <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
            <div class="flex flex-col items-center gap-4 md:gap-6">
                <!-- base - start -->
                <div class="text-3xl text-gray-500 active:text-gray-600 transition duration-100">
                    <div class="w-auto h-6 sm:h-8" width="173" height="39" viewBox="0 0 173 39"
                        fill="currentColor">
                        インポートフォーム
                    </div>
                </div>

                <!-- edit&delete - start -->
                <div class="flex flex-row text-center my-4">
                    {{-- @can('update', $post) --}}
                    {{-- <a href="{{ route('female_pigs.edit', $femalePig) }}" --}}
                    {{-- class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2"> --}}
                    {{-- 編 集 --}}
                    {{-- </a> --}}
                    {{-- @endcan --}}
                    {{-- @can('delete', $post) --}}
                    {{-- <form action="{{ route('female_pigs.destroy', $femalePig) }}" method="post"> --}}
                    {{-- @csrf
                        @method('DELETE')
                        <input type="submit" value="廃 用" onclick="if(!confirm('廃用にしますか？')){return false};"
                            class="bg-pink-400 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">
                    </form> --}}
                </div>
                <!-- edit&delete - end -->

                <!-- quote - start -->
                <div class="flex flex-col sm:flex-row items-center gap-2 md:gap-3">
                    <div>
                        <div class="text-indigo-500 text-sm md:text-base font-bold text-center sm:text-left">John
                            McCulling</div>
                        <p class="text-gray-500 text-sm md:text-sm text-center sm:text-left">CEO / Datadrift</p>
                    </div>
                </div>
                <!-- quote - end -->
            </div>
        </div>
        <!-- base_information - end -->
    </div>

    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
            <!-- text - start -->
            <div class="mb-10 md:mb-16">
                <h2 class="text-gray-800 text-2xl lg:text-3xl font-bold text-center mb-4 md:mb-6">Our competitive
                    advantage</h2>

                <p class="max-w-screen-md text-gray-500 md:text-lg text-center mx-auto">This is a section of some simple
                    filler text, also known as placeholder text. It shares some characteristics of a real written text
                    but is random or otherwise generated.</p>
            </div>
            <!-- text - end -->
                <div>
                </div>
                <div>
                </div>

            <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-8">
                <!-- femalePig_data - start -->
                <div class="flex flex-col border rounded-lg p-4 md:p-6">
                    <h3 class="text-lg md:text-xl font-semibold mb-2">
                        FemalePig_data
                    </h3>
                    <p class="text-gray-500 mb-4">母豚データのインポート、エクスポートはこちらから</p>
                    <form method="post" action="{{ route('female_pigs.import') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="excel_file"><br>
                        <input type="submit" value="インポート"
                            class="text-indigo-500 hover:text-indigo-600 active:text-indigo-700 font-bold transition duration-100 mt-auto">
                    </form>
                    <p class="text-sm text-gray-500 mb-4">エクセルファイルを選択してインポートをクリックするとインポートが開始されます</p>
                    <form method="post" action="{{ route('female_pigs.export') }}">
                        @csrf
                        <input type="submit" value="エクスポート"
                            class="text-indigo-500 hover:text-indigo-600 active:text-indigo-700 font-bold transition duration-100 mt-auto">
                    <p class="text-sm text-gray-500 mb-4">エクスポートをクリックするとエクセルファイルが出力されます</p>
                    </form>
                </div>
                <!-- femalePig_data - end -->

                <!-- femalePig_data - start -->
                <div class="flex flex-col border rounded-lg p-4 md:p-6">
                    <h3 class="text-lg md:text-xl font-semibold mb-2">
                        MalePig_data
                    </h3>
                    <p class="text-gray-500 mb-4">父豚データのインポート、エクスポートはこちらから</p>
                    <form method="post" action="{{ route('male_pigs.import') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="excel_file"><br>
                        <input type="submit" value="インポート"
                            class="text-indigo-500 hover:text-indigo-600 active:text-indigo-700 font-bold transition duration-100 mt-auto">
                    </form>
                    <p class="text-sm text-gray-500 mb-4">エクセルファイルを選択してインポートをクリックするとインポートが開始されます</p>
                    <form method="post" action="{{ route('male_pigs.export') }}">
                        @csrf
                        <input type="submit" value="エクスポート"
                            class="text-indigo-500 hover:text-indigo-600 active:text-indigo-700 font-bold transition duration-100 mt-auto">
                    <p class="text-sm text-gray-500 mb-4">エクスポートをクリックするとエクセルファイルが出力されます</p>
                    </form>
                </div>
                <!-- femalePig_data - end -->

                <!-- mix_info - start -->
                <div class="flex flex-col border rounded-lg p-4 md:p-6">
                    <h3 class="text-lg md:text-xl font-semibold mb-2">
                        交配・出産記録簿
                    </h3>
                    <p class="text-gray-500 mb-4">交配・出産記録簿のインポート、エクスポートはこちらから</p>
                    <form method="post" action="{{ route('mix_infos.import') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="excel_file"><br>
                        <input type="submit" value="インポート"
                            class="text-indigo-500 hover:text-indigo-600 active:text-indigo-700 font-bold transition duration-100 mt-auto">
                    </form>
                    <p class="text-sm text-gray-500 mb-4">エクセルファイルを選択してインポートをクリックするとインポートが開始されます</p>
                    <form method="post" action="{{ route('mix_infos.export') }}">
                        @csrf
                        <input type="submit" value="エクスポート"
                            class="text-indigo-500 hover:text-indigo-600 active:text-indigo-700 font-bold transition duration-100 mt-auto">
                    <p class="text-sm text-gray-500 mb-4">エクスポートをクリックするとエクセルファイルが出力されます</p>
                    </form>
                    
                </div>
                <!-- feature - end -->

                <!-- feature - start -->
                <div class="flex flex-col border rounded-lg p-4 md:p-6">
                    <h3 class="text-lg md:text-xl font-semibold mb-2">Speed</h3>
                    <p class="text-gray-500 mb-4">Filler text is dummy text which has no meaning however looks very
                        similar to real text.</p>
                    <a href="#"
                        class="text-indigo-500 hover:text-indigo-600 active:text-indigo-700 font-bold transition duration-100 mt-auto">More</a>
                </div>
                <!-- feature - end -->

                <!-- feature - start -->
                <div class="flex flex-col border rounded-lg p-4 md:p-6">
                    <h3 class="text-lg md:text-xl font-semibold mb-2">Support</h3>
                    <p class="text-gray-500 mb-4">Filler text is dummy text which has no meaning however looks very
                        similar to real text.</p>
                    <a href="#"
                        class="text-indigo-500 hover:text-indigo-600 active:text-indigo-700 font-bold transition duration-100 mt-auto">More</a>
                </div>
                <!-- feature - end -->

                <!-- feature - start -->
                <div class="flex flex-col border rounded-lg p-4 md:p-6">
                    <h3 class="text-lg md:text-xl font-semibold mb-2">Dark Mode</h3>
                    <p class="text-gray-500 mb-4">Filler text is dummy text which has no meaning however looks very
                        similar to real text.</p>
                    <a href="#"
                        class="text-indigo-500 hover:text-indigo-600 active:text-indigo-700 font-bold transition duration-100 mt-auto">More</a>
                </div>
                <!-- feature - end -->
            </div>
        </div>
    </div>

</x-app-layout>
