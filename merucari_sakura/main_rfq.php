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
//ユーザー情報を入手
session_start();
$id = $_SESSION["id"];
$name = $_SESSION["name"];
$company = $_SESSION["company"];
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
		<p style="margin:2% 0 2% 3%;"><?= $_SESSION["name"]?>さん 何が欲しいでしょうか？</p>
		<div class="bar">

		</div>
	</header>
  </header>
 
  <main>
	<section style="width:100%;display:flex;justify-content:space-evenly;">
	        <img class="imgs" style="width:30%;">
			<form method="post" action="main_rfq_act.php" style="margin: 0 0 1% 10%;width:40%;">
				<ul>
					<li style="display: flex;justify-content:space-between;">カテゴリー*<select name="category" style=" width:62.5%;"><option>一般構造用圧延鋼材</option><option>溶接構造用圧延鋼材</option><option>みがき棒鋼</option><option>PC鋼棒</option><option>建築構造用圧延鋼材</option><option>自動車構造用熱間圧延鋼板</option><option>熱間圧延軟鋼板</option><option>冷間圧延鋼板</option><option>ボイラ及び圧力容器用炭素鋼板</option><option>配管用炭素鋼鋼管</option><option>ボイラ・熱交換器用炭素鋼鋼管</option><option>ピアノ線材</option><option>冷間圧造用炭素鋼線材</option><option>機械構造用炭素鋼</option><option>マンガン鋼</option><option>マンガンクロム鋼</option><option>クロム鋼</option><option>クロムモリブデン鋼</option><option>ニッケルクロム鋼</option><option>ニッケルクロムモリブデン鋼</option><option>アルミニウムクロムモリブデン鋼</option><option>高温用合金鋼ボルト材</option><option>ステンレス鋼</option><option>耐熱鋼</option><option>超合金</option><option>炭素工具鋼</option><option>高速度工具鋼</option><option>合金工具鋼</option><option>ばね鋼</option><option>快削鋼</option><option>軸受鋼</option>
					</select></li>
					<li style="display: flex;justify-content:space-between;">鋼種別*<input type="text" name="item_name" style="width:60%;"></li>
					<li style="display: flex;justify-content:space-between;">形状*<select name="shape" style=" width:62.5%;"><option>鋼板</option><option>コイル</option><option>丸鋼管</option><option>角鋼管</option><option>丸棒</option><option>角棒</option><option>アングル</option><option>チャンネル</option><option>H形鋼</option><option>線材コイル</option><option> Wire</option><option>継手</option>
					</select></li>
					<li style="display: flex;justify-content:space-between;">長さ*<input type="text" name="length" style="width:60%;"></li>
					<li style="display: flex;justify-content:space-between;">幅*<input type="text" name="width" style="width:60%;"></li>
					<li style="display: flex;justify-content:space-between;">厚さ/直径*<input type="text" name="thick_diameter" style="width:60%;"></li>
					<li style="display: flex;justify-content:space-between;">荷高さ<input type="text" name="net_height" style="width:60%;" value="0"></li>
					<li style="display: flex;justify-content:space-between;">荷幅<input type="text" name="net_width" style="width:60%;" value="0"></li>
					<li style="display: flex;justify-content:space-between;">荷奥行き<input type="text" name="net_depth" style="width:60%;" value="0"></li>
					<li style="display: flex;justify-content:space-between;">在庫場所<input type="text" name="place" style="width:60%;"></li>
					<li style="display: flex;justify-content:space-between;">単価<input type="text" name="price" style="width:60%;"></li>
					<li style="display: flex;justify-content:space-between;">重量<input type="text" name="quantity" style="width:60%;"></li>
					<li style="display: flex;justify-content:space-between;">ミルシート*<select name="mil_sheet" style=" width:62.5%;"><option>あり</option><option>なし</option>
					</select></li>
					<li style="display: flex;justify-content:space-between;">画像<input class="img_up" type="file" name="img" style="width:62.5%;"></li>
					<input type="submit" value="確認" style="width:100%; color:white;background-color:red;margin:2% 0 0 0;">
				</ul>
			</form>
		
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
<script>
//ファイルアップロード時に表示する
$(function() {
    $(".img_up").on("change", function(e) {
        // 1枚だけ表示する
        let file = e.target.files[0];
        // ファイルリーダー作成
        let fileReader = new FileReader();
        fileReader.onload = function() {
            // Data URIを取得
            let dataUri = this.result;
            // img要素に表示
            $(".imgs").attr('src', dataUri);
        }
        // ファイルをData URIとして読み込む
        fileReader.readAsDataURL(file);
    });
})
</script>

</body>
</html>
