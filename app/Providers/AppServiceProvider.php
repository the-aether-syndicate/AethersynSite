<?php

namespace App\Providers;


use App\Models\Doctrines\Doctrine;
use App\Models\Page\Page;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\SocialiteManager;
use App\Extensions\EveOnlineProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Contracts\Events\Dispatcher;

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
        $this->register_services();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    function add_composers()
    {
        $this->app['view']->composer(
            'includes.sidebar', Sidebar::class);
    }
    public function register_services()
    {
        // Register the Socialite Factory.
        // From: Laravel\Socialite\SocialiteServiceProvider
        $this->app->singleton('Laravel\Socialite\Contracts\Factory', function ($app) {
            return new SocialiteManager($app);
        });
        // Slap in the Eveonline Socialite Provider
        $eveonline = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $eveonline->extend('eveonline',
            function ($app) use ($eveonline) {
                $config = $app['config']['services.eveonline'];
                return $eveonline->buildProvider(EveOnlineProvider::class, $config);
            }
        );
    }
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $pages = Page::all()->map(function (Page $page) {
                return [
                    'text' => $page['title'],
                    'url' => 'pages/' . $page['id']
                ];
            })->toArray();
            $event->menu->add([
             'text' => 'Pages',
             'submenu'=>[

                 'text' => 'New Page',
                 'url' => 'pages/newpage',
                 'submenu'=>[$pages]
                 ,


            ]]);
        });
    }
}
