<?php

namespace App\Http\Livewire;

use App\Models\FemalePig;
use Livewire\Component;

class Memo extends Component
{
    public FemalePig $femalePig;
    public $female_id;
    public $memo;
    public $memoModalOpen = false;
    public $null = null;

    # $rulesプロパティを設定しなければ正常にバインドされない
    protected $rules = [
        'femalePig.memo' => 'required|string|max:100',
        // 'post.summary' => 'string|max:500'
    ];

    public function render()
    {
        $this->female_id = $this->femalePig->id;
        $femalePig = $this->femalePig;
        return view('livewire.memo')->with(compact('femalePig'));
    }

    // public function mount($femalePig)
    // {
    //     $this->female_id = $femalePig->id;
    //     // $this->content = $post->content;
    // }

    public function openModal()
    {
        $this->memoModalOpen = true;
    }

    public function closeModal()
    {
        $this->memoModalOpen = false;
    }

    public function save()
    {
        $this->validate();
        $this->femalePig->save();

        session()->flash('notice', 'メモしました');
        // $this->emitTo('post-list', 'refersh');
        // $this->create();
        $this->closeModal();
    }

    public function update()
    {
        FemalePig::updateOrCreate(
            ['id' => $this->female_id],
            ['memo' => $this->memo],
        );
        $this->closeModal();
    }

    public function memoWrite()
    {
        // $female_pig = FemalePig::findOrFail($id);
        // $this->female_id = $female_pig->id;
        $this->openModal();
    }

}

