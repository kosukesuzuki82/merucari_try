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
   //ユーザー情報を入手
   $id = $_SESSION["id"];
   $name = $_SESSION["name"];
   $company = $_SESSION["company"];
   $cus_num = $_SESSION["cus_num"];
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
		<div style="display: flex; flex-wrap:wrap; justify-content:space-between;">
		<p style="margin:2% 0 0 3%;"><?= $_SESSION["name"]?>さん マイページ</p>
		<input style="margin:2% 3% 0 0;" type="text" placeholder="検索">
		</div>
		
		<div class="bar">
			<ul class="bar_item">
				<li name="sell" class="sell">売りだしリスト</li>
				<li name="buy" class="buy">買いたいリスト</li>
			</ul>
		</div>
	</header>
    <main style="display:flex; flex-wrap:wrap; margin: 0 5% 0 5%; text-align:center;">
			<?php
			//idからデータを抽出する
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
				//DB登録から抽出→カテゴリー・形状データ全て
				$stmt = $pdo->prepare("SELECT * FROM category");
				$status = $stmt->execute();
				if($status==false){
					$error = $stmt->errorInfo();
					exit("ErrorQuery:".$error[2]);
				}else{
					$row_category = $stmt->fetch();
				}
				$category = $row_category["category_name"];

				$stmt = $pdo->prepare("SELECT * FROM shape");
				$status = $stmt->execute();
				$view ="";
				if($status==false){
					$error = $stmt->errorInfo();
					exit("ErrorQuery:".$error[2]);
				}else{
					$row_shape = $stmt->fetch();
				}
				$shape = $row_shape["shape_name"];
				

				
			//分岐処理を設ける？→売りたい、買いたいでリストを分ける///////////////////////
			// SQL文(売りたいリスト)
				//DB登録から抽出
				// $stmt = $pdo->prepare('SELECT * FROM marc_table');// category,item_name,shape,length,width,thick_diameter,net_width,net_height,net_depth,img,place,price,mil_sheet,quantity 
				$stmt = $pdo->prepare("SELECT * FROM marc_table INNER JOIN shape ON marc_table.shape = shape.shape_id INNER JOIN category ON marc_table.category = category.category_id WHERE '$id' = r_id");
				$status = $stmt->execute();
				$view ="";
				if($status==false){
					$error = $stmt->errorInfo();
					exit("ErrorQuery:".$error[2]);
				}else{
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					  $view .='<div class="sell_list">';
					  $view .='<li style="position: relative;"><img src="img/<';
					  $view .= $row["img"]."</li>";
					  $view .='<li class="item_list">';
					  $view .= $row["category_name"]."</li>";
					  $view .='<li class="item_list">';
					  $view .= $row["item_name"].'</li>';
					  $view .='<li class="item_list">';
					  $view .=$row["shape_name"].'</li>';
					  $view .='<li class="item_list">';
					  $view .=$row["thick_diameter"]."×".$row["width"]."×".$row["length"].'</li>';
					  $view .='<li class="item_list">';
					  $view .=$row["price"].'</li>';
					  $view .='<li class="item_list">';
					  $view .=$row["place"].'</li>';
					  $view .='<form method="get" action="mypage_change.php">';
					  $view .='<div style="text-align:center;">';
					  $view .='<a href="mypage_change.php?marc_num='.$row["marc_num"].'">[編集]</a><a href="mypage_delete_act.php?marc_num='.$row["marc_num"].'">[削除]</a>';
					  $view .='</div>';					 
					  $view .='<input type="hidden" name="category" value="';
					  $view .=$row["category_name"].">";
					  $view .='<input type="hidden" name="item_name" value="';
					  $view .=$row["item_name"].">";
					  $view .='<input type="hidden" name="shape" value="';
					  $view .=$row["shape_name"].">";
					  $view .='<input type="hidden" name="thick_diameter" value="';
					  $view .=$row["thick_diameter"].">";
					  $view .='<input type="hidden" name="width" value="';
					  $view .=$row["width"].">";
					  $view .='<input type="hidden" name="length" value="';
					  $view .=$row["length"].">";
					  $view .='<input type="hidden" name="place" value="';
					  $view .=$row["place"].">";
					  $view .='<input type="hidden" name="price" value="';
					  $view .=$row["price"].">";
					  $view .='<input type="hidden" name="net_width" value="';
					  $view .=$row["net_width"].">";
					  $view .='<input type="hidden" name="net_height" value="';
					  $view .=$row["net_height"].">";
					  $view .='<input type="hidden" name="net_depth" value="';
					  $view .=$row["net_depth"].">";
					  $view .='<input type="hidden" name="quantity" value="';
					  $view .=$row["quantity"].">";
					  $view .='<input type="hidden" name="mil_sheet" value="';
					  $view .=$row["mil_sheet"].">";
					  $view .='<input type="hidden" name="img" value="';
					  $view .=$row["img"].">";
					  $view .='<input type="hidden" name="img" value="';
					  $view .=$row["marc_num"].">";
					  $view .='</form>';
					  $view .='<form method="post" action="mypage_delete.php">';
					//   $view .='<input type="hidden" name="category" value="';
					//   $view .= $row["category"].">";
					//   $view .='<input type="hidden" name="item_name" value="';
					//   $view .=$row["item_name"].">";
					//   $view .='<input type="hidden" name="shape" value="';
					//   $view .=$row["shape"].">";
					//   $view .='<input type="hidden" name="thick_diameter" value="';
					//   $view .=$row["thick_diameter"].">";
					//   $view .='<input type="hidden" name="width" value="';
					//   $view .=$row["width"].">";
					//   $view .='<input type="hidden" name="length" value="';
					//   $view .=$row["length"].">";
					//   $view .='<input type="hidden" name="place" value="';
					//   $view .=$row["place"].">";
					//   $view .='<input type="hidden" name="price" value="';
					//   $view .=$row["price"].">";
					//   $view .='<input type="hidden" name="net_width" value="';
					//   $view .=$row["net_width"].">";
					//   $view .='<input type="hidden" name="net_height" value="';
					//   $view .=$row["net_height"].">";
					//   $view .='<input type="hidden" name="net_depth" value="';
					//   $view .=$row["net_depth"].">";
					//   $view .='<input type="hidden" name="quantity" value="';
					//   $view .=$row["quantity"].">";
					//   $view .='<input type="hidden" name="mil_sheet" value="';
					//   $view .=$row["mil_sheet"].">";
					//   $view .='<input type="hidden" name="img" value="';
					//   $view .=$row["img"].">";
					  $view .='</form>';
					  $view .='</div>';
					}
					//セッション維持
					$_SESSION["company"] = $company;
					$_SESSION["name"] = $name;
					$_SESSION["id"] = $id;
					$_SESSION["cus_num"] = $cus_num;
					$_SESSION["marc_num"] = $row["marc_num"];
				}
				?>
	<!-- リストの数だけ表示する -->
	    <?=$view?>
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
