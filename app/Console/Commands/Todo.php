<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\HomeController;

class Todo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todo';
    protected $home;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(HomeController $home)
    {
        parent::__construct();
        $this->home = $home;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->home->todoScheduler();
        HomeController::todoStaticScheduler();
        Log::alert('Todo Command todo, frm scheduler or cmd.');
        return 0;
    }
}
