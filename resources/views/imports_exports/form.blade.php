<x-app-layout>
    FIXME:インポートコントローラにリクエスト追加
    TODO:データ取込は初期化が必要
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('imports.import') }}
        </h2>
    </x-slot>
    <!-- header - end -->

    <!-- body - start -->
    <section class="bg-white dark:bg-gray-900">
        <div class="container max-w-4xl px-6 py-10 mx-auto">
            <h1 class="text-4xl MplusRound text-center mb-8 text-gray-800 dark:text-white">
                データの入出力
            </h1>
            
            <!-- validation - start -->
            <x-error-validation :errors="$errors" />
            <x-flash-msg :message="session('notice')" />
            <!-- validation - end -->
            
            <div class="mt-12 space-y-8">
                <!-- import - start -->
                <div class="border-2 border-gray-100 rounded-lg dark:border-gray-700">
                    <div class="flex items-center justify-between rounded-t-lg w-full bg-gray-300 px-8 py-6">
                        <h1 class="font-semibold text-lg text-white dark:text-white">
                            インポート
                        </h1>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700">

                    <p class="p-8 text-sm text-gray-500 dark:text-gray-300">
                        エクセルファイルを選択して取込をクリック<br>
                        交配出産記録は母豚データと父豚データの取込後にインポートできます
                    </p>

                    <!-- femalePig_import - start -->
                    <div class="items-center justify-between w-full pt-8 px-8 pb-2">
                        <h1 class="MplusRound font-semibold text-gray-700 dark:text-whit">
                            母豚データのインポート
                        </h1>
                    </div>

                    <div class="pb-8 px-8 text-sm text-gray-500 dark:text-gray-300">
                        <form method="post" action="{{ route('female_pigs.import') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mt-2">
                                    <input type="file" name="excel_file">
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-slate-700 font-medium border-gray-200 hover:text-white text-slate-700 hover:border-slate-700 rounded-lg hover:bg-slate-700 disabled:opacity-50">
                                        <i class="fa-solid fa-file-import"></i>
                                        &ensp;取 込
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- femalePig_import - end -->

                    <!-- malePig_import - start -->
                    <div class="items-center justify-between w-full pt-8 px-8 pb-2">
                        <h1 class="MplusRound font-semibold text-gray-700 dark:text-whit">
                            父豚データのインポート
                        </h1>
                    </div>

                    <div class="pb-8 px-8 text-sm text-gray-500 dark:text-gray-300">
                        <form method="post" action="{{ route('male_pigs.import') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mt-2">
                                    <input type="file" name="excel_file">
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-slate-700 font-medium border-gray-200 hover:text-white text-slate-700 hover:border-slate-700 rounded-lg hover:bg-slate-700 disabled:opacity-50">
                                        <i class="fa-solid fa-file-import"></i>
                                        &ensp;取 込
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- malePig_import - end -->

                    <!-- mixInfo_import - start -->
                    <div class="items-center justify-between w-full pt-8 px-8 pb-2">
                        <h1 class="MplusRound font-semibold text-gray-700 dark:text-whit">
                            交配出産記録のインポート
                        </h1>
                    </div>

                    <div class="pb-8 px-8 text-sm text-gray-500 dark:text-gray-300">
                        <form method="post" action="{{ route('mix_infos.import') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mt-2">
                                    <input type="file" name="excel_file">
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-slate-700 font-medium border-gray-200 hover:text-white text-slate-700 hover:border-slate-700 rounded-lg hover:bg-slate-700 disabled:opacity-50">
                                        <i class="fa-solid fa-file-import"></i>
                                        &ensp;取 込
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- mixInfo_import - end -->
                </div>
                <!-- import - start -->

                <!-- export - start -->
                <div class="border-2 border-gray-100 rounded-lg dark:border-gray-700">
                    <div class="flex items-center justify-between rounded-t-lg w-full bg-gray-300 px-8 py-6">
                        <h1 class="font-semibold text-lg text-white dark:text-white">
                            エクスポート
                        </h1>
                    </div>

                    <hr class="border-gray-200 dark:border-gray-700">

                    <p class="p-8 text-sm text-gray-500 dark:text-gray-300">
                        出力をクリック<br>
                        エクセルファイルが出力されます
                    </p>

                    <!-- femalePig_export - start -->
                    <div class="pb-8 px-8 text-gray-500 dark:text-gray-300">
                        <div class="grid grid-cols-2 gap-4">
                            <h1 class="MplusRound font-semibold text-gray-700 dark:text-whit">
                                母豚データのエクスポート
                            </h1>

                            <form method="post" action="{{ route('female_pigs.export') }}">
                                @csrf
                                <div class="flex justify-end text-sm">
                                    <button type="submit"
                                        class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-slate-700 font-medium border-gray-200 hover:text-white text-slate-700 hover:border-slate-700 rounded-lg hover:bg-slate-700 disabled:opacity-50">
                                        <i class="fa-solid fa-file-export"></i>
                                        &ensp;出 力
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- femalePig_export - end -->

                    <!-- malePig_export - start -->
                    <div class="pb-8 px-8 text-gray-500 dark:text-gray-300">
                        <div class="grid grid-cols-2 gap-4">
                            <h1 class="MplusRound font-semibold text-gray-700 dark:text-whit">
                                父豚データのエクスポート
                            </h1>

                            <form method="post" action="{{ route('male_pigs.export') }}">
                                @csrf
                                <div class="flex justify-end text-sm">
                                    <button type="submit"
                                        class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-slate-700 font-medium border-gray-200 hover:text-white text-slate-700 hover:border-slate-700 rounded-lg hover:bg-slate-700 disabled:opacity-50">
                                        <i class="fa-solid fa-file-export"></i>
                                        &ensp;出 力
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- malePig_export - end -->

                    <!-- mixInfo_export - start -->
                    <div class="pb-8 px-8 text-gray-500 dark:text-gray-300">
                        <div class="grid grid-cols-2 gap-4">
                            <h1 class="MplusRound font-semibold text-gray-700 dark:text-whit">
                                交配出産記録のエクスポート
                            </h1>

                            <form method="get" action="{{ route('mix_infos.export') }}">
                                @csrf
                                <div class="flex justify-end text-sm">
                                    <button type="submit"
                                        class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-slate-700 font-medium border-gray-200 hover:text-white text-slate-700 hover:border-slate-700 rounded-lg hover:bg-slate-700 disabled:opacity-50">
                                        <i class="fa-solid fa-file-export"></i>
                                        &ensp;出 力
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- mixInfo_export - end -->
                </div>
            </div>
            <!-- import - start -->
        </div>
    </section>
</x-app-layout>
