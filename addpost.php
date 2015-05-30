<?php
// include configurations
include "config.inc.php";

/* Get data */
if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    $json = array("status" => 0, "msg" => "Error, token required!");
    goto output;
}

if (isset($_GET['username'])) {
    $username = $_GET['username'];
} else {
    $json = array("status" => 0, "msg" => "Error, username required!");
    goto output;
}

if (isset($_GET['category'])) {
    $category = $_GET['category'];
} else {
    $json = array("status" => 0, "msg" => "Error, category required!");
    goto output;
}

if (isset($_GET['post'])) {
    $post = $_GET['post'];
} else {
    $json = array("status" => 0, "msg" => "Error, post required!");
    goto output;
}


/* Identifying user */
$sql = "SELECT id,username,password FROM users WHERE username='$username' AND password='$token'";
$res = $mysqli->query($sql);
if ($res) {

    if ($res->num_rows == 0)// check that the token is valid
    {
        $json = array("status" => 0, "msg" => "token wrong");
        goto output;
    } else {
        $uId = $res->fetch_assoc()['id'];
    }

} else // problem with database
{
    $json = array("status" => 0, "msg" => "Error checking token!", "details" => $mysqli->error);
    goto output;
}

$today = date("Y-m-d");

$time = date("H:i:s");
$sql = "INSERT INTO posts(id, user_id, category_id, content, p_date, p_time) VALUES (NULL,'$uId','$category','$post','$today','$time')";

$res = $mysqli->query($sql);


if ($res) {
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $rows[] = $row;
        }
        $json = array("status" => 1, "msg" => "comments found !", "comments" => $rows);
    } else {
        $json = array("status" => 1, "msg" => "no comments to be found!", "comments" => array());
    }
} else {
    $json = array("status" => 0, "msg" => "Error getting comments!", "details" => ($mysqli->error));
}

/* Output header */
output:
header('Content-type: application/json');
echo json_encode($json);
