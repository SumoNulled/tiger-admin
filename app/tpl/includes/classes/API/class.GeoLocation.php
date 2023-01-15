<?php
namespace API;

use App;

App\General::class_include('class.API.php', "API");

class GeoLocation
{
    private $address;
    private $city;
    private $state;
    private $benchmark;
    private $format;
    private $api;
    private $link;
    private $data;

    function __construct($address = NULL, $city = NULL, $state = NULL, $zip = NULL, $benchmark = "Public_AR_Census2020", $format = "json")
    {
      $this->address = $address;
      $this->city = $city;
      $this->state = $state;
      $this->zip = $zip;
      $this->benchmark = $benchmark;
      $this->format = $format;

      $this->link = array();
      $this->link['street'] = $this->address;
      $this->link['city'] = $this->city;
      $this->link['state'] = $this->state;
      $this->link['zip'] = $this->zip;
      $this->link['benchmark'] = $this->benchmark;
      $this->link['format'] = $this->format;
    }

    function get_link()
    {
      return $this->link;
    }

    public function ApiURL()
    {
      $array = array();
      foreach($this->get_link() as $x=>$y)
      {
        $array[] = "{$x}" . "=" . rawurlencode($y);
      }

      $array = implode("&", $array);

      return "https://geocoding.geo.census.gov/geocoder/locations/address?{$array}";
    }

    public function set_api($api)
    {
      $this->api = $api;
    }

    public function call_api()
    {
      $this->api = new API();
      $this->api->set_ApiURL($this->ApiURL());
      $this->data = $this->api->response();
    }

    public function get_data()
    {
      return $this->data;
    }

    function set_address($address)
    {
      $address = $address;
      $this->address = $address;
      $this->link['street'] = $this->address;
    }

    function get_address()
    {
      return $this->address;
    }

    function set_city($city)
    {
      $this->city = $city;
      $this->link['city'] = $this->city;
    }

    function get_city()
    {
      return $this->city;
    }

    function set_state($state)
    {
      $this->state = $state;
      $this->link['state'] = $this->state;
    }

    function get_state()
    {
      return $this->state;
    }

    public function set_zip($zip)
    {
      $this->zip = $zip;
      $this->link['zip'] = $this->zip;
    }

    public function get_zip()
    {
      return $this->zip;
    }

    public function matches()
    {
      $matches = $this->get_data()->result->addressMatches;
      return $matches;
    }

    public function street()
    {
      $street = $this->get_data()->result->addressMatches[0]->matchedAddress;
      return $street;
    }

    public function city()
    {
      $city = $this->get_data()->result->addressMatches[0]->addressComponents->city;
      return $city;
    }

    public function state()
    {
      $state = $this->get_data()->result->addressMatches[0]->addressComponents->state;
      return $state;
    }

    public function zip()
    {
      $zip = $this->get_data()->result->addressMatches[0]->addressComponents->zip;
      return $zip;
    }

    public function longitude()
    {
      $lon = $this->get_data()->result->addressMatches[0]->coordinates->x;
      return $lon;
    }

    public function latitude()
    {
      $lon = $this->get_data()->result->addressMatches[0]->coordinates->y;
      return $lon;
    }
}
?>
