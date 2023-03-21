<?php
namespace API;

class API
{
    private $googleApiUrl;
    private $data;

    function __construct($googleApiUrl = null)
    {
      $this->googleApiUrl = $googleApiUrl;
      $currentTime = time();
    }

    public function set_ApiURL($googleApiUrl)
    {
      $this->googleApiUrl = $googleApiUrl;
    }

    public function get_ApiURL()
    {
      return $this->googleApiUrl;
    }

    public function response()
    {
      $ch = curl_init();
      $config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
      curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']);
      curl_setopt($ch, CURLOPT_REFERER, 'https://www.theoldmountain.com.com/');
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $this->get_ApiURL());
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_VERBOSE, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $response = curl_exec($ch);
      curl_close($ch);
      $data = json_decode($response);

      return $data;
    }
}
?>
