<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "connect_db";
$con = mysqli_connect($host, $user, $password, $database);
if (mysqli_connect_error()) {
    echo "Connection Fail: " . mysqli_connect_error();
    exit;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

