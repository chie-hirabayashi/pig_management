<?php

namespace App\Http\Livewire;

use App\Models\FemalePig;
use Livewire\Component;
use App\Models\Place;

class PlaceIn extends Component
{
    public $places, $place_id, $female_id;
    public $femalePigs;
    public $isOpen = false;
    public $null = null;

    public function render()
    {
        $this->places = Place::with('female_pig.mix_infos')->get();
        // dd(date('Y-m-d', strtotime('+21day', strtotime($this->places[1]->female_pig->mix_infos->last()->second_recurrence_schedule))));
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
        Place::updateOrCreate(
            ['id' => $this->place_id],
            ['female_id' => $this->female_id],
        );
        $this->closeModal();
    }

    public function placeIn($id)
    {
        $place = Place::findOrFail($id);
        # find($id):idが見つからない場合null
        # findOrFail($id):idが見つからない場合エラー
        $this->place_id = $place->id;
        $this->female_id = $place->female_id;
        $this->openModal();
    }

    public function placeOut($id)
    {
        $place = Place::findOrFail($id);

        Place::updateOrCreate(
            ['id' => $place->id],
            ['female_id' => null],
        );
        session()->flash(
            'message',
            $this->id
                ? 'Todo Updated Successfully.'
                : 'Todo Created Successfully.'
        );
    }

}

