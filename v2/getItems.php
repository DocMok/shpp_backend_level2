<?php
require_once 'headers.php';
require_once 'Database.php';
session_start();

//$cookieKey = '1WAGJXV9cnCsGr4h';//$_COOKIE['key'];
//$userLogin = getLogin($cookieKey) or die("invalid cookie!");
$userLogin = $_SESSION['login'] or die("invalid session!");

$db = new Database();
$connection = $db->connect();
$tableName = $db->getTableName();

$sqlCreateTable = "CREATE TABLE IF NOT EXISTS $tableName (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, text TEXT NOT NULL, checked BOOLEAN NOT NULL)";
mysqli_query($connection, $sqlCreateTable);

$sqlGetData = "SELECT * FROM $tableName WHERE login='$userLogin'";
$data = mysqli_query($connection, $sqlGetData);

$preJSONData = array("items" => []);
if (mysqli_num_rows($data) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($data)) {
        $preJSONData['items'][] = array("id" => $row["id"],
            "text" => $row["text"],
            "checked" => (int)$row["checked"]);
    }
}

mysqli_close($connection);

echo json_encode($preJSONData);


function getLogin($key) {
    $tableName = 'users';
    $db = new Database($tableName);
    $connection = $db->connect();
    if (isset($key)) {
        $sqlFindUser = "SELECT * FROM $tableName WHERE cookie='$key'";
        $result = mysqli_query($connection, $sqlFindUser) or die(mysqli_error($connection));
        mysqli_close($connection);
        if (mysqli_num_rows($result) == 1) {
            return mysqli_fetch_assoc($result)['login'];
        }
    }
    return false;
}