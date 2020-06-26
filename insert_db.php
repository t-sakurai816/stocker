<?php

// DB情報を定義
define('dsn', 'mysql:host=localhost; dbname=stock; charset=utf8');
define('username', 'root');
define('passwd', 'Hogehoge@1234');

function deleteall() //全削除
{
  try {
    // DBへ接続
    $dbh = new PDO(dsn, username, passwd);
    // echo "DB接続成功";
    // echo "<br>";

  } catch (PDOException $e) {
    // echo "接続失敗: " . $e->getMessage() . "\n";
    die();
  }

  // SQL作成
  $sql = "delete from management;";
  $res = $dbh->query($sql);

  // 確認メッセージ
  // echo "DBへ追加成功しました。";
  // echo "<br>";
  // echo $sql;
  // echo "<br>";

  // 接続を閉じる
  $dbh = null;
}
function addstock($name, $amount) //追加
{
  try {
    // DBへ接続
    $dbh = new PDO(dsn, username, passwd);
    // echo "DB接続成功";
    // echo "<br>";

  } catch (PDOException $e) {
    // echo "接続失敗: " . $e->getMessage() . "\n";
    die();
  }

  // SQL作成
  $sql = "INSERT INTO `management` (`id`, `name`, `amount`) VALUES (NULL, '$name', $amount)";

  // SQL実行
  $res = $dbh->query($sql);

  // 確認メッセージ
  // echo "DBへ追加成功しました。";
  // echo "<br>";
  // echo $sql;
  // echo "<br>";

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
