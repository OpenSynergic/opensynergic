<?php

namespace OpenSynergic\Installer\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;
use OpenSynergic\Installer\Actions\Database\TestMySqlDatabaseConnection;

class ConnectDatabase implements Rule, DataAwareRule
{
  /**
   * All of the data under validation.
   *
   * @var array
   */
  protected $data = [];


  protected $message = "Can't connect to database";

  /**
   * Determine if the validation rule passes.
   *
   * @param  string  $attribute
   * @param  mixed  $value
   * @return bool
   */
  public function passes($attribute, $value)
  {

    $data = $this->data['data'];
    $createdb = isset($data['create_db']) ? $data['create_db'] : false;
    // Try to connect to the database
    try {
      TestMySqlDatabaseConnection::run($data, $createdb);
    } catch (\PDOException $e) {
      if ($e->getCode() == 1049 && $createdb) {
        return true;
      }

      $this->message = $e->getMessage();

      return false;
    }

    return true;
  }

  /**
   * Get the validation error message.
   *
   * @return string
   */
  public function message()
  {
    return $this->message;
  }

  /**
   * Set the data under validation.
   *
   * @param  array  $data
   * @return $this
   */
  public function setData($data)
  {
    $this->data = $data;

    return $this;
  }
}
