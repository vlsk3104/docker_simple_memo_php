<?php
require '../../common/auth.php';
require '../../common/database.php';

if (!isLogin()) {
  header('Location: ../login/');
  exit;
}

//$_GETを使用することで、URLにパラメータで付加した情報を取得する
$id = $_GET['id'];
$user_id = getLoginUserId();

$database_handler = getDatabaseConnection();
if ($statement = $database_handler->prepare("SELECT id, title, content FROM memos WHERE id = :id AND user_id = :user_id")) {
  $statement->bindParam(":id", $id);
  $statement->bindParam(":user_id", $user_id);
  $statement->execute();
  $result = $statement->fetch(PDO::FETCH_ASSOC);
}

$_SESSION['select_memo'] = [
  'id' => $result['id'], //選択したメモのID
  'title' => $result['title'], //選択したメモのタイトル
  'content' => $result['content'] //選択したメモの本文
];
header('Location: ../../memo/');
exit;
