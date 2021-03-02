<?php
require_once 'headers.php';
header("Access-Control-Allow-Methods: PUT");
require_once 'Database.php';
session_start();

require_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    $db = new Database();
    $pdo = $db->connect();
    $tableName = $db->getTableName();

    $inputJson = file_get_contents("php://input");
    $inputJsonDecoded = json_decode($inputJson, true);

    $text = $inputJsonDecoded['text'];
    $checked = (int)$inputJsonDecoded['checked'];
    $id = $inputJsonDecoded['id'];

    $sqlUpdateData = "UPDATE $tableName SET text='$text', checked=$checked WHERE id='$id'";
    $stmt = $pdo->prepare($sqlUpdateData);
    $stmt->execute();
    echo json_encode(array("ok" => true));

}