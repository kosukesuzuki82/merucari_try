
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
<header>s
	   <div class="head">
	   		<h1 class="site_logo">Steel</h1>
			<ul class="nav">
				<li class="nav_item"><a href="info.php">マイページ</a></li>
				<li class="nav_item"><a href="login.php">ログイン</a></li>
				<li class="nav_item"><a href="user_regi.php">会員登録</a></li>
				<li class="nav_item release"><a href="main_regi.php">出品</a></li>
				<li class="nav_item release"><a href="main_rfq.php">引合</a></li>
			</ul>
		</div>
		<div class="bar">
		</div>
	</header>
  <div>
  <form method="post" action="user_regi_act.php" style="text-align:center;">
    <h1 style="margin-bottom: 3%;">会員登録</h1>
    <ul class="list" style="margin:auto; width: 40%;">
      <li style="display: flex; justify-content:space-between;"><p>名前</p><input type="text" name="name"></li>
      <li style="display: flex; justify-content:space-between;"><p>企業名</p><input type="text" name="company"></li>
      <li style="display: flex; justify-content:space-between;"><p>ユーザーID</p><input type="text" name="id"></li>
      <li style="display: flex; justify-content:space-between;"><p>パスワード<p><input type="text" name="pass"></li>
      <li hidden><input type="text" name="flag" style="width:100%;" value="1" hidden></li>
      <li hidden><input type="text" name="cus_num" style="width:100%;" value="1" hidden></li>
    </ul>
    <input type="submit" value="次へ" style="margin-top: 3%; width: 40%; background-color:red; color:white;">
  </form>
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
