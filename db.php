<?php  

$servername = "localhost";
$username = "root";
$password = "";
$database = "poradniki_001-todo";

$db = mysqli_connect($servername, $username, $password, $database);

if (!$db) {
  die("Wystąpił błąd podczas łączenia z bazą danych: " . mysqli_connect_error());
}

?>