<div class="col">
    <div class="card">
        <div class="card-header" style="background-color: #0c437d!important; color: white;">
            <input wire:model="search" class="form-control" placeholder="Ingrese descripcion">
        </div>
        <div class="card-body p-0">
            <div class="table-responsive"> 
                <table class="table table-striped m-0">
                    <thead class="table-primary text-center" style="color: #0c437d;">
                        <tr>
                            <th class="text-center" scope="col" style="min-width: 11rem;">Descripción</th>
                            <th class="text-center" scope="col">Día</th>
                            <th class="text-center" scope="col">Mes</th>
                            <th class="text-center" scope="col">Año</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        @foreach ($data as $dato)
                            <tr>
                                <td>{{ $dato->description }}</td>
                                @if ($dato->day != null)
                                    <td class="text-center align-middle">{{ round($dato->day, 2) }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $dato->day }}</td>
                                @endif
                                @if ($dato->month != null)
                                    <td class="text-center align-middle">{{ round($dato->month, 2) }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $dato->month }}</td>
                                @endif
                                @if ($dato->year != null)
                                    <td class="text-center align-middle">{{ round($dato->year, 2) }}</td>
                                @else
                                    <td class="text-center align-middle">{{ $dato->year }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
