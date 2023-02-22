<?php

namespace App\Http\Livewire;

use App\Models\FemalePig;
use App\Models\MixInfo;
use Livewire\Component;
use App\Models\Place;

class PlaceIn extends Component
{
    // protected $listeners = [
    //     'refresh' => '$refresh', // 再読み込み
    //     'destroy' => 'destroy'
    // ];

    public $places, $place_id, $female_id;
    public $femalePigs;
    public $isOpen = false;
    public $null = null;

    public function render()
    {
        // $this->places = Place::all();
        $this->places = Place::with('female_pig.mix_infos')->get();
//         $mix_infos = MixInfo::whereHas('female_pig.place', function ($query) use ($placeId) {
//     $query->where('id', $placeId);
// })->get();

        // dd($this->places[1]);
        return view('livewire.place-in');
    }

    public function openModal()
    {
        // $this->femalePigs = FemalePig::all()->sortBy('individual_num');
        # 並べ替えはcollectionの場合はsortBy()
        $this->femalePigs = FemalePig::whereDoesntHave('place', function (
            $query
        ) {
            $query->whereNotNull('female_id');
        })->orderBy('individual_num')->get();
        # 並べ替えはEloquentクエリビルダの場合はorderBy()
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function update()
    {
        // $this->validate([
        //     'id' => 'required',
        //     'female_id' => 'required'
        // ]);
        Place::updateOrCreate(
            ['id' => $this->place_id],
            [
                'female_id' => $this->female_id,
            ]
        );
        $this->closeModal();
        // $this->resetInputFields();
    }

    public function placeIn($id)
    {
        $place = Place::findOrFail($id);
        $this->place_id = $place->id;
        $this->female_id = $place->female_id;
        // $this->description = $todo->description;
        $this->openModal();
        // dd($place);
    }

    public function placeOut($id)
    {
        $place = Place::findOrFail($id);
        // $this->validate([
        //     'title' => 'required',
        //     'description' => 'required'
        // ]);
        // dd($place);
        Place::updateOrCreate(
            ['id' => $place->id],
            [
                'female_id' => null,
            ]
        );
        session()->flash(
            'message',
            $this->id
                ? 'Todo Updated Successfully.'
                : 'Todo Created Successfully.'
        );
        // $this->closeModal();
        // $this->resetInputFields();
    }

}

