<?php
/**
* This code is citied and adapted from code provided by Robert Smith and Tania Malik, and it is apart of our course material in our Web Devlopment Server Side module
*/

// We're adapting this to connect to the TalkTempo database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "talktempo"; // Changed to match the project's database name
$dsn = "mysql:host=$host;port=3307;dbname=$dbname"; // Added port=3307
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);

try {
    $connection = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
