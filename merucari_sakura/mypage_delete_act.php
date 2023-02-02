<?php
//sessionハイジャック対策→認証処理が必要なページに入れる
session_start();
if(!isset($_SESSION["chk_ssid"]) ||
   $_SESSION["chk_ssid"] != session_id()){//chk_ssidがログインでセットされているかを判定
	echo "LOGIN ERROR";
	exit();
   //セッションキーを変える→漏えいリスクを防ぐため
   }else{
	session_regenerate_id(true);
	$_SESSION["chk_ssid"] = session_id();
   }
//データ受取
//セッション分
session_start();
$cus_num = $_SESSION["cus_num"];
$id = $_SESSION["id"];
$name = $_SESSION["name"];
$company = $_SESSION["company"];
$marc_num = $_GET["marc_num"];
//データベース接続
//データベース接続
try {
	$db_name = "kgs_merucari";    //データベース名
	$db_id   = "kgs";      //アカウント名
	$db_pw   = "kosuke82";      //パスワード：XAMPPはパスワードなしMAMPのパスワードはroot
	$db_host = "mysql57.kgs.sakura.ne.jp"; //DBホスト
	$db_port = "3306"; //XAMPPの管理画面からport番号確認
	$pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host.';port='.$db_port.'', $db_id, $db_pw);
}catch(PDOException $e){
 exit('DbConnectError:'.$e->getMessage());
 }
//データSQLを作成
$update = $pdo->prepare("DELETE FROM marc_table WHERE marc_num=:marc_num");
$update->bindValue(':marc_num',$marc_num,PDO::PARAM_INT);
$status = $update->execute();
header("Location: mypage.php")
?>