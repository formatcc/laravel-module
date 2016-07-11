<?php

namespace Formatcc\LaravelModule\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        Route::group(['namespace' => 'App\Modules', 'prefix'=>'extension', 'middleware' => 'web',], function ($router) {
            $routes = glob(app_path("Modules")."/*/routes.php");
            $path = str_replace('/', '\/', app_path('Modules'));
            $reg = "/$path\/(.*)\/routes.php/";
            foreach($routes as $route){
                if(preg_match($reg, $route, $matchs)){
                    $dir = $matchs[1];
                    Route::group(['namespace' => $dir, 'prefix'=>$dir], function ($router) use($route){
                        require $route;
                    });
                    $this->loadViewsFrom(app_path('Modules')."/".$dir."/views", $dir);
                }
            }
        });

        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
