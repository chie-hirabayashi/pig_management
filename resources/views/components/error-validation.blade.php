@props(['errors'])

@if ($errors->any())
    {{-- <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-2" role="alert"> --}}
    <div class="px-6 py-4 bg-red-50 rounded-lg text-red-600">
        <p>
            <b>
                <i class="fa-solid fa-bell"></i>&ensp;
                {{ count($errors) }}件のエラー
            </b>
        </p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    {{-- <span class="font-bold">warning</span>  --}}
                    {{ $error }}
                </li>
                {{-- <li>{{ $error }}</li> --}}
            @endforeach
        </ul>
    </div>
@endif
