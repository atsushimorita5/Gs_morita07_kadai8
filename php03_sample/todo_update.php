<?php
// var_dump($_POST);
// exit();

include('functions.php');
$id = $_POST['id'];
$todo = $_POST['todo'];
$deadline = $_POST['deadline'];

$pdo = connect_to_db();

$sql = "UPDATE todo_table SET todo=:todo, deadline=:deadline,updated_at= sysdate() WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':todo', $todo, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
  } else {
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    header("Location:todo_read.php");
    exit();
  }
