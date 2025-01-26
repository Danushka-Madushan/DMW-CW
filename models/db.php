<?php
$host = "localhost"; // This is the container name, not localhost
$dbname = "trustcarecomputers";
$username = "webapp";
$password = "BrsMVUDvx3BHfpN4kt8I";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
