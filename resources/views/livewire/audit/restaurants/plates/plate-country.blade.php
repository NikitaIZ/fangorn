<div wire:init='loadCountries'>
    <div class="d-flex bd-highlight">
        <div class="flex-shrink-1 pr-2">
            @can('plate.edit')
                @livewire('audit.restaurants.plates.plate-create', ['lang' => $this->lang, 'menu' => $this->menu, 'list' => true, 'countries' => true], key('new_plate_country'))
            @endcan
        </div>
        <div class="flex-grow-1 bd-highlight pr-2">
            @can('plate.edit')
                @livewire('audit.restaurants.plates.country-create', ['lang' => $this->lang], key('new_country'))
            @endcan
        </div>
        <div class="flex-grow-1 bd-highlight">
            @can('menu.edit')
                @livewire('audit.restaurants.menus.menu-update', ['menu' => $this->menu], key('update_menu'))
            @endcan
        </div>
    </div>
    @if (count($countries))
        @foreach ($countries as $country)
            @if ($country['id'])
                <div class="py-2">
                    <div class="d-grid gap-2">
                        <a class="btn btn-light border text-left fs-5" data-bs-toggle="collapse" href="#collapse{{ $country['id'] }}" role="button" aria-expanded="false" aria-controls="collapse{{ $country['id'] }}">
                            {{ $country['name'] }} <i class="fa-solid fa-fw fa-angle-down float-right mt-1"></i>
                        </a>
                    </div>
                    <div class="collapse pt-3" id="collapse{{ $country['id'] }}">
                        @livewire('audit.restaurants.plates.plate-index', ['lang' => $this->lang, 'rest' => $this->rest, 'menu' => $this->menu, 'country' => $country['id'], 'countries' => 'true'], key($country['id']))
                    </div>
                </div>
            @else
                <div class="py-2">
                    <div class="d-grid gap-2">
                        <a class="btn btn-danger border text-left fs-5" data-bs-toggle="collapse" href="#sin_asignar" role="button" aria-expanded="false" aria-controls="sin_asignar">
                            Sin asignar <i class="fa-solid fa-fw fa-angle-down float-right mt-1"></i>
                        </a>
                    </div>
                    <div class="collapse pt-3" id="sin_asignar">
                        @livewire('audit.restaurants.plates.plate-index', ['lang' => $this->lang, 'rest' => $this->rest, 'menu' => $this->menu, 'country' => 0, 'countries' => 'true'], key('sin_asignar'))
                    </div>
                </div>
            @endif
        @endforeach
    @endif
</div>
