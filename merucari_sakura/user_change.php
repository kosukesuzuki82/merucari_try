<?php
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
//データを受け取り
$id = $_GET["id"];
//////////更新処理
$sql = "DELETE FROM user_info WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$status = $stmt->execute();

//データ判定・遷移
if($status==false){
	$error = $stmt->errorInfo();
	exit("ErrorQuery:".$error[2]);
}else{
	header("Location: index_third.php");	
	}

?>
