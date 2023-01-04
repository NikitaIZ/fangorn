<?php

namespace App\Http\Livewire\Reserves;

use Illuminate\Support\Facades\DB;

use Livewire\Component;

class DinnerSearch extends Component
{   

    public $search;
    public $filter = "client";
    public $data = [];
    protected $tbl_name = "events_bookings";
    

    
    public function render()
    {      
        $this->getBookings();
        return view('livewire.reserves.dinner-search');
    }

    public function setFilter($type){
        $this->filter = $type;
    }

    public function getBookings(){
        
        $this->data = [];
        

        if($this->search == ""){
            $this->data = [];
        }
        else{
            $aux_data = DB::table("events_bookings")
            ->Where($this->filter,"LIKE","%".$this->search."%")
            ->Where("event_id",'=',4)
            ->orderBy($this->filter)
            ->get();
            
            foreach ($aux_data as $reserve) {
                $aux_reserve = [
                    "id" => $reserve->id,
                    "client" => $reserve->client,
                    "adults" => $reserve->adults,
                    "children" => $reserve->childrem,
                    "area" => $reserve->area,
                    "seats" => $this->parseSeatsFormat($reserve->seats),
                    "order"=> $reserve->order_id,
                    "status" => $reserve->status
                ];

                array_push($this->data,$aux_reserve);
            }
        }
        
        
        

    }


    private function parseGroupFormat($str){
        /* 
        
        Convierte la cadena con el formato
        {"D":{"adultos":4,"ninos":0}}
        En un arreglo que contiene el numero de adultos y niños que estaran en la mesa reservada.
        El resultado es:

        [
            "group" => 'D',
            "number_of_adults => 4,
            "number_of_kids => 0
        ]


        Elimina los corchetes y luego vuelve a convertir el arreglo obtenido en una cadena.
        Elimina los : y vuelve a unir la cadena, hace el mismo procedimiento con
        comas ',' y las comillas dobles '"'
        luego de eliminar todos los ementos, elimina todos aquellos elementos que se encuentren vacios.
        dejando solo una lista con los elementos.

        */


        $group = explode("}",implode("",explode("{",$str)))[0];
        $group = explode(":",$group);
        $group = implode("",$group);
        $group = explode(",",$group);
        $group = implode("",$group);
        $group = explode("\"",$group);


        //Este ultimo elimina todos los elementos vacios de la lista.
        $grupo = array_filter($group,function($value){
            return  $value !== '';
        }); 

        $aux_arr = [
            "group" => $group[1],
            "number_of_adults" => $group[4],
            "number_of_kids" => $group[6]
        ];

        return $aux_arr;
    }
    private function parseSeatsFormat($seats){


        /*
            Convierte la cadena obtenida con el formato
            'D4.1,D4.8,D5.9,D5.10' 
            Y lo convierte en un arreglo Key => Value
            de la siguiente forma

            [
                5 => [9,10],
                4 => [1,8]
            ]

            Convierte la cadena en un arreglo separado por ','
            Luego recorre cada uno de los elementos del arreglo obtenido
            Separa cada elemento por '.' y guarda el numero a la izquierda
            siendo este el numero de mesa.
            Y el numero de la izquierda del punto como el numero de asiento.
            guardandolos en un arreglo Clave => Valor
            Donde la clave es el numero de mesa y el valor es un arreglo de numeros de asiento.

            
        */

        $seats_arr = explode(",",$seats);
        
        $seats_aux = [];
        foreach ($seats_arr as $value) {
            $splitted_str =  explode(".",$value);
            $table_number = ltrim($splitted_str[0],$splitted_str[0][0]);
            $seat_number = $splitted_str[1];

            if(!array_key_exists($table_number,$seats_aux)){
                $seats_aux[$table_number] = [];
            }

            array_push(
                $seats_aux[$table_number],
                $seat_number
            );
        }
        return $seats_aux;
    }
    
}
