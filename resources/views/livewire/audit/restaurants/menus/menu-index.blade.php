<div class="card box-shadow">
    <div class="card-header bg-info">
        <h3 class="card-title">
            @switch($this->type)
                @case('comida')
                    <i class="fa-solid fa-fw fa-utensils"></i>Comida
                @break
                @case('bebida')
                    <i class="fa-solid fa-fw fa-wine-glass"></i>Bebida
                @break
                @case('coctel')
                    <i class="fa-solid fa-fw fa-martini-glass-citrus"></i>Cóctel
                @break
            @endswitch
        </h3>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                    <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </li>
            </ul>
        </div>
        <div class="input-group pt-3 pb-2">
            <div class="flex-grow-1 bd-highlight pr-2">
                <input wire:model="search" class="form-control" placeholder="Ingrese Comida" aria-label="Ingrese Comida">
            </div>
            @can('menu.edit')
                @livewire('audit.restaurants.menus.menu-create', ['rest' => $this->rest, 'lang' => $this->lang, 'type' => $this->type], key($this->type))
            @endcan
        </div>
    </div>
    <div class="card-body p-0" wire:init='loadMenus'>
        @if (count($menu_list))
            <div class="card-body p-0">
                <div class="table-responsive"> 
                    <table class="table table-striped m-0">
                        <thead class="table-info" style="color: #17a2b8">
                            <tr>
                                <th scope="col" class="text-left col-auto" role="button" tabindex="0" wire:click="order('{{ $this->name }}')" style="min-width: 8rem;">
                                    @switch($this->type)
                                        @case('comida')
                                            Comidas
                                        @break
                                        @case('bebida')
                                            Bebidas
                                        @break
                                        @case('coctel')
                                            Cócteles
                                        @break
                                    @endswitch
                                    @if ($sort == '{{ $this->name }}')
                                        @if ($direction == 'asc')
                                            <i class="fa-solid fa-arrow-up-a-z fa-fw float-right mt-1"></i>
                                        @else
                                            <i class="fa-solid fa-arrow-down-z-a fa-fw float-right mt-1"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-sort fa-fw float-right mt-1"></i>
                                    @endif
                                </th>
                                <th scope="col"></th>
                                @can('menu.edit')
                                    <th scope="col" colspan="2"></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody class="table-light">
                            @foreach ($menu_list as $menu_option)
                                <tr>
                                    @switch($this->lang)
                                        @case('es')
                                            <td scope="row" class="align-middle">{{ $menu_option->name_es }}</td>
                                        @break
                                        @case('en')
                                            <td scope="row" class="align-middle">{{ $menu_option->name_en }}</td>
                                        @break
                                        @case('ru')
                                            <td scope="row" class="align-middle">{{ $menu_option->name_ru }}</td>
                                        @break
                                    @endswitch
                                    @can('plate.show')
                                        <td width="10px" class="align-middle">
                                            <a class="btn btn-outline-primary" href="{{ route('audit.restaurants.plates.index', ['lang' => $this->lang, 'rest' => $this->rest->id, 'id' => $menu_option->id]) }}"><i class="fa-solid fa-hand-pointer"></i></a>
                                        </td>
                                    @endcan
                                    @can('menu.edit')
                                        <td width="10px" class="align-middle">
                                            <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#Modal{{ $menu_option->id }}" wire:click='edit({{ $menu_option }})'><i class="fa-solid fa-pen-to-square"></i></button>
                                            <div wire:ignore.self class="modal fade" id="Modal{{ $menu_option->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Modal{{ $menu_option->id }}Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            @switch($this->lang)
                                                                @case('es')
                                                                <h5 class="modal-title"><i class="fa-solid fa-edit fa-fw"></i> Editar {{ $menu_option->name_es }}</h5>
                                                                @break
                                                                @case('en')
                                                                <h5 class="modal-title"><i class="fa-solid fa-edit fa-fw"></i> Editar {{ $menu_option->name_en }}</h5>
                                                                @break
                                                                @case('ru')
                                                                <h5 class="modal-title"><i class="fa-solid fa-edit fa-fw"></i> Editar {{ $menu_option->name_ru }}</h5>
                                                                @break
                                                            @endswitch
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="container-fluid" wire:loading wire:target='edit'>
                                                                <div class="d-flex justify-content-center">
                                                                    <div class="spinner-border text-info" role="status">
                                                                        <span class="visually-hidden">Loading...</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 align-items-center" wire:loading.remove wire:target='edit'>
                                                                <div class="col-8">
                                                                    <label for="menu_id" class="col-form-label text-body">Para:</label>
                                                                    <input class="form-control" name="menu_id" type="text" placeholder="{{ $this->rest->name }}" disabled>
                                                                </div>
                                                                <div class="col-4">
                                                                    <label for="type" class="col-form-label text-body">Tipo:</label>
                                                                        <select class="form-select" wire:model="menu.type" aria-label="Default select example">
                                                                            <option value="">Seleccione</option>
                                                                            <option value="comida">Comida</option>
                                                                            <option value="bebida">Bebida</option>
                                                                            <option value="coctel">Cóctel</option>
                                                                        </select>
                                                                    @error('menu.type')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, Elija un tipo de servicio
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-4">
                                                                    <label for="language" class="col-form-label text-body">Idioma:</label>
                                                                    <input class="form-control" name="language" type="text" value="" placeholder="Español" disabled>
                                                                </div>
                                                                <div class="col-8">
                                                                    <label for="name_es" class="col-form-label text-body">Nombre:</label>
                                                                    <input class="form-control" name="name_es" type="text" wire:model="menu.name_es" autocomplete="off">
                                                                    @error('menu.name_es')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, rellene el campo Nombre en Español
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-4">
                                                                    <input class="form-control" name="language" type="text" value="" placeholder="Ingles" disabled>
                                                                </div>
                                                                <div class="col-8">
                                                                    <input class="form-control" name="name_en" type="text" wire:model="menu.name_en" autocomplete="off">
                                                                    @error('menu.name_en')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, rellene el campo Nombre en Español
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-4">
                                                                    <input class="form-control" name="language" type="text" value="" placeholder="Ruso" disabled>
                                                                </div>
                                                                <div class="col-8">
                                                                    <input class="form-control" name="name_ru" type="text" wire:model="menu.name_ru" autocomplete="off">
                                                                    @error('menu.name_ru')
                                                                        <span class="fs-6 text-danger fst-italic">
                                                                            Por favor, rellene el campo Nombre en Español
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-12">
                                                                    <table class="table table-borderless m-0">
                                                                        <tbody>
                                                                            <tr class="table-light">
                                                                                <td class="col-4">
                                                                                    <label class="col-form-label text-body">Descripciones:</label>
                                                                                </td>
                                                                                <td class="col-2 align-middle">
                                                                                    <div class="form-check form-switch">
                                                                                        <input class="form-check-input" type="checkbox" role="switch" wire:model='menu.description'>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="col-4">
                                                                                    <label class="col-form-label text-body">Servicios:</label>
                                                                                </td>
                                                                                <td class="col-2 align-middle">
                                                                                    <div class="form-check form-switch">
                                                                                        <input class="form-check-input" type="checkbox" role="switch" wire:model='menu.service'>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="col-4">
                                                                                    <label class="col-form-label text-body">Opciones:</label>
                                                                                </td>
                                                                                <td class="col-2 align-middle">
                                                                                    <div class="form-check form-switch">
                                                                                        <input class="form-check-input" type="checkbox" role="switch" wire:model='menu.choice'>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="col-4">
                                                                                    <label class="col-form-label text-body">Países:</label>
                                                                                </td>
                                                                                <td class="col-2 align-middle">
                                                                                    <div class="form-check form-switch">
                                                                                        <input class="form-check-input" type="checkbox" role="switch" wire:model='menu.country'>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-info">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal" wire:click='update' wire:loading.remove wire:target='update'>Actualizar</button>
                                                            <span class="text-body" wire:loading wire:target='update'>Cargando...</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="10px" class="align-middle">
                                            <button class="btn btn-outline-danger" wire:click="$emit('deleteMenu', {{ $menu_option->id }})"><i class="fa-solid fa-trash-can"></i></button>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                    <div class="spinner-grow text-info" style="width: 5rem; height: 5rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>