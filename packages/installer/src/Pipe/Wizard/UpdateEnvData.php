<?php

namespace OpenSynergic\Installer\Pipe\Wizard;

use Closure;
use Illuminate\Support\Str;
use OpenSynergic\Installer\Contracts\Pipe;

class UpdateEnvData implements Pipe
{
    /**
     * Update the environment data. This is only updating the environment data, not creating a new environment data.
     */

    public function handle($content, Closure $next)
    {
        $data = collect($content)
      ->filter(fn ($value, $key) => $key === Str::upper($key))
      ->map(function ($value, $key) {
          if (is_bool($value)) {
              $value = $value ? 'true' : 'false';
          }
          return $value;
      })
      ->toArray();

        $this->updateEnv($data);
        return $next($content);
    }

    public function updateEnv($data)
    {
        $envFile = app()->environmentFilePath();

        $pattern = '/([^\=]*)\=[^\n]*/';

        $lines = file($envFile);
        $newLines = [];
        foreach ($lines as $line) {
            preg_match($pattern, $line, $matches);

            if (!count($matches)) {
                $newLines[] = $line;
                continue;
            }

            if (!key_exists(trim($matches[1]), $data)) {
                $newLines[] = $line;
                continue;
            }

            $line = trim($matches[1]) . "={$data[trim($matches[1])]}\n";
            $newLines[] = $line;
        }

        $newContent = implode('', $newLines);
        file_put_contents($envFile, $newContent);
    }
}
