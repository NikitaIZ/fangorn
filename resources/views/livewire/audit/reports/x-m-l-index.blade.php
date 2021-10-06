<div>
    <div class="card">
        <div class="card-header">
            <input wire:model="search" class="form-control" placeholder="Ingrese Fecha">
        </div>
        @if ($reports->count())
            <div class="card-body">
                <div class="table-responsive"> 
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Subido</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                                <tr>
                                    <td>{{ $report->id }}</td>
                                    <td>{{ $report->date }}</td>
                                    <td>{{ $report->created_at }}</td>
                                    @can('xmls.show')
                                        <td>
                                            <a class="btn btn-primary float-right"" href="{{route('xmls.show', $report->id)}}">Detalles</a>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $reports->onEachSide(0)->links() }}
            </div>
        @else
            <div class="card-body">
                <strong>
                    No hay coincidencias
                </strong>
            </div>
        @endif
    </div>
</div>