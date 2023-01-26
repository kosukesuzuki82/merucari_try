<?php
//データ受信
$name = $_POST["name"];
$company = $_POST["company"];
$id = $_POST["id"];
$pass = $_POST["pass"];
$flag = $_POST["flag"];
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
$sql = "INSERT INTO user_info(name,company,id,pass,flag)
        VALUES(:name,:company,:id,:pass,:flag)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name',$name,PDO::PARAM_STR);
$stmt->bindValue(':company',$company,PDO::PARAM_STR);
$stmt->bindValue(':id',$id,PDO::PARAM_STR);
$stmt->bindValue(':pass',$pass,PDO::PARAM_STR);
$stmt->bindValue(':flag',$flag,PDO::PARAM_INT);
$status = $stmt->execute();
//データ登録処理後
	if($status==false){
	 //SQLにエラーがある場合
	  $error = $stmt->errorInfo();
		 exit("QueryError:".$error[2]);
	}else{
	 //処理が終わると飛ぶサイトを指定
	  header("Location: login.php");
	  exit;
	  }

?>