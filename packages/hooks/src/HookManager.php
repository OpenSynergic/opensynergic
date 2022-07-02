<?php

namespace OpenSynergic\Hooks;

use Closure;

class HookManager
{
    protected array $hooks = [];

    public function register(string $name, Closure $callback): void
    {
        $this->hooks[$name][] = $callback;
    }

    public function call(string $name, ...$arguments): void
    {
        foreach ($this->hooks[$name] ?? [] as $callback) {
            app()->call($callback, [
                'arguments' => $arguments,
                'hookName' => $name,
            ]);
        }
    }

    public function getHooks(): array
    {
        return $this->hooks;
    }

    public function getHookByName(string $name): array
    {
        return $this->hooks[$name] ?? [];
    }
}
