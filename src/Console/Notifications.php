<?php

namespace Yab\Laracogs\Console;

use Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Schema;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Notifications extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laracogs:notifications';

    protected $files;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laracogs will add notifications to your app';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        if (! file_exists(base_path('resources/views/team/create.blade.php'))) {
            $this->line("\n\nPlease perform the starter command:\n");
            $this->info("\n\nphp artisan laracogs:starter\n");
            $this->line("\n\nThen one you're able to run the unit tests successfully re-run this command, to bootstrap your app :)\n");
        } else {
            $fileSystem = new Filesystem;

            $files = $fileSystem->allFiles(__DIR__.'/../Notifications');
            $this->line("\n");
            foreach ($files as $file) {
                $this->line(str_replace(__DIR__.'/../Notifications/', '', $file));
            }

            $this->info("\n\nThese files will be published\n");

            $result = $this->confirm("Are you sure you want to overwrite any files of the same name?");

            if ($result) {
                foreach ($files as $file) {
                    $newFileName = str_replace(__DIR__.'/../Notifications/', '', $file);
                    $this->line("Copying ".$newFileName."...");
                    if (is_dir($file)) {
                        $fileSystem->copyDirectory($file, base_path($newFileName));
                    } else {
                        @mkdir(base_path(str_replace(basename($newFileName), '', $newFileName)), 0755, true);
                        $fileSystem->copy($file, base_path($newFileName));
                    }
                }

                $this->info("\n\n You will need to run: composer require laravel/cashier");
                $this->info("\n\n Then follow the directions regarding notifications on: https://laravel.com/docs/");
                $this->info("\n\n Please review the setup details for notifications.");
                $this->info("\n\n You will want to add things like:");
                $this->line("\n These links: ");
                $this->comment("\n <li><a href='{!! url('user/notifications') !!}'><span class='fa fa-envelope-o'></span> Notifications</a></li>");
                $this->comment("\n <li><a href='{!! url('admin/notifications') !!}'><span class='fa fa-envelope-o'></span> Notifications</a></li>");
                $this->line("\n Add this line to (app/Providers/RouteServiceProvider.php):");
                $this->comment("\n require app_path('Http/notification-routes.php');");
                $this->line("\n Add this to (app/Providers/AppServiceProvider.php) in the register() method:");
                $this->comment("\n \$loader = \Illuminate\Foundation\AliasLoader::getInstance();");
                $this->comment("\n \$loader->alias('Notifications', \App\Facades\Notifications::class);");
                $this->comment("\n \$this->app->singleton('NotificationService', function (\$app) {");
                $this->comment("\n\t return \App::make(\App\Services\NotificationService::class);");
                $this->comment("\n });");
                $this->info("\n Finished setting up notifications");
            } else {
                $this->info("\n You cancelled notifications setup");
            }
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
