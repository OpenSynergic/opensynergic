<?php

namespace OpenSynergic\Installer\Actions\Database;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Database\Capsule\Manager as Capsule;


class TestMySqlDatabaseConnection
{
  use AsAction;

  public function handle(array $content)
  {
    $capsule = new Capsule;

    $connection = [
      'driver' => 'mysql',
      'host' => $content['DB_HOST'],
      'database' => $content['DB_DATABASE'],
      'username' => $content['DB_USERNAME'],
      'password' => $content['DB_PASSWORD'],
      'charset' => 'utf8mb4',
      'collation' => 'utf8mb4_unicode_ci',
      'prefix' => '',
    ];

    $capsule->addConnection($connection, 'test');

    try {
      $capsule->getConnection('test')->getPdo();
    } catch (\PDOException $e) {
      return throw $e;
    }

    return true;
  }
}
