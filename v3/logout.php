<?php
require_once 'headers.php';

session_start();
session_unset();
echo json_encode(array('ok' => true));