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
// $image = $_FILES["img"]["name"];
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
$img = $_FILES["img"]["name"];

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ファイルアップロード処理
// $upload = "img/";
// if(move_uploaded_file($_FILES['img']['tmp_name'],$upload."$image")){
// 	//upload完了
// }else{
// 	echo "Upload failed";
// 	echo $_FILES["img"]["error"];
// }
////////////////////////////////////////////////////////////////////////


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
//////////////////////////カテゴリー・形状のデータID取得
	//DB登録から抽出
	$stmt = $pdo->prepare("SELECT * FROM category WHERE category_name = '$category'");
	$status = $stmt->execute();
	if($status==false){
		$error = $stmt->errorInfo();
		exit("ErrorQuery:".$error[2]);
	}else{
		$row = $stmt->fetch();
	}
	$category_id = $row["category_id"];

	//DB登録から抽出
	$stmt = $pdo->prepare("SELECT * FROM shape WHERE shape_name = '$shape'");
	$status = $stmt->execute();
	if($status==false){
		$error = $stmt->errorInfo();
		exit("ErrorQuery:".$error[2]);
	}else{
		$row = $stmt->fetch();
	}
	$shape_id = $row["shape_id"];


//////////////////////////データ登録
//データSQLを作成
$sql = "INSERT INTO marc_table (category,item_name,shape,length,width,thick_diameter,net_width,net_height,net_depth,img,place,mil_sheet,r_id,company,price,quantity,cus_num)
        VALUES(:category,:item_name,:shape,:length,:width,:thick_diameter,:net_width,:net_height,:net_depth,:img,:place,:mil_sheet,:r_id,:company,:price,:quantity,:cus_num)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':category',$category_id,PDO::PARAM_INT);
$stmt->bindValue(':item_name',$item_name,PDO::PARAM_STR);
$stmt->bindValue(':shape',$shape_id,PDO::PARAM_INT);
$stmt->bindValue(':length',$length,PDO::PARAM_INT);
$stmt->bindValue(':width',$width,PDO::PARAM_INT);
$stmt->bindValue(':thick_diameter',$thick_diameter,PDO::PARAM_INT);
$stmt->bindValue(':net_width',$net_width,PDO::PARAM_INT);
$stmt->bindValue(':net_height',$net_height,PDO::PARAM_INT);
$stmt->bindValue(':net_depth',$net_depth,PDO::PARAM_INT);
$stmt->bindValue(':img',$img,PDO::PARAM_STR);
$stmt->bindValue(':place',$place,PDO::PARAM_STR);
$stmt->bindValue(':mil_sheet',$mil_sheet,PDO::PARAM_STR);
$stmt->bindValue(':r_id',$id,PDO::PARAM_STR);
$stmt->bindValue(':company',$company,PDO::PARAM_STR);
$stmt->bindValue(':price',$price,PDO::PARAM_INT);
$stmt->bindValue(':quantity',$quantity,PDO::PARAM_INT);
$stmt->bindValue(':cus_num',$cus_num,PDO::PARAM_INT);
$status = $stmt->execute();
//採番されたAuto Incrementの値取得
$last_id_str = $pdo->lastInsertId();
$last_id = intval($last_id_str);



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
	$_SESSION["shape"] = $shape;
	$_SESSION["category"] = $category;
	$_SESSION["marc_num"] =$last_id;
	//処理が終わると飛ぶサイトを指定
	 header("Location: main_regi_confirm.php");
	 exit;
	 }
?>