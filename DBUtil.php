<?php
/**
* @author Benjamin Cable <cable.benjamin@gmail.com>
*
* @todo pass your env. variables in the init method
*/
class DBUtil
{
    /**
   * Singleton instance.
   *
   * @var DBUtil
   */
  private static $INSTANCE = null;

  /**
   * PDO Connector.
   *
   * @var PDO
   */
  public $pdoConnector = null;

  /**
   * [init: initializes the database connection].
   *
   * @return [object] [PDO instance]
   */
  private function init()
  {
      $PARAM_port = $YOUR_ENV_VARIABLE_HERE;
      $PARAM_host = $YOUR_ENV_VARIABLE_HERE;
      $PARAM_database_name = $YOUR_ENV_VARIABLE_HERE;
      $PARAM_database_user = $YOUR_ENV_VARIABLE_HERE;
      $PARAM_database_password = $YOUR_ENV_VARIABLE_HERE;

      $this->pdoConnector = new PDO('mysql:host='.$PARAM_host.';port='.$PARAM_port.';dbname='.$PARAM_database_name, $PARAM_database_user, $PARAM_database_password);
  }

  /**
   * [exists: returns true if a query returns non-empty result].
   *
   * @param  [string] $query [your MySQL query]
   *
   * @return [bool]
   */
  public static function exists($query)
  {
      $result = self::getInstance()->pdoConnector->query($query);
      if ($result) {
          foreach ($result as $row) {
              if (isset($row)) {
                  return true;
              }
          }
      }

      return false;
  }

  /**
   * [as_row: returns a single row from a query].
   *
   * @param  [string] $query [your MySQL query]
   *
   * @return [type]          [single row result]
   */
  public static function as_single_row($query)
  {
      $result = self::getInstance()->pdoConnector->query($query);
      if ($result) {
          foreach ($result  as $row) {
              return ($row);
          }

          return false;
      }
  }

  /**
   * [as_array: returns an array of result from a queery].
   *
   * @param  [string] $query [your MySQL query]
   *
   * @return [array]         [query results]
   */
  public static function as_array($query)
  {
      $r = array();
      foreach (self::getInstance()->pdoConnector->query($query) as $row) {
          array_push($r, $row);
      }

      return $r;
  }

  /**
   * [exec: executes a single query then returns the last inserted id].
   *
   * @param  [string] $query [your MySQL query]
   *
   * @return [int]           [the id of the last insert]
   */
  public static function exec($query)
  {
      self::getInstance()->pdoConnector->query($query);

      return self::getInstance()->pdoConnector->lastInsertId();
  }

  /**
   * [getInstance returns the DBUtil singleton instance].
   *
   * @return [object] [the DBUtil instance]
   */
  public static function getInstance()
  {
      if (self::$INSTANCE == null) {
          self::$INSTANCE = new self();
          self::$INSTANCE->init();
      }

      return self::$INSTANCE;
  }
}
