<?php

namespace OpenSynergic\ThemesManager\Concerns\Commands;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

trait CanManipulateFiles
{
    protected function checkForCollision(array $paths): bool
    {
        foreach ($paths as $path) {
            if ($this->fileExists($path)) {
                $this->error("$path already exists, aborting.");

                return true;
            }
        }

        return false;
    }

    protected function copyStubToApp(string $stub, string $targetPath, array $replacements = []): void
    {
        $filesystem = app(Filesystem::class);

        if (!$this->fileExists($stubPath = base_path("stubs/themes-manager/{$stub}.stub"))) {
            $stubPath = __DIR__ . "/../../../stubs/{$stub}.stub";
        }

        $stub = Str::of($filesystem->get($stubPath));

        foreach ($replacements as $key => $replacement) {
            $stub = $stub->replace("{{ {$key} }}", $replacement);
        }

        $stub = (string) $stub;

        $this->writeFile($targetPath, $stub);
    }

    protected function fileExists(string $path): bool
    {
        $filesystem = app(Filesystem::class);

        return $filesystem->exists($path);
    }

    protected function writeFile(string $path, string $contents): void
    {
        $filesystem = app(Filesystem::class);

        $filesystem->ensureDirectoryExists(
            (string) Str::of($path)
                ->beforeLast('/'),
        );

        $filesystem->put($path, $contents);
    }
}
