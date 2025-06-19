<?php
$host="localhost";
$db="punto_venta";
$user="root";
$pass="";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){
    die("error en la conexión: ".$conn->conn.error);
} 

?>