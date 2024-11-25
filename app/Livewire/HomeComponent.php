<?php

namespace App\Livewire;

use Livewire\Component;

class HomeComponent extends Component
{
    public $showQuestionario = false;
    public $resultados = []; // Armazena os resultados

    public function render()
    {
        return view('livewire.home-component')->layout('layouts.app');
    }

}
