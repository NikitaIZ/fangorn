<?php

namespace App\Http\Livewire\Security;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use DateTime;
use DateTimeZone;
use Livewire\WithPagination;
class PersonalWarnRender extends Component
{   
    use WithPagination;
    protected $limit = 5;
    protected $paginationTheme = 'bootstrap';
    public $personal_id;
    protected $tbl_name = "personals_warns";

    
    public function render()
    {
        return view('livewire.security.personal-warn-render',[
            "logs" => $this->getWarns()
        ]);
    }
    public function mount(){
        $this->personal_id = \Route::current()->parameter('personal_id');
    }
    
    private function setTMZ($timestamp){
        $date = new DateTime($timestamp);
        $date->setTimezone(new DateTimeZone("America/Caracas"));
        return $date->format('Y-m-d H:i');
    }

    public function getWarns(){
        $logs = DB::table("$this->tbl_name")
        ->leftJoin("users","users.id","=","$this->tbl_name.created_by")
        ->select(
            'users.name as user_name',
            "$this->tbl_name.title as log_title",
            "$this->tbl_name.description as log_body",
            "$this->tbl_name.created_at as log_datetime",
        )
        ->where("$this->tbl_name.personal_id",$this->personal_id)
        ->orderBy("$this->tbl_name.created_at",'desc')
        ->paginate($this->limit,['*'],'warn_logs');
        
        foreach ($logs as $log) {
            # code...  
            $log->log_datetime = $this->setTMZ($log->log_datetime);  
        }

        return $logs;
    }
}
