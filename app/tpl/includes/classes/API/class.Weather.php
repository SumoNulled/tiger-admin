<?php
namespace API;

use Admin;
use App;

App\General::class_include('class.Alerts.php');
App\General::class_include('class.API.php', "API");

Class Weather
{
    private $longitude;
    private $latitude;
    private $api;
    private $data;

    private $dates;

    function __construct($longitude = NULL, $latitude = NULL)
    {
      $this->latitude = $latitude;
      $this->longitude = $longitude;

      $this->dates = array();
    }

    function set_longitude($longitude)
    {
      $this->longitude = $longitude;
    }

    function get_longitude()
    {
      return $this->longitude;
    }

    function set_latitude($latitude)
    {
      $this->latitude = $latitude;
    }

    function get_latitude()
    {
      return $this->latitude;
    }

    function set_date(...$dates)
    {
      foreach ($dates as $key)
      {
        if (is_array($key))
        {
          foreach($key as $x)
          {
            $x = date("c", strtotime($x));
            $this->dates[] = $x;
          }
        } else {
          $key = date("c", strtotime($key));
          $this->dates[] = $key;
        }
      }
    }

    function get_dates()
    {
      return $this->dates;
    }

    public function properties()
    {
      $latitude = $this->get_latitude();
      $longitude = $this->get_longitude();
      $properties = "https://api.weather.gov/points/{$latitude},{$longitude}";

      $this->set_api($properties);
      $this->call_api();

      $error = isset($this->get_data()->parameterErrors) ? $this->get_data()->parameterErrors : FALSE;

      if ($error)
      {
        echo Admin\Alerts::danger("An error has occurred receiving weather information for coordinates ({$longitude}, {$latitude}). It is most likely this coordinate pair is invalid.");
        $result = null;
      } else {
        $result = $this->get_data();
      }

      return $result;
    }

    public function forecast()
    {
      $api = $this->properties()->properties->forecast;
      $this->set_api($api);
      if ($this->call_api())
      {
        $data = $this->get_data()->properties->periods;
      } else {
        $data = false;
      }

      return $data;
    }

    public function forecast_hourly()
    {
      $api = $this->properties()->properties->forecastHourly;
      $this->set_api($api);
      if ($this->call_api())
      {
        $data = $this->get_data()->properties->periods;
      } else {
        $data = false;
      }

      return $data;
    }

    public function set_api($api)
    {
      $this->api = $api;
    }

    public function ApiURL()
    {
      return $this->api;
    }

    public function call_api()
    {
      $api = new API();
      $api->set_ApiURL($this->ApiURL());
      if ($this->data = $api->response())
      {
        $result = true;
      } else {
        $result = false;
      }

      return $result;
    }

    public function get_data()
    {
      return $this->data;
    }
}

// Example usage:
//$geo = new App\Locations(2);
//$weather = new App\Weather($geo->longitude(), $geo->latitude());
//$weather->set_api($weather->forecast_hourly());
//$weather->call_api();
// OR
// $data = $weather->forecast();
?>
