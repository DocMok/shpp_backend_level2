<?php
require_once 'headers.php';
require_once 'Database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//    $cookieKey = $_COOKIE['key'];
//    $userLogin = getLogin($cookieKey) or die("invalid cookie!");
    $userLogin = $_SESSION['login'] or die("invalid session!");

    $db = new Database();
    $connection = $db->connect();
    $tableName = $db->getTableName();

    $inputJson = file_get_contents("php://input");
    $inputJsonDecoded = json_decode($inputJson, true);
    $text = $inputJsonDecoded['text'];

    $sqlInsertData = "INSERT INTO $tableName (text, checked, login) VALUES ('$text', 0, '$userLogin')";

    if (mysqli_query($connection, $sqlInsertData)) {
        $id = mysqli_insert_id($connection);
        echo json_encode(array("id" => $id));
    } else {
        echo json_encode(array("ok" => false));
    }
    mysqli_close($connection);
}

function getLogin($key) {
    $tableName = 'users';
    $db = new Database($tableName);
    $connection = $db->connect();

    $sqlFindUser = "SELECT * FROM $tableName WHERE key='$key'";
    $result = mysqli_query($connection, $sqlFindUser) or die(mysqli_error($connection));
    mysqli_close($connection);
    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result)['login'];
    }
    return false;
}