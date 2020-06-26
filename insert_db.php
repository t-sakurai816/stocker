<?php

// DB情報を定義
define('dsn', 'mysql:host=localhost; dbname=stock; charset=utf8');
define('username', 'root');
define('passwd', 'Hogehoge@1234');

function db_connect($sql) //DBへ接続からSQL実行まで
{
  try {
    // DBへ接続
    global $dbh;
    $dbh = new PDO(dsn, username, passwd);
    echo "DB接続成功";
    echo "<br>";
  } catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    die();
  }
  // SQL実行
  $res = $dbh->query($sql);
}
function deleteall() //全削除
{
  // SQL作成
  $sql = "delete from test;";

  db_connect($sql);

  // 確認メッセージ
  echo "全削除しました";

  // 接続を閉じる
  $dbh = null;
}
function addstock($name, $amount) //なければ追加、あったらupdate
{
  // SQL作成
  // なければinsert, あればupdate
  $sql = "INSERT INTO test (name,amount, sales) VALUES ('$name',$amount, NULL) ON DUPLICATE KEY UPDATE name = '$name', amount = amount + $amount";

  db_connect($sql);

  // 確認メッセージ
  echo "DBへ追加または変更成功しました。";
  echo "<br>";
  echo $sql;
  echo "<br>";

  // 接続を閉じる
  $dbh = null;
}


switch ($_GET['function']) { //functionの中身によって処理を変える
  case 'deleteall': //deleteallの場合
    deleteall();
    break;
  case 'addstock': //addstockの場合
    if ($_GET['amount'] != null) { //amountがあるときは
      if (preg_match('/^[0-9]+$/', $_GET['amount'])) { //amountが整数であれば
        addstock($_GET['name'], $_GET['amount']);
      } else {  //amountが整数以外であれば
        echo "ERROR"; //ERRORを出力
      }
    } else { //amountが無いときは
      addstock($_GET['name'], "1"); //amountに1をいれる(デフォルト値)
    }
    break;
}
