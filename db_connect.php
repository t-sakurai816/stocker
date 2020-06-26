<?php

$host = 'localhost';
$username = 'root';
$passwd = 'Hogehoge@1234';
$dbname = 'stock';

$link = mysqli_connect($host,$username,$passwd,$dbname);

// 接続状況をチェックします
if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
} else {
    echo "データベースの接続に成功しました。\n";
}