@props(['message'])

@if ($message)
    <div class="px-6 py-4 bg-cyan-50 rounded-lg text-cyan-600">
    {{-- <div class="bg-blue-100 border-blue-500 text-blue-700 border-l-4 p-4 my-2"> --}}
        <i class="fa-solid fa-bell"></i>&ensp;
        {{ $message }}
    </div>
@endif
