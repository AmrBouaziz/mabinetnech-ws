<?php
// include configurations
include 'config.inc.php';

/* Get data */
if (isset($_GET['token']))
    $token = $_GET['token'];
else {
    $json = array("status" => 0, "msg" => "Error, token required!");
    goto output;
};

if (isset($_GET['category']))
    $category = $_GET['category'];
else {
    $json = array("status" => 0, "msg" => "Error, category required!");
    goto output;
};

/* Identifying user */
$sql = "SELECT password from users where password='$token'";
$res = $mysqli->query($sql);
if ($res) {

    if ($res->num_rows == 0)// check that the token is valid
    {
        $json = array("status" => 0, "msg" => "token wrong");
        goto output;
    }

} else // problem with database
{
    $json = array("status" => 0, "msg" => "Error checking token!", "details" => $mysqli->error);
    goto output;
}


/* Adding new Category */
$sql = "INSERT INTO categories(id, name) VALUES(id=null,name='$$category')";

$res = $mysqli->query($sql);

if ($res) {
    $json = array("status" => 1, "msg" => "Done Category added!");
}
else {

    $json = array("status" => 0, "msg" => "Error adding category!", "details" => ($mysqli->error));
}

/* Output header */
output:
header('Content-type: application/json');
echo json_encode($json);