<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Kernal extends Command
{
    protected $commands = [
        \App\Console\Commands\SwaggerClearCommand::class,
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:kernal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
    protected $middlewareGroups = [
        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];
}
