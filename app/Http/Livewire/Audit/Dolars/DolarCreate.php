<?php

namespace App\Http\Livewire\Audit\Dolars;

use DateTime;
use DateTimeZone;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\Audit\Dolar;
use App\Models\Audit\Xml\XmlHistoryReport;

class DolarCreate extends Component
{
    public $daily_rate, $date;

    protected $rules = [
        'daily_rate' => 'required',
        'date'       => 'required',
    ];

    public function save()
    {
        if ($this->daily_rate && $this->date)
        {
            $validate = Dolar::where('date', $this->date)->value('id');
            if ($validate == null) {
                Dolar::create([
                    'user_id'    => Auth::user()->currentTeam->user_id,
                    'daily_rate' => $this->daily_rate,
                    'date'       => $this->date,
                ]);
                
                $day = DateTime::createFromFormat('Y-m-d G:i:s', date('Y-m-d G:i:s'), new DateTimeZone('UTC'));
                $day->setTimeZone(new DateTimeZone('America/Caracas'));

                if ($this->date == $day->format('Y-m-d')) {
                    $this->updateDataJson($this->daily_rate);
                }

                $id = Dolar::where('date', $this->date)->value('id');
                $report = XmlHistoryReport::where('date', $this->date)->value('id');

                if ($report != null){
                    XmlHistoryReport::where('date', $this->date)->update(['dolar_id' => $id]);
                }

                $this->reset('daily_rate', 'date');

                $this->emitTo('audit.dolars.dolar-index', 'render');

                $this->emit('alert', 'Se añadio la nueva tasa de cambio, sin problemas');
            } else {
                $this->emit('error', 'Esa fecha ya esta registrada, elija otra por favor');
            }
        }else
        {
            $this->emit('error', 'Ocurrio un error revise bien el formulario');
            $this->validate();
        }
    }

    public function render()
    {
        return view('livewire.audit.dolars.dolar-create');
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
