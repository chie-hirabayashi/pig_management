<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

<h2 class="mx-2 text-lg text-indigo-500">{{ $count }}</h2>
<button wire:click="inc"
    class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
    +1Button
</button>

<table class="table-fixed w-full">
    <thead>
        <tr class="bg-gray-1000">
            <th class="px-4 py2 w-20">No.</th>
            <th class="px-4 py-2">Title</th>
            <th class="px-4 py-2">Desc</th>
            <th class="px-4 py-4">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($places as $place)
            <tr>
                <td class="border px-4 py-2">{{ $place->id }}</td>
                <td class="border px-4 py-2">{{ $place->place_num }}</td>
                <td class="border px-4 py-2">{{ $place->female_id }}</td>
                <td class="border px-4 py2">
                    <button wire:click="edit({{ $place->id }})"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                    <button wire:click="delete({{ $place->id }})"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@livewireScripts
</div>
