<?php

namespace OpenSynergic\Installer\Contracts;

use Closure;

interface Pipe
{
    public function handle($content, Closure $next);
}
