<?php

namespace App\Http\Livewire\Audit\Reports;

use DateTime;
use DateTimeZone;

use Livewire\Component;
use App\Models\Audit\Xml\XmlHistoryReport;

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
        $reports = XmlHistoryReport::where('folder', 'LIKE', '%' . $this->search . '%')->orWhere('id', 'LIKE', '%' . $this->search . '%')->orderby('id', 'desc')->paginate(25);

        foreach ($reports as $key => $value) {
            $date = DateTime::createFromFormat('Y-m-d G:i:s', $value['created_at'], new DateTimeZone('UTC'));
            $value['created_at'] = $date->setTimeZone(new DateTimeZone('America/Caracas'))->format('Y-m-d g:i A');
        }

        return view('livewire.audit.reports.xml-index', compact('reports'));
    }
}
