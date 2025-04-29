<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SwaggerClearCommand extends Command
{
    protected $signature = 'swagger:clear';
    protected $description = 'Clear Swagger documentation cache';

    public function handle()
    {
        File::deleteDirectory(storage_path('api-docs'));
        $this->info('Swagger documentation cache cleared!');
    }
}