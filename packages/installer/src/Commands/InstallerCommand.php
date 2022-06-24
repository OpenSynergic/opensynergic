<?php

namespace OpenSynergic\Installer\Commands;

use Illuminate\Console\Command;

class InstallerCommand extends Command
{
    public $signature = 'installer';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
