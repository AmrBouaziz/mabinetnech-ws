<?php
// include configurations
include "config.inc.php";

/* Get data */
if (isset($_GET['name']))
    $name = $_GET['name'];
else {
    $json = array("status" => 0, "msg" => "Error, user name or email required!");
    goto output;
};

if (isset($_GET['password']))
    $password = $_GET['password'];
else {
    $json = array("status" => 0, "msg" => "Error, password required!");
    goto output;
};

$sql = "SELECT * FROM mabinetnetch.users WHERE password=MD5('$password') AND (username='$name' OR email='$name')";

$res = $mysqli->query($sql);

if ($res) {
    if ($res->num_rows == 1) {
        $json = array("status" => 1, "msg" => "user found !", "user" => $res->fetch_assoc());
    } else {
        $json = array("status" => 0, "msg" => "username or password wrong !");
    }
} else {
    $json = array("status" => 0, "msg" => "Error adding Category!", "details" => ($mysqli->error));
}


/* Output header */
output:
header('Content-type: application/json');
echo json_encode($json);
