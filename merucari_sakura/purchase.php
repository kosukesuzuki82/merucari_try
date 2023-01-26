<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
	<title>Document</title>
</head>
<body>
<header>更新ページ</header>

<?php
//id受け取り
$id = $_GET["id"];
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
//データセレクト
$sql = "SELECT * FROM user_info WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$status = $stmt->execute();

//データ表示
$view ="";
if($status==false){
	$error = $stmt->errorInfo();
	exit("ErrorQuery:".$error[2]);
}else{//更新処理で1データのみの場合は
		$row = $stmt->fetch();
	}
?>
<form method="post" action="index_fifth.php">
<label>名前:<input type="text" name="uname" value="<?=$row["uname"]?>"></label><br>
<label>年齢:<input type="text" name="age" value="<?=$row["age"]?>"></label><br>
<label>解答1:<input type="text" name="ans_one" value="<?=$row["解答1"]?>"></label><br>
<label>解答2:<input type="text" name="ans_two" value="<?=$row["解答2"]?>"></label><br>
<label>解答3:<input type="text" name="ans_three" value="<?=$row["解答3"]?>"></label><br>
<input type="hidden" name="id" value="<?=$id?>"><br>
<input type="submit" value="送信">
</form>

</body>
</html>