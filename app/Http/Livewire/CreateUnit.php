<?php

namespace App\Http\Livewire;

use App\Models\Unit;
use LivewireUI\Modal\ModalComponent;

class CreateUnit extends ModalComponent
{
    public $name;
    public $symbol;
    public $description;

    protected $rules = [
        'name' => 'required|string|max:255',
        'symbol' => 'required|string|max:50|unique:units,symbol',
        'description' => 'nullable|string'
    ];

    public function save()
    {
        $this->validate();

        Unit::create([
            'name' => $this->name,
            'symbol' => $this->symbol,
            'description' => $this->description
        ]);

        $this->closeModalWithEvents([
            'unitCreated' => true
        ]);

        session()->flash('success', 'Satuan berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.create-unit');
    }
} 