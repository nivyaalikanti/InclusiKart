<?php
$servername = "localhost";
$username = "root"; // Default for XAMPP
$password = ""; // Default is empty in XAMPP
$dbname = "disability_platform"; // Make sure the database exists

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// try {
//     $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("Connection failed: " . $e->getMessage());
// }
?>
