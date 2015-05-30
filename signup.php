<?php
// include configurations
include "config.inc.php";

// Get data
$name = $_GET['name'];
$email = $_GET['email'];
$password = $_GET['password'];

// Insert data into data base
$sql = "INSERT INTO users (id, username, email, password, previlege_lvl) VALUES (NULL, '$name', '$email', MD5('$password'), '1');";

$res = $mysqli->query($sql);

if ($res) {
    // return the newly created user (for the ID)
    $sql = "SELECT * FROM mabinetnetch.users WHERE password=MD5('$password') AND (username='$name' OR email='$name')";
    $res = $mysqli->query($sql);
    $json = array("status" => 1, "msg" => "Done User added!", "user" => $res->fetch_assoc());
} else {
    $json = array("status" => 0, "msg" => "Error adding user!", "details" => ($mysqli->error));
}

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
