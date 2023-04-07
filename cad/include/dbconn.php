<?php
date_default_timezone_set('Asia/Tokyo');
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
try {
  $pdo = new PDO('mysql:dbname=xs621032_kojima;host=localhost', "xs621032_tmuser", "0QUAF8oh8P");
} catch (PDOException $e) {

  exit('データベースに接続できませんでした。' . $e->getMessage());
}

$stmt = $pdo->query('SET NAMES utf8');
if (!$stmt) {
  $info = $pdo->errorInfo();
  exit($info[2]);
}
