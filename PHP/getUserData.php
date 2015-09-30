<?php
#Query DB for userinfo
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

$queryUsers = $con->query('SELECT * FROM users where nickname="'.$nickname.'"');
$queryDevices = $con->query('SELECT * FROM devices where nickname="'.$nickname.'"');

$resultUsers = $queryUsers->fetch(PDO::FETCH_ASSOC);
$userID = $resultUsers['idusers'];
$userName = $resultUsers['name'];
$userAvatar = $resultUsers['avatar'];
$userTreeStatus = $resultUsers['treestatus'];
$userFriends = $resultUsers['friends'];
$userPunkte = $resultUsers['punkte'];
$userSavings = $resultUsers['savings'];
$userChange = $resultUsers['change'];
$userBugs = $resultUsers['bugs'];
$devicesCount = $queryDevices->rowCount();	//Anzahl devices

echo json_encode(array('id'=>$userID, 'name' => $userName, 'avatar' => $userAvatar, 'treestatus' => $userTreeStatus, 'friends' => $userFriends, 'punkte' => $userPunkte, 'savings' => $userSavings, 'change' => $userChange, 'bugs' => $userBugs, 'devicescount' => $devicesCount));

$queryDevices = null;
$queryUsers = null;
$con = null;
?>