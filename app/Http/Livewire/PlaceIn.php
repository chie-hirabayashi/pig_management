<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Place;

class PlaceIn extends Component
{
    protected $listeners = [
        'refresh' => '$refresh', // 再読み込み
        'destroy' => 'destroy'
    ];

    public $places;
    public $isOpen=false;

    public $count = 10;

    public function inc()
    {
        $this->count++;
    }
    
    public function render()
    {
        $this->places = Place::all();
        return view('livewire.place-in');
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function edit($id)
    {
        $place = Place::findOrFail($id);
        dd($place);
        // $this->todo_id = $todo->id;
        // $this->title = $todo->title;
        // $this->description = $todo->description;
        $this->openModal();
    }
}
