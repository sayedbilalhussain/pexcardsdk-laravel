<?php
namespace SayedBilalHussain\PexCardSdk;

use illuminate\Support\ServiceProvider;

class PexCardServiceProvider extends ServiceProvider
{
   public function boot()
   {
       $this->publishes([
           __DIR__.'/config/pex.php' => config_path('pex.php')
       ]);
   }
   public function register()
   {
     $this->app->singleton(PexService::class,function(){
         return new PexService();
     });
   }
}


?>
