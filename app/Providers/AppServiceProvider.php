<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        //
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->addBefore('create_team', [
                'can'  => 'teams.show',
                'text' => 'Ajustes',
                'key'  => 'ajustes',
                'icon' => 'fas fa-fw fa-users-cog',
                'url'  => route('teams.show', Auth::user()->currentTeam->id)
            ]);

            foreach (Auth::user()->allTeams() as $team) {
                $event->menu->addIn('change_team', [
                    'can'  => 'teams.show',
                    'text' => $team->name,
                    'url'  => route('teams.show', $team->id)
                ]);
            }
        

        });
        Schema::defaultStringLength(191);
    }
}
