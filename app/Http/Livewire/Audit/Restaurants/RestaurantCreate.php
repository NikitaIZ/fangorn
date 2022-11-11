<?php

namespace App\Http\Livewire\Audit\Restaurants;

use Livewire\Component;

use App\Models\Audit\Restaurants\Restaurant;

class RestaurantCreate extends Component
{
    public $name, $food = 0, $drink = 0, $coctel = 0;

    protected $rules = [
        'name' => 'required',
    ];

    public function save()
    {
        if ($this->name)
        {
            Restaurant::create([
                'name'   => $this->name,
                'food'   => $this->food,
                'drink'  => $this->drink,
                'coctel' => $this->coctel,
            ]);

            $this->reset('name');

            $this->emitTo('audit.restaurants.restaurant-index', 'render');

            $this->emit('alert', 'Se creo un Nuevo Restaurante sin problemas');
        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function render()
    {
        return view('livewire.audit.restaurants.restaurant-create');
    }

    public function enabled($option)
    {
        switch ($option) {
            case 'food':
                if ($this->food == 0){
                    $this->food = 1;
                }else{
                    $this->food = 0;
                }
            break;
            case 'drink':
                if ($this->drink == 0){
                    $this->drink = 1;
                }else{
                    $this->drink = 0;
                }
            break;
            case 'coctel':
                if ($this->coctel == 0){
                    $this->coctel = 1;
                }else{
                    $this->coctel = 0;
                }
            break;
        }
    }
}
