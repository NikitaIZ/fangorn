<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Audit\Dolar;
use App\Models\Audit\Xml\XmlForecastDate;

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

        $date = date("Y-m-d");
        $dolar = Dolar::where('date', $date)->value('id');
        if ($dolar == null){
            $dolar = Dolar::orderByDesc('date')->value('daily_rate');
            $XmlHistoryReport = new Dolar();
            $XmlHistoryReport->user_id    = 1;
            $XmlHistoryReport->daily_rate = $dolar;
            $XmlHistoryReport->date       = $date;
            $XmlHistoryReport->save();
        }
    }
}
