<div class="fixed z-10 inset-0 text-center sm:block" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-gray-500"></div>
    <div class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
        role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <form class="">
            <div class="px-6 pt-5">
                <div class="">
                    <div class="mb-4">
                        <label for="memo" class="block text-gray-700 text-sm font-bold mb-2">memo</label>
                        {{-- <input type="text" name="memo" value="{{ old('memo', $femalePig->memo) }}" required
                            wire:model="memo"> --}}
                        {{-- <p>{{ $femalePig->memo }}</p> --}}
                        <textarea name="memo" wire:model="femalePig.memo" rows="5"
                            class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                            required placeholder="メモ"></textarea>
                        @error('femalePig.memo')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <span class="my-2 flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button wire:click="closeModal()" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-cyan-800 text-base leading-6 font-medium text-white shadow-sm hover:bg-cyan-600 focus:outline-none focus:border-cyan-800 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        キャンセル
                    </button>
                </span>
                <span class="my-2 flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button wire:click.prevent="save()" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-cyan-800 text-base leading-6 font-medium text-white shadow-sm hover:bg-cyan-600 focus:outline-none focus:border-cyan-800 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        OK
                    </button>
                </span>
            </div>
        </form>
    </div>
</div>
