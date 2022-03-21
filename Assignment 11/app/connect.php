<?php

$address = 'localhost';
$user = 'group8';
$password = 'M6t6WI';
$db = 'group8';

$conn = mysqli_connect($address, $user, $password, $db);
if (mysqli_connect_errno()) {
	return false;
}

return $conn;
