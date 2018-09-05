<?php
$year = date("Y");
$month = date("m");
$day = date("d");
$response = file_get_contents('https://api.poc.hujjat.org/salaat/city/london/year/' . $year . '/month/' . $month . '/day/' .$day);
$response = json_decode($response);
?>
<p>Imsaak: <?php echo $response->imsaak; ?></p>
<p>Fajr: <?php echo $response->fajr; ?></p>
<p>Sunrise: <?php echo $response->sunrise; ?></p>
<p>Zohr: <?php echo $response->zohr; ?></p>
<p>Sunset: <?php echo $response->sunset; ?></p>
<p>Maghrib: <?php echo $response->maghrib; ?></p>
