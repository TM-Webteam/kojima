<?php
/*ファイルの読み込み*/
require ("../../../include/dbconn.php");
include ("../../../include/convert.php");
include ("../../../include/list.php");
//include ("../../user/include/list.php");
//include ("../../include/list/db_class_new.php");

include("../include/header.php");
//include("../top/syonin.php");

$form_type_list[wpdl] = "カタログダウンロード";
$form_type_list[contact] = "ご相談・お問合せ";
$form_type_list[request] = "営業依頼・デモ申込み";

$request_type_list['uu'] = "UU数";
$request_type_list['dl'] = "DL総数";

$main_title = $form_type_list[$_REQUEST['site_type']] . "［" . $request_type_list[$_REQUEST[request_type]] . "］";

// 掲載企業
/*	$sql_inq = "SELECT";
	$sql_inq .= " T1.*";
	$sql_inq .= ",T2.c_type";
	$sql_inq .= ",T2.company_name";
	$sql_inq .= ",T3.service_name";
	$sql_inq .= " FROM";
	$sql_inq .= " mm_contract T1";
	$sql_inq .= " LEFT JOIN";
	$sql_inq .= " tm_compmaster T2";
	$sql_inq .= " ON";
	$sql_inq .= " (T1.company_id = T2.company_id)";
	$sql_inq .= " LEFT JOIN";
	$sql_inq .= " mp_comp T3";
	$sql_inq .= " ON";
	$sql_inq .= " (T1.contract_id = T3.contract_id)";
	$sql_inq .= " WHERE";
	$sql_inq .= " T1.service_type = " . $mp_column_type['mm_contract']['service_type'];
	$sql_inq .= " and T1.del_flg <>" . $mp_column_type['mm_contract']['del_flg'];

	$prm = array();
	$sql_inqm = createSQL($sql_inq,array(
		1164,1
	));
	//SQLを実行
	// echo $sql_inqm;
	$result_inq = ExecSQL($sql_inqm,null);
	while ($arr_user = mysql_fetch_assoc($result_inq[0])) {
		$mp_data[company_name][$arr_user[contract_id]] = cmp($arr_user['c_type'],$arr_user['company_name']);
		$mp_data[service_name][$arr_user[contract_id]] = $arr_user[service_name];
	}*/

// var_dump($mp_data);

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

	$sql_inq_comp = "SELECT";
	$sql_inq_comp .= " *";
	$sql_inq_comp .= " FROM";
	$sql_inq_comp .= " inquery";
	$sql_inq_comp .= " WHERE";
	$sql_inq_comp .= " inquery_id > '0'";
	$sql_inq_comp .= " AND site_type = '" . $_REQUEST[site_type] . "'";
	if (!empty($_SESSION[start_date])) {
			$sql_inq_comp .= " AND inquery_date >= '" . $_SESSION[start_date] . " 0:00:00'";
	}
	if (!empty($_SESSION[end_date])) {
			$sql_inq_comp .= " AND inquery_date <= '" . $_SESSION[end_date] . " 23:59:59'";
	}

	if ($_REQUEST[request_type] == "uu") {
		$sql_inq_comp .= " group by email";
	}

	$sql_inq_comp .= " order by inquery_date desc";
	// echo $sql_inq_comp;

	//$result_inq_comp = mysql_query ($sql_inq_comp);
	//$row_num_inq_comp = mysql_num_rows ($result_inq_comp);
	$stmt = $pdo -> prepare($sql_inq_comp);
	$stmt->execute();
	$row_num_inq_comp=$stmt->rowCount();
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

<table class="Tblform_ret">
<tr>
	<th>期間</th>
	<td><?php echo $_SESSION[start_date]; ?> ～<?php echo $_SESSION[end_date]; ?></td>
</tr>
</table>

<strong class="fcRedb"><?php echo $row_num_inq_comp; ?></strong>件中／<?php echo $dis_a; ?> - <?php echo $dis_b; ?>件表示　<a href="dl.php?site_type=<?php echo $_REQUEST[site_type]; ?>&request_type=<?php echo $_REQUEST[request_type]; ?>" target="_blank">CSVダウンロード</a>

<table class="Tblform_ret">
<tr>
	<th style="width:12%;">お問合せ日時</th>
	<th style="width:23%;">会社名</th>
	<!-- <th style="width:13%;">お問合せ経路</th> -->
<?php if ($_REQUEST[site_type] == "contact" OR $_REQUEST[site_type] == "request"): ?>
	<th style="width:32%;">お問合せ種別</th>
<?php endif ?>
<?php if ($_REQUEST[site_type] == "wpdl"): ?>
	<th style="width:32%;">ダウンロード資料</th>
<?php endif ?>
</tr>
<?php
	$page_no_cnt = ceil($row_num_inq_comp / $page_view);
	$sql_inq_comp .= " LIMIT " . $page_view;
	$sql_inq_comp .= " OFFSET " . $offset;
	$stmt = $pdo -> prepare($sql_inq_comp);
	
	//SQLの実行
	$stmt->execute();
	//件数の取得
	//$row_num_dl = $stmt->rowCount();
	//$result_inq_comp = mysql_query ($sql_inq_comp);
	while ($PG_REC_MAT = $stmt->fetch(PDO::FETCH_ASSOC)) {
	//while ($PG_REC_MAT = mysql_fetch_assoc($result_inq_comp)) {
		echo "<tr>\n";
		// お問合わせ日時
		echo "	<td style=\"text-align:center;\">" . $PG_REC_MAT[inquery_date] . "</td>\n";
		// 会社名
		echo "	<td><a href=\"?t=".time()."&type=details&inquery_id=".$PG_REC_MAT[inquery_id]."&k=1&site_type=" . $_REQUEST[site_type] . "&request_type=" . $_REQUEST[request_type] . "\">" . $PG_REC_MAT[company_name] . "</a></td>\n";

		// 三列目---お問合わせ種別(site_type===contact)
		if ($_REQUEST['site_type'] == "contact") {
				echo "	<td>" . $PG_REC_MAT['contact_kind'] . "</td>\n";
		}elseif($_REQUEST['site_type'] == "request") {
				echo "	<td>" . $PG_REC_MAT['contact_kind2'] . "</td>\n";

		// ダウンロード資料を表示する場合(site_type===wpdl)
		}elseif($_REQUEST[site_type] == "wpdl") {
				echo "	<td>" . $PG_REC_MAT[material_name] . "</td>\n";
		}

		echo "</tr>\n";
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
<a href="<?php echo $now_page; ?>?t=<?php echo time(); ?>&page=<?php echo $b_page; ?>&act=list&dis=1&site_type=<?php echo $_REQUEST[site_type]; ?>&request_type=<?php echo $_REQUEST[request_type]; ?>">←前の<?php echo $page_view; ?>件</a>
<?php } ?>
</td>
<td style="width:360px;text-align:center;">
<?
		if($row_num_inq_comp > $page_view){
			for ($i=0; $i<$page_no_cnt; $i++) {
				$page_no = $i + 1;
				if($page_no != $_SESSION[page]){
					echo "<a href=\"$now_page?t=".time()."&page=$page_no&act=list&dis=1&site_type=" . $_REQUEST[site_type] . "&request_type=" . $_REQUEST[request_type] . "\">";
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
<a href="<?php echo $now_page; ?>?t=<?php echo time(); ?>&page=<?php echo $n_page; ?>&act=list&dis=1&site_type=<?php echo $_REQUEST[site_type]; ?>&request_type=<?php echo $_REQUEST[request_type]; ?>">→次の<?php echo $page_view; ?>件</a>
<?php } ?>
</td>
</tr>
</table>

</div><!-- contents -->

<?
}
/*リード確認画面********************************************************************************/
if($_POST[act] == "details"){

	$sql_inq_comp = "SELECT";
	$sql_inq_comp .= " *";
	$sql_inq_comp .= " FROM";
	$sql_inq_comp .= " inquery";
	$sql_inq_comp .= " WHERE";
	$sql_inq_comp .= " inquery_id = '" . $_REQUEST[inquery_id] . "'";
	$stmt = $pdo -> prepare($sql_inq_comp);
	
	//SQLの実行
	$stmt->execute();
	//件数の取得
	$row_num_user = $stmt->rowCount();
	$tm_dl_user = $stmt->fetch(PDO::FETCH_ASSOC);
	//$result_user = mysql_query ($sql_inq_comp);
	//$row_num_user = mysql_num_rows ($result_user);
	//$tm_dl_user = mysql_fetch_assoc($result_user);

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
	<? echo $tm_dl_user['inquery_date']; ?>
	</td>
</tr>
<?php if ($_REQUEST['site_type'] == "contact"): ?>
	<tr>
		<th>お問合せ種別</th>
		<td>
		<? echo $tm_dl_user['contact_kind']; ?>
		</td>
	</tr>
<?php endif ?>
<?php if ($_REQUEST['site_type'] == "request"): ?>
	<tr>
		<th>お問合せ種別</th>
		<td>
		<? echo $tm_dl_user['contact_kind2']; ?>
		</td>
	</tr>
<?php endif ?>
<?php if ($_REQUEST['site_type'] == "wpdl"): ?>
	<tr>
		<th>ダウンロードした資料</th>
		<td>
		<? echo $tm_dl_user['material_name']; ?>
		</td>
	</tr>
<?php endif ?>
<?php if ($_REQUEST['site_type'] == "contact" OR $_REQUEST['site_type'] == "request"): ?>
	<tr>
		<th>興味・関心のあるサービス</th>
		<td>
		<? echo $tm_dl_user['service']; ?>
		</td>
	</tr>
<?php endif ?>
<tr>
	<th>会社名</th>
	<td>
	<? echo $tm_dl_user['company_name']; ?>
	</td>
</tr>
<tr>
	<th>部署名</th>
	<td>
	<? echo $tm_dl_user['division']; ?>
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
	<th>メールアドレス</th>
	<td>
	<? echo $tm_dl_user[email]; ?>
	</td>
</tr>
<tr>
	<th>あなたの立場をお聞かせ下さい。</th>
	<td>
		<?php echo $tm_dl_user['standpoint']; ?>
	</td>
</tr>
<?php if ($_REQUEST['site_type'] == "wpdl"): ?>
	<tr>
		<th>御社のご状況をお聞かせください。</th>
		<td>
		<? echo $tm_dl_user['status']; ?>
		</td>
	</tr>
	<tr>
		<th>詳細説明</th>
		<td>
		<? echo $tm_dl_user['detail_caption']; ?>
		</td>
	</tr>
<?php endif ?>
<?php if ($_REQUEST['site_type'] == "contact" OR $_REQUEST['site_type'] == "request"): ?>
	<tr>
		<th>お問合せ内容</th>
		<td>
		<? echo $tm_dl_user['comment']; ?>
		</td>
	</tr>
<?php endif ?>
<?php
	/*$sql_inq_comp = "SELECT";
	$sql_inq_comp .= " *";
	$sql_inq_comp .= " FROM";
	$sql_inq_comp .= " mkcd_inquery_anq";
	$sql_inq_comp .= " WHERE";
	$sql_inq_comp .= " inquery_no = '" . $_REQUEST[inquery_no] . "'";
	if ($_REQUEST[site_type] == "contact") {
		$sql_inq_comp .= " and  anq_title <> 'お問合せ種別'";
	}
	$sql_inq_comp .= " order by inquery_anq_no";
	$result_user = mysql_query ($sql_inq_comp);
	$row_num_user = mysql_num_rows ($result_user);
	while ($tm_dl_user = mysql_fetch_assoc($result_user)) {
		echo "<tr>\n";
		echo "<th>" . $tm_dl_user[anq_title] . "</th>\n";
		echo "<td>" . $tm_dl_user[anq] . "</td>\n";
		echo "</tr>\n";
	}*/
 ?>
</table>


<div class="btn">

<form action="<?php echo $now_page; ?>?t=<?php echo time(); ?>" method="post">
<p><input type="submit" value="&nbsp;一覧へ戻る&nbsp;" class="submit01" /></p>
<input type="hidden" name="site_type" value="<?php echo $_REQUEST[site_type]; ?>">
<input type="hidden" name="request_type" value="<?php echo $_REQUEST[request_type]; ?>">
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
