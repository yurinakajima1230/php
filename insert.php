<?php
//1. POSTデータ取得
//[name,email,age,naiyou]
$bookname = $_POST["bookname"];
$bookurl = $_POST["bookurl"];
$bookcomment = $_POST["bookcomment"];

//2. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_bm;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DB_CONECT:'.$e->getMessage());
}


//３．データ登録SQL作成
$sql = "INSERT INTO gs_bm_table(bookname,bookurl,bookcomment,indate)VALUES(:bookname,:bookurl,:bookcomment,sysdate());";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':bookname', $bookname, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':bookurl', $bookurl, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':bookcomment', $bookcomment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}else{
  //５．index.phpへリダイレクト
header("Location: index.php");
exit();
}
?>
