<?php
session_start();
if ($_SESSION['sys']['management']['id'] == "" or $_SESSION['sys']['management']['pass'] == "") {
	header("Location:../");
}
/*ページの取得*/
$reff = explode("/", $_SERVER['REQUEST_URI']);
$reff = array_reverse($reff);
$reff_new = explode("?", $reff[0]);
$now_page = $reff_new[0];
if ($now_page == "") {
	$now_page = "index.php";
}
// echo $now_page;
// var_dump($reff);
$type_comment_list = array(
	"list_" => "検索する",
	"add_regist" => "登録内容確認画面へ",
	"err_regist" => "登録内容確認画面へ",
	"add_upd" => "変更内容確認画面へ",
	"err_upd" => "変更内容確認画面へ",
	"conf_regist" => "新規登録",
	"conf_upd" => "登録内容変更",
	"conf_del" => "登録内容削除",
	"end_regist" => "新規登録完了しました。",
	"end_upd" => "登録内容変更完了しました。",
	"end_del" => "登録内容削除完了しました。"
);
$page_title_sub_list = array(
	"list_" => "検索・一覧",
	"add_regist" => "新規登録画面",
	"err_regist" => "新規登録画面",
	"add_upd" => "変更画面",
	"conf_regist" => "新規登録確認",
	"conf_upd" => "変更内容確認",
	"conf_del" => "削除内容確認",
	"end_regist" => "新規登録完了",
	"end_upd" => "登録内容変更完了",
	"end_del" => "登録内容削除完了"
);
/*メインタイトル*/
$dir_page = $reff[1] . "/" . $now_page;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
	<title>小島衣料CADサービス　管理画面</title>
	<link href="../css/k_default.css" rel="stylesheet" type="text/css" />
	<!-- <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script> -->
	<?php if ($now_page != "category.php") : ?>
		<script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
	<?php else : ?>
		<script type="text/javascript" src="../../js/jquery-1.4.4.min.js"></script>
	<?php endif ?>
	<!-- <script type="text/javascript" src="../../js/thickbox.js"></script> -->
	<!-- <link href="../../css/thickbox.css" type="text/css" rel="stylesheet" media="screen" /> -->
	<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen, projection" />
	<!--[if lte IE 7]>
<link rel="stylesheet" type="text/css" href="../../css/ie.css" media="screen" />
    <![endif]-->
	<?php if ($now_page == "index.php") : ?>
		<!-- <link rel="stylesheet" href="../../css/jquery-ui.min.css" /> -->
		<script type="text/javascript" src="../../js/jquery-ui.min.js"></script>
	<?php endif ?>

	<!-- <script type="text/javascript" language="javascript" src="../../js/jquery.dropdownPlain.js"></script> -->
	<script type="text/javascript" src="../../js/ui.datepicker.js"></script>
	<script type="text/javascript" src="../../js/ui.datepicker-ja.js"></script>
	<!-- <script type="text/javascript" src="../../js/jquery.elastic.source.js"></script> -->
	<link href="../../css/datepicker.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../../js/jscolor.js"></script>

	<?php if ($now_page == "category.php") : ?>
		<!-- <link rel="stylesheet" href="../../css/jquery.ui.all.css"> -->
		<script type="text/javascript" src="../../js/jquery.ui.core.js"></script>
		<script type="text/javascript" src="../../js/jquery.ui.widget.js"></script>
		<script type="text/javascript" src="../../js/jquery.ui.mouse.js"></script>
		<script type="text/javascript" src="../../js/jquery.ui.sortable.js"></script>
		<!-- <script type="text/javascript" src="../../js/colorpic.js"></script> -->
	<?php endif ?>

	<?php if ($now_page != "category.php") : ?>
		<script type="text/javascript" src="../../js/form_cr.js"></script>
	<?php endif ?>
	<!-- <link rel="stylesheet" href="../../css/colorpic.css"> -->

	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/flick/jquery-ui.min.css"> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> -->

	<script type="text/javascript">
		<!--
		$(function() {
			$('.calender').datepicker({
				dateFormat: 'yy-mm-dd',
			});
		});
		// 
		-->
	</script>
	<script type="text/javascript" src="../../js/jquery.droppy.js"></script>
	<script type="text/javascript">
		$(function() {
			$("#nav").droppy();
		});
	</script>
</head>
<!-- datepicekrサイズ -->
<style>
	.ui-datepicker {
		font-size: 60%;
	}
</style>

<body>
	<div id="wrapper">

		<div id="header">

			<div class="inbox">
				<div class="logo">
					<h1>
						<!--img src="../images/logo.gif" width="500" height="45" alt="" /-->
					</h1>
				</div>
				<div class="sublink">
					<p class="name">
					<form action="../logout.php" method="post"><span><strong><?php echo $_SESSION['sys']['management_p']['company_name']; ?></strong>　ログイン中</span><input type="submit" value="ログアウト" name="add" /></form>
					</p>
				</div>
			</div><!-- /inbox -->

		</div><!-- /header -->

		<div id="Gnav" class="clearfix">
			<ul id="nav">
				<li><a href="../blog/?ret_del=1&t=<?php echo time(); ?>">ブログ</a>
					<ul>
						<li><a href="../blog/?t=<?php echo time(); ?>">ブログ一覧</a></li>
						<li><a href="../blog/category.php?t=<?php echo time(); ?>&category_type=blog_category">カテゴリ一覧</a></li>
						<!-- <li><a href="../blog/category.php?t=<?php echo time(); ?>&category_type=blog_phase">フェーズ一覧</a></li> -->
					</ul>
				</li>
				<li><a href="../qa/category.php?ret_del=1&t=<?php echo time(); ?>&category_type=qa_category">QAカテゴリ</a>
				</li>
				<li><a href="../customer_reviews/category.php?ret_del=1&t=<?php echo time(); ?>&category_type=qa_category" style="width: 110px;">お客様の声カテゴリ</a>
				</li>
				<!-- 		<li><a href="../catalog/?t=<?php echo time(); ?>">資料</a>
			<ul>
				<li><a href="../catalog/?t=<?php echo time(); ?>">資料一覧</a></li>
			</ul>
		</li>
		<li><a href="../news/?t=<?php echo time(); ?>">ニュース</a>
			<ul>
				<li><a href="../news/?t=<?php echo time(); ?>">ニュース一覧</a></li>
			</ul>
		</li> -->
			</ul>
		</div>

		<?php
		//print_r($_SESSION[sys][management]);
		?>
		<!-- /subnavi -->