<?php
/*ファイルの読み込み*/
require ("../../../include/dbconn.php");
include ("../../../include/convert.php");
include ("../../../include/list.php");
include("../include/header.php");

// 資料種別
$blog_type = "blog";
$_POST['item_l_no'] = "1";

$fontsize_min = 12;
$fontsize_max = 25;
//ページタイトル
$main_title = "News";
//添付ファイル数


//表示・非表示を切り替える
if($_REQUEST['act'] == "dis"){

	$sql = "UPDATE news SET";
	$sql .= " ".$_REQUEST['column_name']." = :column_name";
	$sql .= " WHERE news_no = :news_no";

	$stmt = $pdo -> prepare($sql);
	$stmt->bindParam(':column_name', $_REQUEST['column_value'], PDO::PARAM_STR);
	$stmt->bindValue(':news_no', $_REQUEST['key_no'], PDO::PARAM_INT);
	$stmt->execute();

	$_POST['act'] = "";

}

if($_POST['act'] == ""){
	$_POST['act'] = "list";
}
if($_POST['act'] == "list"){
	$_POST['type'] = "";
}
//-----------------------------------------------------------------------------------------//
//一覧画面からの各処理
//-----------------------------------------------------------------------------------------//
if($_POST['act2'] == "1"){

	$now_date = date("Y/m/d", time());
	$now_time = date("H:i:s", time());

	foreach($_POST as $key => $value){
		$key_no = array();
		$key_no = SplitChar($key,":");
		if($key_no[0] == "add"){//新規登録
			$_POST['act'] = "add";
			$_POST['type'] = "regist";
			break;
		}
		if($key_no[0] == "upd"){//変更
			$_POST['act'] = "add";
			$_POST['type'] = "upd";
			break;
		}
		if($key_no[0] == "del"){//削除
			$_POST['act'] = "conf";
			$_POST['type'] = "del";
			break;
		}
	}

	//変更・削除時の企業情報取得
	if($_POST['type'] == "upd" or $_POST['type'] == "del"){

		$sql_updl = "SELECT";
		$sql_updl .= " *";
		$sql_updl .= " FROM";
		$sql_updl .= " news";
		$sql_updl .= " WHERE";
		$sql_updl .= " news_no = ".$key_no[1];

		//パラメーター配列の初期化
		$prm = array();
		// $prm[] = $key_no[1];

		//パラメーターを使いSQLの作成
		$sql = createSQL($sql_updl,$prm);

		$stmt = $pdo->query($sql);
		if (!$stmt) {
			$info = $pdo->errorInfo();
			exit($info[2]);
		}

		$arr_updl = $stmt->fetch(PDO::FETCH_ASSOC);

		$_POST['news_no'] = $arr_updl['news_no'];
		$_POST['title'] = Br2Nr($arr_updl['title']);
		$_POST['url'] = Br2Nr($arr_updl['url']);
		$_POST['category'] = explode(",", $arr_updl['category']);
		$_POST['comment'] = Br2Nr($arr_updl['comment']);
		$_POST['news_date'] = $arr_updl['news_date'];
		$_POST['keywords'] = preg_replace("/,/","\n",$arr_updl['keywords']);
		$_POST['description'] = $arr_updl['description'];
	}
}


//-----------------------------------------------------------------------------------------//
//入力チェック・画像処理
//-----------------------------------------------------------------------------------------//
if($_POST['act'] == "conf"){

	//入力チェック
//	$err_mess[] = SelectChk($_POST[tm_user],"担当者");
//	$err_mess[] = InputChk($_POST[end_date],"終了日");
//	$err_mess[] = InputChk($_POST[title],"タイトル");


	//エラーチェック
	foreach((array)$err_mess as $err_key){
		if($err_key != ""){
			$_POST['act'] = "err";
			break;
		}
	}

}
/*キーの設定*/
$act_type_key = $_POST['act']."_".$_POST['type'];
//-----------------------------------------------------------------------------------------//
//検索・一覧画面
//-----------------------------------------------------------------------------------------//
if($_POST['act'] == "list"){
	if($_REQUEST['ret_del'] == "1"){
		$_SESSION['sys']['management_p']['job'] = "";
	}
	//1ページに表示する件数
	$page_view = 20;
	if($_POST['ret'] == "1"){
		$_SESSION['sys']['management_p']['job']['page'] = "1";
	}
	if ($_SESSION['sys']['management_p']['job']['page'] == "") { $_SESSION['sys']['management_p']['job']['page'] = 1; }
	if($_REQUEST[dis] == "1"){
		$_SESSION['sys']['management_p']['job']['page'] = $_REQUEST['page'];
	}else{
		$_SESSION['sys']['management_p']['job']['page'] = 1;
	}
	$base_page = $_SESSION['sys']['management_p']['job']['page'];

	if($base_page == 1){
		$offset = 0;
	}else{
		$offset_key = $base_page - 1;
		$offset = $offset_key * $page_view;
	}
	/*ファイル数の取得*/
	$sql = "SELECT";
	$sql .= " *";
	$sql .= " FROM";
	$sql .= " news";
	$sql .= " WHERE";
	$sql .= " del_flg = 0";
	$sql .= " ORDER BY news_date DESC";

	//パラメーター配列の初期化
	$prm = array();
	// $prm[] = '0';

	//パラメーターを使いSQLの作成
	$sql_mat_num = createSQL($sql,$prm);

	//SQLを実行
	// $result_mat_num = ExecSQL($sql_mat_num,null);

$stmt = $pdo->query($sql_mat_num);
$stmt->execute();

$row_num_inq_comp=$stmt->rowCount();
if (!$stmt) {
	$info = $pdo->errorInfo();
	exit($info[2]);
}


	if($base_page == "1"){
		$dis_a = 1;
		if($row_num_inq_comp < $page_view){
			$dis_b = $row_num_inq_comp;
		}else{
			$dis_b = $page_view;
		}
	}else{
		$dis_b_key = $base_page * $page_view;
		$dis_a = (($base_page - 1) * $page_view) + 1;
		if($row_num_inq_comp < $dis_b_key){
			$dis_b = $row_num_inq_comp;
		}else{
			$dis_b = $dis_b_key;
		}
	}
?>
<div id="contents">

<h2><?php echo $main_title; ?>一覧</h2>
<p class="stext">
修正・変更をされたい場合は「更新」ボタンをクリックして下さい。<br />
削除をされたい場合は「削除」ボタンをクリックして下さい。(削除確認画面が表示されます）
</p>

<strong class="fcRedb"><?php echo $row_num_inq_comp; ?></strong>件中／<?php echo $dis_a; ?> - <?php echo $dis_b; ?>件表示

<form action="<?php echo $now_page; ?>?t=<?php echo time(); ?>" method="post">

<table class="Tblform_ret">
<tr>
	<th style="width:12%;">日時</th>
	<th>タイトル</th>
	<th style="width:6%;">掲載</th>
	<th style="width:8%;"></th>
	<th style="width:8%;"></th>
</tr>
<?php
	$page_no_cnt = ceil($row_num_inq_comp / $page_view);
	$sql .= " LIMIT " . $page_view;
	$sql .= " OFFSET " . $offset;

	// $prm[] = $page_view;
	// $prm[] = $offset;

	//パラメーターを使いSQLの作成
	$sql_mat_num = createSQL($sql,$prm);
	// echo $sql_mat_num;
	//SQLを実行
	// $result_mat_num = ExecSQL($sql_mat_num,null);

$stmt = $pdo->query($sql_mat_num);
$stmt->execute();
if (!$stmt) {
	$info = $pdo->errorInfo();
	exit($info[2]);
}


	while ($PG_REC_MAT = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$link_a = "";
		$link_b = "";
		if (!empty($PG_REC_MAT[url])) {
			$link_a = "<a href=\"" . $PG_REC_MAT[url] . "\" target=\"_blank\">";
			$link_b = "</a>";
		} else {
			if (!empty($PG_REC_MAT[comment])) {
				$link_a = "<a href=\"/news_detail.php?n_no=".$PG_REC_MAT['news_no']."&mode=test\" target=\"_blank\">";
				$link_b = "</a>";
			}
		}
		echo "<tr>\n";
		echo "	<td>" . $PG_REC_MAT['news_date'] . "</td>\n";
		echo "	<td>";
		echo "	<p>" . $link_a . $PG_REC_MAT['title'] . $link_b . "</p>";
		echo "</td>\n";
		echo "	<td style=\"text-align:center;\">\n";
		if($PG_REC_MAT['display_flg'] == "open"){
			echo "<a href=\"".$now_page."?t=".time()."&act=dis&column_name=display_flg&column_value=close&key_no=".$PG_REC_MAT['news_no']."\" onClick=\"if( !confirm('非掲載にしますか？') ) { return false; }\">○</a>";
		}else{
			echo "<a href=\"".$now_page."?t=".time()."&act=dis&column_name=display_flg&column_value=open&key_no=".$PG_REC_MAT['news_no']."\" onClick=\"if( !confirm('掲載しますか？') ) { return false; }\">×</a>";
		}
		echo "</td>\n";
		echo "	<td style=\"text-align:center;\">\n";
		echo "	<input type=\"submit\" name=\"upd:".$PG_REC_MAT['news_no']."\" class=\"submit01\" value=\"更新\">\n";
		echo "	</td>\n";
		echo "	<td style=\"text-align:center;\">\n";
		echo "	<input type=\"submit\" name=\"del:".$PG_REC_MAT['news_no']."\" value=\"削除\" class=\"submit01\">\n";
		echo "	</td>\n";
		echo "</tr>\n";
	}
?>
</table>

<table style="width:500px;margin:0 auto 20px;">
<tr><td align="center">
<?php

$page_st = $base_page - 5;

$page_ed = $base_page + 5;

if ($page_st < 0) {
	$page_st = 0;
	$page_ed = 10;
}

if ($page_no_cnt < $page_ed) {
	$page_ed = $page_no_cnt;
	$page_st = $page_no_cnt - 9;
	if($page_st < 0){
		$page_st = "0";
	}
}

if ($page_st > 0) {
	echo "		&nbsp;<a href=\"".$now_page."?t=" . time() . "&page=1&dis=1\"><< 先頭へ</a>\n";
}

if ($base_page > 1) {
	$b_page = $base_page - 1;
	echo "		&nbsp;<a href=\"".$now_page."?t=" . time() . "&page=" . $b_page . "&dis=1\">< 前へ</a>\n";
}

if($row_num_inq_comp > $page_view){
	//for ($i=0; $i<$page_no_cnt; $i++) {
	for ($i=$page_st; $i<$page_ed; $i++) {
		$page_no = $i + 1;
		if ($page_no != $base_page) {
			echo "&nbsp;<a href=\"".$now_page."?t=" . time() . "&page=" . $page_no . "&dis=1\">" . $page_no . "</a>";
		}else{
			echo "&nbsp;" . $page_no;
		}
	}
}


//最後のページの場合は非表示-->
if ($page_no_cnt > $base_page) {
	$n_page = $base_page + 1;
	echo "		&nbsp;<a href=\"".$now_page."?t=" . time() . "&page=" . $n_page . "&dis=1\">次へ ></a>\n";
}

if ($page_no_cnt != $page_ed) {
	echo "		&nbsp;<a href=\"".$now_page."?t=" . time() . "&page=" . $page_no_cnt . "&dis=1\">最後 >></a>\n";
}
?>

</td>
</tr>
</table>

<div class="formbtn">
<p class="grn"><button type="submit" name="add">新規登録はこちら</button></p>
</div>
<input type="hidden" name="act2" value="1">
</form>

</div><!-- contents -->

<?php
}
//-----------------------------------------------------------------------------------------//
//登録画面
//-----------------------------------------------------------------------------------------//
if($_POST['act'] == "add" or $_POST['act'] == "err"){
	if (empty($_POST['news_date'])) {
		$_POST['news_date'] = date("Y-m-d", time());
	}
?>

<div id="contents">

<h2><?php echo $main_title; ?><?php echo $page_title_sub_list[$act_type_key]; ?></h2>
<p class="stext">下記項目を記入の上、「<?php echo $type_comment_list[$act_type_key]; ?>」ボタンをクリックしてください。<br />
（※は入力必須項目です）<br />
登録後、当社担当者が内容確認の上本掲載をさせていただきます。
</p>
<?php
	if($_POST['act'] == "err"){
		echo "<p style=\"color:#990000;\">".Arr2Val($err_mess)."</p>";
		echo $err_count;
	}
?>

<script type="text/javascript">
	$(function(){
		// フォントサイズ
		$(".subbtn_font_size").click(function(){
			var svalue = $(this).parents("td").find("#f_size").val();
			var selectvalue = "";
			if(svalue > 0){
				selectvalue = "font-size:"+svalue+"px;";
			}
			if(document.all){ //IE
				var str=document.selection.createRange().text;
				document.selection.createRange().text="<span style='" + selectvalue + "'>" + str + "</span>";
			} else { //Firefox
				var el=$(this).parents("td").find("#box").get(0);
				var sPos = el.selectionStart;
				var ePos = el.selectionEnd;
				var str = el.value.substring(sPos, ePos);
				el.value =
				el.value.substring(0, sPos) +
				"<span style='" + selectvalue + "'>" + str + "</span>" +
				el.value.substr(ePos);
			}
		});

		// フォントカラー
		$(".subbtn_font_color").click(function(){
			var svalue = $(this).parents("td").find("#color").val();

			if(document.all){ //IE
				var str=document.selection.createRange().text;
				document.selection.createRange().text="<span style='color:#" + svalue + "'>" + str + "</span>";
			} else { //Firefox
				var el=$(this).parents("td").find("#box").get(0);
				var sPos = el.selectionStart;
				var ePos = el.selectionEnd;
				var str = el.value.substring(sPos, ePos);
				el.value =
				el.value.substring(0, sPos) +
				"<span style='color:#" + svalue + "'>" + str + "</span>" +
				el.value.substr(ePos);
			}
		});

		// 太字
		$(".subbtn_bold").click(function(){
			if(document.all){ //IE
				var str=document.selection.createRange().text;
				document.selection.createRange().text="<span style=font-weight:bold;>" + str + "</span>";
			} else { //Firefox
				var el=$(this).parents("td").find("#box").get(0);
				var sPos = el.selectionStart;
				var ePos = el.selectionEnd;
				var str = el.value.substring(sPos, ePos);
				el.value =
				el.value.substring(0, sPos) +
				"<span style=font-weight:bold;>" + str + "</span>" +
				el.value.substr(ePos);
			}
		});

		// リンク
		$(".subbtn_ank").click(function(){
			var link_text = $(this).parents("td").find("#ank_txt").val();
			var svalue = $(this).parents("td").find("#l_type").val();
			var selectvalue = "";
			if(svalue == 2){
				selectvalue = " target='_blank'";
			}
			if(document.all){ //IE
				var str=document.selection.createRange().text;
				document.selection.createRange().text="<a href='" + link_text + "'" + selectvalue + ">" + str + "</a>";
			} else { //Firefox
				var el=$(this).parents("td").find("#box").get(0);
				var sPos = el.selectionStart;
				var ePos = el.selectionEnd;
				var str = el.value.substring(sPos, ePos);
				el.value =
				el.value.substring(0, sPos) +
				"<a href='" + link_text + "'" + selectvalue + ">" + str + "</a>" +
				el.value.substr(ePos);
			}
		});


	});

</script>

<form action="<?php echo $now_page; ?>?t=<?php echo time(); ?>" method="post" name="FORM1" enctype="multipart/form-data">
<table class="Tblform">
<tr>
	<th>日時<span>※</span></th>
	<td>
<input type="text" name="news_date" value="<?php echo $_POST['news_date']; ?>" size="15" id="calender_1">
	</td>
</tr>
<tr>
	<th>タイトル<span>※</span></th>
	<td>

<textarea name="title" cols="60" rows="5" class="form_color_r"><?php echo $_POST['title']; ?></textarea>
	</td>
</tr>
<tr>
	<th>URL</th>
	<td>
		<input type="text" name="url" value="<?php echo $_POST['url']; ?>" size="70">
	</td>
</tr>
<tr>
	<th>カテゴリ<span>※</span></th>
	<td class="tag_style">
<?php
foreach ($item_list['news_category'] as $key => $value) {
	$ckecked ="";
	$clss_ckecked ="";
	if (in_array($key, (array)$_POST[category])) {
		$clss_ckecked ="selected";
		$ckecked =" checked";
	}
?>
<input type="checkbox" name="category[]" id="category<?php echo $key; ?>" value="<?php echo $key; ?>"<?php echo $ckecked; ?> /><label for="category<?php echo $key; ?>" class="<?php echo $clss_ckecked; ?>"><?php echo $value; ?></label>
<?php
}
?>
	</td>
</tr>
<tr>
	<th>本文</th>
	<td>
<p style="margin-bottom:5px;">
<input type="button" value="太字" class="subbtn subbtn_bold">
　URL：<input type="text" name="ank_txt" id="ank_txt" size="40">
<select id="l_type" name="linktype">
<option value="1">通常リンク
<option value="2">外部リンク
</select>
<input type="button" value="リンク" class="subbtn subbtn_ank">
</p>

<p style="margin-bottom:5px;">
　文字サイズ：
<select id="f_size" name="font_size">
<?php
for($f = $fontsize_min;$f <= $fontsize_max;$f++){
	echo "<option value=\"".$f."\">".$f."px\n";
}
?>
</select>
<input type="button" value="文字サイズ" class="subbtn subbtn_font_size">

<input type="text" class="color" id="color" name="color0" /><input type="button" value="フォントカラー"
 class="subbtn subbtn_font_color">
</p>

<textarea name="comment" cols="60" rows="5" class="form_color_r" id="box"><?php echo $_POST['comment']; ?></textarea>

	</td>
</tr>
<tr>
	<th>meta description</th>
	<td>
		<textarea name="description" cols="60" rows="5" class="form_color_r"><?php echo $_POST[description]; ?></textarea>
	</td>
</tr>
<tr>
	<th>meta keywords</th>
	<td>
		<textarea name="keywords" cols="60" rows="5" class="form_color_r"><?php echo $_POST[keywords]; ?></textarea>
		<br /><span style="color:#ff0000;">※ワード毎に改行して下さい。</span>
	</td>
</tr>
</table>

	<div class="formbtn">
		<span><p class="gr"><button type="button" onClick="location.href='<?php echo $now_page; ?>?t=<?php echo time(); ?>'" name="btn1">一覧ページにもどる</button></p></span>

		<span><p class="grn"><button type="submit" name="btn2">登録内容を確認する</button></p></span>
		<input type="hidden" name="act" value="conf">
		<input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">
<?php
	if($_POST['type'] == "upd"){
		echo "<input type=\"hidden\" name=\"news_no\" value=\"".$_POST['news_no']."\">";
	}
?>
		</form>
	</div>


</div><!-- contents -->
<?php
}
//-----------------------------------------------------------------------------------------//
//確認画面
//-----------------------------------------------------------------------------------------//
if($_POST['act'] == "conf"){
// var_dump($_POST);
?>
<div id="contents">

<h2><?php echo $main_title; ?><?php echo $page_title_sub_list[$act_type_key]; ?></h2>
<p class="stext">登録内容を確認の上、「<?php echo $type_comment_list[$act_type_key]; ?>」ボタンをクリックしてください。
</p>

<table class="Tblform">
<tr>
	<th>日時</th>
	<td><?php echo $_POST['news_date']; ?></td>
</tr>
<tr>
	<th>タイトル</th>
	<td><?php echo $_POST['title']; ?></td>
</tr>
<tr>
	<th>URL</th>
	<td><?php echo $_POST['url']; ?></td>
</tr>
<tr>
	<th>カテゴリ<span>※</span></th>
	<td>
<?php
foreach ((array)$_POST['category'] as $value) {
	echo $item_list['news_category'][$value] . "<br />";
}
?>
</tr>
<tr>
	<th>本文</th>
	<td><?php echo Nr2Br($_POST['comment']); ?></td>
</tr>
<tr>
	<th>meta description</th>
	<td><?php echo NrDel($_POST['description']); ?></td>
</tr>
<tr>
	<th>meta keywords</th>
	<td><?php echo NrDel(preg_replace("/\n/",",",$_POST['keywords'])); ?></td>
</tr>

</table>

			<div class="formbtn">
				<form id="regist_form" name="regist_form" action="<?php echo $now_page; ?>" method="post">
				<p class="gr"><button type="submit">前のページにもどる</button></p>
<input type="hidden" name="act" value="add">
<?php
	$arr_leave_out = array("act","del","act2");
	echo HiddenView($arr_leave_out);
?>
				</form>
				<form id="regist_form" name="regist_form" action="<?php echo $now_page; ?>" method="post">
				<p class="grn"><button type="submit">完了画面へ</button></p>
			<input type="hidden" name="act" value="end">
<?php
	$arr_leave_out = array("act","del","act2");
	echo HiddenView($arr_leave_out);
?>
				</form>
			</div>

</div><!-- contents -->
<?php
}
//-----------------------------------------------------------------------------------------//
//完了画面
//-----------------------------------------------------------------------------------------//
if($_POST['act'] == "end"){

	//現在日付を取得
	$now_date_time = date("Y/m/d H:i:s", time());

	if($_POST[type] == "regist"){

		//SQLを作成
		$sql = "INSERT INTO news (";
		$sql .= " news_date";
		$sql .= ",title";
		$sql .= ",category";
		$sql .= ",url";
		$sql .= ",comment";
		$sql .= ",description";
		$sql .= ",keywords";
		$sql .= ",add_date";
		$sql .= ",upd_date";
		$sql .= ") VALUES (";
		$sql .= " :news_date";
		$sql .= ",:title";
		$sql .= ",:category";
		$sql .= ",:url";
		$sql .= ",:comment";
		$sql .= ",:description";
		$sql .= ",:keywords";
		$sql .= ",:add_date";
		$sql .= ",:upd_date";
		$sql .= ")";


		$stmt = $pdo -> prepare($sql);
		$stmt->bindParam(':news_date', $_POST['news_date'], PDO::PARAM_STR);
		$stmt->bindParam(':title', Nr2Br($_POST['title']), PDO::PARAM_STR);
		$stmt->bindParam(':category', implode(",", $_POST['category']), PDO::PARAM_STR);
		$stmt->bindParam(':url', $_POST['url'], PDO::PARAM_STR);
		$stmt->bindParam(':comment', Nr2Br($_POST['comment']), PDO::PARAM_STR);
		$stmt->bindParam(':description', NrDel($_POST[description]), PDO::PARAM_STR);
		$stmt->bindParam(':keywords', NrDel(preg_replace("/\n/",",",$_POST[keywords])), PDO::PARAM_STR);
		$stmt->bindParam(':add_date', $now_date_time, PDO::PARAM_STR);
		$stmt->bindParam(':upd_date', $now_date_time, PDO::PARAM_STR);

		$stmt->execute();

		// $_POST[blog_no] = $pdo->lastInsertId();
// echo $_POST[blog_no];
}
	if($_POST[type] == "upd"){//更新処理

		$sql = "UPDATE news SET";
		$sql .= " news_date = :news_date";
		$sql .= ",title = :title";
		$sql .= ",category = :category";
		$sql .= ",url = :url";
		$sql .= ",comment = :comment";
		$sql .= ",description = :description";
		$sql .= ",keywords = :keywords";
		$sql .= ",upd_date = :upd_date";
		$sql .= " WHERE news_no = :news_no";

		// echo $sql;

		$stmt = $pdo -> prepare($sql);
		$stmt->bindParam(':news_date', $_POST['news_date'], PDO::PARAM_STR);
		$stmt->bindParam(':title', Nr2Br($_POST['title']), PDO::PARAM_STR);
		$stmt->bindParam(':category', implode(",", $_POST['category']), PDO::PARAM_STR);
		$stmt->bindParam(':url', $_POST['url'], PDO::PARAM_STR);
		$stmt->bindParam(':comment', Nr2Br($_POST['comment']), PDO::PARAM_STR);
		$stmt->bindParam(':description', NrDel($_POST['description']), PDO::PARAM_STR);
		$stmt->bindParam(':keywords', NrDel(preg_replace("/\n/",",",$_POST['keywords'])), PDO::PARAM_STR);
		$stmt->bindParam(':upd_date', $now_date_time, PDO::PARAM_STR);
		$stmt->bindValue(':news_no', $_POST['news_no'], PDO::PARAM_INT);

		$stmt->execute();

	}


	if($_POST[type] == "del"){//削除処理

		$sql = "UPDATE news SET";
		$sql .= " del_flg = '1'";
		$sql .= " WHERE news_no = :news_no";

		$stmt = $pdo -> prepare($sql);
		$stmt->bindValue(':news_no', $_POST['news_no'], PDO::PARAM_INT);

		$stmt->execute();
	}
?>
<div id="contents">

<div class="thanks">
<?php
		echo $type_comment_list[$act_type_key] . "\n";
?>
</div>

<form action="<?php echo $now_page; ?>?t=<?php echo time(); ?>" method="post">
<div class="btn">
<input type="submit" value="&nbsp;一覧へ戻る&nbsp;" class="submit01" />
<input type="hidden" name="company_id" value="<?php echo $_POST[company_id] ?>">
</div>
</form>
<!-- thanks -->

</div><!-- contents -->


<?php
}
include("../include/footer.php");
?>

</div><!-- /wrapper -->

</body>
</html>
