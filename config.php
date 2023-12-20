<?php

$host = "localhost";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "postgres";

$connectionString = "host=$host port=$port dbname=$dbname user=$user password=$password";
$connection = pg_connect($connectionString);

if (!$connection) {
    die("Connection failed: " . pg_last_error());
}
?>