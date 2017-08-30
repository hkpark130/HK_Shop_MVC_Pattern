<?php
require '../bootstrap.php';
require '../HkApp.php';

$app = new HkApp(true); //error출력 여부(true-표시, false-미표시)
$app->run();
?>
