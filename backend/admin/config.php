<?php
/**
* This code is citied and adapted from code provided by Robert Smith and Tania Malik, and it is apart of our course material in our Web Devlopment Server Side module
*/

/**
* Configuration for database connection
*/
$host = "localhost";
$username = "root";
$password = "";
$dbname = "talktempo"; // Changed to match the project's database
$dsn = "mysql:host=$host;port=3307;dbname=$dbname"; // Added port=3307
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);
