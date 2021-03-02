<?php
require_once 'headers.php';
require_once 'Database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $userLogin = $_SESSION['login'] or die("invalid session!");

    $db = new Database();
    $pdo = $db->connect();
    $tableName = $db->getTableName();

    $inputJson = file_get_contents("php://input");
    $inputJsonDecoded = json_decode($inputJson, true);
    $text = $inputJsonDecoded['text'];

    $sqlInsertData = "INSERT INTO $tableName (text, checked, login) VALUES ('$text', 0, '$userLogin')";

    $stmt = $pdo->prepare($sqlInsertData);
    $stmt->execute();
    $id = $pdo->lastInsertId();
    echo json_encode(array("id" => $id));
}