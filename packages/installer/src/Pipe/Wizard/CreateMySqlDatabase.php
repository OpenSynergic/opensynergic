<?php

namespace OpenSynergic\Installer\Pipe\Wizard;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use OpenSynergic\Installer\Contracts\Pipe;

class CreateMySqlDatabase implements Pipe
{
    public function handle($content, Closure $next)
    {
        $createdb = isset($content['create_db']) ? $content['create_db'] : false;

        if (!$createdb) {
            return $next($content);
        }

        try {
            $connection = [
                'driver' => 'mysql',
                'host' => $content['DB_HOST'],
                'database' => null,
                'username' => $content['DB_USERNAME'],
                'password' => $content['DB_PASSWORD'],
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
            ];

            Config::set("database.connections.mysql_only_connect", $connection);

            $schema = $content['DB_DATABASE'];
            $charset = config("database.connections.mysql.charset", 'utf8mb4');
            $collation = config("database.connections.mysql.collation", 'utf8mb4_unicode_ci');

            DB::connection('mysql_only_connect')->statement("CREATE DATABASE IF NOT EXISTS $schema CHARACTER SET $charset COLLATE $collation");
        } catch (\Throwable $th) {
            throw $th;
        }

        return $next($content);
    }
}
