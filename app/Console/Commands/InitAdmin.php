<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\InitController;

class InitAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initialize:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will initialize the admin panel roles and permissions in the project';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $initializeAdmin = new InitController();
        $initializeAdmin->initialize();
        $this->info("Admin Panel initialized successfully !");
    }
}
