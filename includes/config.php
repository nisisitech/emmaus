<?php
date_default_timezone_set('Africa/Nairobi');
$servername="localhost";
$username="root";
$password="";
$database="emmausin_emmaus";

$conn= new mysqli($servername,$username,$password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{

}
?>