<?php

$address = 'localhost';
$user = 'root';
$password = 'NEWPASSWORD';
$db = 'portal';

$conn = mysqli_connect($address, $user, $password, $db);
if (mysqli_connect_errno()) {
	return false;
}

return $conn;