<?php
require_once 'headers.php';
header("Access-Control-Allow-Methods: DELETE");
require_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $db = new Database();
    $pdo = $db->connect();
    $tableName = $db->getTableName();

    $inputJson = file_get_contents("php://input");
    $inputJsonDecoded = json_decode($inputJson, true);
    $id = $inputJsonDecoded['id'];

    $sqlRemoveData = "DELETE FROM  $tableName WHERE id=$id";
    $stmt = $pdo->prepare($sqlRemoveData);
    $stmt->execute();
    echo json_encode(array("ok" => true));

}