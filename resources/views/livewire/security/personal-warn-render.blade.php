<div class="table-responsive">
    <table class="table border  table-striped p-0 m-0">
        <thead class="bg-danger">
            <tr>
                <th scope="col">Creador</th>
                <th scope="col">Razon</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{$log->user_name}}</td>
                    <td>{{$log->log_title}}</td>
                    <td>{{$log->log_body}}</td>
                    <td>{{$log->log_datetime}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="container-fluid m-0 p-0 d-flex justify-content-center">
        <div class="d-flex align-items-center pt-4   align-items-bottom">
            {{$logs->links()}}
        </div>
    </div>
</div>
