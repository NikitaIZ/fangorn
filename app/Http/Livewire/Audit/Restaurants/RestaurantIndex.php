<?php

namespace App\Http\Livewire\Audit\Restaurants;

use Throwable;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Log;

use App\Models\Audit\Restaurants\Restaurant;

class RestaurantIndex extends Component
{
    use WithPagination;

    public $restaurant;

    public $search      = '';
    public $cant        = '25';
    public $sort        = 'id';
    public $direction   = 'asc';
    public $readyToLoad = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'restaurant.name'   => 'required',
        'restaurant.food'   => 'required',
        'restaurant.drink'  => 'required',
        'restaurant.coctel' => 'required',
    ];

    protected $listeners = [
        'render' => 'render',
        'delete' => 'delete'
    ];

    protected $queryString = [
        'search'    => ['except' => ''],
        'cant'      => ['except' => '25'],
        'sort'      => ['except' => 'id'],
        'direction' => ['except' => 'asc']
    ];

    public function updatingSearch() {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->readyToLoad){
            $restaurants = Restaurant::where('name', 'LIKE', '%' . $this->search . '%')
                                    ->orderby($this->sort, $this->direction)
                                    ->paginate($this->cant);
            foreach ($restaurants as $restaurant) {
                $restaurant->link = preg_replace('/\s+/', '-', $restaurant->name);
            }
        }else{
            $restaurants = [];
        }
        return view('livewire.audit.restaurants.restaurant-index', compact('restaurants'));
    }

    public function loadRestaurants()
    {
        $this->readyToLoad = true;
    }

    public function order($sort){
        if ($this->sort == $sort) {
            if ($this->direction == 'asc') {
                $this->direction = 'desc';
            }else {
                $this->direction = 'asc';
            }
        }else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }

    public function edit(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
    }

    public function update()
    {
        if ($this->restaurant->name)
        {
            $this->restaurant->save();

            $this->emit('alert', 'Se Actualizo el Restaurante sin problemas');

            $this->emitTo('audit.restaurants.restaurant-index', 'render');
        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function delete($id)
    {
        try {
            $variable = Restaurant::findOrFail($id);
            $variable->delete();
        } catch(Throwable $e) {
            Log::error($e);
        }
        $this->emitTo('audit.restaurants.restaurant-index', 'render');
    }
}
