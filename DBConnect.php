<?php
$dbhost='mysql:host=localhost;dbname=novaposhta';
$dbuser='root';
$dbpass='';
$pdo = new PDO(
    $dbhost,
    $dbuser,
    $dbpass,
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
);
$pdo->exec('SET NAMES utf8');
?>