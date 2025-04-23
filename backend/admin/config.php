<?php
/**
* This code is citied and from Robert Smith and Tania Malik, and is apart of our course material in our Web Devlopment module
*/

/**
* Configuration for database connection
*
*/
$host = "localhost";
$username = "root";
$password = "";
$dbname = "test"; // will use later
$dsn = "mysql:host=$host;dbname=$dbname"; // will use later
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);
