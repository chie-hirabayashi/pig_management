@if ($memoModalOpen)
    @include('livewire.memo-modal')
@endif
<div class="w-80">
    <div class="rounded overflow-hidden border shadow-lg">
        <h2 class="MplusRound text-center pt-2 font-semibold">メ モ</h2>
        <div class="px-6 py-2">
            <p class="break-words">{!! $this->memo ? e($this->memo) : nl2br(e($femalePig->memo)) !!}</p>
            <div class="flex justify-end">
            <button wire:click="memoWrite()"
                class="text-right basis-1/2 font-medium lg:text-xs xl:text-sm text-cyan-800 hover:underline hover:font-bold">
                <i class="fa-solid fa-pencil"></i>
            </button>
            </div>
        </div>
    </div>
</div>
