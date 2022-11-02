<x-app-layout>
    <x-slot name="header">
        <h2 class="">
            {{ __('female_pigs.index') }}
        </h2>
    </x-slot>
    <div class="bg-white py-6 sm:py-8 lg:py-12">
        <div class="max-w-screen-xl px-4 md:px-8 mx-auto">
            <h2 class="text-gray-800 text-2xl lg:text-3xl font-bold text-center mb-8 md:mb-12">
                femalePigs 一覧
            </h2>

            <x-flash-msg :message="session('notice')" />

            <div class="grid sm:grid-cols-5 lg:grid-cols-5 gap-y-10 sm:gap-y-12 lg:divide-x">
                <!-- quote - start -->
                @foreach ($femalePigs as $femalePig)
                    <div class="flex flex-col items-center gap-4 md:gap-6 sm:px-4 lg:px-8">
                        <div class="text-gray-600 text-xl text-center">
                            <a href="{{ route('female_pigs.show', $femalePig) }}">
                                {{ $femalePig->individual_num }}
                            </a>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-2 md:gap-3">
                            <div>
                                <div class="text-indigo-500 text-base md:text-base font-bold text-center sm:text-center">
                                    {{ $femalePig->age }} 歳
                                </div>
                                <p class="text-gray-500 text-sm md:text-sm text-center sm:text-left">
                                    保育中・待機中・観察中
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- quote - end -->
            </div>
        </div>
    </div>
</x-app-layout>
