<?php

namespace App\Http\Livewire\Audit\Dolars;

use Throwable;

use DateTime;
use DateTimeZone;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Models\Audit\Dolar;
use App\Models\Audit\Xml\XmlHistoryReport;

use App\Models\Views\ViewDolar;

class DolarIndex extends Component
{
    use WithPagination;

    public $dolar;

    public $search      = '';
    public $cant        = '10';
    public $sort        = 'date';
    public $direction   = 'desc';
    public $readyToLoad = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'dolar.user_id'    => 'required',
        'dolar.daily_rate' => 'required',
        'dolar.date'       => 'required',
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
            $dolars = ViewDolar::where('user', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('date', 'LIKE', '%' . $this->search . '%')
                            ->orderby($this->sort, $this->direction)
                            ->paginate($this->cant);
            foreach ($dolars as $key => $value) {
                $date = DateTime::createFromFormat('Y-m-d G:i:s', $value['updated_at'], new DateTimeZone('UTC'));
                $value['time'] = $date->setTimeZone(new DateTimeZone('America/Caracas'))->format('Y-m-d g:i.A');
            }
        }else{
            $dolars = [];
        }
        return view('livewire.audit.dolars.dolar-index', compact('dolars'));
    }

    public function loadDolars()
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

    public function edit(Dolar $dolar)
    {
        $this->dolar = $dolar;
    }

    public function update()
    {
        if ($this->dolar->daily_rate && $this->dolar->date)
        {
            $this->dolar->user_id = Auth::user()->currentTeam->user_id;
            $this->dolar->save();

            $day = DateTime::createFromFormat('Y-m-d G:i:s', date('Y-m-d G:i:s'), new DateTimeZone('UTC'));
            $day->setTimeZone(new DateTimeZone('America/Caracas'));

            if ($this->dolar->date == $day->format('Y-m-d')) {
                $this->updateDataJson($this->dolar->daily_rate);
            }

            $this->emit('alert', 'Se Actualizo la Tasa de Cambio seleccionada');

            $this->emitTo('audit.dolars.dolar-index', 'render');
        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function delete($id)
    {
        try {
            $variable = Dolar::findOrFail($id);
            $variable->delete();
            $dolar = Dolar::orderByDesc('date')->value('id');
            XmlHistoryReport::where('dolar_id', $id)->update(['dolar_id' => $dolar]);
        } catch(Throwable $e) {
            Log::error($e);
        }
        $this->emitTo('audit.dolars.dolar-index', 'render');
    }

    private function updateDataJson($dayli){
        $data['dolar'] = $dayli;
        $dataJson = json_encode($data, true);
        file_put_contents(config('app.ftp.local') . "\datos.json", $dataJson);

        $ftp_server = config('app.ftp.server');
        $ftp_user_name = config('app.ftp.name');
        $ftp_user_pass = config('app.ftp.pass');
        $file = config('app.ftp.local') . "\datos.json";
        $remote_file = config('app.ftp.remote') . "datos.json";

        // set up basic connection
        $conn_id = ftp_connect($ftp_server);
        if($conn_id){
            // login with username and password
            ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
            ftp_put($conn_id, $remote_file, $file, FTP_ASCII);
            ftp_close($conn_id);
        }
    }
}
