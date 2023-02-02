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
//form分
$category = $_POST["category"];
$item_name = $_POST["item_name"];
$shape = $_POST["shape"];
$length_str = $_POST["length"];//int変換
$length = intval($length_str);
$width_str = $_POST["width"];//int変換
$width = intval($width_str);
$thick_diameter_str = $_POST["thick_diameter"];//int変換
$thick_diameter = intval($thick_diameter_str);
$net_height_str = $_POST["net_height"];//int変換
$net_height = intval($net_height_str);
$net_width_str = $_POST["net_width"];//int変換
$net_width = intval($net_width_str);
$net_depth_str = $_POST["net_depth"];//int変換
$net_depth = intval($net_depth_str);
$place = $_POST["place"];
$price_str = $_POST["price"];//int変換
$price = intval($price_str);
$quantity_str = $_POST["quantity"];//int変換
$quantity = intval($quantity_str);
$mil_sheet = $_POST["mil_sheet"];
$img = $_POST["img"];
$marc_num_str = $_POST["marc_num"];
$marc_num = intval($marc_num_str);
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
//変更後のカテゴリーデータを数値型に変換
$stmt = $pdo->prepare("SELECT * FROM category WHERE category_name = '$category'");
$status = $stmt->execute();
$view ="";
if($status==false){
	$error = $stmt->errorInfo();
	exit("ErrorQuery:".$error[2]);
}else{
	$row_category = $stmt->fetch();
}
//変更後の形状データを数値型に変換
$stmt = $pdo->prepare("SELECT * FROM shape WHERE shape_name = '$shape'");
$status = $stmt->execute();
$view ="";
if($status==false){
	$error = $stmt->errorInfo();
	exit("ErrorQuery:".$error[2]);
}else{
	$row_shape = $stmt->fetch();
}
$category_id =$row_category["category_id"];
$shape_id =$row_shape["shape_id"];


$update = $pdo->prepare("UPDATE marc_table SET category=:category,item_name=:item_name,shape=:shape,length=:length,width=:width,thick_diameter=:thick_diameter,net_width=:net_width,net_height=:net_height,net_depth=:net_depth,img=:img,place=:place,mil_sheet=:mil_sheet,price=:price,quantity=:quantity WHERE marc_num = $marc_num");
$update->bindValue(':category',$category_id,PDO::PARAM_INT);
$update->bindValue(':item_name',$item_name,PDO::PARAM_STR);
$update->bindValue(':shape',$shape_id,PDO::PARAM_INT);
$update->bindValue(':length',$length,PDO::PARAM_INT);
$update->bindValue(':width',$width,PDO::PARAM_INT);
$update->bindValue(':thick_diameter',$thick_diameter,PDO::PARAM_INT);
$update->bindValue(':net_width',$net_width,PDO::PARAM_INT);
$update->bindValue(':net_height',$net_height,PDO::PARAM_INT);
$update->bindValue(':net_depth',$net_depth,PDO::PARAM_INT);
$update->bindValue(':img',$img,PDO::PARAM_STR);
$update->bindValue(':place',$place,PDO::PARAM_STR);
$update->bindValue(':mil_sheet',$mil_sheet,PDO::PARAM_STR);
$update->bindValue(':price',$price,PDO::PARAM_INT);
$update->bindValue(':quantity',$quantity,PDO::PARAM_INT);
$status = $update->execute();
//データ登録処理後
if($status==false){
	//SQLにエラーがある場合
	 $error = $stmt->errorInfo();
		exit("QueryError:".$error[2]);
   }else{
	//セッションの維持
	$_SESSION["company"] = $company;
	$_SESSION["name"] = $name;
	$_SESSION["id"] = $id;
	$_SESSION["cus_num"] = $cus_num;
	//処理が終わると飛ぶサイトを指定
	 header("Location: mypage.php");
	 exit;
	 }
?>