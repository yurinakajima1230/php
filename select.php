<?php
//1. DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_bm;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DB_CONECT'.$e->getMessage());
}

//2. データ取得SQL作成
$sql = "SELECT * FROM gs_bm_table";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute(); 

//3. データ表示
$view = "";
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
} else {
  //データ取得成功時
  $values = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ブックマーク一覧</title>
<link rel="stylesheet" href="css/bookmark.css">
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: pink;
    margin: 0;
    padding: 20px;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }
  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }
  th {
    background-color: #f2f2f2;
  }
</style>
</head>
<body>

<!-- ヘッダー -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <p>ブックマーク一覧</p>
      </div>
    </div>
  </nav>
</header>

<!-- メインコンテンツ -->
<div class="container jumbotron">
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>書籍名</th>
        <th>書籍URL</th>
        <th>コメント</th>
        <th>登録日時</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($values)): ?>
        <?php foreach($values as $value): ?>
          <tr>
            <td><?= $value["id"] ?></td>
            <td><?= $value["bookname"] ?></td>
            <td><?= $value["bookurl"] ?></td>
            <td><?= $value["bookcomment"] ?></td>
            <td><?= $value["indate"] ?></td>
            <td><a href="detail.php?id=<?= $value['id'] ?>">更新</a></td> <!-- 更新リンク -->
            <td><a href="delete.php?id=<?= $value['id'] ?>" onclick="return confirm('本当に削除しますか？')">削除</a></td> <!-- 削除リンク --> 
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5">データがありません</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- フッター -->
<footer>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php">登録</a>
      </div>
    </div>
  </nav>
</footer>

</body>
</html>
