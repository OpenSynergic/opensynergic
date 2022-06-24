<?php

namespace OpenSynergic\EventManagement\Commands;

use Illuminate\Console\Command;

class EventManagementCommand extends Command
{
    public $signature = 'ems';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
