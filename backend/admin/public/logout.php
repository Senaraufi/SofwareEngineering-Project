<?php
/**
* This code is citied and adapted from code provided by Robert Smith and Tania Malik, and it is apart of our course material in our Web Devlopment Server Side module
*/

// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: /admin_access.php");
exit;
?>
