<?php

namespace App\Livewire;

use Livewire\Component;

class ResultadosComponent extends Component
{
    public $resultados;

    public function mount()
    {
        $this->resultados = session()->get('resultados', []);
        
    }



    public function render()
    {
        return view('livewire.resultados-component')->layout('layouts.app');
    }
}
