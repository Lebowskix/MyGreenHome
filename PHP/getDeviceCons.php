<?php
#Query DB for consumption/time

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

#Welche Geräte waren an ?
$queryClasses = $con->query('SELECT DISTINCT devices.klasse FROM consumption, devices where devices.iddevices=consumption.iddevices and devices.nickname="'.$nickname.'" and consumption.time > Now() - INTERVAL "'.$time.'" DAY');
$resultClasses = $queryClasses->fetchAll(PDO::FETCH_COLUMN, 0);
$amountClasses = count($resultClasses);
for ($x = 0; $x < $amountClasses; $x++) {
    $geraet[$x] = $resultClasses[$x];
}
#Durchschnittsverbrauch des Geraets berechnen 1. Wieviele Eintraege -> 2. Eintraege addieren -> 3. Eintraege durch Anzahl teilen
$addAll = 0;
for ($x = 0; $x < $amountClasses; $x++) {
	$addSingle[$x] = 0;
	$queryTimeCons = $con->query('SELECT consumption.watt FROM consumption, devices where devices.iddevices=consumption.iddevices and devices.nickname="'.$nickname.'" and devices.klasse="'.$geraet[$x].'" and consumption.time > Now() - INTERVAL "'.$time.'" DAY');
	$resultTimeCons = $queryTimeCons->fetchAll(PDO::FETCH_COLUMN, 0);
	for ($i = 0; $i < count($resultTimeCons); $i++) {
		$addSingle[$x] += $resultTimeCons[$i];
	}
	$addSingle[$x] = ($addSingle[$x]/count($resultTimeCons));	#Durchschnittsverbrauch
	$averageCons[$x] = $addSingle[$x];				#Durchschnittsverbrauch speichern
	$zeit = ((count($resultTimeCons)*10)/60)/60; 	#Wenn 20 x 10sec einträge, dann war das device 20x 10sec an. -> Returns ON Zeit in std
	$addSingle[$x] = ($addSingle[$x] * $zeit)/1000;
}

$aResult = array();
$counter = 0;
for ($i = 0; $i < $amountClasses; $i++) {
	$aResult[] = array("geraet" => $geraet[$i], "verbrauch" => round($addSingle[$i],2), "average" => round($averageCons[$i], 2));
}

/* Form der Ausgabe:
var data = [
{"value": 100, "name": "alpha"},
{"value": 70, "name": "beta"},
{"value": 40, "name": "gamma"},
{"value": 15, "name": "delta"},
{"value": 5, "name": "epsilon"},
{"value": 1, "name": "zeta"}
];*/
	
echo json_encode($aResult);

$queryTimeCons = null;
$con = null;
?>