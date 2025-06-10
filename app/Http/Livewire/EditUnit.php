<?php

namespace App\Http\Livewire;

use App\Models\Unit;
use LivewireUI\Modal\ModalComponent;

class EditUnit extends ModalComponent
{
    public Unit $unit;
    public $name;
    public $symbol;
    public $description;

    protected $rules = [
        'name' => 'required|string|max:255',
        'symbol' => 'required|string|max:50',
        'description' => 'nullable|string'
    ];

    public function mount(Unit $unit)
    {
        $this->unit = $unit;
        $this->name = $unit->name;
        $this->symbol = $unit->symbol;
        $this->description = $unit->description;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:50|unique:units,symbol,' . $this->unit->id,
            'description' => 'nullable|string'
        ]);

        $this->unit->update([
            'name' => $this->name,
            'symbol' => $this->symbol,
            'description' => $this->description
        ]);

        $this->closeModalWithEvents([
            'unitUpdated' => true
        ]);

        session()->flash('success', 'Satuan berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.edit-unit');
    }
} 