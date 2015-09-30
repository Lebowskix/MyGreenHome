<?php
#UPDATE DB bugs for user
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

$sql = 'UPDATE users SET bugs=0 where nickname="'.$nickname.'"';
$con->query($sql);


$queryTimeCons = null;
$con = null;
?> 