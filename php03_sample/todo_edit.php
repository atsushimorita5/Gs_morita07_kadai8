<?php

include("functions.php");
$id = $_GET['id'];
// DB接続&id名でテーブルから検索
$pdo = connect_to_db();

$sql = 'SELECT * FROM todo_table WHERE id=:id'; 
$stmt = $pdo->prepare($sql); 
$stmt->bindValue(':id', $id, PDO::PARAM_STR); 
$status = $stmt->execute();

if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  // fetchAll()関数でSQLで取得したレコードを配列で取得できる
  // データの出力用変数（初期値は空文字）を設定
}  

?>

<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB連携型todoリスト（編集画面）</title>
  </head>
  <body>
    <form action="todo_update.php" method="POST">
      <fieldset>
        <legend>DB連携型todoリスト（編集画面）</legend>
        <a href="todo_read.php">一覧画面</a>
        <div>
        <input type="text" name="todo" value="<?= $record["todo"] ?>">
        <input type="date" name="deadline" value="<?= $record["deadline"] ?>">
        </div>
        <div>
          deadline: <input type="date" name="deadline">
        </div>
        <div>
          <button>submit</button>
        </div>
        <input type="hidden" name="id" value="<?=$record['id']?>">
      </fieldset>
    </form>
  </body>
</html>