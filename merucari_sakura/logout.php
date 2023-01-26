<?php
session_start();
$_SESSION = array();

//cookieに保存してあるSession IDの保存期間を過去にして破棄
if(isset($_COOKIE[session_name()])){
  setcookie(session_name(),'',time()-42000,'/');
}
session_destroy();
header("Location: login.php");
exit();

?>