<?php
$str = '255'; // 文字列(string)型
$int = 255.9; // 整数(int)型
$flt = 255.99; // 浮動小数点(float)型

$amount = $_GET['amount'];
echo gettype($amount);
echo "<br>";

// echo $cast;

// 文字列(string)型の判定
if (preg_match('/^[0-9]+$/', $amount)) {
  echo $amount;
  echo "<br>";
  echo '文字列string => OK!';
  echo "<br>";
  echo "<br>";
} else {
  echo '文字列string => ダメ！';
}

// 整数(int)型
if (is_int($amount)) {
  echo $amount;
  echo "<br>";
  echo '整数int => OK!';
  echo "<br>";
  echo "<br>";
} else {
  echo $amount;
  echo "<br>";
  echo '整数int => ダメ！';
  echo "<br>";
  echo "<br>";
}

// 小数(float)型
// if (is_numeric($amount)) {
//   echo $amount;
//   echo "<br>";
//   echo '小数float => OK!';
//   echo "<br>";
//   echo "<br>";
// } else {
//   echo '小数float => ダメ！';
// }
