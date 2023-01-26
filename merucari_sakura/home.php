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
<body>

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
?>
	<header>
	   <div class="head">
	   		<h1 class="site_logo">Steel</h1>
			<ul class="nav">
				<li class="nav_item"><a href="mypage.php">マイページ</a></li>
				<li class="nav_item"><a href="login.php">ログイン</a></li>
				<li class="nav_item"><a href="user_regi.php">会員登録</a></li>
				<li class="nav_item release"><a href="main_regi.php">出品</a></li>
				<li class="nav_item release"><a href="main_rfq.php">引合</a></li>
			</ul>
		</div>
		<p style="margin:2% 0 0 3%;"><?= $_SESSION["name"]?>さん ようこそ！！</p>
		<div class="bar">
			<ul class="bar_item">
				<li>売りたいリスト</li>
				<li>欲しいリスト</li>
			</ul>
		</div>
	</header>
    <main>


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
</html>
