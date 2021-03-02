<?php
require_once 'headers.php';
require_once 'Database.php';
session_start();


//$cookieKey = '1WAGJXV9cnCsGr4h';//$_COOKIE['key'];
//$userLogin = getLogin($cookieKey) or die("invalid cookie!");
//$userLogin = $_SESSION['login'] or die("invalid session!");
$userLogin = 'DocMok';
$db = new Database();
$pdo = $db->connect();
$tableName = $db->getTableName();

$sqlCreateTable = "CREATE TABLE IF NOT EXISTS $tableName (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, text TEXT NOT NULL, checked BOOLEAN NOT NULL)";
$stmt = $pdo->prepare($sqlCreateTable);
$stmt->execute();

$sqlGetData = "SELECT * FROM $tableName WHERE login='$userLogin'";
$stmt = $pdo->prepare($sqlGetData);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$preJSONData = array("items" => []);
if (count($rows) > 0) {
    // output data of each row
    foreach ($rows as $row) {
        $preJSONData['items'][] = array("id" => $row["id"],
            "text" => $row["text"],
            "checked" => (int)$row["checked"]);
    }
}

echo json_encode($preJSONData);


function getLogin($key)
{
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