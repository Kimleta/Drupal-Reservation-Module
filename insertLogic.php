<?php 
$servername = "localhost:3308";
$username = "root" ;
$password = '' ;
$dbname = "bioskop";

$conn = new mysqli($servername,$username,$password,$dbname) ;
if ($conn->connect_error) {
  die("Connection failed :" . $conn->connect_error) ;
}

$title = $_POST["title"];
$day = $_POST["day"];
$genre = $_POST["genre"];
$name = $_POST["name"];
$date = date('Y-m-d H:i:s') ;
var_dump($date);
$sql = "INSERT INTO reservations (day_of_reservation, time_of_reservation, reserved_movie_name, reserved_movie_genre, customer_name) 
VALUES ('{$day}', '{$date}', '{$title}', '{$genre}', '{$name}');" ;

$conn->query($sql) ;
$conn->close();

?>