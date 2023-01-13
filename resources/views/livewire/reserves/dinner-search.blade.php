<div class="container-fluid m-0 p-0">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            
            <div class="search-container">
                <div class="search-box">
                    <label for="name" class="search-label">
                        <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                    </label>
                    <input type="search" wire:model="search" name="search" id="search" class="search-input" placeholder="Buscar">
                </div>
            </div>
            <div class="container-fluid border p-3 w-75 shadow-lg  bg-body ">
                <h4>Filtros</h4>
                <div class="input-group">
                    <div class="form-check form-check-inline ">
                        <input wire:click="setFilter('client')" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="client">
                        <label wire:click="setFilter('client')" class="form-check-label" for="inlineRadio1">Nombre</label>
                    </div>
                    <div class="form-check form-check-inline ">
                        <input wire:click="setFilter('seats')" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="seats">
                        <label wire:click="setFilter('seats')" class="form-check-label" for="inlineRadio2">Mesa</label>
                    </div>
                    <div class="form-check form-check-inline ">
                        <input wire:click="setFilter('area')" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="group">
                        <label wire:click="setFilter('area')" class="form-check-label" for="inlineRadio3">Grupo</label>
                    </div>
                    <div class="form-check form-check-inline ">
                        <input wire:click="setFilter('order_id')" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="order">
                        <label wire:click="setFilter('order_id')"  class="form-check-label" for="inlineRadio4">Nro. Orden</label>
                    </div>
                </div>
            </div>
            <div class="container-fluid  rounded">
                @foreach($data as $reserve)
                    @if($reserve['status'] != "cancelled")
                        <div class="card mb-5 mt-5 shadow-lg mb-5 bg-body rounded p-0">
                            <h5 class="card-header p-4 text-white wyndham-bg">Informacion de Compra</h5>
                            <div class="card-body">
                                <div class="container-fluid">
                                    <h3 class="m-0">{{$reserve['client']}}</h3>
                                    <p>Orden: {{$reserve["order"]}}</p>
                                </div>
                                <hr>
                                <div class="container-fluid">
                                    <h5 class="m-0">Adultos: {{$reserve["adults"]}}</h5>
                                    <h5 class="m-0">Niños: {{$reserve["children"]}}</h5>
                                    <hr>
                                    <div class="reserve-state">
                                        <h3>Estado de Orden</h3>
                                        @if($reserve["status"]== "completed")
                                            <h4 style="width:fit-content;" class="m-0 bg-success text-white rounded p-2">Completado</h4>
                                        @else
                                            <h4 style="width:fit-content;" class="m-0 bg-warning text-white rounded p-2">En Espera</h4>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="container-fluid">
                                    <h3>Grupo</h3>
                                    <h4 style="width:fit-content;" class="m-0 wyndham-bg text-white rounded p-2">{{$reserve["area"]}}</h4>
                                </div>
                                <hr>
                                <div class="container-fluid">
                                    <h3>Mesas y asientos</h3>
                                    @foreach($reserve['seats'] as $key => $value)
                                    <div class="box ">
                                        <h5 class="subtitle is-5">Mesa {{$key}}</h5>
                                        <div class="box-seat" >
                                            @foreach($reserve['seats'][$key] as $seat)
                                                <div class="seat wyndham-bg"  class="box">
                                                    <span class="seat-span">{{$seat}}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                
                @endforeach
            </div>
        </div>

        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

        <div class=" p-1 d-grid gap-2 col-12 mx-auto m-1">
            <a href="https://10.80.22.178:8087" class="btn btn-primary p-4" type="button">Activar Camara</a>
        
        </div>
        </div>

    </div>


    
</div>



