<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive"> 
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Día</th>
                            <th>Mes</th>
                            <th>Año</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $dato)
                            <tr>
                                <td>{{ $dato->Descripción }}</td>
                                <td>{{ $dato->Dia }}</td>
                                <td>{{ $dato->Mes }}</td>
                                <td>{{ $dato->Año }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
