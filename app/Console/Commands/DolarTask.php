<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Audit\Dolar;

use Goutte\Client;

class DolarTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dolar:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar reporte del dolar';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /* $array = XmlForecastDate::select('*')->get();
        foreach ($array as $value) {
            $dolar = Dolar::where('date', $value->date)->value('id');
            if ($dolar == null){
                $dolar = Dolar::orderByDesc('date')->value('id');
            }
            XmlForecastDate::where('id', $value->id)->update(['dolar_id' => $dolar]);
        }*/

        $client = new Client();
        $url = 'https://www.bcv.org.ve/';
        $page = $client->request('GET', $url);
        $texto = $page->filter(selector:'#dolar')->text();
        $valor = substr($texto, 4);
        $dolar = str_replace(",", ".", $valor);
        $dolar = round($dolar, 2);

        $date = date("Y-m-d");
        $check = Dolar::where('date', $date)->value('id');

        if ($check == null){
            $XmlHistoryReport = new Dolar();
            $XmlHistoryReport->user_id    = 1;
            $XmlHistoryReport->daily_rate = $dolar;
            $XmlHistoryReport->date       = $date;
            $XmlHistoryReport->save();
        }
    }
}
