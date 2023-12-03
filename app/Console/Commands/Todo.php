<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\GrowCtrl;

class Todo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todo';
    protected $grow;
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
    public function __construct(GrowCtrl $grow)
    {
        parent::__construct();
        $this->grow = $grow;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->grow->data();
        //HomeController::todoStaticScheduler();
        //Log::alert('Todo Command todo, frm scheduler or cmd.');
        return 0;
    }
}
