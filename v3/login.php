<?php
require_once 'headers.php';
require_once 'Database.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tableName = 'users';
    $db = new Database($tableName);
    $pdo = $db->connect();

    $inputJson = file_get_contents("php://input");
    $inputJsonDecoded = json_decode($inputJson, true);
    $login = $inputJsonDecoded['login'];
    $password = $inputJsonDecoded['pass'];

    $sqlCheckUser = "SELECT * FROM $tableName WHERE login='$login' and password='$password'";
    $stmt = $pdo->prepare($sqlCheckUser);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($rows) == 1) {
        $_SESSION['login'] = $login;
//        $key = generateCookie();
//        $sqlSetCookie = "UPDATE $tableName SET cookie='$key' WHERE login='$login'";
//        mysqli_query($connection, $sqlSetCookie);
//        setcookie('key', $key, time() + 300, '/', 'http://front.local');
        echo json_encode(array("ok" => true));
    }
}

function generateCookie($len = 16): string
{
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $cookie = '';
    for ($i = 0; $i < $len; $i++) {
        $randomChar = $chars[mt_rand(0, strlen($chars) - 1)];
        $cookie .= $randomChar;
    }
    return $cookie;
}