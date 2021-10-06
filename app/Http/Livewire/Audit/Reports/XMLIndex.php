<?php

namespace App\Http\Livewire\Audit\Reports;

use DateTime;
use DateTimeZone;

use Livewire\Component;
use App\Models\Xml\XmlReport;

use Livewire\WithPagination;

class XMLIndex extends Component
{
    use WithPagination;

    public $search;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch() {
        $this->resetPage();
    }

    public function render()
    {
        
        $reports = XmlReport::where('date', 'LIKE', '%' . $this->search . '%')
                            ->orderby('id', 'desc')
                            ->paginate();

        foreach ($reports as $key => $value) {
            $date = DateTime::createFromFormat('Y-m-d G:i:s',
                                                $value['created_at'],
                                                new DateTimeZone('UTC'));
            $date->setTimeZone(new DateTimeZone('America/Caracas'));
            $value['created_at'] = $date->format('Y-m-d g:i A');
        }

        return view('livewire.audit.reports.x-m-l-index', compact('reports'));
    }
}
