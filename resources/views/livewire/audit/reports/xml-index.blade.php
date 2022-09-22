<div class="col-lg-10 col-12">
    <div class="card" style="border-radius: 20px; box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
        <div class="card-header" style="background-color: #0c437d!important; color: white; border-radius: 10px 10px 0px 0px">
            <input wire:model="search" class="form-control" placeholder="Ingrese ID o Reporte">
        </div>
        @if ($reports->count())
            <div class="card-body p-0">
                <div class="table-responsive"> 
                    <table class="table table-striped m-0">
                        <thead class="table-primary text-center" style="color: #0c437d;">
                            <tr>
                                <th class="text-center" scope="col">ID</th>
                                <th class="text-center" scope="col">Reporte</th>
                                <th class="text-center" scope="col" style="min-width: 11rem;">Añadido</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="table-light">
                            @foreach ($reports as $report)
                                <tr>
                                    <td class="text-center align-middle">{{ $report->id }}</td>
                                    <td class="text-center align-middle">{{ $report->folder }}</td>
                                    <td class="text-center align-middle">{{ $report->created_at }}</td>
                                    <td width="10px">
                                        <a class="btn btn-wyndham" href="{{route('audit.reports.show', $report->id)}}">Detalles</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer father" style="background-color: #0c437d!important; color: white; border-radius: 0px 0px 10px 10px">
                <div class="child">
                    {{ $reports->onEachSide(0)->links() }}
                </div>
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