<?php
function outputName($name,$hoge)
{
  echo "$name";
  echo "$hoge";
}

outputName($_GET['name'],$_GET['hoge']);//urlから値を受け取る
