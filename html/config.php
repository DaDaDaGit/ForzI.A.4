<?php
session_start();
$conn = mysqli_connect("localhost","root","","paroli_616954");

if(mysqli_connect_errno()){
    die(mysqli_connect_errno());
}
?>