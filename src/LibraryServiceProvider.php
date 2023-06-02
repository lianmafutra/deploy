<?php

namespace LianMafutra\Deploy;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class LibraryServiceProvider extends ServiceProvider
{


   /** @var string */
   private const CONSOLE_PATH = __DIR__ . '/../app/Console/Commands/Deploy.php';
   private const CONSOLE_PATH2 = __DIR__ . '/../app/Console/Commands/DeploySetup.php';
   private const CONFIG_FILE = __DIR__ . '/../config/deploy.php';

   /**
    * Bootstrap the application services.
    *
    * @return void
    */
   public function boot(): void
   {




      if (function_exists('config_path')) { // function not available and 'publish' not relevant in Lumen
         $this->publishes([
            self::CONFIG_FILE => config_path('deploy.php'),
         ], 'deploy');
      }

      $this->publishes([
         self::CONSOLE_PATH => app_path('Deploy.php'),
      ], 'deploy');

      $this->publishes([
         self::CONSOLE_PATH2 => app_path('DeploySetup.php'),
      ], 'deploy');




      $this
         ->registerComponents()
         ->registerComponentsPublishers();
   }

   /**
    * Register the application services.
    *
    * @return void
    */
   public function register(): void
   {
      $this->mergeConfigFrom(self::CONFIG_FILE, 'deploy');
   }

   /**
    * Register the Blade form components.
    *
    * @return $this
    */
   private function registerComponents(): self
   {


      return $this;
   }

   /**
    * Register the publishers of the component resources.
    *
    * @return $this
    */
   public function registerComponentsPublishers(): self
   {

      $this->publishes([
         self::CONFIG_FILE => config_path('deploy.php'),
      ], 'deploy');

      $this->publishes([
         self::CONSOLE_PATH => app_path('Console/Commands/Deploy.php'),
      ], 'deploy');

      $this->publishes([
         self::CONSOLE_PATH2 => app_path('Console/Commands/DeploySetup.php'),
      ], 'deploy');



      return $this;
   }
}
