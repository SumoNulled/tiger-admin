<?php
  namespace App;
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  class Config
  {

    // Private Member Variables - To access them, you must use $this->member
    private $host;
    private $username;
    private $password;
    private $dbname;

    function __construct()
    {
      $this->host = "theoldmountain.com";
      $this->username = "admin";
      $this->password = "3459847Cd!";
      $this->dbname = "theoldmountain";
    }

    function getHost()
    {
      return $this->host;
    }

    function getUsername()
    {
      return $this->username;
    }

    function getPassword()
    {
      return $this->password;
    }

    function getDatabaseName()
    {
      return $this->dbname;
    }
  }
?>
