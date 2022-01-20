<?php

// general settings
$host       = "localhost";
$database   = "reservationsfeeble";
$user       = "root";
$password   = "";

// make connection with database
$db = mysqli_connect($host, $user, $password, $database)
// display connection error if something isn't right
or die("Error: " . mysqli_connect_error());
