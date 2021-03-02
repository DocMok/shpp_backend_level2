<?php
require_once 'headers.php';
require_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableName = 'users';
    $db = new Database($tableName);
    $connection = $db->connect();

    $inputJson = file_get_contents("php://input");
    $inputJsonDecoded = json_decode($inputJson, true);

    $login = $inputJsonDecoded['login'];
    $password = $inputJsonDecoded['pass'];

    $sqlAddUser = "INSERT INTO $tableName (login, password) VALUES ('$login', '$password')";
    if (mysqli_query($connection, $sqlAddUser)) {
        echo json_encode(array("ok" => true));
    } else {
        echo json_encode(array("ok" => false));
    }
    mysqli_close($connection);
}