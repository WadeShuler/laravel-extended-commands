<?php

namespace WadeShuler\ExtendedCommands\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearLogs extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'clear:logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all log files in the storage/logs directory';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (! File::delete(File::glob(storage_path(('logs/*.log'))))) {
            $this->error("Error deleting one or more log files!");
        }

        $this->info("Log files have been deleted!");
    }
}
