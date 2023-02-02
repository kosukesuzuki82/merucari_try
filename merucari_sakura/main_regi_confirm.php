<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
	<title>Steel</title>
</head>
<?php
//ユーザー情報を入手
session_start();
$id = $_SESSION["id"];
$name = $_SESSION["name"];
$company = $_SESSION["company"];
$marc_num =$_SESSION["marc_num"];
?>

  <header>
	   <div class="head">
	   		<h1 class="site_logo">Steel</h1>
			<ul class="nav">
				<li class="nav_item"><a href="info.php">マイページ</a></li>
				<li class="nav_item"><a href="login.php">ログイン</a></li>
				<li class="nav_item"><a href="user_regi.php">会員登録</a></li>
				<li class="nav_item release"><a href="main_regi.php">出品</a></li>
			</ul>
		</div>
		<p style="margin:2% 0 2% 3%;"><?= $_SESSION["name"]?>さん ようこそ！！</p>
		<div class="bar">

		</div>
	</header>
  </header>
 
  <main>
	<section style="width:100%;display:flex;justify-content:space-evenly;">

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
	//DB登録から抽出→メインテーブル
	$stmt = $pdo->prepare("SELECT category,item_name,shape,length,width,thick_diameter,net_width,net_height,net_depth,img,place,price,mil_sheet,quantity FROM marc_table WHERE $marc_num = marc_num");
	$status = $stmt->execute();
	$view ="";
	if($status==false){
		$error = $stmt->errorInfo();
		exit("ErrorQuery:".$error[2]);
	}else{
		$row = $stmt->fetch();
		//セッション維持
		$_SESSION["company"] = $company;
		$_SESSION["name"] = $name;
		$_SESSION["id"] = $id;
	}
	$shape_name = $_SESSION["shape"];
	$shape_str = $row["shape"];///shape idがメインテーブルより入る
	$shape = intval($shape_str);
	$category_name = $_SESSION["category"];
	$category_str = $row["category"];///category idがメインテーブルより入る
	$category = intval($category_str);

	//DB登録から抽出→カテゴリー・形状
	$stmt = $pdo->prepare("SELECT * FROM category WHERE category_id = $category");
	$status = $stmt->execute();
	if($status==false){
		$error = $stmt->errorInfo();
		exit("ErrorQuery:".$error[2]);
	}else{
		$row_category = $stmt->fetch();
	}
	// $category_name = $row_category["category_name"];

	$stmt = $pdo->prepare("SELECT * FROM shape WHERE shape_id = $shape");
	$status = $stmt->execute();
	$view ="";
	if($status==false){
		$error = $stmt->errorInfo();
		exit("ErrorQuery:".$error[2]);
	}else{
		$row_shape = $stmt->fetch();
	}
	// $shape_name = $row_shape["shape_name"];
    ?>
	<img class="imgs" style="width:30%;" src="img/<?=$row["img"]?>">
	<form method="post" action="home.php" style="width: 40%;">
		<ul>
			<li style="display: flex;justify-content:space-between; margin-bottom:2%;">カテゴリー<p><?=$category_name?></p></li>
			<li style="display: flex;justify-content:space-between; margin-bottom:2%;">鋼種別<p><?=$row["item_name"]?></p></li>
			<li style="display: flex;justify-content:space-between; margin-bottom:2%;">形状<p><?=$shape_name?></p></li>
			<li style="display: flex;justify-content:space-between; margin-bottom:2%;">サイズ<p><?=$row["thick_diameter"]?>×<?=$row["width"]?>×<?=$row["length"]?></p></li>
			<li style="display: flex;justify-content:space-between; margin-bottom:2%;">荷姿<p><?=$row["net_height"]?>×<?=$row["net_width"]?>×<?=$row["net_depth"]?></p></li>
			<li style="display: flex;justify-content:space-between; margin-bottom:2%;">在庫場所<p><?=$row["place"]?></p></li>
			<li style="display: flex;justify-content:space-between; margin-bottom:2%;">単価<p><?=$row["price"]?></p></li>
			<li style="display: flex;justify-content:space-between; margin-bottom:2%;">重量<p><?=$row["quantity"]?></p></li>
			<li style="display: flex;justify-content:space-between; margin-bottom:2%;">ミルシート<p><?=$row["mil_sheet"]?></p></li>
			<input type="submit" value="この内容で登録しました" style="width:100%; color:white;background-color:red;margin:2% 0 0 0;">
		</ul>
	</form>
	</section>
  </main>

  <footer>
		<div class="footer_info">
			<h3 class="footer_title">Steelについて</h3>
				<ul>
					<li><a href="*.php">会社概要</a></li>
					<li><a href="*.php">Steel利用規約</a></li>
					<li><a href="*.php">コンプライアンスポリシー</a></li>
				</ul>
		</div>
	</footer>
	<div style="text-align:right; margin:3% 2% 1%;">
	<a href="logout.php">ログアウト</a>
	</div>

</body>