<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\Security\PersonalController;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Security\PersonalModel;


class SecuritySectionPersonalTest extends TestCase
{
    

    
    
    /** @test */

    public function can_access_delete(){

        $this->withoutExceptionHandling();
        
        $user = User::factory()->withPersonalTeam()->create();
        $this->actingAs($user);

        \Session::start();

        $personal = new PersonalModel();
        $personal->name = "NNNN";
        $personal->last_name = "LN";
        $personal->position = "Ppp";
        $personal->area = "AAAA";
        $personal->identification = 1234;
        $personal->state = 1;
        $personal->created_by_id = $user->id;

        $personal->save();


        $response = $this->get("security/delete/$personal->id");
        $response->assertOk();

        $response->assertViewHas("personal",$value = $personal);

    }

    /** @test */
    public function can_delete_personal(){

        /* 
        
            Este test genera un usuario e inicia sesion.
            Crea un nuevo registro del tipo personal lo guarda
            y hace una peticion para obrrarlo, verifica que este redireccionando.
            y por ultimo verifica que el registro se haya borrado.
        */
        $this->withoutExceptionHandling();
        
        $user = User::factory()->withPersonalTeam()->create();
        $this->actingAs($user);

        \Session::start();

        $personal = new PersonalModel();
        $personal->name = "NNNN";
        $personal->last_name = "LN";
        $personal->position = "Ppp";
        $personal->area = "AAAA";
        $personal->identification = 1235;
        $personal->state = 1;
        $personal->created_by_id = $user->id;

        $personal->save();

        $response = $this->post("security/delete/$personal->id",[
            "_token" => csrf_token()
        ]);
        $response->assertRedirect();

        $personal = DB::table('personal_models')->latest('created_at')->first();
        $this->assertEquals($personal,null);
    }

    /** @test */
    public function can_show_users_in_security_personal_section(){
        \Session::start();
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $response = $this->get('/security/personal');
        $response->assertOk();
    
    }

    

    /** @test */
    public function can_access_register(){
        $this->withoutExceptionHandling();
        
        \Session::start();
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        
        $response = $this->get('/security/register');

        $response->assertOk();    
    }

    /** @test */

    public function can_access_update(){
        $this->withoutExceptionHandling();
        
        $user = User::factory()->withPersonalTeam()->create();
        $this->actingAs($user);

        \Session::start();


        $personal = new PersonalModel();
        $personal->name = "NNNN";
        $personal->last_name = "LN";
        $personal->position = "Ppp";
        $personal->area = "AAAA";
        $personal->identification = 1236;
        $personal->state = 1;
        $personal->created_by_id = $user->id;

        $personal->save();


        $personal = PersonalModel::where("id",$personal->id)->get()->first();

        
        
        $response = $this->get("/security/update/$personal->id");
        $response->assertOk();


        $response->assertViewHas("personal",$value = $personal);



    }


    

    /** @test */

    public function can_update_personal(){

        //Inicializa un nuevo usuario y una sesion.
        $this->withoutExceptionHandling();

        $user = User::factory()->withPersonalTeam()->create();
        \Session::start();
        $this->actingAs($user);

        //Inicializa un nuevo personal. y lo guarda en la bd.

        $personal = new PersonalModel();
        $personal->name = "NNNN";
        $personal->last_name = "LN";
        $personal->position = "Ppp";
        $personal->area = "AAAA";
        $personal->identification = 1237;
        $personal->state = 1;
        $personal->created_by_id = $user->id;

        $personal->save();

        $req_personal = [
            "name"=>"updated name",
            "last_name"=>"updated_last_name",
            "position"=>"updated_position",
            "area"=>"updated_area",
            "identification"=>"1919191",
            "user_state"=>"1",
            "_token" => csrf_token()
        ];

        //Mensaje de respuesta esperado.
        $response = [
            "message" => "Actualizacion exitosa!",
            "status"=>"Successfull"
        ];
        
        
        //Datos esperados en el formulario.
        $response = $this->post("/security/update/$personal->id",$req_personal);
        //Se espsera una respuesta 200, si todo esta bien.
        $response->assertOk();

        //Se obtiene el registro que se acaba de ingresar.
        $personal = PersonalModel::where("id",$personal->id)->get()->first();


        //y se verifica si fue actualizado.

        $this->assertEquals($personal->name,$req_personal['name']);
        $this->assertEquals($personal->last_name,$req_personal['last_name']);
        $this->assertEquals($personal->position,$req_personal['position']);
        $this->assertEquals($personal->area,$req_personal['area']);
        $this->assertEquals($personal->identification,$req_personal['identification']);
        $this->assertEquals($personal->state,$req_personal['user_state']);
        

        $response->assertViewHas("personal",$value = $personal);
        $response->assertViewHas("response",function($response){
            return $response['status'] === "Successfull"
                   && $response["message"] === "Actualizacion exitosa!";
        });




    }

    /** @test */
    public function can_create_personal(){
        $this->withoutExceptionHandling();

        

        /*
            Test para validar que la creacion de un personal se haga correctamente.
        */
        //respuesta de la consulta.
        $response = [
            "message" => "Se registro exitosamente!",
            "status" => "Successfull",
        ];

        //Inicia una sesion falsa con los permisos para acceder a la vista.
        \Session::start();
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());


        $req_personal = [
            "name"=>"test name",
            "last_name"=>"test last name",
            "position"=>"test position",
            "area"=>"test area",
            "identification"=>"1238",
            "user_state"=>"1",
            "_token" => csrf_token()
        ];

        //Envia una peticion post a la ruta con los datos.
        $response = $this->post("/security/register",$req_personal);
        $response->assertOk();

        //Obtiene el personal que se acaba de crear en la base de datos..
        $personal = PersonalModel::where("identification","1238")->get()->first();

        $response->assertViewHas("response",function($response){
            return $response['status'] === "Successfull" 
                   && $response['message'] === "Registro completado!";
        });
        
        $this->assertEquals($personal->name,$req_personal['name']);
        $this->assertEquals($personal->last_name,$req_personal['last_name']);
        $this->assertEquals($personal->position,$req_personal['position']);
        $this->assertEquals($personal->area,$req_personal['area']);
        $this->assertEquals($personal->state,$req_personal['user_state']);
        $this->assertEquals($personal->identification,$req_personal['identification']);
        $this->assertEquals($personal->created_by_id,$user->id);
        
       
    }



}
