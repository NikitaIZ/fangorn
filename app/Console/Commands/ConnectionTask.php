<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;


class ConnectionTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'connection:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Conectar unidades';

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
        $directories = scandir('Z:\\');
        Storage::append('archivo.txt', $directories[1]);
        Storage::append('archivo.txt', $directories[2]);
        Storage::append('archivo.txt', $directories[3]);
        Storage::append('archivo.txt', $directories[4]);

    }
}
