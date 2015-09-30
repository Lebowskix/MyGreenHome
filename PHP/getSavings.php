<?php
#Query DB for users.savings

$host = "213.136.71.88";
$dbname = "mygreenhome";
$user = "mghome";
$pass = "benfejonmgh1";
$aResult = array();

try {
  # MySQL with PDO_MYSQL
  $con = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
}

catch(PDOException $e) {
    echo $e->getMessage();
}


$querySavings = $con->query('SELECT savings FROM users');
$resultSavings = $querySavings->fetchAll(PDO::FETCH_COLUMN, 0);

for ($i = 0; $i < count($resultSavings); $i++) {
	array_push($aResult,intval($resultSavings[$i]));
}
	
echo json_encode($aResult);

$querySavings = null;
$con = null;
?>