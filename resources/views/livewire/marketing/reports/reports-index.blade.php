<div class="d-flex flex-column gap-1 px-3">



    
    

    @if(\Session::has("response"))
        <div class="alert alert-info" role="alert">
            Session::get("response")
        </div>
    @endif

   
    <div style="width:fit-content;" class="d-flex gap-2"  >
        <select wire:model="filter" class="form-select bg-info" aria-label=".form-select-lg example">
            <option value="month" selected>Mes</option>
            <option value="day">Dia</option>
        </select>
        <input wire:model="search" class="form-control bg-info" type="date" name="date-filter" id="date-filter">
    </div>
    <div class="">
        <div wire:loading class="spinner-grow text-info" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div  wire:loading.remove >
        <div wire:init="loadData" class="accordion d-flex flex-column gap-2" id="accordionPanelsStayOpenExample">
            <div  class="accordion-item ">
                <h2 class="accordion-header " id="panelsStayOpen-headingOne">
                    <button class="accordion-button text-info bg-info " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        Accordion Item #1
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                    <div class="accordion-body">
                        <h5 class="bg-secondary p-2 m-0 text-center " >Hotel Palm Beach</h5>
                        <div class="table-responsive">
                            <table class="shadow p-3 mb-5 bg-body rounded table table-bordered rounded">
                                <thead>
                                    <tr>
                                        <th>Dia</th>
                                        <th>Disponibles</th>
                                        <th>Ocupadas</th>
                                        <th>% Ocupadas</th>
                                        <th>Tarifa</th>
                                        <th>Produccion Diaria</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>128</td>
                                        <td>112</td>
                                        <td>87,50%</td>
                                        <td>105.00 $</td>
                                        <td>11,760 $</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>128</td>
                                        <td>101</td>
                                        <td>78,91%</td>
                                        <td>85.00 $</td>
                                        <td>8,585 $</td>
                                    </tr>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
