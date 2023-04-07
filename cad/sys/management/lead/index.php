<?php
/*ファイルの読み込み*/
require ("../../../include/dbconn.php");
include ("../../../include/convert.php");
include ("../../../include/list.php");
//include ("../../user/include/list.php");
//include ("../../include/list/db_class_new.php");

include("../include/header.php");
//include("../top/syonin.php");
$main_title = "リード";

// フォームリスト
$form_type_list[wpdl] = "カタログダウンロード";
$form_type_list[contact] = "ご相談・お問合せ";
$form_type_list[request] = "営業依頼・デモ申込み";

//DBの接続を閉じる
//mysql_close();

// include(			MARKEMEDIA_PATH."wp_dl/include/dbmkcd_test.php");
//include ("../../../wp_dl/include/dbmkcd.php");

if($_POST[act] == ""){
	$_POST[act] = "list";
}
if($_REQUEST[type] == "details"){
	$_POST[act] = "details";
}

/*キーの設定*/
$act_type_key = $_POST[act]."_".$_POST[type];
?>

<?
/*検索・一覧画面**************************************************************************/
if($_POST[act] == "list"){
	if ($_REQUEST[ret_del] == "1") {
		$_SESSION[start_date] = "";
		$_SESSION[end_date] = "";
	}
	//1ページに表示する件数
	$page_view = 20;
	if ($_SESSION[page] == "") { $_SESSION[page] = 1; }
	if($_REQUEST[dis] == "1"){
		$_SESSION[page] = $_REQUEST[page];
	}else{
		$_SESSION[page] = 1;
	}
	if($_SESSION[page] == 1){
		$offset = 0;
	}else{
		$offset_key = $_SESSION[page] - 1;
		$offset = $offset_key * $page_view;
	}
	if($_POST[ret] != ""){
		$_SESSION[start_date] = $_POST[start_date];
		$_SESSION[end_date] = $_POST[end_date];
	}
	$_POST[start_date] = $_SESSION[start_date];
	$_POST[end_date] = $_SESSION[end_date];






	// echo $sql_inq_comp;

	//$result_inq_comp = mysql_query ($sql_inq_comp);
	$stmt->execute();
	$row_num_inq_comp=$stmt->rowCount();
	//$row_num_inq_comp = mysql_num_rows ($result_inq_comp);
	if($_SESSION[page] == "1"){
		$dis_a = 1;
		if($row_num_inq_comp < $page_view){
			$dis_b = $row_num_inq_comp;
		}else{
			$dis_b = $page_view;
		}
	}else{
		$dis_b_key = $_SESSION[page] * $page_view;
		$dis_a = (($_SESSION[page] - 1) * $page_view) + 1;
		if($row_num_inq_comp < $dis_b_key){
			$dis_b = $row_num_inq_comp;
		}else{
			$dis_b = $dis_b_key;
		}
	}
?>


<div id="contents" style="width:1200px;">

<h2><?php echo $main_title; ?>一覧</h2>
<p class="stext"></p>

<form action="<?php echo $now_page; ?>?t=<?php echo time(); ?>" method="post">
<table class="Tblform_ret">
<tr>
	<th>お問合せ日</th>
	<td>
	<input type="text" name="start_date" size="30" value="<?php echo $_POST[start_date]; ?>" id="calender_1">
 ～
	<input type="text" name="end_date" size="30" value="<?php echo $_POST[end_date]; ?>" id="calender_2">
	</td>
</tr>
</table>

<br>
<div class="btn_ret">
<input type="submit" name="ret" value="&nbsp;<?php echo $type_comment_list[$act_type_key]; ?>&nbsp;" class="submit01" />
</div>
</form>

<strong class="fcRedb"><?php echo $row_num_inq_comp; ?></strong>件中／<?php echo $dis_a; ?> - <?php echo $dis_b; ?>件表示

<?
if($_SESSION[company_id] != ""){
?>
　<a href="dl_telema.php">CSVダウンロード</a>
<?
}
?>
<table class="Tblform_ret">
<tr>
	<th style="width:50%;">種別</th>
	<th style="width:25%;">UU数</th>
	<th style="width:25%;">DL総数</th>
</tr>
<?php
foreach ($form_type_list as $site_type => $site_name) {
	$sql_inq_comp = "SELECT";
	$sql_inq_comp .= " *";
	$sql_inq_comp .= " FROM";
	$sql_inq_comp .= " inquery";
	$sql_inq_comp .= " WHERE";
	$sql_inq_comp .= " inquery_id > '0'";
	$sql_inq_comp .= " AND site_type = '" . $site_type . "'";
	//$sql_inq_comp .= " and T1.open_flg <> '9'";
	if (!empty($_SESSION[start_date])) {
			$sql_inq_comp .= " and inquery_date >= '" . $_SESSION[start_date] . " 0:00:00'";
	}
	if (!empty($_SESSION[end_date])) {
			$sql_inq_comp .= " and inquery_date <= '" . $_SESSION[end_date] . " 23:59:59'";
	}

	$stmt = $pdo -> prepare($sql_inq_comp);
	
	//SQLの実行
	$stmt->execute();
	//件数の取得
	$row_num_dl = $stmt->rowCount();

	//$result_inq_comp = mysql_query ($sql_inq_comp);
	//$row_num_dl = mysql_num_rows ($result_inq_comp);

	$sql_inq_comp .= " group by email";
	$stmt = $pdo -> prepare($sql_inq_comp);
	//SQLの実行
	$stmt->execute();
	//件数の取得
	$row_num_uu = $stmt->rowCount();

?>
<tr>
	<th style="text-align: left;"><?php echo $site_name; ?></th>
	<td style="text-align: center;font-size: 1.2em"><a href="lead.php?site_type=<?php echo $site_type; ?>&request_type=uu"><?php echo $row_num_uu; ?></a></td>
	<td style="text-align: center;font-size: 1.2em"><a href="lead.php?site_type=<?php echo $site_type; ?>&request_type=dl"><?php echo $row_num_dl; ?></a></td>
</tr>
<?php
}
?>



</table>

<br>

<table class="btn" style="width:700px;">
<tr>
<td style="width:70px;text-align:left;">
<?php
	if ($_SESSION[page] > 1) {
		$b_page = $_SESSION[page] - 1;
?>
<a href="<?php echo $now_page; ?>?t=<?php echo time(); ?>&page=<?php echo $b_page; ?>&act=list&dis=1">←前の<?php echo $page_view; ?>件</a>
<?php } ?>
</td>
<td style="width:360px;text-align:center;">
<?
		if($row_num_inq_comp > $page_view){
			for ($i=0; $i<$page_no_cnt; $i++) {
				$page_no = $i + 1;
				if($page_no != $_SESSION[page]){
					echo "<a href=\"$now_page?t=".time()."&page=$page_no&act=list&dis=1\">";
				}
				echo $page_no;
				if($page_no != $_SESSION[page]){
					echo "</a>";
				}
				echo "&nbsp;&nbsp;";
			}
		}
?>

</td>
<td style="width:70px;text-align:right;">
<?php
		if ($page_no_cnt > $_SESSION[page]) {
			$n_page = $_SESSION[page] + 1;
?>
<a href="<?php echo $now_page; ?>?t=<?php echo time(); ?>&page=<?php echo $n_page; ?>&act=list&dis=1">→次の<?php echo $page_view; ?>件</a>
<?php } ?>
</td>
</tr>
</table>

</div><!-- contents -->

<?
}
/*登録画面********************************************************************************/
if($_POST[act] == "details"){

	$sql_inq_comp = "SELECT";
	$sql_inq_comp .= " T1.*";
	$sql_inq_comp .= ",T2.material_name";
	$sql_inq_comp .= ",T2.detail_flg";
	$sql_inq_comp .= ",T2.estimate_flg";
	$sql_inq_comp .= ",T2.goods_demo_flg";
	$sql_inq_comp .= ",T2.wpdl_flg";
	$sql_inq_comp .= ",T2.wp_request_flg";
	$sql_inq_comp .= " FROM";
	$sql_inq_comp .= " mkcd_inquery_basic T1";
	$sql_inq_comp .= " LEFT JOIN";
	$sql_inq_comp .= " mkcd_inquery_material T2";
	$sql_inq_comp .= " ON";
	$sql_inq_comp .= " (T1.inquery_no = T2.inquery_no)";
	$sql_inq_comp .= " WHERE";
	$sql_inq_comp .= " T1.inquery_no = '" . $_REQUEST[inquery_no] . "'";
	$result_user = mysql_query ($sql_inq_comp);
	$row_num_user = mysql_num_rows ($result_user);
	$tm_dl_user = mysql_fetch_assoc($result_user);
?>
<style>
.Tblform th {
white-space: normal;
}
</style>
<div id="contents">

<h2><?php echo $main_title; ?>詳細</h2>


<table class="Tblform">
<tr>
	<th>お問合せ日時</th>
	<td>
	<? echo $tm_dl_user[inquery_date]; ?>
	</td>
</tr>
<tr>
	<th>ダウンロードした資料</th>
	<td>
	<? echo $tm_dl_user[material_name]; ?>
	</td>
</tr>
<tr>
	<th>会社名</th>
	<td>
	<? echo $tm_dl_user[company_name]; ?>
	</td>
</tr>
<tr>
	<th>サイトURL</th>
	<td>
	<? echo $tm_dl_user[url]; ?>
	</td>
</tr>
<tr>
	<th>部署名</th>
	<td>
	<? echo $tm_dl_user[division]; ?>
	</td>
</tr>
<tr>
	<th>役職名</th>
	<td>
		<?php echo $tm_dl_user["post_name"]?>
	</td>
</tr>
<tr>
	<th>お名前</th>
	<td>
	<? echo $tm_dl_user[name]; ?>
	</td>
</tr>
<tr>
	<th>電話番号</th>
	<td>
	<? echo $tm_dl_user[tel]; ?>
	</td>
</tr>
<tr>
	<th>FAX番号</th>
	<td>
	<? echo $tm_dl_user[fax]; ?>
	</td>
</tr>
<tr>
	<th>メールアドレス</th>
	<td>
	<? echo $tm_dl_user[email]; ?>
	</td>
</tr>
<tr>
	<th>住所<span class="form_red">必須</span></th>
	<td>
		<?php echo $address_code[$tm_dl_user["address1"]]?><?php echo $tm_dl_user["address2"]?>
	</td>
</tr>
<tr>
	<th>業種<span class="form_red">必須</span></th>
	<td>
		<?php echo $business_list[$tm_dl_user["business"]]?>
	</td>
</tr>
<tr>
	<th>役職<span class="form_red">必須</span></th>
	<td>
		<?php echo $post_list[$tm_dl_user["post"]]?>
	</td>
</tr>
<tr>
	<th>職種<span class="form_red">必須</span></th>
	<td>
		<?php echo $occupational_list[$tm_dl_user["occupational"]]?>
	</td>
</tr>
<tr>
	<th>従業員数<span class="form_red">必須</span></th>
	<td>
		<?php echo $employees_list[$tm_dl_user["employees"]]?>
	</td>
</tr>
<tr>
	<th>会社の年商<span class="form_red">必須</span></th>
	<td>
		<?php echo $turnover_list[$tm_dl_user["turnover"]]?>
	</td>
</tr>
<tr>
	<th>あなたはサービス導入の意思決定に、<br />どのような立場で関わっていますか？<span class="form_red">必須</span></th>
	<td>
		<?php echo $standpoint_list[$tm_dl_user["standpoint"]]?>
	</td>
</tr>
<?php
	$sql_inq_comp = "SELECT";
	$sql_inq_comp .= " *";
	$sql_inq_comp .= " FROM";
	$sql_inq_comp .= " mkcd_inquery_anq";
	$sql_inq_comp .= " WHERE";
	$sql_inq_comp .= " inquery_no = '" . $_REQUEST[inquery_no] . "'";
	$sql_inq_comp .= " order by inquery_anq_no";
	$result_user = mysql_query ($sql_inq_comp);
	$row_num_user = mysql_num_rows ($result_user);
	while ($tm_dl_user = mysql_fetch_assoc($result_user)) {
		echo "<tr>\n";
		echo "<th>" . $tm_dl_user[anq_title] . "</th>\n";
		echo "<td>" . $tm_dl_user[anq] . "</td>\n";
		echo "</tr>\n";
	}
 ?>
</table>


<div class="btn">

<form action="<?php echo $now_page; ?>?t=<?php echo time(); ?>" method="post">
<p><input type="submit" value="&nbsp;一覧へ戻る&nbsp;" class="submit01" /></p>
</form>


</div>

</div><!-- contents -->

<?
}
?>

<?
include("../include/footer.php");
?>

</div><!-- /wrapper -->

</body>
</html>
