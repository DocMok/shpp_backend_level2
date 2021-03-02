<?php
require_once 'headers.php';
header("Access-Control-Allow-Methods: DELETE");
require_once 'Database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $db = new Database();
    $connection = $db->connect();
    $tableName = $db->getTableName();

    $inputJson = file_get_contents("php://input");
    $inputJsonDecoded = json_decode($inputJson, true);
    $id = $inputJsonDecoded['id'];

    $sqlRemoveData = "DELETE FROM  $tableName WHERE id=$id";
    if (mysqli_query($connection, $sqlRemoveData)) {
        echo json_encode(array("ok" => true));
    } else {
        echo json_encode(array("ok" => false));
    }
    mysqli_close($connection);
}