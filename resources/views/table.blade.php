@extends('adminlte::page')
@section('title', 'Personal')

@section('css')

  

@stop

@section('content_header')




@stop


@section('content')

<div class="container-fluid py-2">
    <div class="container-fluid bg-info ">
        <h5 class="p-2">Tarifas Boda Daniel y Candy desde el 23 al 27/03/2023</h5>
    </div>
    <table class="table table-bordered table-striped p-0 m-0">
        <thead class="">
            <tr>
                <th>Habitaciones</th>
                <th>1-2 pax</th>
                <th>3 pax</th>
                <th>4 pax</th>
                <th>5 pax</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Sencilla/Doble</td>
                <td>90$</td>
                <td>135$</td>
                <td>180$</td>
                <td>N/A</td>
            </tr>
            <tr>
                <td>Suite</td>
                <td>130$</td>
                <td>175$</td>
                <td>220$</td>
                <td>265$</td>
            </tr>
            <tr>
                <td>Niños (5 a 11 años)</td>
                <td  colspan="4">25 $</td>
            </tr>
        </tbody>
    </table>
</div>

@stop

@section('js')


@stop