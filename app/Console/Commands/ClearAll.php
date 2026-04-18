<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearAll extends Command
{
    protected $signature   = 'clear:all';
    protected $description = 'Clear all caches — views, config, route, cache';

    public function handle()
    {
        $this->call('view:clear');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('clear-compiled');
        $this->info('✅ All caches cleared successfully!');
    }
}