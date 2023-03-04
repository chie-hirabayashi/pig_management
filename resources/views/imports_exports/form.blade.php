<x-app-layout>
    <!-- header - start -->
    <x-slot name="header">
        <h2 class="">
            {{ __('imports.import') }}
        </h2>
    </x-slot>
    <!-- header - end -->

    <!-- body - start -->
    <section class="bg-white">
        <div class="container max-w-4xl px-6 py-10 mx-auto">
            <h1 class="text-4xl MplusRound text-center mb-8 text-gray-800">
                データの入出力
            </h1>
            
            <!-- validation - start -->
            <x-error-validation :errors="$errors" />
            <x-flash-msg :message="session('notice')" />
            <!-- validation - end -->
            
            <div class="mt-12 space-y-8">
                <!-- import - start -->
                <div class="border-2 border-gray-100 rounded-lg">
                    <div class="flex items-center justify-between rounded-t-lg w-full bg-gray-300 px-8 py-6">
                        <h1 class="font-semibold text-lg text-white">
                            インポート
                        </h1>
                    </div>

                    <hr class="border-gray-200">

                        

                    
                    @if (empty($mix_infos->all()))
                    <p class="p-8 text-sm text-gray-500">
                        エクセルファイルを選択して取込をクリック<br>
                        交配出産記録は母豚データと父豚データの取込後にインポートできます
                    </p>

                    <!-- femalePig_import - start -->
                    <div class="items-center justify-between w-full pt-8 px-8 pb-2">
                        <h1 class="MplusRound font-semibold text-gray-700">
                            母豚データのインポート
                        </h1>
                    </div>

                    <div class="pb-8 px-8 text-sm text-gray-500">
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
                        <h1 class="MplusRound font-semibold text-gray-700">
                            父豚データのインポート
                        </h1>
                    </div>

                    <div class="pb-8 px-8 text-sm text-gray-500">
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
                        <h1 class="MplusRound font-semibold text-gray-700">
                            交配出産記録のインポート
                        </h1>
                    </div>

                    <div class="pb-8 px-8 text-sm text-gray-500">
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
                    @else
                    <p class="p-8 text-sm text-gray-500">
                        初期データはインポート済みです
                    </p>
                    @endif
                    
                </div>
                <!-- import - start -->

                <!-- export - start -->
                <div class="border-2 border-gray-100 rounded-lg">
                    <div class="flex items-center justify-between rounded-t-lg w-full bg-gray-300 px-8 py-6">
                        <h1 class="font-semibold text-lg text-white">
                            エクスポート
                        </h1>
                    </div>

                    <hr class="border-gray-200">

                    <p class="p-8 text-sm text-gray-500">
                        出力をクリック<br>
                        エクセルファイルが出力されます
                    </p>

                    <!-- femalePig_export - start -->
                    <div class="pb-8 px-8 text-gray-500">
                        <div class="grid grid-cols-2 gap-4">
                            <h1 class="MplusRound font-semibold text-gray-700">
                                母豚データのエクスポート
                            </h1>

                            <div class="flex justify-end text-sm">
                                <div class="grid grid-cols-2 gap-2">
                                    <form method="post" action="{{ route('female_pigs.export') }}">
                                        @csrf
                                        <div class="flex justify-end text-sm">
                                            <button type="submit"
                                                class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-slate-700 font-medium border-gray-200 hover:text-white text-slate-700 hover:border-slate-700 rounded-lg hover:bg-slate-700 disabled:opacity-50">
                                                <i class="fa-solid fa-file-export"></i>
                                                &ensp;帳簿出力
                                            </button>
                                        </div>
                                    </form>
                                    <form method="post" action="{{ route('female_pigs.source_export') }}">
                                        @csrf
                                        <div class="flex justify-end text-sm">
                                            <button type="submit"
                                                class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-slate-700 font-medium border-gray-200 hover:text-white text-slate-700 hover:border-slate-700 rounded-lg hover:bg-slate-700 disabled:opacity-50">
                                                <i class="fa-solid fa-file-export"></i>
                                                &ensp;sourceデータ出力
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- femalePig_export - end -->

                    <!-- malePig_export - start -->
                    <div class="pb-8 px-8 text-gray-500">
                        <div class="grid grid-cols-2 gap-4">
                            <h1 class="MplusRound font-semibold text-gray-700">
                                父豚データのエクスポート
                            </h1>

                            <div class="flex justify-end text-sm">
                                <div class="grid grid-cols-2 gap-2">
                                    <form method="post" action="{{ route('male_pigs.export') }}">
                                        @csrf
                                        <div class="flex justify-end text-sm">
                                            <button type="submit"
                                                class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-slate-700 font-medium border-gray-200 hover:text-white text-slate-700 hover:border-slate-700 rounded-lg hover:bg-slate-700 disabled:opacity-50">
                                                <i class="fa-solid fa-file-export"></i>
                                                &ensp;帳簿出力
                                            </button>
                                        </div>
                                    </form>
                                    <form method="post" action="{{ route('male_pigs.source_export') }}">
                                        @csrf
                                        <div class="flex justify-end text-sm">
                                            <button type="submit"
                                                class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-slate-700 font-medium border-gray-200 hover:text-white text-slate-700 hover:border-slate-700 rounded-lg hover:bg-slate-700 disabled:opacity-50">
                                                <i class="fa-solid fa-file-export"></i>
                                                &ensp;sourceデータ出力
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- malePig_export - end -->

                    <!-- mixInfo_export - start -->
                    <div class="pb-8 px-8 text-gray-500">
                        <div class="grid grid-cols-2 gap-4">
                            <h1 class="MplusRound font-semibold text-gray-700">
                                交配出産記録のエクスポート
                            </h1>

                            <div class="flex justify-end text-sm">
                                <div class="grid grid-cols-2 gap-2">
                                    <form method="get" action="{{ route('mix_infos.export') }}">
                                        @csrf
                                        <div class="flex justify-end text-sm">
                                            <button type="submit"
                                                class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-slate-700 font-medium border-gray-200 hover:text-white text-slate-700 hover:border-slate-700 rounded-lg hover:bg-slate-700 disabled:opacity-50">
                                                <i class="fa-solid fa-file-export"></i>
                                                &ensp;帳簿出力
                                            </button>
                                        </div>
                                    </form>
                                    <form method="get" action="{{ route('mix_infos.source_export') }}">
                                        @csrf
                                        <div class="flex justify-end text-sm">
                                            <button type="submit"
                                                class="mr-2 py-1.5 px-4 transition-colors bg-gray-50 border active:bg-slate-700 font-medium border-gray-200 hover:text-white text-slate-700 hover:border-slate-700 rounded-lg hover:bg-slate-700 disabled:opacity-50">
                                                <i class="fa-solid fa-file-export"></i>
                                                &ensp;sourceデータ出力
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- mixInfo_export - end -->
                </div>
            </div>
            <!-- import - start -->
        </div>
    </section>
</x-app-layout>
