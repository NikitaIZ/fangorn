<?php

namespace App\Http\Livewire\Audit\Reports;

use Livewire\Component;
use App\Models\Views\ViewXmlHistoryReport;

class XMLShow extends Component
{
    public $search;

    public $xml;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data = ViewXmlHistoryReport::where('description', 'LIKE', '%' . $this->search . '%')->where('id', $this->xml)->orderBy('headings_id')->get();

        return view('livewire.audit.reports.xml-show', compact('data'));
    }
}
