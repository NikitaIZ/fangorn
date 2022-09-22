@extends('adminlte::page')

@section('title', 'Buffet')

@section('content_header')
    <button id="button1" onclick="show_on_hold()" class="btn btn-warning float-right">
        En Espera
    </button>
    <button id="button2" onclick="show_on_completed()" class="invisible d-none">
        Completos
    </button>
    <h1>Cena de Año Nuevo</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{ session('info') }}</strong>
        </div>
    @endif
    <div id="infoCompleted" class="">
        <div class="row py-2">
            <div class="col-lg-3 col-6">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill-wave"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total</span>
                        <span class="info-box-number">
                            {{ $total["completed"][0] }}$
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
                            {{ $total["completed"][1] }}
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
                            {{ $total["completed"][2] }}
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
                            {{ $total["completed"][3] }}
                            <small></small>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <!--<div class="card-header">
            </div>-->
            @if (count($data))
                <div class="card-body">
                    <div class="table-responsive"> 
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>CLIENTE</th>
                                    <th>ADULTOS</th>
                                    <th>NIÑOS</th>
                                    <th>SUBTOTAL</th>
                                    <th>CUPON</th>
                                    <th>TOTAL</th>
                                    <th>PRECIO</th>
                                    <th>FECHA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $dato)
                                    @if ($dato["status"] == "wc-completed")
                                        <tr>
                                            <td>{{ $dato["orderId"] }}</td>
                                            <td>{{ $dato["cliente"] }}</td>
                                            <td>{{ $dato["adultos"] }}</td>
                                            @if ($dato["niños"] != null)
                                                <td>{{ $dato["niños"] }}</td>
                                            @else
                                                <td>0</td>
                                            @endif
                                            <td>{{ $dato["subtotal"] }}$</td>
                                            @if ($dato["cupon"] != null)
                                                <td> -{{ $dato["cupon"] }}$</td>
                                            @else
                                                <td>Ninguno</td>
                                            @endif
                                            <td>{{ $dato["total"] }}$</td>
                                            <td>{{ $dato["precio"] }}$</td>
                                            <td>{{ $dato["fecha"] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--<div class="card-footer">
                </div>-->
            @else
                <div class="card-body">
                    <strong>
                        No Hay Reservas Para Navidad
                    </strong>
                </div>
            @endif
        </div>
    </div>

    <div id="inOnHold" class="invisible d-none">
        <div class="row py-2">
            <div class="col-lg-3 col-6">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill-wave"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total</span>
                        <span class="info-box-number">
                            {{ $total["hold"][0] }}$
                            <small></small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pedidos</span>
                        <span class="info-box-number">
                            {{ $total["hold"][1] }}
                            <small></small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="info-box">
                    <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-male"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Adultos</span>
                        <span class="info-box-number">
                            {{ $total["hold"][2] }}
                            <small></small>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="info-box">
                    <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-child"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Niños</span>
                        <span class="info-box-number">
                            {{ $total["hold"][3] }}
                            <small></small>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <!--<div class="card-header">
            </div>-->
            @if (count($data))
                <div class="card-body">
                    <div class="table-responsive"> 
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>CLIENTE</th>
                                    <th>ADULTOS</th>
                                    <th>NIÑOS</th>
                                    <th>SUBTOTAL</th>
                                    <th>CUPON</th>
                                    <th>TOTAL</th>
                                    <th>PRECIO</th>
                                    <th>FECHA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $dato)
                                    @if ($dato["status"] == "wc-on-hold")
                                        <tr>
                                            <td>{{ $dato["orderId"] }}</td>
                                            <td>{{ $dato["cliente"] }}</td>
                                            <td>{{ $dato["adultos"] }}</td>
                                            @if ($dato["niños"] != null)
                                                <td>{{ $dato["niños"] }}</td>
                                            @else
                                                <td>0</td>
                                            @endif
                                            <td>{{ $dato["subtotal"] }}$</td>
                                            @if ($dato["cupon"] != null)
                                                <td> -{{ $dato["cupon"] }}$</td>
                                            @else
                                                <td>Ninguno</td>
                                            @endif
                                            <td>{{ $dato["total"] }}$</td>
                                            <td>{{ $dato["precio"] }}$</td>
                                            <td>{{ $dato["fecha"] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--<div class="card-footer">
                </div>-->
            @else
                <div class="card-body">
                    <strong>
                        No Hay Reservas Para Navidad
                    </strong>
                </div>
            @endif
        </div>
    </div>
@stop

@section('js')
    <script>
        function show_on_hold(){
            infoCompleted.className = "invisible d-none";
            inOnHold.className      = "";
            button1.className       = "invisible d-none"
            button2.className       = "btn btn-success float-right"
        };
    
        function show_on_completed(){     
            infoCompleted.className = "";
            inOnHold.className      = "invisible d-none";
            button1.className       = "btn btn-warning float-right"
            button2.className       = "invisible d-none"
        };
    </script>
@stop