<x-app-layout>
    TODO:インポートコントローラにリクエスト追加
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

            <div class="grid sm:grid-cols-2 xl:grid-cols-2 gap-4 md:gap-8">
                <!-- femalePig_data - start -->
                <div class="flex flex-col border rounded-lg p-4 md:p-6">
                    <h3 class="text-lg md:text-xl MplusRound mb-2">
                        母豚データのインポート
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">エクセルファイルを選択して取込をクリックするとインポートが開始されます</p>
                    <form method="post" action="{{ route('female_pigs.import') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="excel_file">
                        <!-- button - start -->
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="px-6 py-2 leading-5 text-white transition-colors duration-300 transform bg-indigo-500 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-gray-600">
                                <i class="fa-solid fa-file-import"></i>
                                &ensp;取 込
                            </button>
                        </div>
                        <!-- button - end -->
                    </form>
                </div>
                <!-- femalePig_data - end -->
                
                <!-- femalePig_data - start -->
                <div class="flex flex-col border rounded-lg p-4 md:p-6">
                    <h3 class="text-lg md:text-xl MplusRound mb-2">
                        母豚データのエクスポート
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">エクセルファイルが出力されます</p>
                    <form method="post" action="{{ route('female_pigs.export') }}">
                        @csrf
                        <!-- button - start -->
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="px-6 py-2 leading-5 text-white transition-colors duration-300 transform bg-indigo-500 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-gray-600">
                                出 力&ensp;
                                <i class="fa-solid fa-file-export"></i>
                            </button>
                        </div>
                        <!-- button - end -->
                    </form>
                </div>
                <!-- femalePig_data - end -->

                <!-- malePig_data - start -->
                <div class="flex flex-col border rounded-lg p-4 md:p-6">
                    <h3 class="text-lg md:text-xl MplusRound mb-2">
                        父豚データのインストール
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">エクセルファイルを選択して取込をクリックするとインポートが開始されます</p>
                    <form method="post" action="{{ route('male_pigs.import') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="excel_file"><br>
                        <!-- button - start -->
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="px-6 py-2 leading-5 text-white transition-colors duration-300 transform bg-indigo-500 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-gray-600">
                                <i class="fa-solid fa-file-import"></i>
                                &ensp;取 込
                            </button>
                        </div>
                        <!-- button - end -->
                    </form>
                </div>
                <!-- malePig_data - end -->

                <!-- malePig_data - start -->
                <div class="flex flex-col border rounded-lg p-4 md:p-6">
                    <h3 class="text-lg md:text-xl MplusRound mb-2">
                        父豚データのエクスポート
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">エクセルファイルが出力されます</p>
                    <form method="post" action="{{ route('male_pigs.export') }}">
                        @csrf
                        <!-- button - start -->
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="px-6 py-2 leading-5 text-white transition-colors duration-300 transform bg-indigo-500 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-gray-600">
                                出 力&ensp;
                                <i class="fa-solid fa-file-export"></i>
                            </button>
                        </div>
                        <!-- button - end -->
                    </form>
                </div>
                <!-- malePig_data - end -->

                <!-- mix_info - start -->
                <div class="flex flex-col border rounded-lg p-4 md:p-6">
                    <h3 class="text-lg md:text-xl MplusRound mb-2">
                        交配・出産記録簿のインポート
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">エクセルファイルを選択して取込をクリックするとインポートが開始されます</p>
                    <form method="post" action="{{ route('mix_infos.import') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="excel_file"><br>
                        <!-- button - start -->
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="px-6 py-2 leading-5 text-white transition-colors duration-300 transform bg-indigo-500 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-gray-600">
                                <i class="fa-solid fa-file-import"></i>
                                &ensp;取 込
                            </button>
                        </div>
                        <!-- button - end -->
                    </form>
                </div>
                <!-- feature - end -->

                <!-- mix_info - start -->
                <div class="flex flex-col border rounded-lg p-4 md:p-6">
                    <h3 class="text-lg md:text-xl MplusRound mb-2">
                        交配・出産記録簿のエクスポート
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">エクセルファイルが出力されます</p>
                    <form method="post" action="{{ route('mix_infos.export') }}">
                        @csrf
                        <!-- button - start -->
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="px-6 py-2 leading-5 text-white transition-colors duration-300 transform bg-indigo-500 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-gray-600">
                                出 力&ensp;
                                <i class="fa-solid fa-file-export"></i>
                            </button>
                        </div>
                        <!-- button - end -->
                    </form>
                </div>
                <!-- feature - end -->
            </div>
        </div>
    </div>
</x-app-layout>
