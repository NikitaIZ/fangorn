<?php

namespace App\Http\Livewire\Audit\Dolar;

use DateTime;
use DateTimeZone;

use App\Models\Views\ViewDolar;
use Livewire\Component;

use Livewire\WithPagination;

class DolarIndex extends Component
{
    use WithPagination;

    public $search;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch() {
        $this->resetPage();
    }

    public function render()
    {
        $dolars = ViewDolar::where('Usuario', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('Fecha', 'LIKE', '%' . $this->search . '%')
                            ->orderby('Fecha', 'desc')
                            ->paginate();

        foreach ($dolars as $key => $value) {
            $date = DateTime::createFromFormat('Y-m-d G:i:s',
                                                $value['Subido'],
                                                new DateTimeZone('UTC')
                                                );
            $date->setTimeZone(new DateTimeZone('America/Caracas'));
            $value['Subido'] = $date->format('Y-m-d g:i A');
        }
        foreach ($dolars as $key => $value) {
            $date = DateTime::createFromFormat('Y-m-d G:i:s',
                                                $value['Actualizado'],
                                                new DateTimeZone('UTC')
                                                );
            $date->setTimeZone(new DateTimeZone('America/Caracas'));
            $value['Actualizado'] = $date->format('Y-m-d g:i A');
        }
        return view('livewire.audit.dolar.dolar-index', compact('dolars'));
    }
}
