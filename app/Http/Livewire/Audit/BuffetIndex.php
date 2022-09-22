<?php

namespace App\Http\Livewire\Audit;

use Throwable;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Log;

use App\Models\Audit\Buffet;

class BuffetIndex extends Component
{
    use WithPagination;

    public $buffet;

    public $search      = '';
    public $cant        = '10';
    public $sort        = 'id';
    public $direction   = 'asc';
    public $readyToLoad = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'buffet.service'  => 'required',
        'buffet.adults'   => 'required',
        'buffet.children' => 'required',
    ];

    protected $listeners = [
        'render' => 'render',
        'delete' => 'delete'
    ];

    protected $queryString = [
        'search'    => ['except' => ''],
        'cant'      => ['except' => '10'],
        'sort'      => ['except' => 'date'],
        'direction' => ['except' => 'desc']
    ];

    public function updatingSearch() {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->readyToLoad){
            $buffets = Buffet::where('service', 'LIKE', '%' . $this->search . '%')
                            ->orderby($this->sort, $this->direction)
                            ->paginate($this->cant);
        }else{
            $buffets = [];
        }
        return view('livewire.audit.buffet-index', compact('buffets'));
    }

    public function loadBuffets()
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

    public function edit(Buffet $buffet)
    {
        $this->buffet = $buffet;
    }

    public function update()
    {
        if ($this->buffet->service && $this->buffet->adults && $this->buffet->children)
        {
            $this->buffet->save();
            $this->emit('alert', 'Se Actualizo el Restaurante sin problemas');
            $this->emitTo('audit.buffet-index', 'render');
        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function delete($id)
    {
        try {
            $variable = Buffet::findOrFail($id);
            $variable->delete();
        } catch(Throwable $e) {
            Log::error($e);
        }
        $this->emitTo('audit.buffet-index', 'render');
    }
}
