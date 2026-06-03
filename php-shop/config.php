<?php
$host   = "localhost";
$user   = "root";
$pass   = "";
$dbname = "shop";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("<h2 style='color:red;font-family:sans-serif;'>Erreur DB: " . $conn->connect_error . "<br><a href='setup.php'>Cliquez ici pour configurer la base de données</a></h2>");
}
$conn->set_charset("utf8");
session_start();
?>
