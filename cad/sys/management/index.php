<?php
include ("../../include/dbconn.php");
include ("../../include/convert.php");
include ("../../include/list.php");
//-----------------------------------------------------------------------//
//LOGIN処理
//-----------------------------------------------------------------------//
if ( isset($_POST['act']) == "login" ){
	$error_msg = "";
	if ($_POST['id'] == "" or $_POST['pass'] == ""){
		$error_msg = "'id'またはPasswordが入力されていません。";
	}else{
		// 入力されたメールアドレスの登録確認
		if(in_array($_POST['id'], $id)){
			$pass_flg = "none";
			if($pass[$_POST['id']] == $_POST['pass']){
				$pass_flg = "done";
			}
			if( $pass_flg == "none" ){
				$error_msg = "パスワードが違います。";
			}
		}else{
			// 'id'がない
			$error_msg = "入力された'id'は存在しません。";
		}
	}

	if ($error_msg != ""){
		$_POST['act'] = "err";
	}else{
		session_start();
		$_SESSION = array();
		$_SESSION['sys']['management']['id'] = $_POST['id'];
		$_SESSION['sys']['management']['pass'] = $_POST['pass'];

		$time_t = time();
		$header_link = "blog/?t=".$time_t;
		header("Location:$header_link");
		exit;
	}


}

//-----------------------------------------------------------------------//
//LOGIN画面
//-----------------------------------------------------------------------//
if( isset( $_POST['act'] ) == "" or isset( $_POST['act'] ) == "err" ){

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--meta http-equiv="X-UA-Compatible" content="IE=emulateIE8" /-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>小島衣料CADサービス　管理画面</title>
<link href="css/k_default.css" rel="stylesheet" type="text/css" />

</head>

<body style="background:none;">

<div class="login_wrapper">
<div class="logo">
	<h1><!--img src="images/logo.gif" w'id'th="500" height="45" alt="" /--></h1>
</div>


<div class="login">


<h1>管理画面へのログインはこちらから</h1>
<form action="index.php" method="post">
<?php
	if($_POST['act'] == "err"){
		echo "<p style=\"color:#990000;\">".$error_msg."</p>";
	}
?>
<table class="Tbl">
  <tr>
    <td>id</td>
    <td><input type="text" name="id" value="<?= $_POST['id'] ?>" /></td>
    </tr>
  <tr>
    <td>パスワード</td>
    <td><input type="password" name="pass" value="<?= $_POST['pass'] ?>" /></td>
  </tr>
</table>

<div class="formbtn">
<p class="grn"><button type="submit">ログイン</button></p>
</div>
<input type="hidden" name="act" value="login" />
</form>

</div><!-- /login -->



<? include("include/footer.php"); ?>



</div><!-- /login_wrapper -->

</body>
</html>
<?php
}

?>
