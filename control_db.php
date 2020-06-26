<?php

// DB情報を定義
define('dsn', 'mysql:host=localhost; dbname=stock; charset=utf8');
define('username', 'root');
define('passwd', 'Hogehoge@1234');

function db_connect($sql) //DBへ接続からSQL実行まで
{
  try {
    // DBへ接続
    $dbh = new PDO(dsn, username, passwd);
    // echo "DB接続成功";
  } catch (PDOException $e) {
    // echo "接続失敗: " . $e->getMessage() . "\n";
    die();
  }
  // SQL実行
  $res = $dbh->query($sql);
}
function addstock($name, $amount) //なければ追加、あったらupdate
{
  // SQL作成
  // なければinsert, あればupdate
  $sql = "INSERT INTO test (name,amount, sales) VALUES ('$name',$amount, NULL) ON DUPLICATE KEY UPDATE name = '$name', amount = amount + $amount";

  db_connect($sql);

  // 接続を閉じる
  $dbh = null;
}
function checkstock($name, $num) //在庫表示
{
  try {
    // DBへ接続
    $dbh = new PDO(dsn, username, passwd);
    // echo "DB接続成功";
  } catch (PDOException $e) {
    // echo "接続失敗: " . $e->getMessage() . "\n";
    die();
  }

  // SQL作成
  if ($num == 1) { //nameがある時
    $sql = "select name,amount from test where name ='$name'";
    // SQL実行
    $res = $dbh->query($sql);
    // 在庫表示
    foreach ($res as $row) {
      echo $row['name'] . ": " . $row['amount'] . "\n";
    }
  } else if ($num == 2) { //nameがない時
    $sql = "select name,amount from test";
    // SQL実行
    $res = $dbh->query($sql);
    //在庫表示
    foreach ($res as $row) {
      echo $row['name'] . ': ' . $row['amount'] . "\n";
    }
  }
  // 接続を閉じる
  $dbh = null;
}
function sell($name, $amount, $price)
{
  // SQL作成
  if ($_GET['price'] != null) {
    $sql = "UPDATE test SET amount = amount - $amount, sales = COALESCE(sales,0) + $amount * $price WHERE name = '$name'";
  } else {
    $sql = "UPDATE test SET amount = amount - $amount WHERE name = '$name'";
  }

  db_connect($sql);

  // 接続を閉じる
  $dbh = null;
}
function checksales()
{

  try {
    // DBへ接続
    $dbh = new PDO(dsn, username, passwd);
    // echo "DB接続成功";
  } catch (PDOException $e) {
    // echo "接続失敗: " . $e->getMessage() . "\n";
    die();
  }

  $sql = "select sum(sales) from test";
  // SQL実行
  $res = $dbh->query($sql);
  // salesの合計値を出力
  foreach ($res as $row) {
    echo "sales" . ": " . $row['sum(sales)'];

    // 接続を閉じる
    $dbh = null;
  }
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



switch ($_GET['function']) { //functionの中身によって処理を変える

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
  case 'checkstock':  //checkstockの場合
    if ($_GET['name'] != null) { //nameがnullの時
      $num = 1;
      checkstock($_GET['name'], $num);
    } else {
      $num = 2;
      checkstock($_GET['name'], $num);
    }
    break;
  case 'sell':  //sellの場合
    if ($_GET['amount'] != null && $_GET['price'] != null) { //amountがある && priceがある
      sell($_GET['name'], $_GET['amount'], $_GET['price']);
    } else if ($_GET['amount'] != null && $_GET['price'] == null) { //amountがある && priceがない
      sell($_GET['name'], $_GET['amount'], null); //price = null
    } else if ($_GET['amount'] == null && $_GET['price'] != null) { //amountがない && priceがある
      sell($_GET['name'], "1", $_GET['price']); //amountに1を入れる(省略時は1)
    } else { //amountがない && priceがない
      sell($_GET['name'], "1", null); //amountに1を入れる(省略時は1)
    }
    break;

  case 'checksales':
    checksales();
    break;

  case 'deleteall': //deleteallの場合
    deleteall();
    break;
}
