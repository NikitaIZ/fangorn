<?php

namespace App\Http\Livewire\Audit;

use App\Models\Audit\Buffet;
use Livewire\Component;

class BuffetCreate extends Component
{
    public $daily_rate, $date;

    protected $rules = [
        'service'  => 'required',
        'adults'   => 'required',
        'children' => 'required',
    ];

    public function save()
    {
        if ($this->service && $this->adults && $this->children)
        {
            $validate = Buffet::where('service', $this->service)->value('id');
            if ($validate == null) {
                Buffet::create([
                    'service'  => $this->service,
                    'adults'   => $this->adults,
                    'children' => $this->children,
                ]);

                $this->reset('service', 'adults', 'children');

                $this->emitTo('audit.buffet-index', 'render');

                $this->emit('alert', 'Se añadio el nuevo servicio, sin problemas');
            } else {
                $this->emit('error', 'Ese servicio ya esta registrado, elija otra por favor');
            }
        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function render()
    {
        return view('livewire.audit.buffet-create');
    }
}
