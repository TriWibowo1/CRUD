<?php
$host = "localhost";
$user = "root";
$pass = "";
$db =  "akademik";

$connection = mysqli_connect($host, $user, $pass, $db);
if (!$connection) { //cek koneksi
    die("tidak bisa terkoneksi ke database");
}
