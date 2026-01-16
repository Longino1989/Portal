<?php

$url = 'test.php';
$json = file_get_contents($url);
$jo = json_decode($json);
echo $jo->title;

?>