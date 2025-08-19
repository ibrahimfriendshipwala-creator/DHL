<?php
$servername = "localhost";
$username = "udg55r6gw7kdk";
$password = "mehagkamqn56";
$database = "dbgqtmhtbkbgsp";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
