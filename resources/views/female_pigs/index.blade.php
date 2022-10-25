<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold leading-tight">
            {{ __('female_pigs.index') }}
        </h2>
    </x-slot>

    <div class="container max-w-7xl mx-auto px-4 md:px-12 pb-3 mt-3">

        <x-flash-msg :message="session('notice')" />

        <div class="flex flex-wrap -mx-1 lg:-mx-4 mb-4">
            @foreach ($femalePigs as $femalePig)
                <article class="w-full px-4 md:w-1/2 text-xl text-gray-800 leading-normal">
                    <a href="{{ route('female_pigs.show', $femalePig) }}">
                        <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">{{ $femalePig->individual_num }}</h2>
                        <h3>{{ $femalePig->age }}歳</h3>
                    </a>
                </article>
            @endforeach
        </div>
        {{-- {{ $posts->links() }} --}}
    </div>
</x-app-layout>
