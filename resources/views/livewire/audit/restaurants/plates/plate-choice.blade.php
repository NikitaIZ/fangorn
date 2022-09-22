<div wire:init='loadChoices'>
    <div class="d-flex bd-highlight pb-2">
        <div class="flex-shrink-1 pr-2">
            @can('plate.edit')
                @livewire('audit.restaurants.plates.plate-create', ['lang' => $this->lang, 'menu' => $this->menu, 'list' => true, 'choices' => true], key('new_plate_choice'))
            @endcan
        </div>
        <div class="flex-grow-1 bd-highlight pr-2">
            @can('plate.edit')
                @livewire('audit.restaurants.plates.choice-create', ['lang' => $this->lang, 'menu' => $this->menu], key('new_choice'))
            @endcan
        </div>
        <div class="flex-grow-1 bd-highlight">
            @can('menu.edit')
                @livewire('audit.restaurants.menus.menu-update', ['lang' => $this->lang, 'menu' => $this->menu], key('update_menu'))
            @endcan
        </div>
    </div>
    @if (count($choices))
        @foreach ($choices as $choice)
            @if ($choice['id'])
                <div class="py-2">
                    <div class="d-grid gap-2">
                        <a class="btn btn-light border text-left fs-5" data-bs-toggle="collapse" href="#collapse{{ $choice['id'] }}" role="button" aria-expanded="false" aria-controls="collapse{{ $choice['id'] }}">
                            {{ $choice['name'] }} <i class="fa-solid fa-fw fa-angle-down float-right mt-1"></i>
                        </a>
                    </div>
                    <div class="collapse pt-3" id="collapse{{ $choice['id'] }}">
                        @livewire('audit.restaurants.plates.plate-index', ['lang' => $this->lang, 'rest' => $this->rest, 'menu' => $this->menu, 'choice' => $choice['id'], 'choices' => 'true'], key($choice['id']))
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
                        @livewire('audit.restaurants.plates.plate-index', ['lang' => $this->lang, 'rest' => $this->rest, 'menu' => $this->menu, 'choice' => 0, 'choices' => 'true'], key('sin_asignar'))
                    </div>
                </div>
            @endif
        @endforeach
    @endif
</div>
