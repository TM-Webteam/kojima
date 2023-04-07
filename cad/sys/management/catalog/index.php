<?php
/*ファイルの読み込み*/
require ("../../../include/dbconn.php");
include ("../../../include/convert.php");
include ("../../../include/list.php");
include("../include/header.php");

// 資料種別
$sql = "SELECT";
$sql .= " T1.*";
$sql .= ",T2.item_column_name";
$sql .= " FROM";
$sql .= " item_m T1";
$sql .= " LEFT JOIN";
$sql .= " item_l T2";
$sql .= " ON";
$sql .= " (T1.item_l_no = T2.item_l_no)";
$sql .= " WHERE";
$sql .= " T1.del_flg = '0'";
$sql .= " ORDER BY T1.item_l_no,T1.sort_no";

//パラメーター配列の初期化
$prm = array();
// $prm[] = '0';

//パラメーターを使いSQLの作成
$sql_mat_num = createSQL($sql,$prm);
// echo $sql_mat_num;
//SQLを実行
// $result = ExecSQL($sql_mat_num,null);

$stmt = $pdo->query($sql_mat_num);
if (!$stmt) {
	$info = $pdo->errorInfo();
	exit($info[2]);
}


while ($PG_REC_MAT = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$item_list[$PG_REC_MAT['item_column_name']][$PG_REC_MAT['item_m_no']] = $PG_REC_MAT['item_m_name'];
}


$fontsize_min = 12;
$fontsize_max = 25;
//ページタイトル
$main_title = "カタログ";
//添付ファイル数
$_POST['up_file_cnt'] = "3";
$upfile_title_list[1] = "資料画像１";
$upfile_title_list[2] = "資料画像２";
$upfile_title_list[3] = "ダウンロード資料";
$up_file_path = "../../../up_file/";
//ファイルアップロードタイトル


//表示・非表示を切り替える
if($_REQUEST['act'] == "dis"){

	$sql = "UPDATE material SET";
	$sql .= " ".$_REQUEST['column_name']." = :column_value";
	$sql .= " WHERE material_no = :material_no";

	$stmt = $pdo -> prepare($sql);
	$stmt->bindParam(':column_value', $_REQUEST['column_value'], PDO::PARAM_STR);
	$stmt->bindValue(':material_no', $_REQUEST['key_no'], PDO::PARAM_INT);
	$stmt->execute();

	$_POST['act'] = "";

}
if($_REQUEST['act'] == "top"){
	$_POST['act'] = "add";
	$_POST['type'] = "regist";
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
		$sql_updl .= " material";
		$sql_updl .= " WHERE";
		$sql_updl .= " material_no = :material_no";

		$stmt = $pdo -> prepare($sql_updl);
		$stmt->bindParam(':material_no', $key_no[1], PDO::PARAM_STR);

		$stmt->execute();
		if (!$stmt) {
			$info = $pdo->errorInfo();
			exit($info[2]);
		}

		$arr_updl = $stmt->fetch(PDO::FETCH_ASSOC);


		$_POST['material_no'] = $arr_updl['material_no'];
		$_POST['title'] = Br2Nr($arr_updl['title']);
		$_POST['sub_title'] = Br2Nr($arr_updl['sub_title']);
		$_POST['copy'] = Br2Nr($arr_updl['copy']);
		$_POST['comment'] = Br2Nr($arr_updl['comment']);
		$_POST['material_category'] = $arr_updl['material_category'];
		$_POST['genre'] = explode(",",$arr_updl['genre']);
		$_POST['needs'] = explode(",",$arr_updl['needs']);
		$_POST['genre_recommend'] = explode(",",$arr_updl['genre_recommend']);
		$_POST['needs_recommend'] = explode(",",$arr_updl['needs_recommend']);
		$_POST['contents1_title'] = Br2Nr($arr_updl['contents1_title']);
		$_POST['contents1_comment'] = Br2Nr($arr_updl['contents1_comment']);
		$_POST['contents2_title'] = Br2Nr($arr_updl['contents2_title']);
		$_POST['contents2_comment'] = Br2Nr($arr_updl['contents2_comment']);
		$_POST['material_toc1'] = Br2Nr($arr_updl['material_toc1']);
		$_POST['up_file1'] = $arr_updl['up_file1'];
		$_POST['up_file2'] = $arr_updl['up_file2'];
		$_POST['up_file3'] = $arr_updl['up_file3'];
		$_POST['file_name'] = $arr_updl['file_name'];
		$_POST['keywords'] = preg_replace("/,/","\n",$arr_updl['keywords']);
		$_POST['description'] = $arr_updl['description'];

	}
}

//-----------------------------------------------------------------------------------------//
//入力チェック・画像処理
//-----------------------------------------------------------------------------------------//
if($_POST['act'] == "conf"){

	$err_mess = array();
	$up_name = date( "YmdHis", time() );

	//入力チェック
	// $err_mess[] = SelectChk($_POST['genre'],"ジャンル");
	$err_mess[] = InputChk($_POST['title'],"資料タイトル");

	// ダウンロード資料名の半角とアンダーバーチェック------------------------------------------------
	if (!preg_match("/^[a-zA-Z0-9_]+$/",$_POST['file_name'])) {
		$err_mess[] = "ダウンロード資料名の項目は半角英数字かアンダーバーで入力してください<br>\n";
	}
	foreach((array)$err_mess as $err_key){
		if($err_key != ""){
			$_POST['act'] = "err";
			break;
		}
	}

	// エラーがゼロのとき実行
	if($_POST['act'] == "conf"){
		// ファイル情報
		for($i = 1;$i <= $_POST['up_file_cnt'];$i++){
			$up_file_key = "up_file".$i;
			$upfile_key = "upfile".$i;
			$up_file_del_key = "up_file_del".$i;
			// サーバー上から取得
			$up_file_name = $_FILES[$upfile_key]["name"];
			$up_file_size = $_FILES[$upfile_key]["size"];
			// 分割
			$up_image_t = explode(".", $up_file_name);
			// ファイルの拡張子の取得
			$up_file_type = $up_image_t[1];
			// ファイル名の取得
			$image_name1 = $up_image_t[0];

				// ダウンロード資料のみファイル名変更
				if($upfile_key == "upfile3"){
					$image_name1 = $_POST['file_name'];
					//更新のときはエラーチェックは無し。
					if($_POST['type'] != "upd"){
						// アップロードするファイル名
						$fname = $_POST['file_name'] . "." . $up_file_type;
						// 存在を確認するファイルへのパス
						$upf_dir = '../../../up_file/'.$fname;
						// ファイルのエラーチェック
						if(file_exists($upf_dir)){
							$err_mess[] = "${fname}という名の資料は既に存在します、資料名を変更してください<br>\n";
						}
					}

				}else{
					$image_name1 = $up_name."_".$i;
				}

				// ファイルを削除がチェックされた場合はunlinkファイル削除
				if($_POST[$up_file_del_key] != "" AND $_POST['act'] == "conf"){
					$del_path = $up_file_path . $_POST[$up_file_key];
					unlink($del_path);
					$_POST[$up_file_key] = "";
				}
				// エラーがあった場合
				if($err_mess != ""){
					foreach($err_mess as $err_key){
						if($err_key != ""){
							$_POST['act'] = "err";
							$_POST['type'] = "regist";
							break;
						}
					}
				}
				// サーバにファイルが存在するかどうか確認してファイルをアップロード
				// if($_POST['act'] == "conf" AND $up_file_name != "" AND $err_mess == ""){
				if($_POST['act'] == "conf" AND $up_file_name != ""){
					if($_POST[$up_file_key] != ""){
						//
						$del_path = $up_file_path.$_POST[$up_file_key];
						unlink($del_path);
						$_POST[$up_file_key] = "";
					}
					$up_image1 = $up_file_path.$image_name1;
					$type = array("xls","ppt","pdf","doc");
					$ret = UpFileCnv($upfile_key,$up_image1,"","",$image_name1);
					$err_mess[] = $ret['err_mess'];
					if ($ret['file_name']) { $_POST[$up_file_key] = $ret['file_name']; }
				}
		}
	}

	//エラーチェック
	foreach($err_mess as $err_key){
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
	if($_REQUEST['dis'] == "1"){
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
	$sql .= " material";
	$sql .= " WHERE";
	$sql .= " del_flg = '0'";
	$sql .= " ORDER BY add_date DESC";

	//パラメーター配列の初期化
	$prm = array();
	// $prm[] = '0';

	//パラメーターを使いSQLの作成
	$sql_mat_num = createSQL($sql,$prm);
// echo $sql_mat_num;

$stmt = $pdo->query($sql_mat_num);
$stmt->execute();
// 件数の取得
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
	<th style="width:78%;">資料タイトル</th>
	<th style="width:6%;">TOP</th>
	<!-- <th style="width:6%;">おすすめ</th> -->
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

$stmt = $pdo->query($sql_mat_num);
$stmt->execute();
if (!$stmt) {
	$info = $pdo->errorInfo();
	exit($info[2]);
}


	while ($PG_REC_MAT = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>\n";
		// 資料タイトル
		echo "	<td>";
		if($PG_REC_MAT['display_flg'] == "close"){
			echo "	<p><a href=\"/wp_detail/".$PG_REC_MAT['material_no']."/test/\" target=\"_blank\">" . $PG_REC_MAT['title'] . "</a></p>";
		}else{
			echo "	<p><a href=\"/wp_detail/".$PG_REC_MAT['material_no']."/\" target=\"_blank\">" . $PG_REC_MAT['title'] . "</a></p>";
		}
		echo "</td>\n";
		// TOP表示
		echo "	<td style=\"text-align:center;\">\n";
		if($PG_REC_MAT['top_flg'] == "open"){
			echo "<a href=\"".$now_page."?t=".time()."&act=dis&column_name=top_flg&column_value=close&key_no=".$PG_REC_MAT['material_no']."\" onClick=\"if( !confirm('TOPページから非掲載にしますか？') ) { return false; }\">○</a>";
		}else{
			echo "<a href=\"".$now_page."?t=".time()."&act=dis&column_name=top_flg&column_value=open&key_no=".$PG_REC_MAT['material_no']."\" onClick=\"if( !confirm('TOPページに掲載しますか？') ) { return false; }\">×</a>";
		}
		echo "</td>\n";
		// 注目表示
		// echo "	<td style=\"text-align:center;\">\n";
		// if($PG_REC_MAT['pickup_flg'] == "open"){
		// 	echo "<a href=\"".$now_page."?t=".time()."&act=dis&column_name=pickup_flg&column_value=close&key_no=".$PG_REC_MAT['material_no']."\" onClick=\"if( !confirm('おすすめ資料ぺーじから非掲載にしますか？') ) { return false; }\">○</a>";
		// }else{
		// 	echo "<a href=\"".$now_page."?t=".time()."&act=dis&column_name=pickup_flg&column_value=open&key_no=".$PG_REC_MAT['material_no']."\" onClick=\"if( !confirm('おすすめ資料ページに掲載しますか？') ) { return false; }\">×</a>";
		// }
		// echo "</td>\n";
		// 掲載表示
		echo "	<td style=\"text-align:center;\">\n";
		if($PG_REC_MAT['display_flg'] == "open"){
			echo "<a href=\"".$now_page."?t=".time()."&act=dis&column_name=display_flg&column_value=close&key_no=".$PG_REC_MAT['material_no']."\" onClick=\"if( !confirm('非掲載にしますか？') ) { return false; }\">○</a>";
		}else{
			echo "<a href=\"".$now_page."?t=".time()."&act=dis&column_name=display_flg&column_value=open&key_no=".$PG_REC_MAT['material_no']."\" onClick=\"if( !confirm('掲載しますか？') ) { return false; }\">×</a>";
		}
		echo "</td>\n";
		// 更新ボタン
		echo "	<td style=\"text-align:center;\">\n";
		echo "	<input type=\"submit\" name=\"upd:".$PG_REC_MAT['material_no']."\" class=\"submit01\" value=\"更新\">\n";
		echo "	</td>\n";
		// 削除ボタン
		echo "	<td style=\"text-align:center;\">\n";
		echo "	<input type=\"submit\" name=\"del:".$PG_REC_MAT['material_no']."\" value=\"削除\" class=\"submit01\">\n";
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
	if ($_POST['block_cnt'] == "" or $_POST['block_cnt'] == "0") {
		$_POST['block_cnt'] = "1";
	}
	if (empty($_POST['blog_date'])) {
		$_POST['blog_date'] = date("Y-m-d", time());
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

<form action="<?php echo $now_page; ?>?t=<?php echo time(); ?>" method="post" name="FORM1" enctype="multipart/form-data">
<table class="Tblform">
<tr>
	<th>カテゴリ<span>※</span></th>
	<td>
	<select name="material_category" id="" class="form_color_r">
	<option value="">
	<?php echo SelectView("material_category",$item_list['material_category'],""); ?>
	</select>
	</td>
</tr>

<tr>
	<th>資料タイトル<span>※</span></th>
	<td>

<textarea name="title" cols="60" rows="5" class="form_color_r"><?php echo $_POST['title']; ?></textarea>
	</td>
</tr>
<tr>
	<th>キャッチコピー</th>
	<td>
<textarea name="copy" cols="60" rows="5" class="form_color_r"><?php echo $_POST['copy']; ?></textarea>
	</td>
</tr>
<tr>
	<th>本文</th>
	<td>
<textarea name="comment" cols="60" rows="5" class="form_color_r"><?php echo $_POST['comment']; ?></textarea>
	</td>
</tr>


<?php
		for($i = 1;$i <= $_POST['up_file_cnt'];$i++){
			$up_file_key = "up_file".$i;
			$upfile_key = "upfile".$i;
			$up_file_del_key = "up_file_del".$i;
?>
<tr>
	<th><?php echo $upfile_title_list[$i]; ?></th>
	<td>
	<input type="file" name="<?php echo $upfile_key; ?>" size="40">
	<?php if ($_POST[$up_file_key] != "") { ?>
	<br><a href="<?php echo $up_file_path.$_POST[$up_file_key]; ?>" target="_blank"><?php echo $_POST[$up_file_key]; ?></a>
	<input type="hidden" name="<?php echo $up_file_key; ?>" value="<?php echo $_POST[$up_file_key]; ?>">
	　<input type="checkbox" name="<?php echo $up_file_del_key; ?>[]" value="1">ファイルを削除
	<?php } ?>
	</td>
</tr>
<?php
		}
?>
<tr>
	<th>ダウンロード資料名<span>※</span></th>
	<td>
		<?php
		$disabled = "";
if($_POST['type'] == "upd"){
	echo $_POST['file_name'];
	?>
		<input type="hidden" name="file_name" value="<?php echo $_POST['file_name']; ?>">
	<?php
}else{
		?>
		<textarea name="file_name" cols="50" class="form_color_r"><?php echo $_POST['file_name']; ?></textarea>
<?php
}
?>
	</td>
</tr>
<tr>
	<th>目次</th>
	<td>
<textarea name="material_toc1" cols="60" rows="5" class="form_color_r"><?php echo $_POST['material_toc1']; ?></textarea>
	</td>
</tr>
<tr>
	<th>meta description</th>
	<td>
		<textarea name="description" cols="60" rows="5" class="form_color_r"><?php echo $_POST['description']; ?></textarea>
	</td>
</tr>
<tr>
	<th>meta keywords</th>
	<td>
		<textarea name="keywords" cols="60" rows="5" class="form_color_r"><?php echo $_POST['keywords']; ?></textarea>
		<br /><span style="color:#ff0000;">※ワード毎に改行して下さい。</span>
	</td>
</tr>
</table>

	<div class="formbtn">
		<span><p class="gr"><button type="button" onClick="location.href='<?php echo $now_page; ?>?t=<?php echo time(); ?>'" name="btn1">一覧ページにもどる</button></p></span>

		<span><p class="grn"><button type="submit" name="btn2">登録内容を確認する</button></p></span>
		<input type="hidden" name="act" value="conf">
		<input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">
<input type="hidden" name="block_cnt" value="<?php echo $_POST['block_cnt']; ?>">
<?php
	if($_POST['type'] == "upd"){
		echo "<input type=\"hidden\" name=\"material_no\" value=\"".$_POST['material_no']."\">";
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
	<th>カテゴリ<span>※</span></th>
	<td><?php echo $item_list['material_category'][$_POST['material_category']]; ?></td>
</tr>
	<tr>
		<th>資料タイトル</th>
		<td><?php echo Nr2Br($_POST['title']); ?></td>
	</tr>
	<tr>
		<th>キャッチコピー</th>
		<td><?php echo Nr2Br($_POST['copy']); ?></td>
	</tr>
	<tr>
		<th>本文</th>
		<td><?php echo Nr2Br($_POST['comment']); ?></td>
	</tr>
<?php
	for($i = 1;$i <= $_POST['up_file_cnt'];$i++){
		$up_file_key = "up_file".$i;
?>
<tr>
	<th><?php echo $upfile_title_list[$i]; ?></th>
	<td>
	<?php if ($_POST[$up_file_key]) { ?>
	<a href="<?php echo $up_file_path.$_POST[$up_file_key]; ?>" target="_blank"><?php echo $_POST[$up_file_key]; ?></a>
	<?php } ?>
	</td>
</tr>
<?php
	}
?>
<tr>
	<th>ダウンロード資料名<span>※</span></th>
	<td><?php echo $_POST['file_name']; ?></td>
</tr>
<tr>
	<th>目次</th>
		<td><?php echo Nr2Br($_POST['material_toc1']); ?></td>
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

	if($_POST['type'] == "regist"){

		//SQLを作成
		$sql = "INSERT INTO material (";
		$sql .= " title";
		$sql .= ",sub_title";
		$sql .= ",copy";
		$sql .= ",comment";
		$sql .= ",material_category";
		$sql .= ",genre";
		$sql .= ",needs";
		$sql .= ",genre_recommend";
		$sql .= ",needs_recommend";
		$sql .= ",material_toc1";
		$sql .= ",up_file1";
		$sql .= ",up_file2";
		$sql .= ",up_file3";
		$sql .= ",file_name";
		$sql .= ",description";
		$sql .= ",keywords";
		$sql .= ",add_date";
		$sql .= ",upd_date";
		$sql .= ") VALUES (";
		$sql .= " :title";
		$sql .= ",:sub_title";
		$sql .= ",:copy";
		$sql .= ",:comment";
		$sql .= ",:material_category";
		$sql .= ",:genre";
		$sql .= ",:needs";
		$sql .= ",:genre_recommend";
		$sql .= ",:needs_recommend";
		$sql .= ",:material_toc1";
		$sql .= ",:up_file1";
		$sql .= ",:up_file2";
		$sql .= ",:up_file3";
		$sql .= ",:file_name";
		$sql .= ",:description";
		$sql .= ",:keywords";
		$sql .= ",:add_date";
		$sql .= ",:upd_date";
		$sql .= ")";

		$stmt = $pdo -> prepare($sql);
		$stmt->bindParam(':title', Nr2Br($_POST['title']), PDO::PARAM_STR);
		$stmt->bindValue(':sub_title', Nr2Br($_POST['sub_title']), PDO::PARAM_STR);
		$stmt->bindValue(':copy', Nr2Br($_POST['copy']), PDO::PARAM_STR);
		$stmt->bindValue(':comment', Nr2Br($_POST['comment']), PDO::PARAM_STR);
		$stmt->bindValue(':material_category', $_POST['material_category'], PDO::PARAM_STR);
		$stmt->bindParam(':genre', implode(",", $_POST['genre']), PDO::PARAM_STR);
		$stmt->bindParam(':needs', implode(",", $_POST['needs']), PDO::PARAM_STR);
		$stmt->bindParam(':genre_recommend', implode(",", $_POST['genre_recommend']), PDO::PARAM_STR);
		$stmt->bindParam(':needs_recommend', implode(",", $_POST['needs_recommend']), PDO::PARAM_STR);
		$stmt->bindValue(':material_toc1', Nr2Br($_POST['material_toc1']), PDO::PARAM_STR);
		$stmt->bindParam(':up_file1', $_POST['up_file1'], PDO::PARAM_STR);
		$stmt->bindParam(':up_file2', $_POST['up_file2'], PDO::PARAM_STR);
		$stmt->bindParam(':up_file3', $_POST['up_file3'], PDO::PARAM_STR);
		$stmt->bindParam(':file_name', $_POST['file_name'], PDO::PARAM_STR);
		$stmt->bindParam(':description', NrDel($_POST['description']), PDO::PARAM_STR);
		$stmt->bindParam(':keywords', NrDel(preg_replace("/\n/",",",$_POST[keywords])), PDO::PARAM_STR);
		$stmt->bindParam(':add_date', $now_date_time, PDO::PARAM_STR);
		$stmt->bindParam(':upd_date', $now_date_time, PDO::PARAM_STR);

		$stmt->execute();

		$_POST['material_no'] = $pdo->lastInsertId();
	}

	if($_POST['type'] == "upd"){//更新処理

		$sql = "UPDATE material SET";
		$sql .= " title = :title";
		$sql .= ",sub_title = :sub_title";
		$sql .= ",copy = :copy";
		$sql .= ",comment = :comment";
		$sql .= ",material_category = :material_category";
		$sql .= ",genre = :genre";
		$sql .= ",genre_recommend = :genre_recommend";
		$sql .= ",needs = :needs";
		$sql .= ",needs_recommend = :needs_recommend";
		$sql .= ",material_toc1 = :material_toc1";
		$sql .= ",up_file1 = :up_file1";
		$sql .= ",up_file2 = :up_file2";
		$sql .= ",up_file3 = :up_file3";
		$sql .= ",file_name = :file_name";
		$sql .= ",description = :description";
		$sql .= ",keywords = :keywords";
		$sql .= ",upd_date = :upd_date";
		$sql .= " WHERE material_no = :material_no";


		$stmt = $pdo -> prepare($sql);
		$stmt->bindParam(':title', Nr2Br($_POST['title']), PDO::PARAM_STR);
		$stmt->bindValue(':sub_title', Nr2Br($_POST['sub_title']), PDO::PARAM_STR);
		$stmt->bindValue(':copy', Nr2Br($_POST['copy']), PDO::PARAM_STR);
		$stmt->bindValue(':comment', Nr2Br($_POST['comment']), PDO::PARAM_STR);
		$stmt->bindValue(':material_category', $_POST['material_category'], PDO::PARAM_STR);
		$stmt->bindParam(':genre', implode(",", $_POST['genre']), PDO::PARAM_STR);
		$stmt->bindParam(':genre_recommend', implode(",", $_POST['genre_recommend']), PDO::PARAM_STR);
		$stmt->bindParam(':needs', implode(",", $_POST['needs']), PDO::PARAM_STR);
		$stmt->bindParam(':needs_recommend', implode(",", $_POST['needs_recommend']), PDO::PARAM_STR);
		$stmt->bindValue(':material_toc1', Nr2Br($_POST['material_toc1']), PDO::PARAM_STR);
		$stmt->bindParam(':up_file1', $_POST['up_file1'], PDO::PARAM_STR);
		$stmt->bindParam(':up_file2', $_POST['up_file2'], PDO::PARAM_STR);
		$stmt->bindParam(':up_file3', $_POST['up_file3'], PDO::PARAM_STR);
		$stmt->bindParam(':file_name', $_POST['file_name'], PDO::PARAM_STR);
		$stmt->bindParam(':description', NrDel($_POST['description']), PDO::PARAM_STR);
		$stmt->bindParam(':keywords', NrDel(preg_replace("/\n/",",",$_POST['keywords'])), PDO::PARAM_STR);
		$stmt->bindParam(':upd_date', $now_date_time, PDO::PARAM_STR);
		$stmt->bindValue(':material_no', $_POST['material_no'], PDO::PARAM_INT);

		$stmt->execute();

	}

	if($_POST['type'] == "del"){//削除処理

		$sql = "UPDATE material SET";
		$sql .= " del_flg = '1'";
		$sql .= " WHERE material_no = :material_no";

		$stmt = $pdo -> prepare($sql);
		$stmt->bindValue(':material_no', $_POST['material_no'], PDO::PARAM_INT);

		$stmt->execute();

	}
?>
<div id="contents">

<div class="thanks">
<?php
	// if($result) {
		echo $type_comment_list[$act_type_key] . "\n";
	// }else{
	// 	echo "エラーが発生しました<br>\n";
	// 	// echo $sql;
	// }
?>
</div>

<form action="<?php echo $now_page; ?>?t=<?php echo time(); ?>" method="post">
<div class="btn">
<input type="submit" value="&nbsp;一覧へ戻る&nbsp;" class="submit01" />
<input type="hidden" name="company_id" value="<?php echo $_POST['company_id'] ?>">
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
