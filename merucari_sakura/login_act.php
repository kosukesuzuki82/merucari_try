<?php
//session start
session_start();
//データ受信
$id = $_POST["id"];
$pass = $_POST["pass"];
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
$sql = "SELECT * FROM user_info WHERE id=:id AND pass=:pass";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id);
$stmt->bindValue(':pass',$pass);
$status = $stmt->execute();
//SQLにエラーがある場合
	if($status==false){
	  $error = $stmt->errorInfo();
	  exit("QueryError:".$error[2]);
	}
//抽出データ数を取得
$val = $stmt->fetch();//1レコードを取得
//該当レコードがあればSESSIONに値を代入
if($val["id"] != ""){
	$_SESSION["chk_ssid"] = session_id();//ログイン時の独自idを作る
	$_SESSION["company"] = $val['company'];
	$_SESSION["cus_num"] = $val['cus_num'];
	$_SESSION["name"] = $val['name'];
	$_SESSION["id"] = $val['id'];
	header("Location: home.php");
}else{
	header("Location: login.php");
}
//処理終了
exit();
?>