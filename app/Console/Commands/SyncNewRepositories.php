<?php

namespace App\Console\Commands;

use App\Services\RepositoriesService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncNewRepositories extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repositories:sync';
    protected $app;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Syncing Data From Github';

    public function __construct()
    {
        parent::__construct();
        $this->app = app();
    }


    public function handle()
    {
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $counter = 1;

        while (true) {
            $data = [
                'pushed'    => $yesterday,
                'per_page'  => 100,
                'page'      => $counter++,
                'sort'      => 'stars',
                'order'     => 'desc',
            ];

            $response = app(RepositoriesService::class)->sync($data);

            if (!$response) {
                break;
            }
        }
    }
}
