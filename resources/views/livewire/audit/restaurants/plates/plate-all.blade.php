<div wire:init='loadAll'>
    <div class="d-flex bd-highlight pb-2">
        <div class="d-flex pr-2">
            @can('plate.edit')
                @livewire('audit.restaurants.plates.plate-create', ['lang' => $this->lang, 'menu' => $this->menu, 'list' => true, 'choices' => true, 'countries' => true], key('new_plate_choice'))
            @endcan
        </div>
        <div class="d-flex bd-highlight pr-2">
            @can('plate.edit')
                @livewire('audit.restaurants.plates.choice-create', ['lang' => $this->lang, 'menu' => $this->menu], key('new_choice'))
            @endcan
        </div>
        <div class="d-flex bd-highlight">
            @can('plate.edit')
                @livewire('audit.restaurants.plates.country-create', ['lang' => $this->lang, 'menu' => $this->menu], key('new_country'))
            @endcan
        </div>
        <div class="flex-grow-1 bd-highlight">
            @can('menu.edit')
                @livewire('audit.restaurants.menus.menu-update', ['lang' => $this->lang, 'menu' => $this->menu], key('update_menu'))
            @endcan
        </div>
    </div>
    @if (count($list))
        @foreach ($list as $choice)
            <div class="py-2">
                <div class="d-grid gap-2">
                    <a class="btn btn-info border text-left fs-5" data-bs-toggle="collapse" href="#{{ $choice['coll'] }}" role="button" aria-expanded="false" aria-controls="{{ $choice['coll'] }}">
                        {{ $choice['name'] }} <i class="fa-solid fa-fw fa-angle-down float-right mt-1"></i>
                    </a>
                </div>
                <div class="collapse show py-2" id="{{ $choice['coll'] }}">
                    @foreach ($choice['option'] as $country)
                        <div class="ml-3 mr-2 py-2">
                            <div class="d-grid gap-2">
                                <a class="btn btn-light border text-left fs-5" data-bs-toggle="collapse" href="#{{ $choice['coll'] }}{{ $country['coll'] }}" role="button" aria-expanded="false" aria-controls="{{ $choice['coll'] }}{{ $country['coll'] }}">
                                    {{ $country['name'] }} <i class="fa-solid fa-fw fa-angle-down float-right mt-1"></i>
                                </a>
                            </div>
                            <div class="collapse pt-3" id="{{ $choice['coll'] }}{{ $country['coll'] }}">
                                @livewire('audit.restaurants.plates.plate-index', [
                                                                                    'lang' => $this->lang, 
                                                                                    'rest' => $this->rest, 
                                                                                    'menu' => $this->menu, 
                                                                                    'choice' => $choice['id'], 
                                                                                    'country' => $country['id'], 
                                                                                    'choices' => 'true', 
                                                                                    'countries' => 'true'
                                                                                ], key($choice['coll'] . $country['coll'] ))
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</div>