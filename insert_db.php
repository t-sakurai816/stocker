<?php

// DB情報を定義
define('dsn', 'mysql:host=localhost; dbname=stock; charset=utf8');
define('username', 'root');
define('passwd', 'Hogehoge@1234');

// 変数の初期化
$sql = null;
$res = null;
$dbh = null;

function addstock(){
  try {
    // DBへ接続
    $dbh = new PDO(dsn, username, passwd);
    echo "DB接続成功\n";
  
    // SQL作成
    $sql = "INSERT INTO `management` (`id`, `name`) VALUES (NULL, 'db5')";
  
    // SQL実行
    $res = $dbh->query($sql);
    
    // 確認メッセージ
    echo "DBへ追加成功しました。\n";
    echo $sql;
  
  } catch(PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    die();
  }
  
  // 接続を閉じる
  $dbh = null;
}

addstock();
