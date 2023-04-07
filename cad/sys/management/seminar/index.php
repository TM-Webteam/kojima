<?php
/*ファイルの読み込み*/
require ("../../../include/dbconn.php");
include ("../../../include/convert.php");
include ("../../../include/list.php");
include("../include/header.php");

// 資料種別
$seminar_type = "seminar";
$_POST['item_l_no'] = "1";

$fontsize_min = 12;
$fontsize_max = 25;
//ページタイトル
$main_title = "セミナー";

// **************************************************************
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
$sql_mat_num = $sql;


$stmt = $pdo->query($sql_mat_num);
if (!$stmt) {
	$info = $pdo->errorInfo();
	exit($info[2]);
}

while ($PG_REC_MAT = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$item_list[$PG_REC_MAT['item_column_name']][$PG_REC_MAT['item_m_no']] = $PG_REC_MAT['item_m_name'];
	if (!empty($PG_REC_MAT['color'])) {
		$item_color_list[$PG_REC_MAT['item_column_name']][$PG_REC_MAT['item_m_no']] = $PG_REC_MAT['color'];
	}
}

// ****************************************************************
// セミナー情報の取得
$sql_updl = "SELECT";
$sql_updl .= " *";
$sql_updl .= " FROM";
$sql_updl .= " seminar";
$sql_updl .= " WHERE";
$sql_updl .= " display_flg = 'open' ";
$sql_updl .= " AND del_flg = 0 ";

//パラメーターを使いSQLの作成
// $sql_st = createSQL($sql_updl,$prm);
// echo "<p>" . $sql_st . "</p>";
//SQLを実行
$result_updl = pdo_exec_query($sql_updl);

$row_num_updl = $result_updl[1];
while ( $arr_updl = pdo_fetch_assoc($result_updl[0])) {
	$material_arr[$arr_updl['seminar_no']] = strip_tags($arr_updl['title']);
}
// ****************************************************************


//表示・非表示を切り替える
if($_REQUEST['act'] == "dis"){

	$sql = "UPDATE seminar SET";
	$sql .= " ".$_REQUEST['column_name']." = :column_name";
	$sql .= " WHERE seminar_no = :seminar_no";

	$stmt = $pdo -> prepare($sql);
	$stmt->bindParam(':column_name', $_REQUEST['column_value'], PDO::PARAM_STR);
	$stmt->bindValue(':seminar_no', $_REQUEST['key_no'], PDO::PARAM_INT);
	$stmt->execute();

	$_POST['act'] = "";

}

if($_REQUEST['act'] == "top"){
	$_POST['act'] = "add";
	$_POST['type'] = "regist";
}

//セミナープログラムの枠の追加
if(!empty($_POST['program_cnt_add'])){
	$_POST['program_cnt']++;
	$_POST['act'] = "add";
}
// セミナー日程の追加,hiddenで飛んできたdate_cnt_addが空でなければdate_cntを追加
if(!empty($_POST['date_cnt_add'])){
	$_POST['date_cnt']++;
	$_POST['act'] = "add";
}

// セミナー対象の追加,hiddenで飛んできたdate_cnt_addが空でなければtarget_cntを追加
if(!empty($_POST['target_cnt_add'])){
	$_POST['target_cnt']++;
	$_POST['act'] = "add";
}

// セミナーお伝えしたいことの追加,hiddenで飛んできたdate_cnt_addが空でなければinstruct_cntを追加
if(!empty($_POST['instruct_cnt_add'])){
	$_POST['instruct_cnt']++;
	$_POST['act'] = "add";
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

	//更新・削除時の企業情報取得
	if($_POST['type'] == "upd" or $_POST['type'] == "del"){

		$sql_updl = "SELECT";
		$sql_updl .= " *";
		$sql_updl .= " FROM";
		$sql_updl .= " seminar";
		$sql_updl .= " WHERE";
		$sql_updl .= " seminar_no = :seminar_no";

		$stmt = $pdo -> prepare($sql_updl);
		$stmt->bindParam(':seminar_no', $key_no[1], PDO::PARAM_STR);

		// SQLの実行
		$stmt->execute();
		if (!$stmt) {
			$info = $pdo->errorInfo();
			exit($info[2]);
		}

		$arr_updl = $stmt->fetch(PDO::FETCH_ASSOC);

		$_POST['seminar_no'] = $arr_updl['seminar_no'];
		$_POST['title'] = Br2Nr($arr_updl['title']);
		$_POST['subtitle'] = Br2Nr($arr_updl['subtitle']);
		$_POST['comment'] = Br2Nr($arr_updl['comment']);
		$_POST['catch_copy'] = Br2Nr($arr_updl['catch_copy']);
		$_POST['venue'] = Br2Nr($arr_updl['venue']);
		$_POST['traffic'] = Br2Nr($arr_updl['traffic']);
		$_POST['cost'] = Br2Nr($arr_updl['cost']);
		$_POST['capacity'] = Br2Nr($arr_updl['capacity']);
		$_POST['organized'] = Br2Nr($arr_updl['organized']);
		$_POST['target_user'] = Br2Nr($arr_updl['target_user']);


			// セミナープログラム取得（更新画面用）*********************************************
			$sql_in = "SELECT";
			$sql_in .= " *";
			$sql_in .= " FROM";
			$sql_in .= " seminar_program";
			$sql_in .= " WHERE";
			$sql_in .= " seminar_no = :seminar_no";
			$sql_in .= " AND del_flg = :del_flg";
			$sql_in .= " ORDER BY seminar_program_no";

			$stmt_inm = $pdo -> prepare($sql_in);

			$del_flg = 0;
			$stmt_inm->bindParam(':seminar_no', $key_no[1], PDO::PARAM_INT);
			$stmt_inm->bindParam(':del_flg', $del_flg, PDO::PARAM_INT);

			$stmt_inm->execute();


			$cnt_l = 0;
		while ($arr_updl = $stmt_inm->fetch(PDO::FETCH_ASSOC)) {
			$cnt_l++;
			$time_key = "seminar_time" . $cnt_l;// 時間
			$title_key = "seminar_title" . $cnt_l;// タイトル
			$person_key = "lecture_person".$cnt_l;// 講演者

			$_POST[$time_key ] = Br2Nr($arr_updl['seminar_program_time']);
			$_POST[$title_key] = Br2Nr($arr_updl['seminar_program_title']);
			$_POST[$person_key] = Br2Nr($arr_updl['lecture_person']);
		}
		// セミナープログラムの枠数の取得
		$_POST['program_cnt'] = $cnt_l;

			// セミナー日付の取得（更新画面用）*********************************************
			$sql_updl = "SELECT";
			$sql_updl .= " *";
			$sql_updl .= " FROM";
			$sql_updl .= " seminar_date";
			$sql_updl .= " WHERE";
			$sql_updl .= " seminar_no = :seminar_no";
			$sql_updl .= " AND del_flg = :del_flg";
			$sql_updl .= " ORDER BY seminar_date_no";

			$del_flg = 0;
			$stmt = $pdo -> prepare($sql_updl);
			$stmt->bindParam(':seminar_no', $key_no[1], PDO::PARAM_INT);
			$stmt->bindParam(':del_flg', $del_flg, PDO::PARAM_INT);
			// SQLの実行
			$stmt->execute();

			$cnt_l2 = 0;// セミナー日付のカウント
			while ($arr_updl = $stmt->fetch(PDO::FETCH_ASSOC)) {
			// セミナー日付
				$cnt_l2++;
				$date_key = "seminar_date" . $cnt_l2; // セミナー日付
				$s_time_key = "s_time" . $cnt_l2; // セミナー日付
				$r_time_key = "r_time" . $cnt_l2; // 受付時間
				$_POST[$date_key] = Br2Nr($arr_updl['seminar_date']);
				$_POST[$s_time_key] = Br2Nr($arr_updl['seminar_time']);
				$_POST[$r_time_key] = Br2Nr($arr_updl['reception_time']);

			}
			$_POST['date_cnt'] = $cnt_l2;

			// セミナー対象の取得（更新画面用）*********************************************
			$sql_updl = "SELECT";
			$sql_updl .= " *";
			$sql_updl .= " FROM";
			$sql_updl .= " seminar_other";
			$sql_updl .= " WHERE";
			$sql_updl .= " seminar_no = :seminar_no";
			$sql_updl .= " AND del_flg = :del_flg";
			$sql_updl .= " ORDER BY seminar_other_no";

			$del_flg = 0;
			$stmt = $pdo -> prepare($sql_updl);
			$stmt->bindParam(':seminar_no', $key_no[1], PDO::PARAM_INT);
			$stmt->bindParam(':del_flg', $del_flg, PDO::PARAM_INT);
			// SQLの実行
			$stmt->execute();

			if (!$stmt) {
				$info = $pdo->errorInfo();
				exit($info[2]);
			}


			$cnt_l3 = 0;// セミナー対象のカウント
			$cnt_l4 = 0;// セミナーお伝えすることのカウント
			while ($arr_updl = $stmt->fetch(PDO::FETCH_ASSOC)) {
				// 対象とお伝えすることで場合分け
				if ($arr_updl['column_name'] == "seminar_target") {
					// セミナー対象
					$cnt_l3++;
					$target_key = "seminar_target" . $cnt_l3; // セミナー対象
					$_POST[$target_key] = Br2Nr($arr_updl['column_value']);

				}elseif ($arr_updl['column_name'] == "seminar_instruct") {
					// セミナーお伝えすること
					$cnt_l4++;
					$instruct_key = "seminar_instruct" . $cnt_l4; // セミナーお伝えすること
					$_POST[$instruct_key] = Br2Nr($arr_updl['column_value']);
				}

			}
			$_POST['target_cnt'] = $cnt_l3;
			$_POST['instruct_cnt'] = $cnt_l4;
			// var_dump($arr_updls);
	}
}


//-----------------------------------------------------------------------------------------//
//入力チェック・画像処理
//-----------------------------------------------------------------------------------------//
if($_POST['act'] == "conf"){

	$err_mess = array();
	$up_name = date( "YmdHis", time() );

	for($i = 1;$i <= $_POST['block_cnt'];$i++){
		if($err_mess != ""){
			foreach($err_mess as $err_key){
				if($err_key != ""){
					$_POST['act'] = "err";
					$_POST['type'] = "regist";
					break;
				}
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
		$_SESSION['sys']['management_p']['job'] = array();
	}
	//1ページに表示する件数
	$page_view = 20;
	if($_POST['ret'] == "1"){
		$_SESSION['sys']['management_p']['job']['page'] = "1";
	}
	if (empty($_SESSION['sys']['management_p']['job']['page'])) { $_SESSION['sys']['management_p']['job']['page'] = 1; }
	if($_REQUEST['dis'] == "1"){
		$_SESSION['sys']['management_p']['job']['page'] = $_REQUEST['page'];
	}else{
		$_SESSION['sys']['management_p']['job']['page'] = 1;
	}
	// 現在のページ
	$base_page = $_SESSION['sys']['management_p']['job']['page'];


	if($base_page == 1){// 現在のページが先頭の時はoffset=0
		$offset = 0;
	}else{// 現在のページからoffsetの値を計算
		$offset_key = $base_page - 1;
		$offset = $offset_key * $page_view;
	}
	/*件数とセミナー一覧情報の取得*/
	$sql = "SELECT";
	$sql .= " *";
	$sql .= " FROM";
	$sql .= " seminar";
	$sql .= " WHERE";
	$sql .= " del_flg = '0'";
	$sql .= " ORDER BY add_date DESC";


	//パラメーター配列の初期化
	$prm = array();

	//パラメーターを使いSQLの作成
	$sql_mat_num = createSQL($sql,$prm);

	//SQLを実行
	$stmt = $pdo->query($sql_mat_num);
	// SQLの件数の取得
	$row_num_inq_comp=$stmt->rowCount();
	// エラー出力
	if (!$stmt) {
		$info = $pdo->errorInfo();
		exit($info[2]);
	}



	if($base_page == 1){// 現在のページが先頭の時
		$dis_a = 1;
		// 取得したセミナー件数よりも１ページの表示件数が多い時
		if($row_num_inq_comp < $page_view){
			$dis_b = $row_num_inq_comp;
		}else{
			$dis_b = $page_view;
		}
	}else{
		$dis_b_key = $base_page * $page_view;
		// 表示ページの先頭の件数$dis_a
		$dis_a = (($base_page - 1) * $page_view) + 1;
		if($row_num_inq_comp < $dis_b_key){
			$dis_b = $row_num_inq_comp;//表示ページの最後の件数$dis_ｂ
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
	<th style="width:10%;">開催日時</th>
	<th style="width:34%;">セミナータイトル</th>
	<!-- <th style="width:22%;">カテゴリ</th> -->
	<th style="width:6%;">TOP</th>
	<th style="width:6%;">掲載</th>
	<th style="width:8%;"></th>
	<th style="width:8%;"></th>
</tr>
<?php
	// ページ数の計算
	$page_no_cnt = ceil($row_num_inq_comp / $page_view);
	// 一ページの件数
	$sql .= " LIMIT " . $page_view;
	$sql .= " OFFSET " . $offset;

	// $prm[] = $page_view;
	// $prm[] = $offset;

	//パラメーターを使いSQLの作成
	$sql_mat_num = createSQL($sql,$prm);

	//SQLを実行
	// $result_mat_num = ExecSQL($sql_mat_num,null);

	$stmt = $pdo->query($sql_mat_num);
	$stmt->execute();
	if (!$stmt) {
		$info = $pdo->errorInfo();
		exit($info[2]);
	}


	while ($PG_REC_MAT = $stmt->fetch(PDO::FETCH_ASSOC)) {

		$category_arr = explode(",", $PG_REC_MAT['category']);

		echo "<tr>\n";
			// 開催日時
			echo "	<td style=\"text-align:center\";>";

			// セミナー開始日程の取得*****************************
			$sql_date = "SELECT";
			$sql_date .= " *";
			$sql_date .= " FROM";
			$sql_date .= " seminar_date";
			$sql_date .= " WHERE";
			$sql_date .= " seminar_no =".$PG_REC_MAT['seminar_no'];
			$sql_date .= " AND del_flg = '0'";
			$sql_date .= " ORDER BY seminar_date_no";

			//パラメーター配列の初期化
			$prm = array();
			$sql_mat_num = createSQL($sql_date,$prm);
			//SQLを実行
			$stmt_d = $pdo->query($sql_mat_num);
			// 登録された開催日程の表示
			while ($SEMI_DATE = $stmt_d->fetch(PDO::FETCH_ASSOC)) {
				echo $SEMI_DATE['seminar_date']."<br>";
			}
			echo "</td>\n";
			// セミナー開始日程の取得終了*****************************

		// セミナータイトル
		echo "	<td>";
		if($PG_REC_MAT['display_flg'] === "close"){
			echo "	<p><a href=\"/seminar_detail/".$PG_REC_MAT['seminar_no']."/test/\" target=\"_blank\">" . $PG_REC_MAT['title'] . "</a></p>";
		}else{
			echo "	<p><a href=\"/seminar_detail/".$PG_REC_MAT['seminar_no']."/\" target=\"_blank\">" . $PG_REC_MAT['title'] . "</a></p>";
		}
		echo "</td>\n";
		// カテゴリ
		// echo "	<td>\n";
		// foreach ($category_arr as $category_value) {
		// 	echo "<p>" . $item_list['blog_category'][$category_value] . "</p>\n";
		// }
		// echo "</td>\n";

		// TOP
		echo "	<td style=\"text-align:center;\">\n";
		if($PG_REC_MAT['new_flg'] == "open"){
			echo "<a href=\"".$now_page."?t=".time()."&act=dis&column_name=new_flg&column_value=close&key_no=".$PG_REC_MAT['seminar_no']."\" onClick=\"if( !confirm('新着を解除しますか？') ) { return false; }\">○</a>";
		}else{
			echo "<a href=\"".$now_page."?t=".time()."&act=dis&column_name=new_flg&column_value=open&key_no=".$PG_REC_MAT['seminar_no']."\" onClick=\"if( !confirm('新着に登録しますか？') ) { return false; }\">×</a>";
		}
		echo "</td>\n";

		// 掲載項目
		echo "	<td style=\"text-align:center;\">\n";
		if($PG_REC_MAT['display_flg'] == "open"){
			echo "<a href=\"".$now_page."?t=".time()."&act=dis&column_name=display_flg&column_value=close&key_no=".$PG_REC_MAT['seminar_no']."\" onClick=\"if( !confirm('非掲載にしますか？') ) { return false; }\">○</a>";
		}else{
			echo "<a href=\"".$now_page."?t=".time()."&act=dis&column_name=display_flg&column_value=open&key_no=".$PG_REC_MAT['seminar_no']."\" onClick=\"if( !confirm('掲載しますか？') ) { return false; }\">×</a>";
		}
		echo "</td>\n";
		// 更新
		echo "	<td style=\"text-align:center;\">\n";
		echo "	<input type=\"submit\" name=\"upd:".$PG_REC_MAT['seminar_no']."\" class=\"submit01\" value=\"更新\">\n";
		echo "	</td>\n";
		// 削除
		echo "	<td style=\"text-align:center;\">\n";
		echo "	<input type=\"submit\" name=\"del:".$PG_REC_MAT['seminar_no']."\" value=\"削除\" class=\"submit01\">\n";
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
if($_POST['act'] == "add" OR $_POST['act'] == "err"){
	// セミナープログラムの枠数の初期設定
	if ($_POST['program_cnt'] == "" OR $_POST['program_cnt'] == 0) {
		$_POST['program_cnt'] = 1;
	}
	// 日程の枠数の初期設定
	if($_POST['date_cnt'] =="" OR $_POST['date_cnt'] ==0){
		$_POST['date_cnt'] = 1;
	}
	// セミナーの対象の枠数の初期設定
	if($_POST['target_cnt'] =="" OR $_POST['target_cnt'] ==0){
		$_POST['target_cnt'] = 1;
	}
		// セミナーお伝えしたいことの枠数の初期設定
	if($_POST['instruct_cnt'] =="" OR $_POST['instruct_cnt'] ==0){
		$_POST['instruct_cnt'] = 1;
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
	<th>セミナ-一覧(リード文)<span>※</span></th>
	<td>
		<textarea name="target_user" cols="60" rows="5" class="form_color_r"><?php echo $_POST['target_user']; ?></textarea>
	</td>
</tr>
<tr>
	<th>セミナ-タイトル<span>※</span></th>
	<td>
		<textarea name="title" cols="60" rows="5" class="form_color_r"><?php echo $_POST['title']; ?></textarea>
	</td>
</tr>
<tr>
	<th>サブタイトル</th>
	<td>
		<textarea name="subtitle" cols="60" rows="5" class="form_color_r"><?php echo $_POST['subtitle']; ?></textarea>
	</td>
</tr>
<tr>
	<th>キャッチコピー</th>
	<td>
		<textarea name="catch_copy" cols="60" rows="5" class="form_color_r"><?php echo $_POST['catch_copy']; ?></textarea>
	</td>
</tr>
<tr>
	<th>本文</th>
	<td>
		<textarea name="comment" cols="60" rows="5" class="form_color_r"><?php echo $_POST['comment']; ?></textarea>
	</td>
</tr>
<tr>
	<th>会場</th>
	<td>
		<textarea name="venue" cols="60" rows="5" class="form_color_r"><?php echo $_POST['venue']; ?></textarea>
	</td>
</tr>
<tr>
	<th>交通</th>
	<td>
		<textarea name="traffic" cols="60" rows="5" class="form_color_r"><?php echo $_POST['traffic']; ?></textarea>
	</td>
</tr>
<tr>
	<th>費用</th>
	<td>
		<input type="text" name="cost" size="50" class="form_color_r" value= "<?php echo $_POST['cost']; ?>" >
	</td>
</tr>
<tr>
	<th>定員</th>
	<td>
		<input type="text" name="capacity" size="50" class="form_color_r" value= "<?php echo $_POST['capacity']; ?>" >
	</td>
</tr>
<tr>
	<th>主催</th>
	<td>
		<textarea name="organized" cols="60" rows="5" class="form_color_r"><?php echo $_POST['organized']; ?></textarea>
	</td>
</tr>


<?php 	// セミナープログラムの追加
for ($i=1; $i <= $_POST['program_cnt']; $i++) {
	$time_key = "seminar_time" . $i;// 時間
	$title_key = "seminar_title" . $i;// タイトル
	$person_key = "lecture_person".$i;// 講演者
?>
	<tr>
		<th>セミナープログラム<?php echo $i; ?>
	<?php if ($_POST['program_cnt'] == $i): ?>
			<p><button type="submit" name="program_cnt_add" value="<?php echo $i; ?>">セミナープログラムを追加</button></p>
			<input type="hidden" name="program_cnt" value="<?php echo $_POST['program_cnt']; ?>">
	<?php endif ?>
		</th>
		<td>
			<p>■時間</p>
				<input type="text" name="<?php echo $time_key; ?>" size="50" class="form_color_r" value= "<?php echo $_POST[$time_key]; ?>" >
			<p>■タイトル</p>
				<textarea name="<?php echo $title_key; ?>" cols="60" rows="5" class="form_color_r"><?php echo $_POST[$title_key]; ?></textarea>
	<!-- 		<p>■講演者</p>
				<input type="text" name="<?php echo $person_key; ?>" size="50" class="form_color_r" value= "<?php echo $_POST[$person_key]; ?>"> -->
		</td>
	</tr>

<?php
} ?>

<?php 	// 日程の追加
for($i=1;$i<= $_POST['date_cnt'];$i++){
	$date_key = "seminar_date" . $i;
	$s_time_key = "s_time" . $i;
	$r_time_key = "r_time" . $i;
?>
	<tr>
		<th>日程<?= $i ?>
			<?php if($_POST['date_cnt'] == $i): ?>
				<P><button type="submit" name="date_cnt_add" value="<?php echo $i ?>">日付を追加</button></P>
				<input type="hidden" name="date_cnt" value="<?php echo $_POST['date_cnt'] ?>">
			<?php endif ?>
		</th>
		<td>
			<p>■セミナー日程</p>
			<input type="text" name="<?php echo $date_key ?>" size="50" class="form_color_r" value="<?php echo $_POST[$date_key]; ?>" placeholder="2018-01-01" id="calender_<?= $i?>" autocomplete="off">
			<p>■セミナー時間</p>
			<input type="text" name="<?php echo $s_time_key ?>" size="50" class="form_color_r" value="<?php echo $_POST[$s_time_key]; ?>">
			<p>■受付時間</p>
			<input type="text" name="<?php echo $r_time_key ?>" size="50" class="form_color_r" value="<?php echo $_POST[$r_time_key]; ?>">
		</td>
	</tr>
<?php } ?>

<?php 	// セミナーおつたえすることの追加
for($i=1;$i<= $_POST['instruct_cnt'];$i++){
	$instruct_key = "seminar_instruct" . $i  	?>
	<tr>
		<th>セミナーでお伝えをすること<?= $i ?>
			<?php if($_POST['instruct_cnt'] == $i): ?>
				<P><button type="submit" name="instruct_cnt_add" value="<?= $i ?>">セミナーでお伝えを追加</button></P>
				<input type="hidden" name="instruct_cnt" value="<?= $_POST['instruct_cnt'] ?>">
			<?php endif ?>
		</th>
		<td>
			<input type="text" name="<?= $instruct_key ?>" size="50" class="form_color_r" value="<?= $_POST[$instruct_key]; ?>">
		</td>
	</tr>
<?php } ?>

<?php 	// セミナー対象の追加
for($i=1;$i<= $_POST['target_cnt'];$i++){
	$target_key = "seminar_target" . $i  	?>
	<tr>
		<th>セミナー対象<?= $i ?>
			<?php if($_POST['target_cnt'] == $i): ?>
				<P><button type="submit" name="target_cnt_add" value="<?= $i ?>">セミナー対象を追加</button></P>
				<input type="hidden" name="target_cnt" value="<?= $_POST['target_cnt'] ?>">
			<?php endif ?>
		</th>
		<td>
			<input type="text" name="<?= $target_key ?>" size="50" class="form_color_r" value="<?= $_POST[$target_key]; ?>">
		</td>
	</tr>
<?php } ?>

</table>

<!-- <div class="formbtn" style="margin-bottom:10px;">
	<p class="bl"><button type="submit" name="block_cnt_add" value="1">段落を追加</button></p>
</div> -->

	<div class="formbtn">
		<span><p class="gr"><button type="button" onClick="location.href='<?php echo $now_page; ?>?t=<?php echo time(); ?>'" name="btn1">一覧ページにもどる</button></p></span>

		<span><p class="grn"><button type="submit" name="btn2">登録内容を確認する</button></p></span>
		<input type="hidden" name="act" value="conf">
		<input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">
		<input type="hidden" name="block_cnt" value="<?php echo $_POST['block_cnt']; ?>">
<?php
	if($_POST['type'] == "upd"){
		echo "<input type=\"hidden\" name=\"seminar_no\" value=\"".$_POST['seminar_no']."\">";
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

?>
<div id="contents">

<h2><?php echo $main_title; ?><?php echo $page_title_sub_list[$act_type_key]; ?></h2>
<p class="stext">登録内容を確認の上、「<?php echo $type_comment_list[$act_type_key]; ?>」ボタンをクリックしてください。
</p>

<table class="Tblform">
<tr>
	<th>セミナー一覧(リード文)<span>※</span></th>
	<td><?php echo Nr2Br($_POST['target_user']); ?></td>
</tr>
<tr>
	<th>セミナータイトル<span>※</span></th>
	<td><?php echo Nr2Br($_POST['title']); ?></td>
</tr>
<tr>
	<th>サブタイトル</th>
	<td><?php echo Nr2Br($_POST['subtitle']); ?></td>
</tr>
<tr>
	<th>キャッチコピー</th>
	<td><?php echo Nr2Br($_POST['catch_copy']) ?></td>
</tr>
<tr>
	<th>本文</th>
	<td><?php echo Nr2Br($_POST['comment']); ?></td>
</tr>
<tr>
	<th>会場</th>
	<td><?php echo Nr2Br($_POST['venue']); ?></td>
</tr>
<tr>
	<th>交通</th>
	<td><?php echo Nr2Br($_POST['traffic']); ?></td>
</tr>
<tr>
	<th>費用</th>
	<td><?php echo $_POST['cost']; ?></td>
</tr>
<tr>
	<th>定員</th>
	<td><?php echo $_POST['capacity']; ?></td>
</tr>
<tr>
	<th>主催</th>
	<td><?= $_POST['organized'] ?></td>
</tr>
<!-- <tr>
	<th>対象</th>
	<td><?= $_POST['target_user'];?></td>
</tr>
 -->
	<!-- セミナープログラムの追加 -->
	<?php for ($i=1; $i <= $_POST['program_cnt']; $i++):
			$time_key = "seminar_time" . $i;// セミナー時間
			$title_key = "seminar_title" . $i;// タイトル
			$person_key = "lecture_person".$i;// 講演者 ?>
			<tr>
				<th colspan="2">セミナープログラム<?php echo $i; ?></th>
			</tr>
			<tr>
				<th>時間</th>
				<td><?php echo $_POST[$time_key]; ?></td>
			</tr>
			<tr>
				<th>タイトル</th>
				<td><?php echo $_POST[$title_key]; ?></td>
			</tr>
<!-- 			<tr>
				<th>講演者</th>
				<td><?php echo $_POST[$person_key]; ?></td>
			</tr> -->
	<?php endfor ?>

	<!-- セミナー日程 -->
	<?php for ($i=1; $i <= $_POST['date_cnt']; $i++):
			$date_key = "seminar_date" . $i;// セミナー日程
			$s_time_key = "s_time" . $i; // セミナー時間 
			$r_time_key = "r_time" . $i; // 受付時間 ?>
			<tr>
				<th colspan="2">日程<?php echo $i; ?></th>
			</tr>
			<tr>
				<th>セミナー日程</th>
				<td><?php echo $_POST[$date_key]; ?></td>
			</tr>
			<tr>
				<th>セミナー時間</th>
				<td><?php echo $_POST[$s_time_key]; ?></td>
			</tr>
			<tr>
				<th>受付時間</th>
				<td><?php echo $_POST[$r_time_key]; ?></td>
			</tr>
	<?php endfor ?>

	<!-- セミナーお伝えすること -->
	<?php for ($i=1; $i <= $_POST['instruct_cnt']; $i++):
			$instruct_key = "seminar_instruct" . $i;// セミナー対象 ?>
			<tr>
				<th colspan="2">セミナーお伝えすること<?php echo $i; ?></th>
			</tr>
			<tr>
				<th>セミナーお伝えすること</th>
				<td><?php echo $_POST[$instruct_key]; ?></td>
			</tr>
	<?php endfor ?>

	<!-- セミナー対象 -->
	<?php for ($i=1; $i <= $_POST['target_cnt']; $i++):
			$target_key = "seminar_target" . $i;// セミナー対象 ?>
			<tr>
				<th colspan="2">対象<?php echo $i; ?></th>
			</tr>
			<tr>
				<th>セミナー対象</th>
				<td><?php echo $_POST[$target_key]; ?></td>
			</tr>
	<?php endfor ?>

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

	// 新規登録
	if($_POST['type'] == "regist"){
		//SQLを作成
		$sql = "INSERT INTO seminar (";
		$sql .= " title";
		$sql .= ",subtitle";
		$sql .= ",catch_copy";
		$sql .= ",comment";
		$sql .= ",venue";
		$sql .= ",traffic";
		$sql .= ",cost";
		$sql .= ",capacity";
		$sql .= ",organized";
		$sql .= ",target_user";
		$sql .= ",add_date";
		// $sql .= ",upd_date";
		$sql .= ") VALUES (";
		$sql .= " :title";
		$sql .= ",:subtitle";
		$sql .= ",:catch_copy";
		$sql .= ",:comment";
		$sql .= ",:venue";
		$sql .= ",:traffic";
		$sql .= ",:cost";
		$sql .= ",:capacity";
		$sql .= ",:organized";
		$sql .= ",:target_user";
		$sql .= ",:add_date";
		// $sql .= ",:upd_date";
		$sql .= ")";

		// $stmt = $pdo->query($sql);

		$stmt = $pdo -> prepare($sql);
		$stmt->bindParam(':title', Nr2Br($_POST['title']), PDO::PARAM_STR);
		$stmt->bindParam(':subtitle', Nr2Br($_POST['subtitle']), PDO::PARAM_STR);
		$stmt->bindValue(':catch_copy', Nr2Br($_POST['catch_copy']), PDO::PARAM_STR);
		$stmt->bindParam(':comment', Nr2Br($_POST['comment']), PDO::PARAM_STR);
		$stmt->bindParam(':venue', Nr2Br($_POST['venue']), PDO::PARAM_STR);
		$stmt->bindParam(':traffic', Nr2Br($_POST['traffic']), PDO::PARAM_STR);
		$stmt->bindParam(':cost', Nr2Br($_POST['cost']), PDO::PARAM_STR);
		$stmt->bindParam(':capacity', Nr2Br($_POST['capacity']), PDO::PARAM_STR);
		$stmt->bindParam(':organized', Nr2Br($_POST['organized']), PDO::PARAM_STR);
		$stmt->bindParam(':target_user', Nr2Br($_POST['target_user']), PDO::PARAM_STR);
		$stmt->bindParam(':add_date', $now_date_time, PDO::PARAM_STR);
		// $stmt->bindParam(':upd_date', $now_date_time, PDO::PARAM_STR);

		$stmt->execute();

		$_POST['seminar_no'] = $pdo->lastInsertId();
	}
	if($_POST['type'] == "upd"){//更新処理

		$sql = "UPDATE seminar SET";
		$sql .= " title = :title";
		$sql .= ",subtitle = :subtitle";
		$sql .= ",catch_copy = :catch_copy";
		$sql .= ",comment = :comment";
		$sql .= ",venue = :venue";
		$sql .= ",traffic = :traffic";
		$sql .= ",cost = :cost";
		$sql .= ",capacity = :capacity";
		$sql .= ",organized = :organized";
		$sql .= ",target_user = :target_user";
		$sql .= ",upd_date = :upd_date";
		$sql .= " WHERE seminar_no = :seminar_no";


		$stmt = $pdo -> prepare($sql);
		$stmt->bindParam(':title', Nr2Br($_POST['title']), PDO::PARAM_STR);
		$stmt->bindParam(':subtitle', Nr2Br($_POST['subtitle']), PDO::PARAM_STR);
		$stmt->bindValue(':catch_copy', Nr2Br($_POST['catch_copy']), PDO::PARAM_STR);
		$stmt->bindParam(':comment', Nr2Br($_POST['comment']), PDO::PARAM_STR);
		$stmt->bindParam(':venue', Nr2Br($_POST['venue']), PDO::PARAM_STR);
		$stmt->bindParam(':traffic', Nr2Br($_POST['traffic']), PDO::PARAM_STR);
		$stmt->bindParam(':cost', $_POST['cost'], PDO::PARAM_STR);
		$stmt->bindParam(':capacity', $_POST['capacity'], PDO::PARAM_STR);
		$stmt->bindParam(':organized',$_POST['organized'], PDO::PARAM_STR);
		$stmt->bindParam(':target_user', Nr2Br($_POST['target_user']), PDO::PARAM_STR);
		$stmt->bindParam(':upd_date', $now_date_time, PDO::PARAM_STR);
		$stmt->bindValue(':seminar_no', $_POST['seminar_no'], PDO::PARAM_INT);

		$stmt->execute();


			// 更新処理を行うセミナー日程の初期化
			$sql = "UPDATE seminar_date SET del_flg = '1' WHERE seminar_no = :seminar_no";
			$stmt = $pdo -> prepare($sql);
			$stmt->bindValue(':seminar_no', $_POST['seminar_no'], PDO::PARAM_INT);
			$stmt->execute();

			// 更新処理を行うセミナー対象、お伝えすることの初期化
			$sql = "UPDATE seminar_other SET del_flg = '1' WHERE seminar_no = :seminar_no";
			$stmt = $pdo -> prepare($sql);
			$stmt->bindValue(':seminar_no', $_POST['seminar_no'], PDO::PARAM_INT);
			$stmt->execute();

			// 更新処理を行うセミナープログラムの初期化
			$sql = "UPDATE seminar_program SET del_flg = '1' WHERE seminar_no = :seminar_no";
			$stmt = $pdo -> prepare($sql);
			$stmt->bindValue(':seminar_no', $_POST['seminar_no'], PDO::PARAM_INT);
			$stmt->execute();
	}

	// セミナープログラム、日程の新規・再登録
	if ($_POST['type'] == "regist" OR $_POST['type'] == "upd") {
		// セミナープログラムの追加
		for ($i=1; $i <= $_POST['program_cnt']; $i++) {
			$title_key = "seminar_title" . $i;// タイトル
			$time_key = "seminar_time" . $i;// 時間
			$person_key = "lecture_person".$i;// 講演者

			if (!empty($_POST[$time_key])) {
	// echo "<p>3:" . $_POST['seminar_no'] . "</p>";

				//SQLを作成
				$sql = "INSERT INTO seminar_program (";
				$sql .= " seminar_no";
				$sql .= ",seminar_program_title";
				$sql .= ",seminar_program_time";
				$sql .= ",lecture_person";
				$sql .= ") VALUES (";
				$sql .= " :seminar_no";
				$sql .= ",:seminar_program_title";
				$sql .= ",:seminar_program_time";
				$sql .= ",:lecture_person";
				$sql .= ")";

				$stmt = $pdo -> prepare($sql);
				$stmt->bindValue(':seminar_no', $_POST['seminar_no'], PDO::PARAM_STR);
				$stmt->bindParam(':seminar_program_title', Nr2Br($_POST[$title_key]), PDO::PARAM_STR);
				$stmt->bindParam(':seminar_program_time', Nr2Br($_POST[$time_key]), PDO::PARAM_STR);
				$stmt->bindParam(':lecture_person', $_POST[$person_key], PDO::PARAM_STR);
				// SQLの実行
				$stmt->execute();

			}
		}
		// セミナー日程の登録
		for ($i=1; $i <= $_POST['date_cnt']; $i++) {
			$date_key = "seminar_date" . $i;
			$s_time_key = "s_time" . $i; // セミナー時間
			$r_time_key = "r_time" . $i; // 受付時間

			if (!empty($_POST[$date_key])) {
				//SQLを作成
				$sql = "INSERT INTO seminar_date (";
				$sql .= " seminar_no";
				$sql .= ",seminar_date";
				$sql .= ",seminar_time";
				$sql .= ",reception_time";
				$sql .= ") VALUES (";
				$sql .= " :seminar_no";
				$sql .= ",:seminar_date";
				$sql .= ",:seminar_time";
				$sql .= ",:reception_time";
				$sql .= ")";

				$stmt = $pdo -> prepare($sql);


				$stmt->bindValue(':seminar_no', $_POST['seminar_no'], PDO::PARAM_INT);
				$stmt->bindParam(':seminar_date',$_POST[$date_key], PDO::PARAM_STR);
				$stmt->bindParam(':seminar_time',$_POST[$s_time_key], PDO::PARAM_STR);
				$stmt->bindParam(':reception_time',$_POST[$r_time_key], PDO::PARAM_STR);

				$stmt->execute();
				// $_POST['seminar_other_no'] = $pdo->lastInsertId();

			}
		}
		// セミナー対象
		for ($i=1; $i <= $_POST['target_cnt']; $i++) {
			$target_key = "seminar_target" . $i;

			if (!empty($_POST[$target_key])) {
				//SQLを作成
				$sql = "INSERT INTO seminar_other (";
				$sql .= " seminar_no";
				$sql .= ",column_name";
				$sql .= ",column_value";
				$sql .= ") VALUES (";
				$sql .= " :seminar_no";
				$sql .= ",:column_name";
				$sql .= ",:column_value";
				$sql .= ")";

				$stmt = $pdo -> prepare($sql);

				$column_name_target = "seminar_target";

				$stmt->bindValue(':seminar_no', $_POST['seminar_no'], PDO::PARAM_INT);
				$stmt->bindParam(':column_name',$column_name_target, PDO::PARAM_STR);
				$stmt->bindParam(':column_value', $_POST[$target_key], PDO::PARAM_STR);

				$stmt->execute();
				// $_POST['seminar_other_no'] = $pdo->lastInsertId();

			}
		}
			// セミナーお伝えすること
		for ($i=1; $i <= $_POST['instruct_cnt']; $i++) {
			$instruct_key = "seminar_instruct" . $i;

			if (!empty($_POST[$instruct_key])) {
				//SQLを作成
				$sql = "INSERT INTO seminar_other (";
				$sql .= " seminar_no";
				$sql .= ",column_name";
				$sql .= ",column_value";
				$sql .= ") VALUES (";
				$sql .= " :seminar_no";
				$sql .= ",:column_name";
				$sql .= ",:column_value";
				$sql .= ")";

				$stmt = $pdo -> prepare($sql);

				$column_name_instruct = "seminar_instruct";

				$stmt->bindValue(':seminar_no', $_POST['seminar_no'], PDO::PARAM_INT);
				$stmt->bindParam(':column_name',$column_name_instruct, PDO::PARAM_STR);
				$stmt->bindParam(':column_value', $_POST[$instruct_key], PDO::PARAM_STR);

				$stmt->execute();
				// $_POST['seminar_other_no'] = $pdo->lastInsertId();

			}
		}
	} // セミナープログラム、日程の新規・再登録ー終了

	if($_POST['type'] == "del"){//削除処理

		$sql = "UPDATE seminar SET";
		$sql .= " del_flg = '1'";
		$sql .= " WHERE seminar_no = :seminar_no";

		$stmt = $pdo -> prepare($sql);
		$stmt->bindValue(':seminar_no', $_POST['sminar_no'], PDO::PARAM_INT);

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
