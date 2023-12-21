<?php

$host = "legalconnect.postgres.database.azure.com";
$port = "5432";
$dbname = "postgres";
$user = "legalconnect";
$password = "srilekha@3";

$connectionString = "host=$host port=$port dbname=$dbname user=$user password=$password";
$connection = pg_connect($connectionString);

if (!$connection) {
    die("Connection failed: " . pg_last_error());
}
?>
