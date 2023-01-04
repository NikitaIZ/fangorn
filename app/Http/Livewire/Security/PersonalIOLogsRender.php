<?php

namespace App\Http\Livewire\Security;

use Livewire\Component;
use App\Models\Security\PersonalIOLog as PersonalIOLogModel;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeZone;
class PersonalIOLogsRender extends Component

{   use WithPagination;

    protected $limit = 5;
    protected $paginationTheme = 'bootstrap';
    protected $tbl_name = "personal_io_logs";
    public $personal_id;

    public function render()
    {
        return view('livewire.security.personal-i-o-logs-render',[
            "logs" => $this->getLogs()
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

    public function getLogs(){
        $logs = DB::table("$this->tbl_name")
        ->leftJoin("users","users.id","=","$this->tbl_name.created_by")
        ->select(
            'users.name as user_name',
            "$this->tbl_name.type as log_type",
            "$this->tbl_name.description as log_body",
            "$this->tbl_name.created_at as log_datetime",
        )
        ->where("$this->tbl_name.personal_id",$this->personal_id)
        ->orderBy("$this->tbl_name.created_at",'desc')
        ->paginate($this->limit,['*'],'io_logs');
        
        foreach ($logs as $log) {
            # code...  
            $log->log_datetime = $this->setTMZ($log->log_datetime);  
        }

        return $logs;
    }
    
}
