<div class="row">
    <div class="col-12">
        <button wire:click="excel()" class="btn btn-success float-left">
            <i class="fa-solid fa-file-excel"></i> Excel
        </button>
        @if ($this->status == "completed" )
            <button wire:click="status('on hold')" class="btn btn-warning float-right">
                En Espera
            </button>
        @else
            <button wire:click="status('completed')" class="btn btn-success float-right">
                Completos
            </button>
        @endif
        <h2 class="text-center">Cena Navideña</h2>
        
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill-wave"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total</span>
                <span class="info-box-number">
                    {{ $total['total'] }}$
                    <small></small>
                </span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pedidos</span>
                <span class="info-box-number">
                    {{ $total['count'] }}
                    <small></small>
                </span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-male"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Adultos</span>
                <span class="info-box-number">
                    {{ $total['adults'] }}
                    <small></small>
                </span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="info-box">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-child"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Niños</span>
                <span class="info-box-number">
                    {{ $total['childrem'] }}
                    <small></small>
                </span>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;">
            <div class="card-header bg-danger p-2">
                <div class="d-flex bd-highlight">
                    <div class="flex-shrink-1 pr-1">
                        <select class="form-select" wire:model='cant' aria-label="Default select example">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="flex-grow-1 bd-highlight pr-1">
                        <input wire:model="search" class="form-control" placeholder="Ingrese Nombre de Cliente">
                    </div>
                    <div class="flex-shrink-1 pr-1" style="width: 18%;">
                        <input class="form-control" autocomplete="off" name="date_start" type="date" autocomplete="off" wire:model="date_start" min="2022-10-31" max="2023-01-01">
                    </div>
                    <div class="flex-shrink-1" style="width: 18%;">
                        <input class="form-control" autocomplete="off" name="date_end" type="date" autocomplete="off" wire:model="date_end" min="2022-10-31" max="2023-01-01">
                    </div>
                </div>
            </div>
            <div class="card-body p-0" wire:init='loadBookings'>
                @if (count($bookings))
                    <div class="table-responsive"> 
                        <table class="table table-striped m-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="col-auto" role="button" tabindex="0" wire:click="order('order_id')">
                                        ID
                                        @if ($sort == 'order_id')
                                            @if ($direction == 'asc')
                                                <i class="fa-solid fa-arrow-up-1-9 fa-fw float-right mt-1"></i>
                                            @else
                                                <i class="fa-solid fa-arrow-down-9-1 fa-fw float-right mt-1"></i>
                                            @endif
                                        @else
                                            <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                        @endif
                                    </th>
                                    <th scope="col" class="text-left col-auto" role="button" tabindex="0" wire:click="order('client')" style="min-width: 10rem;">
                                        Cliente
                                        @if ($sort == 'client')
                                            @if ($direction == 'asc')
                                                <i class="fa-solid fa-arrow-up-a-z fa-fw float-right mt-1"></i>
                                            @else
                                                <i class="fa-solid fa-arrow-down-z-a fa-fw float-right mt-1"></i>
                                            @endif
                                        @else
                                            <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                        @endif
                                    </th>
                                    <th scope="col" class="text-center col-auto" role="button" tabindex="0" wire:click="order('adults')" style="min-width: 7rem;">
                                        Adultos
                                        @if ($sort == 'adults')
                                            @if ($direction == 'asc')
                                                <i class="fa-solid fa-arrow-up-1-9 fa-fw float-right mt-1"></i>
                                            @else
                                                <i class="fa-solid fa-arrow-down-9-1 fa-fw float-right mt-1"></i>
                                            @endif
                                        @else
                                            <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                        @endif
                                    </th>
                                    <th scope="col" class="text-center col-auto" role="button" tabindex="0" wire:click="order('childrem')" style="min-width: 6rem;">
                                        Niños
                                        @if ($sort == 'childrem')
                                            @if ($direction == 'asc')
                                                <i class="fa-solid fa-arrow-up-1-9 fa-fw float-right mt-1"></i>
                                            @else
                                                <i class="fa-solid fa-arrow-down-9-1 fa-fw float-right mt-1"></i>
                                            @endif
                                        @else
                                            <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                        @endif
                                    </th>
                                    <th scope="col" class="text-center col-auto" role="button" tabindex="0" wire:click="order('total')" style="min-width: 6rem;">
                                        Total
                                        @if ($sort == 'total')
                                            @if ($direction == 'asc')
                                                <i class="fa-solid fa-arrow-up-1-9 fa-fw float-right mt-1"></i>
                                            @else
                                                <i class="fa-solid fa-arrow-down-9-1 fa-fw float-right mt-1"></i>
                                            @endif
                                        @else
                                            <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                        @endif
                                    </th>
                                    <th scope="col" class="text-center col-auto" role="button" tabindex="0" wire:click="order('area')" style="min-width: 6rem;">
                                        Grupo
                                        @if ($sort == 'area')
                                            @if ($direction == 'asc')
                                                <i class="fa-solid fa-arrow-up-a-z fa-fw float-right mt-1"></i>
                                            @else
                                                <i class="fa-solid fa-arrow-down-z-a fa-fw float-right mt-1"></i>
                                            @endif
                                        @else
                                            <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                        @endif
                                    </th>
                                    <th scope="col" class="text-center col-auto" role="button" tabindex="0" wire:click="order('created_at')" style="min-width: 12rem;">
                                        Fecha
                                        @if ($sort == 'created_at')
                                            @if ($direction == 'asc')
                                                <i class="fa-solid fa-calendar-plus fa-fw float-right mt-1"></i>
                                            @else
                                                <i class="fa-regular fa-calendar-plus fa-fw float-right mt-1"></i>
                                            @endif
                                        @else
                                            <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                        @endif
                                    </th>
                                    <th scope="col"></th>
                                    <!--<th scope="col" colspan="2"></th>-->
                                </tr>
                            </thead>
                            <tbody class="table-light">
                                @foreach ($bookings as $booking)
                                    @if ($booking->status == $this->status)
                                        <tr>
                                            <td scope="row" class="text-center align-middle">{{ $booking->order_id }}</td>
                                            <td>{{ $booking->client }}</td>
                                            <td class="text-center align-middle">{{ $booking->adults }}</td>
                                            <td class="text-center align-middle">{{ $booking->childrem }}</td>
                                            <td class="text-center align-middle">{{ number_format($booking->total, 2, ',', '.')}}$</td>
                                            <td class="text-center align-middle">{{ $booking->created_at }}</td>
                                            <td width="10px" class="align-middle">
                                                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#Modal{{ $booking->order_id }}" wire:click="getDataTablesAndSeats({{ $booking->order_id }})"><i class="fa-solid fa-circle-info"></i></button>
                                                <div wire:ignore.self class="modal fade" id="Modal{{ $booking->order_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Modal{{ $booking->order_id }}Label" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-success">
                                                                <h5 class="modal-title"><i class="fa-solid fa-circle-info fa-fw"></i> Detalles</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="container-fluid" wire:loading wire:target='getDataTablesAndSeats'>
                                                                    <div class="d-flex justify-content-center align-middle">
                                                                        <div class="spinner-border text-success align-middle" role="status">
                                                                            <span class="visually-hidden">Loading...</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row fact-info" wire:loading.remove wire:target='getDataTablesAndSeats'>
                                                                    <div class="col-12 text-center">
                                                                        <h5 class="text-danger">N° de Compra: </h5>
                                                                        <h4>
                                                                            {{ $booking->order_id }}
                                                                        </h4>
                                                                    </div>
                                                                    <div class="col-6 text-center">
                                                                        <h5 class="text-danger">Comprado Por:</h5>
                                                                        <p>
                                                                            {{ $booking->client }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-6 text-center">
                                                                        <h5 class="text-danger">Grupo</h5>
                                                                        <p>
                                                                            {{ $booking->area }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <table class="table table-light table-borderless" wire:loading.remove wire:target='getDataTablesAndSeats'>
                                                                    <tbody class="text-center">
                                                                        <tr class="solid-border">
                                                                            <td colspan="2">
                                                                                <h5 class="text-danger">Reserva</h5>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <h6>Adultos</h6>
                                                                            </td>
                                                                            <td>
                                                                                <h6>Niños</h6>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <p>{{ $booking->adults }}</p>
                                                                            </td>
                                                                            <td>
                                                                                <p>{{ $booking->childrem }}</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <h6>Mesas</h6>
                                                                            </td>
                                                                            <td>
                                                                                <h6>Asientos</h6>
                                                                            </td>
                                                                        </tr>
                                                                        @foreach ($this->tables as $key => $table) 
                                                                            <tr>
                                                                                <td>
                                                                                    <p>{{ $table }}</p>
                                                                                </td>
                                                                                <td>
                                                                                    <p>{{ $this->seats[$key] }}</p>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                        <tr class="solid-border">
                                                                            <td colspan="2">
                                                                                <h5 class="text-danger">Precios</h5>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="col-2">
                                                                                <h6>Adultos</h6>
                                                                            </td>
                                                                            <td class="col-2">
                                                                                <h6>Niños</h6>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <p>{{ number_format($booking->price_adult, 2, ',', '.') }}$</p>
                                                                            </td>
                                                                            <td>
                                                                                <p>{{ number_format($booking->price_childrem, 2, ',', '.') }}$</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="solid-border">
                                                                            <td colspan="2">
                                                                                <h5 class="text-danger">Fechas</h5>
                                                                            </td>
                                                                        </tr>
                                                                        @if ($this->status == "completed")
                                                                            <tr>
                                                                                <td>
                                                                                    <h6>Reserva</h6>
                                                                                </td>
                                                                                <td>
                                                                                    <h6>Compra</h6>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    <p>{{ $booking->created_at }}</p>
                                                                                </td>
                                                                                <td>
                                                                                    <p>{{ $booking->updated_at }}</p>
                                                                                </td>
                                                                            </tr>
                                                                        @else
                                                                            <tr>
                                                                                <td colspan="2">
                                                                                    <h5>Reserva</h5>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2">
                                                                                    <p>{{ $booking->created_at }}</p>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                                <table class="table table-striped table-hover" wire:loading.remove wire:target='getDataTablesAndSeats'>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Sub Total</td>
                                                                            <td class="text-center">{{ number_format($booking->subtotal, 2, ',', '.') }}$</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>{{ $this->coupon . " " . $booking->coupon_description }}</td>
                                                                            <td class="text-center"> -{{ number_format($booking->discount, 2, ',', '.') }}$</td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <tfoot style="color: green;">
                                                                        <tr class="bg-success">
                                                                            <th>Total</th>
                                                                            <th class="text-center">{{ number_format($booking->total, 2, ',', '.') }}$</th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer bg-success">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <!--<td width="10px" class="align-middle">
                                                <button class="btn btn-outline-danger" wire:click="$emit('deleteReserve', {{ $booking->order_id }})"><i class="fa-solid fa-trash-can"></i></button>
                                            </td>-->
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-danger father">
                    <div class="child">
                        {{ $bookings->onEachSide(0)->links() }}
                    </div>
                </div>
                @else
                    @if ($this->readyToLoad)
                        <div class="p-4 text-center">
                            <strong>
                                No hay registro
                            </strong>
                        </div>
                    @else
                        <div class="p-4 d-flex justify-content-center">
                            <div class="spinner-grow text-success" style="width: 5rem; height: 5rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>