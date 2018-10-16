<?php

namespace ShawnRong\Avocado\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'avocado:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the commands to install avocado necessary packages';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // vendor publish JWT
        $this->call('vendor:publish', ['--provider' => 'Tymon\JWTAuth\Providers\LaravelServiceProvider']);
        $this->call('jwt:secret');
        // vendor publish Dingo
        $this->call('vendor:publish', ['--provider' => 'Dingo\Api\Provider\LaravelServiceProvider']);
    }
}
