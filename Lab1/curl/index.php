<?php
require_once("./functions.php");
require_once("./config.php");

$all_cities = file_get_contents("./files/city.list.json");
$json_cities = json_decode($all_cities, true); //true to decode into array 
$egyptianCities = array_filter($json_cities, "get_egyptianCities");
$appiKey = "a22526416c6c50c498226813c02c4170";
if (!empty($_POST)) {
    if (isset($_POST["submit"])) {
        $city_id = $_POST["city"];
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?id=" . $city_id . "&appid=" . $appiKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return the transfer as a string of the return value of curl_exec() instead of outputting it directly. 
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // follow any "Location:"header that the server sends as part of the HTTP header. 
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);
        $date = date("d-m-y h:i:sa");
        $icon = "https://openweathermap.org/img/wn/". $data["weather"][0]["icon"] . "@2x.png";        
        if (!empty($data)) {
            die('<body style="background: linear-gradient(#ECF2FF,
            #E3DFFD,
            #E5D1FA,
            #FFF4D2) ;background-attachment: fixed;">
            <div style=";
            width:50%;
            margin:8vh auto;
            padding:3%;
            background-color: white;
            border-radius: 20px;">'
                . '<center><h2 style="color:#A3C7D6;">' . $data["name"] . ' Weather Status</h2></br>'
                . "<p> Today is: " . $date . "</p>"
                . "<p> Description:  " . $data["weather"][0]["description"] . "</p>"
                . '<img src="' . $icon . '" alt="">'
                ."<p> Min_Temp:  ".$data["main"]["temp_min"]."&degF</p>"
                ."<p> Max_Temp:  ".$data["main"]["temp_min"]."&degF</p>"
                ."<p> Humidity:  ".$data["main"]["humidity"]."%</p>"
                ."<p> Wind:  ".($data["wind"]["speed"])." Km/h</p>"
                ."<a href='http://localhost/webServices/Lab1/curl'>BACK</a>"
                . '</center>' .
                '</div></body>');
        }
    }
}
require_once("./views/weather.php");
