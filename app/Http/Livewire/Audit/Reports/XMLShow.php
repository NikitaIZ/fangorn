<?php

namespace App\Http\Livewire\Audit\Reports;

use Livewire\Component;
use App\Models\Views\ViewXmlReport;

class XMLShow extends Component
{
    public $search;

    public $xml;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data = ViewXmlReport::where('ID', $this->xml)->get();
        return view('livewire.audit.reports.x-m-l-show', compact('data'));
    }
}
