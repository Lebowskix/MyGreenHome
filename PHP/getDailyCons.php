<?php
#Query DB for daily overall consumption

$time = intval($_GET['time']);
$nickname = $_GET['nick'];

$host = "213.136.71.88";
$dbname = "mygreenhome";
$user = "mghome";
$pass = "benfejonmgh1";

try {
  # MySQL with PDO_MYSQL
  $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
}

catch(PDOException $e) {
    echo $e->getMessage();
}

date_default_timezone_set("Europe/Berlin");
$aResult = array();
$addAll = array();
$compareTime = 0;
#Durchschnittsverbrauch des Geraets berechnen 1. Wieviele Eintraege -> 2. Eintraege addieren -> 3. Eintraege durch Anzahl teilen
for ($x = 0; $x < $time; $x++){	#$x = Time
	$addAll[$x] = 0;
	$compareTime += 1;
	$queryTimeCons = $con->query('SELECT consumption.watt FROM consumption, devices where devices.iddevices=consumption.iddevices and devices.nickname="'.$nickname.'" and consumption.time between Now() - INTERVAL "'.$compareTime.'" day and Now() - INTERVAL "'.$x.'" DAY');
	$resultTimeCons = $queryTimeCons->fetchAll(PDO::FETCH_COLUMN, 0);
	for ($i = 0; $i < count($resultTimeCons); $i++) {
		$addAll[$x] += $resultTimeCons[$i];
	}
	$addAll[$x] = ($addAll[$x]/count($resultTimeCons));	#Durchschnittsverbrauch
	$zeit = ((count($resultTimeCons)*10)/60)/60; 				#Wenn 20 x 10sec einträge, dann war das device 20x 10sec an. -> Returns ON Zeit in std
	$addAll[$x] = ($addAll[$x] * $zeit)/1000;				#Endverbrauch in KWh in der gegebenen Zeit
	
	$timestamp = strtotime('-'.$x.' day');
	$date = date("d.m", $timestamp);
	$aResult[] = array("datum" => intval($date), "name" => "Tages-Verbrauch", "verbrauch" => round($addAll[$x],2));
}

/* Form der Ausgabe
var sample_data = [
    {"datum": 22, "name":"conse", "value": 17.12},
    {"datum": 21, "name":"conse", "value": 20.31},
*/

	
echo json_encode($aResult);

$queryTimeCons = null;
$con = null;
?>