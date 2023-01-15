<?php
if (isset($_POST['pt_weather']))
{
    App\General::class_include('class.Locations.php');
    App\General::class_include('class.Weather.php', "API");

    $location = new App\Locations;

    $geo = new App\Locations($location->id("University of Memphis"));
    $weather = new API\Weather($geo->longitude() , $geo->latitude());

    $date = new DateTime("next monday 6:00am");
    $Monday = $date->format("c");

    $date = new DateTime("next wednesday 6:00am");
    $Wednesday = $date->format("c");

    $date = new DateTime("next friday 6:00am");
    $Friday = $date->format("c");

    $weather->set_date($Monday, $Wednesday, $Friday);
    $data = $weather->forecast_hourly();

    if (isset($error))
    {
        $error = Admin\Alerts::danger($error, "Error!");
        renderForm($error);
    }
    else
    {
        for ($i = 0;$i < sizeof($weather->get_dates());$i++)
        {
            $key = array_column($data, null, 'startTime') [$weather->get_dates() [$i]] ?? false;
            if ($key)
            {
                $_FORECAST['temperature'] = "{$key->temperature} °{$key->temperatureUnit}";
                $_FORECAST['short_forecast'] = $key->shortForecast;
                $_FORECAST['detailed_forecast'] = $key->detailedForecast;
                $_FORECAST['wind_speed'] = $key->windSpeed;
                $_FORECAST['wind_direction'] = $key->windDirection;
                $_FORECAST['timestamp'] = date("Y-m-d H:i:s", strtotime($key->startTime));

                // Begin processing creation of forecast.
                foreach ($_FORECAST as $x => $y)
                {
                    switch ($x)
                    {
                        case "submit" :
                        //Do Nothing

                    break;

                    default : if (!in_array($x, $_SESSION['disabled_indexes']))
                    {
                        $Fields[] = "`" . $x . "`";
                        $Values[] = ($y != NULL) ? $y : NULL;
                        $params[] = "?";
                    }
                break;
            }
        }
        $Params[] = "(" . implode(",", $params) . ")";
        unset($params);
    }
    else
    {
        $error = "Please enter a valid date/time combination. TIP: This service cannot access past forecasts and can only access 7 days into the future.";
    }
}

$Fields = "(" . implode(",", array_unique($Fields)) . ")";
$Params = implode(",", $Params);

var_dump($Values);
$sql = "INSERT INTO intelligence_weather_forecasts {$Fields} VALUES {$Params}";
if ($sql = App\SQL::query($sql, $Values))
{
    $success = "You have successfully added <b>the next 3 PT Days</b> to the Tiger Battalion databse. Refreshing in <span id=\"countdown\"></span>.";
    $success = Admin\Alerts::success($success, "Success!");
    renderPTWeather(NULL, $success);
}
else
{
    echo "Error! Please contact your system administrator.";
}
}
}
else
{
    renderPTWeather();
}

// Begin parsing manual submit.
if (isset($_POST['submit']))
{
    App\General::class_include('class.Locations.php');
    App\General::class_include('class.Weather.php', "API");

    $geo = new App\Locations($_POST['location_id']);
    $weather = new API\Weather($geo->longitude() , $geo->latitude());

    if ($_POST['location_id'] == "")
    {
        $error = "Please select a valid location.";
    }
    else if ($_POST['date'] == "")
    {
        $error = "Please enter a valid date.";
    }
    else if ($_POST['time'] == "")
    {
        $error = "Please enter a valid time.";
    }

    $location = isset($_POST['location_id']) ? $_POST['location_id'] : "";

    $date = isset($_POST['date']) ? $_POST['date'] : "";

    $time = isset($_POST['time']) ? $_POST['time'] : "";

    $minutes = date("i", strtotime($time));

    if ($minutes > 30)
    {
        $hour = 1;
    }
    else
    {
        $hour = 0;
    }

    $time = date("H", strtotime($time)) + $hour . ":00";

    $timestamp = date("c", strtotime($date . " " . $time));

    $data = $weather->forecast_hourly();

    $weather->set_date($timestamp);
    unset($_POST['date']);
    unset($_POST['time']);
    unset($minutes);
    unset($hour);
    unset($time);
    unset($timstamp);

    for ($i = 0;$i < sizeof($weather->get_dates());$i++)
    {
        $key = array_column($data, null, 'startTime') [$weather->get_dates() [$i]] ?? false;
        if ($key)
        {
            $_POST['temperature'] = "{$key->temperature} °{$key->temperatureUnit}";
            $_POST['short_forecast'] = $key->shortForecast;
            $_POST['detailed_forecast'] = $key->detailedForecast;
            $_POST['wind_speed'] = $key->windSpeed;
            $_POST['wind_direction'] = $key->windDirection;
            $_POST['timestamp'] = date("Y-m-d G:i:s", strtotime($key->startTime));
        }
        else
        {
            $error = "Please enter a valid date/time combination. TIP: This service cannot access past forecasts and can only access 7 days into the future.";
        }
    }
    if (isset($error))
    {
        $error = Admin\Alerts::danger($error, "Error!");
        renderForm($error);
    }
    else
    {
        // Begin processing creation of forecast.
        foreach ($_POST as $x => $y)
        {
            switch ($x)
            {
                case "submit" :
                //Do Nothing

            break;

            default : if (!in_array($x, $_SESSION['disabled_indexes']))
            {
                $Fields[] = "`" . $x . "`";
                $Values[] = ($y != NULL) ? $y : NULL;
                $Params[] = "?";
            }
        break;
    }
}

$Fields = implode(",", $Fields);
$Params = implode(",", $Params);
if (App\SQL::query("INSERT INTO intelligence_weather_forecasts (" . $Fields . ") VALUES (" . $Params . ")", $Values))
{
    $success = "You have successfully added a forecast for {$_POST['timestamp']} to the Tiger Battalion databse. Refreshing in <span id=\"countdown\"></span>.";
    $success = Admin\Alerts::success($success, "Success!");
    renderForm(NULL, $success);
}
else
{
    echo "Error! Please contact your system administrator.";
}

}
}
else
{
    renderForm();
}
?>
