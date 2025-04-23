<?php
/**
* This code is citied and from Robert Smith and Tania Malik, and is apart of our course material in our Web Devlopment module
*/

require_once '../config.php'; //access the login values
try {
    $connection = new PDO($dsn, $username, $password, $options);
echo 'DB connected';} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
