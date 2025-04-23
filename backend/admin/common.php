<?php
/**
* This code is citied and from Robert Smith and Tania Malik, and is apart of our course material in our Web Devlopment module
*/

function escape($data) {
    $data = htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
    $data = trim($data);
    $data = stripslashes($data);
    return ($data);
}   
