<?php
$host = "localhost";
$db_user = "ibrahim";       
$db_pass = "ibrahim123";    
$db_name = "sqli";          

$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
