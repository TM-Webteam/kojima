<?php
/*ファイルの読み込み*/
require("../../../include/dbconn.php");
include("../../../include/convert.php");
include("../../../include/list.php");
include("../include/header.php");

/**
 * CTA表示用配列
 */
$cta_veiw_list[1] = "表示する";

// 資料種別
$blog_type = "blog";
$_POST['item_l_no'] = "1";

$fontsize_min = 12;
$fontsize_max = 25;
//ページタイトル
$main_title = "ブログ";
//添付ファイル数
$_POST['up_file_cnt'] = "1";
$upfile_title_list[1] = "メイン画像";
$up_file_path = "../../../up_file/";
//ファイルアップロードタイトル

// 関連記事個数
$_POST['rec_cnt'] = "5";

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
$sql_mat_num = createSQL($sql, $prm);
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
	if (!empty($PG_REC_MAT['color'])) {
		$item_color_list[$PG_REC_MAT['item_column_name']][$PG_REC_MAT['item_m_no']] = $PG_REC_MAT['color'];
	}
}

$sql_updl = "SELECT";
$sql_updl .= " *";
$sql_updl .= " FROM";
$sql_updl .= " material";
$sql_updl .= " WHERE";
$sql_updl .= " display_flg = 'open' ";
$sql_updl .= " AND del_flg = 0 ";

// echo $sql_updl;

// //パラメーター配列の初期化
// $prm = array();
// $prm[] = $fm_company_id;
// $prm[] = 'open';
// $prm[] = 'open';

//パラメーターを使いSQLの作成
// $sql_st = createSQL($sql_updl,$prm);
// echo "<p>" . $sql_st . "</p>";
//SQLを実行
$result_updl = pdo_exec_query($sql_updl);

$row_num_updl = $result_updl[1];
while ($arr_updl = pdo_fetch_assoc($result_updl[0])) {
	$material_arr[$arr_updl['material_no']] = strip_tags($arr_updl['title']);
}

/**
 *関連ブログ用にフログの配列作成
 *更新日　2020-11-17
 */
$sql = "SELECT";
$sql .= " *";
$sql .= " FROM";
$sql .= " blog";
$sql .= " WHERE";
$sql .= " del_flg = '0'";
$sql .= " and display_flg = 'open'";
$sql .= " ORDER BY blog_date DESC";

$stmt = $pdo->query($sql);
$stmt->execute();

while ($BLOG_REC = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$blog_rec_arr[$BLOG_REC['blog_no']] = $BLOG_REC;
	$blog_list_arr[$BLOG_REC['blog_no']] = $BLOG_REC['title'];
}

$cl_arr = $blog_rec_arr;
$cl_arr['modeling']['title'] = "「3Dモデリングサービス」LP";
$cl_arr['service']['title'] = "「パターンメイキング・グレーディング」LP";

// var_dump($cl_arr);

//表示・非表示を切り替える
if ($_REQUEST['act'] == "dis") {

	$sql = "UPDATE blog SET";
	$sql .= " " . $_REQUEST['column_name'] . " = :column_name";
	$sql .= " WHERE blog_no = :blog_no";

	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':column_name', $_REQUEST['column_value'], PDO::PARAM_STR);
	$stmt->bindValue(':blog_no', $_REQUEST['key_no'], PDO::PARAM_INT);
	$stmt->execute();

	$_POST['act'] = "";
	include("../include/xml_discharge.php");
}
if ($_REQUEST['act'] == "top") {
	$_POST['act'] = "add";
	$_POST['type'] = "regist";
}

//項目の追加
if (!empty($_POST['block_cnt_add']) or !empty($_POST['innner_cnt_add'])) {

	if (!empty($_POST['block_cnt_add'])) {
		$_POST['block_cnt']++;
		$_POST['act'] = "add";
	}
	if (!empty($_POST['innner_cnt_add'])) {
		$inner_cnt_key = "inner_cnt" . $_POST['innner_cnt_add'];
		$_POST[$inner_cnt_key]++;
		$_POST['act'] = "add";
	}

	$err_mess = array();
	$up_name = date("YmdHis", time());

	for ($i = 1; $i <= $_POST['up_file_cnt']; $i++) {
		$up_file_key = "up_file" . $i;
		$upfile_key = "upfile" . $i;
		$up_file_del_key = "up_file_del" . $i;
		$up_file_name = $_FILES[$upfile_key]["name"];
		$up_file_size = $_FILES[$upfile_key]["size"];
		$up_image_t = explode("\.", $up_file_name);
		$up_file_type = $up_image_t[1];
		$image_name1 = $up_image_t[0];
		$image_name1 = $up_name . "_" . $i;
		if ($_POST[$up_file_del_key] != "") {
			$del_path = $up_file_path . $_POST[$up_file_key];
			unlink($del_path);
			$_POST[$up_file_key] = "";
		}
		if ($err_mess != "") {
			foreach ($err_mess as $err_key) {
				if ($err_key != "") {
					$_POST['act'] = "err";
					$_POST['type'] = "regist";
					break;
				}
			}
		}
		if ($up_file_name != "") {
			if ($_POST[$up_file_key] != "") {
				$del_path = $up_file_path . $_POST[$up_file_key];
				unlink($del_path);
				$_POST[$up_file_key] = "";
			}
			$up_image1 = $up_file_path . $image_name1;
			$type = array("xls", "ppt", "pdf", "doc");
			$ret = UpFileCnv($upfile_key, $up_image1, "", "", $image_name1);
			$err_mess[] = $ret['err_mess'];
			if ($ret['file_name']) {
				$_POST[$up_file_key] = $ret['file_name'];
			}
		}
	}
	foreach ($err_mess as $err_key) {
		if ($err_key != "") {
			$_POST['act'] = "err";
			break;
		}
	}

	$division_keys = $_POST["division_key"];
	if (!in_array($_POST['block_cnt'], $division_keys)) {
		$division_keys[] = $_POST['block_cnt'];
	}
	foreach ($division_keys as $i) {
		// 	for ($i=1; $i <= $_POST['block_cnt']; $i++) {
		$up_file_key = "up_file_block" . $i;
		$upfile_key = "upfile_block" . $i;
		$up_file_del_key = "up_file_del_block" . $i;
		$inner_cnt_key = "inner_cnt" . $i;
		$up_file_name = $_FILES[$upfile_key]["name"];
		$up_file_size = $_FILES[$upfile_key]["size"];
		$up_image_t = explode("\.", $up_file_name);
		$up_file_type = $up_image_t[1];
		$image_name1 = $up_image_t[0];
		$image_name1 = $up_name . "_b" . $i;
		if ($_POST[$up_file_del_key] != "") {
			$del_path = $up_file_path . $_POST[$up_file_key];
			unlink($del_path);
			$_POST[$up_file_key] = "";
		}
		if ($err_mess != "") {
			foreach ($err_mess as $err_key) {
				if ($err_key != "") {
					$_POST['act'] = "err";
					$_POST['type'] = "regist";
					break;
				}
			}
		}
		if ($up_file_name != "") {
			if ($_POST[$up_file_key] != "") {
				$del_path = $up_file_path . $_POST[$up_file_key];
				unlink($del_path);
				$_POST[$up_file_key] = "";
			}
			$up_image1 = $up_file_path . $image_name1;
			$type = array("xls", "ppt", "pdf", "doc");
			$ret = UpFileCnv($upfile_key, $up_image1, "", "", $image_name1);
			$err_mess[] = $ret['err_mess'];
			if ($ret['file_name']) {
				$_POST[$up_file_key] = $ret['file_name'];
			}
		}

		$inner_division_keys[$i] = $_POST["inner_division_key"][$i];
		if (!in_array($_POST[$inner_cnt_key], $inner_division_keys[$i])) {
			$inner_division_keys[$i][] = $_POST[$inner_cnt_key];
		}
		foreach ($inner_division_keys[$i] as $i2) {
			// 		for($i2 = 1;$i2 <= $_POST[$inner_cnt_key];$i2++){
			$up_file_key = "up_file_inner" . $i . "_" . $i2;
			$upfile_key = "upfile_inner" . $i . "_" . $i2;
			$up_file_del_key = "up_file_del_inner" . $i . "_" . $i2;
			$up_file_name = $_FILES[$upfile_key]["name"];
			$up_file_size = $_FILES[$upfile_key]["size"];
			$up_image_t = explode("\.", $up_file_name);
			$up_file_type = $up_image_t[1];
			$image_name1 = $up_image_t[0];
			$image_name1 = $up_name . "_in" . $i . "_" . $i2;
			if ($_POST[$up_file_del_key] != "") {
				$del_path = $up_file_path . $_POST[$up_file_key];
				unlink($del_path);
				$_POST[$up_file_key] = "";
			}
			if ($err_mess != "") {
				foreach ($err_mess as $err_key) {
					if ($err_key != "") {
						$_POST['act'] = "err";
						// $_POST['type'] = "regist";
						break;
					}
				}
			}
			if ($up_file_name != "") {
				if ($_POST[$up_file_key] != "") {
					$del_path = $up_file_path . $_POST[$up_file_key];
					unlink($del_path);
					$_POST[$up_file_key] = "";
				}
				$up_image1 = $up_file_path . $image_name1;
				$type = array("xls", "ppt", "pdf", "doc");
				$ret = UpFileCnv($upfile_key, $up_image1, "", "", $image_name1);
				$err_mess[] = $ret['err_mess'];
				if ($ret['file_name']) {
					$_POST[$up_file_key] = $ret['file_name'];
				}
			}
		}
	}
	foreach ($err_mess as $err_key) {
		if ($err_key != "") {
			$_POST['act'] = "err";
			break;
		}
	}
}
if ($_POST['act'] == "") {
	$_POST['act'] = "list";
}
if ($_POST['act'] == "list") {
	$_POST['type'] = "";
}
//-----------------------------------------------------------------------------------------//
//一覧画面からの各処理
//-----------------------------------------------------------------------------------------//
if ($_POST['act2'] == "1") {

	$now_date = date("Y/m/d", time());
	$now_time = date("H:i:s", time());

	foreach ($_POST as $key => $value) {
		$key_no = array();
		$key_no = SplitChar($key, ":");
		if ($key_no[0] == "add") { //新規登録
			$_POST['act'] = "add";
			$_POST['type'] = "regist";
			break;
		}
		if ($key_no[0] == "upd") { //変更
			$_POST['act'] = "add";
			$_POST['type'] = "upd";
			break;
		}
		if ($key_no[0] == "del") { //削除
			$_POST['act'] = "conf";
			$_POST['type'] = "del";
			break;
		}
	}

	//変更・削除時の企業情報取得
	if ($_POST['type'] == "upd" or $_POST['type'] == "del") {

		$sql_updl = "SELECT";
		$sql_updl .= " *";
		$sql_updl .= " FROM";
		$sql_updl .= " blog";
		$sql_updl .= " WHERE";
		$sql_updl .= " blog_no = :blog_no";

		$stmt = $pdo->prepare($sql_updl);
		$stmt->bindParam(':blog_no', $key_no[1], PDO::PARAM_STR);

		$stmt->execute();
		if (!$stmt) {
			$info = $pdo->errorInfo();
			exit($info[2]);
		}

		$arr_updl = $stmt->fetch(PDO::FETCH_ASSOC);

		$_POST['blog_no'] = $arr_updl['blog_no'];
		$_POST['title'] = Br2Nr($arr_updl['title']);
		$_POST['education_name'] = Br2Nr($arr_updl['education_name']);
		$_POST['product_name'] = Br2Nr($arr_updl['product_name']);
		$_POST['lead_sentence'] = Br2Nr($arr_updl['lead_sentence']);
		$_POST['comment'] = Br2Nr($arr_updl['comment']);
		$_POST['category'] = explode(",", $arr_updl['category']);
		$_POST['related_service'] = explode(",", $arr_updl['related_service']);
		$_POST['category_recommend'] = explode(",", $arr_updl['category_recommend']);
		$_POST['related_service_recommend'] = explode(",", $arr_updl['related_service_recommend']);
		$_POST['material_no'] = $arr_updl['material_no'];
		$_POST['blog_date'] = $arr_updl['blog_date'];
		$_POST['keywords'] = preg_replace("/,/", "\n", $arr_updl['keywords']);
		$_POST['description'] = $arr_updl['description'];
		$_POST['up_file1'] = $arr_updl['up_file1'];
		$_POST['alt1'] = $arr_updl['alt1'];
		$_POST['right_column'] = explode(",", $arr_updl['right_column']);
		$_POST['cta_flg'] = explode(":", $arr_updl['cta_flg']);
		$_POST['cta_flg_second'] = explode(":", $arr_updl['product_name']);
		$_POST['slug'] = $arr_updl['slug'];
		$_POST['rec_main_title'] = $arr_updl['rec_main_title'];




		$sql_updl = "SELECT";
		$sql_updl .= " *";
		$sql_updl .= " FROM";
		$sql_updl .= " blog_other";
		$sql_updl .= " WHERE";
		$sql_updl .= " blog_no = :blog_no";
		$sql_updl .= " and parent_id = '0'";
		$sql_updl .= " order by blog_other_no";

		$stmt = $pdo->prepare($sql_updl);
		$stmt->bindParam(':blog_no', $key_no[1], PDO::PARAM_INT);

		$stmt->execute();

		if (!$stmt) {
			$info = $pdo->errorInfo();
			exit($info[2]);
		}


		$cnt_l = 0;
		while ($arr_updl = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$cnt_l++;
			$title_key = "title" . $cnt_l;
			$up_file_key = "up_file_block" . $cnt_l;
			$contents_commnt_key = "contents_commnt" . $cnt_l;
			$inner_cnt_key = "inner_cnt" . $cnt_l;
			$blog_image_view_key = "blog_image_view" . $cnt_l;
			$innner_alt_key = "innner_alt" . $cnt_l;
			$_POST[$title_key] = Br2Nr($arr_updl['subtitle']);
			$_POST[$up_file_key] = $arr_updl['up_file1'];
			$_POST[$innner_alt_key] = $arr_updl['up_file_alt1'];
			$_POST[$blog_image_view_key] = Br2Nr($arr_updl['blog_image_view']);
			$_POST[$contents_commnt_key] = Br2Nr($arr_updl['subcomment']);

			// innerbox
			$sql_in = "SELECT";
			$sql_in .= " *";
			$sql_in .= " FROM";
			$sql_in .= " blog_other";
			$sql_in .= " WHERE";
			$sql_in .= " blog_no = :blog_no";
			$sql_in .= " and parent_id = :parent_id";
			$sql_in .= " order by blog_other_no";

			$stmt_inm = $pdo->prepare($sql_in);
			$stmt_inm->bindParam(':blog_no', $key_no[1], PDO::PARAM_INT);
			$stmt_inm->bindParam(':parent_id', $arr_updl['blog_other_no'], PDO::PARAM_INT);

			$stmt_inm->execute();


			$cnt_l2 = 0;
			while ($arr_updl_in = $stmt_inm->fetch(PDO::FETCH_ASSOC)) {
				$cnt_l2++;
				$inner_title_key = "inner_title" . $cnt_l . "_" . $cnt_l2;
				$inner_comment_key = "inner_comment" . $cnt_l . "_" . $cnt_l2;
				$up_file_key = "up_file_inner" . $cnt_l . "_" . $cnt_l2;
				$up_file_alt_key = "up_file_alt" . $cnt_l . "_" . $cnt_l2;
				$inner_blog_image_view_key = "inner_blog_image_view" . $cnt_l . "_" . $cnt_l2;
				$url_key = "url" . $cnt_l . "_" . $cnt_l2;
				$_POST[$inner_title_key] = Br2Nr($arr_updl_in['subtitle']);
				$_POST[$up_file_key] = $arr_updl_in['up_file1'];
				$_POST[$up_file_alt_key] = $arr_updl_in['up_file_alt1'];
				$_POST[$inner_blog_image_view_key] = $arr_updl_in['blog_image_view'];
				$_POST[$inner_comment_key] = Br2Nr($arr_updl_in['subcomment']);
			}
			$_POST[$inner_cnt_key] = $cnt_l2;

			// 関連する記事
			$sql_rec = "SELECT";
			$sql_rec .= " *";
			$sql_rec .= " FROM";
			$sql_rec .= " blog_item";
			$sql_rec .= " WHERE";
			$sql_rec .= " blog_no = :blog_no";
			$sql_rec .= " order by blog_item_no";

			$stmt_rec = $pdo->prepare($sql_rec);
			$stmt_rec->bindParam(':blog_no', $key_no[1], PDO::PARAM_INT);

			$stmt_rec->execute();

			$cnt_rec = 0;
			while ($arr_updl_rec = $stmt_rec->fetch(PDO::FETCH_ASSOC)) {
				$cnt_rec++;
				$title_key = "rec_title" . $cnt_rec;
				$url_key = "rec_url" . $cnt_rec;
				$_POST[$title_key] = $arr_updl_rec['title'];
				$_POST[$url_key] = $arr_updl_rec['url'];
			}
		}
		$_POST['block_cnt'] = $cnt_l;
	}
}


//-----------------------------------------------------------------------------------------//
//入力チェック・画像処理
//-----------------------------------------------------------------------------------------//
if ($_POST['act'] == "conf") {

	$err_mess = array();
	$up_name = date("YmdHis", time());

	for ($i = 1; $i <= $_POST['up_file_cnt']; $i++) {
		$up_file_key = "up_file" . $i;
		$upfile_key = "upfile" . $i;
		$up_file_del_key = "up_file_del" . $i;
		$up_file_name = $_FILES[$upfile_key]["name"];
		$up_file_size = $_FILES[$upfile_key]["size"];
		$up_image_t = explode("\.", $up_file_name);
		$up_file_type = $up_image_t[1];
		$image_name1 = $up_image_t[0];
		$image_name1 = $up_name . "_" . $i;
		if ($_POST[$up_file_del_key] != "" and $_POST['act'] == "conf") {
			$del_path = $up_file_path . $_POST[$up_file_key];
			unlink($del_path);
			$_POST[$up_file_key] = "";
		}
		if ($err_mess != "") {
			foreach ($err_mess as $err_key) {
				if ($err_key != "") {
					$_POST['act'] = "err";
					$_POST['type'] = "regist";
					break;
				}
			}
		}
		if ($_POST['act'] == "conf" and $up_file_name != "") {
			if ($_POST[$up_file_key] != "") {
				$del_path = $up_file_path . $_POST[$up_file_key];
				unlink($del_path);
				$_POST[$up_file_key] = "";
			}
			$up_image1 = $up_file_path . $image_name1;
			$type = array("xls", "ppt", "pdf", "doc");
			$ret = UpFileCnv($upfile_key, $up_image1, "", "", $image_name1);
			$err_mess[] = $ret['err_mess'];
			if ($ret['file_name']) {
				$_POST[$up_file_key] = $ret['file_name'];
			}
		}
	}
	for ($i = 1; $i <= $_POST['block_cnt']; $i++) {
		$title_key = "title" . $i;
		$up_file_key = "up_file_block" . $i;
		$upfile_key = "upfile_block" . $i;
		$up_file_del_key = "up_file_del_block" . $i;
		$inner_cnt_key = "inner_cnt" . $i;
		$up_file_name = $_FILES[$upfile_key]["name"];
		$up_file_size = $_FILES[$upfile_key]["size"];
		$up_image_t = explode("\.", $up_file_name);
		$up_file_type = $up_image_t[1];
		$image_name1 = $up_image_t[0];
		$image_name1 = $up_name . "_b" . $i;
		if ($_POST[$up_file_del_key] != "" and $_POST['act'] == "conf") {
			$del_path = $up_file_path . $_POST[$up_file_key];
			unlink($del_path);
			$_POST[$up_file_key] = "";
		}
		if ($err_mess != "") {
			foreach ($err_mess as $err_key) {
				if ($err_key != "") {
					$_POST['act'] = "err";
					$_POST['type'] = "regist";
					break;
				}
			}
		}
		if ($_POST['act'] == "conf" and $up_file_name != "") {
			if ($_POST[$up_file_key] != "") {
				$del_path = $up_file_path . $_POST[$up_file_key];
				unlink($del_path);
				$_POST[$up_file_key] = "";
			}
			$up_image1 = $up_file_path . $image_name1;
			$type = array("xls", "ppt", "pdf", "doc");
			$ret = UpFileCnv($upfile_key, $up_image1, "", "", $image_name1);
			$err_mess[] = $ret['err_mess'];
			if ($ret['file_name']) {
				$_POST[$up_file_key] = $ret['file_name'];
			}
		}


		for ($i2 = 1; $i2 <= $_POST[$inner_cnt_key]; $i2++) {
			$up_file_key = "up_file_inner" . $i . "_" . $i2;
			$upfile_key = "upfile_inner" . $i . "_" . $i2;
			$up_file_del_key = "up_file_del_inner" . $i . "_" . $i2;
			$up_file_name = $_FILES[$upfile_key]["name"];
			$up_file_size = $_FILES[$upfile_key]["size"];
			$up_image_t = explode("\.", $up_file_name);
			$up_file_type = $up_image_t[1];
			$image_name1 = $up_image_t[0];
			$image_name1 = $up_name . "_in" . $i . "_" . $i2;
			if ($_POST[$up_file_del_key] != "" and $_POST['act'] == "conf") {
				$del_path = $up_file_path . $_POST[$up_file_key];
				unlink($del_path);
				$_POST[$up_file_key] = "";
			}
			if ($err_mess != "") {
				foreach ($err_mess as $err_key) {
					if ($err_key != "") {
						$_POST['act'] = "err";
						// $_POST['type'] = "regist";
						break;
					}
				}
			}
			if ($up_file_name != "") {
				if ($_POST[$up_file_key] != "") {
					$del_path = $up_file_path . $_POST[$up_file_key];
					unlink($del_path);
					$_POST[$up_file_key] = "";
				}
				$up_image1 = $up_file_path . $image_name1;
				$type = array("xls", "ppt", "pdf", "doc");
				$ret = UpFileCnv($upfile_key, $up_image1, "", "", $image_name1);
				$err_mess[] = $ret['err_mess'];
				if ($ret['file_name']) {
					$_POST[$up_file_key] = $ret['file_name'];
				}
			}
		}
	}

	//入力チェック
	//	$err_mess[] = SelectChk($_POST[tm_user],"担当者");
	//	$err_mess[] = InputChk($_POST[end_date],"終了日");
	//	$err_mess[] = InputChk($_POST[title],"タイトル");
	if (!preg_match('/^[0-9a-z_-]+$/', $_POST['slug'])) {
		$err_mess[] = 'スラッグは半角英数アンダーバーで入力してください。';
	}
	$sql_slug = "SELECT";
	$sql_slug .= " *";
	$sql_slug .= " FROM";
	$sql_slug .= " blog";
	$sql_slug .= " WHERE";
	$sql_slug .= " slug = '" . $_POST['slug'] . "'";
	//パラメーター配列の初期化
	$prm = array();
	//パラメーターを使いSQLの作成
	$sql_slug = createSQL($sql_slug, $prm);
	$stmt = $pdo->query($sql_slug);
	$row_num_slug = $stmt->rowCount();
	if ($_POST['type'] == "upd" or $_POST['type'] == "del") {
		$key_num = 1;
	} else {
		$key_num = 0;
	}
	if ($row_num_slug > $key_num) {
		$err_mess[] = 'スラッグはユニークです';
	}
	//エラーチェック
	foreach ($err_mess as $err_key) {
		if ($err_key != "") {
			$_POST['act'] = "err";
			break;
		}
	}
}
/*キーの設定*/
$act_type_key = $_POST['act'] . "_" . $_POST['type'];
//-----------------------------------------------------------------------------------------//
//検索・一覧画面
//-----------------------------------------------------------------------------------------//
if ($_POST['act'] == "list") {
	if ($_REQUEST['ret_del'] == "1") {
		$_SESSION['sys']['management_p']['job'] = array();
	}
	//1ページに表示する件数
	$page_view = 20;
	if ($_POST['ret'] == "1") {
		$_SESSION['sys']['management_p']['job']['page'] = "1";
	}
	if (empty($_SESSION['sys']['management_p']['job']['page'])) {
		$_SESSION['sys']['management_p']['job']['page'] = 1;
	}
	if ($_REQUEST['dis'] == "1") {
		$_SESSION['sys']['management_p']['job']['page'] = $_REQUEST['page'];
	} else {
		$_SESSION['sys']['management_p']['job']['page'] = 1;
	}
	$base_page = $_SESSION['sys']['management_p']['job']['page'];

	if ($base_page == 1) {
		$offset = 0;
	} else {
		$offset_key = $base_page - 1;
		$offset = $offset_key * $page_view;
	}
	/*ファイル数の取得*/
	$sql = "SELECT";
	$sql .= " *";
	$sql .= " FROM";
	$sql .= " blog";
	$sql .= " WHERE";
	$sql .= " del_flg = '0'";
	$sql .= " ORDER BY blog_date DESC";

	//パラメーター配列の初期化
	$prm = array();
	// $prm[] = '0';

	//パラメーターを使いSQLの作成
	$sql_mat_num = createSQL($sql, $prm);
	//SQLを実行
	// $result_mat_num = ExecSQL($sql_mat_num,null);

	$stmt = $pdo->query($sql_mat_num);
	$stmt->execute();
	$row_num_inq_comp = $stmt->rowCount();
	if (!$stmt) {
		$info = $pdo->errorInfo();
		exit($info[2]);
	}


	if ($base_page == "1") {
		$dis_a = 1;
		if ($row_num_inq_comp < $page_view) {
			$dis_b = $row_num_inq_comp;
		} else {
			$dis_b = $page_view;
		}
	} else {
		$dis_b_key = $base_page * $page_view;
		$dis_a = (($base_page - 1) * $page_view) + 1;
		if ($row_num_inq_comp < $dis_b_key) {
			$dis_b = $row_num_inq_comp;
		} else {
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
					<th style="width:10%;">日時</th>
					<th style="width:34%;">ブログタイトル</th>
					<th style="width:22%;">カテゴリ</th>
					<th style="width:6%;">TOP</th>
					<!-- <th style="width:6%;">記事TOP</th> -->
					<th style="width:6%;">掲載</th>
					<th style="width:6%;">ランキング</th>
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
				$sql_mat_num = createSQL($sql, $prm);
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
					$category_arr = explode(",", $PG_REC_MAT['category']);
					// 日時
					echo "<tr>\n";
					echo "	<td>" . $PG_REC_MAT['blog_date'] . "</td>\n";
					// ブログタイトル
					echo "	<td>";
					if ($PG_REC_MAT['display_flg'] == "close") {
						echo "	<p><a href=\"../../../blog/detail.php?b_no=" . $PG_REC_MAT['blog_no'] . "&mode=test\" target=\"_blank\">" . $PG_REC_MAT['title'] . "</a></p>";
					} else {
						echo "	<p><a href=\"../../../blog/detail.php?b_no=" . $PG_REC_MAT['blog_no'] . "\" target=\"_blank\">" . $PG_REC_MAT['title'] . "</a></p>";
					}
					echo "</td>\n";
					// カテゴリ
					echo "	<td>\n";
					foreach ($category_arr as $category_value) {
						echo "<p>" . $item_list['blog_category'][$category_value] . "</p>\n";
					}
					echo "</td>\n";
					// TOP
					echo "	<td style=\"text-align:center;\">\n";
					if ($PG_REC_MAT['new_flg'] == "open") {
						echo "<a href=\"" . $now_page . "?t=" . time() . "&act=dis&column_name=new_flg&column_value=close&key_no=" . $PG_REC_MAT['blog_no'] . "\" onClick=\"if( !confirm('新着を解除しますか？') ) { return false; }\">○</a>";
					} else {
						echo "<a href=\"" . $now_page . "?t=" . time() . "&act=dis&column_name=new_flg&column_value=open&key_no=" . $PG_REC_MAT['blog_no'] . "\" onClick=\"if( !confirm('新着に登録しますか？') ) { return false; }\">×</a>";
					}
					echo "</td>\n";
					// echo "	<td style=\"text-align:center;\">\n";
					// if($PG_REC_MAT['pickup_flg'] == "open"){
					// 	echo "<a href=\"".$now_page."?t=".time()."&act=dis&column_name=pickup_flg&column_value=close&key_no=".$PG_REC_MAT['blog_no']."\" onClick=\"if( !confirm('pickupを解除しますか？') ) { return false; }\">○</a>";
					// }else{
					// 	echo "<a href=\"".$now_page."?t=".time()."&act=dis&column_name=pickup_flg&column_value=open&key_no=".$PG_REC_MAT['blog_no']."\" onClick=\"if( !confirm('pickupに登録しますか？') ) { return false; }\">×</a>";
					// }
					// echo "</td>\n";

					// 掲載項目
					echo "	<td style=\"text-align:center;\">\n";
					if ($PG_REC_MAT['display_flg'] == "open") {
						echo "<a href=\"" . $now_page . "?t=" . time() . "&act=dis&column_name=display_flg&column_value=close&key_no=" . $PG_REC_MAT['blog_no'] . "\" onClick=\"if( !confirm('非掲載にしますか？') ) { return false; }\">○</a>";
					} else {
						echo "<a href=\"" . $now_page . "?t=" . time() . "&act=dis&column_name=display_flg&column_value=open&key_no=" . $PG_REC_MAT['blog_no'] . "\" onClick=\"if( !confirm('掲載しますか？') ) { return false; }\">×</a>";
					}
					echo "</td>\n";
					// ランキング表示
					echo "	<td style=\"text-align:center;\">\n";
					if ($PG_REC_MAT['ranking_flg'] == "open") {
						echo "<a href=\"" . $now_page . "?t=" . time() . "&act=dis&column_name=ranking_flg&column_value=close&key_no=" . $PG_REC_MAT['blog_no'] . "\" onClick=\"if( !confirm('ランキングより非表示にしますか？') ) { return false; }\">○</a>";
					} else {
						echo "<a href=\"" . $now_page . "?t=" . time() . "&act=dis&column_name=ranking_flg&column_value=open&key_no=" . $PG_REC_MAT['blog_no'] . "\" onClick=\"if( !confirm('ランキングに掲載しますか？') ) { return false; }\">×</a>";
					}
					echo "</td>\n";
					// 更新
					echo "	<td style=\"text-align:center;\">\n";
					echo "	<input type=\"submit\" name=\"upd:" . $PG_REC_MAT['blog_no'] . "\" class=\"submit01\" value=\"更新\">\n";
					echo "	</td>\n";
					// 削除
					echo "	<td style=\"text-align:center;\">\n";
					echo "	<input type=\"submit\" name=\"del:" . $PG_REC_MAT['blog_no'] . "\" value=\"削除\" class=\"submit01\">\n";
					echo "	</td>\n";
					echo "</tr>\n";
				}
				?>
			</table>

			<table style="width:500px;margin:0 auto 20px;">
				<tr>
					<td align="center">
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
							if ($page_st < 0) {
								$page_st = "0";
							}
						}

						if ($page_st > 0) {
							echo "		&nbsp;<a href=\"" . $now_page . "?t=" . time() . "&page=1&dis=1\"><< 先頭へ</a>\n";
						}

						if ($base_page > 1) {
							$b_page = $base_page - 1;
							echo "		&nbsp;<a href=\"" . $now_page . "?t=" . time() . "&page=" . $b_page . "&dis=1\">< 前へ</a>\n";
						}

						if ($row_num_inq_comp > $page_view) {
							//for ($i=0; $i<$page_no_cnt; $i++) {
							for ($i = $page_st; $i < $page_ed; $i++) {
								$page_no = $i + 1;
								if ($page_no != $base_page) {
									echo "&nbsp;<a href=\"" . $now_page . "?t=" . time() . "&page=" . $page_no . "&dis=1\">" . $page_no . "</a>";
								} else {
									echo "&nbsp;" . $page_no;
								}
							}
						}


						//最後のページの場合は非表示-->
						if ($page_no_cnt > $base_page) {
							$n_page = $base_page + 1;
							echo "		&nbsp;<a href=\"" . $now_page . "?t=" . time() . "&page=" . $n_page . "&dis=1\">次へ ></a>\n";
						}

						if ($page_no_cnt != $page_ed) {
							echo "		&nbsp;<a href=\"" . $now_page . "?t=" . time() . "&page=" . $page_no_cnt . "&dis=1\">最後 >></a>\n";
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
if ($_POST['act'] == "add" or $_POST['act'] == "err") {

	$jsonPostVals = HiddenDecodeViewJSON($_POST);
	if (!empty($jsonPostVals)) {
		foreach ($jsonPostVals as $key => $value) {
			$_POST[$key] = $value;
		}
	}

	if ($_POST['block_cnt'] == "" or $_POST['block_cnt'] == "0") {
		$_POST['block_cnt'] = "1";
	}
	if (empty($_POST['blog_date'])) {
		$_POST['blog_date'] = date("Y-m-d", time());
	}
	$_POST['rec_cnt'] = "5";
?>

	<script type="text/javascript">
		$(function() {
			// フォントサイズ
			$(".subbtn_font_size").click(function() {
				var svalue = $(this).parents("td").find("#f_size").val();
				var selectvalue = "";
				if (svalue > 0) {
					selectvalue = "font-size:" + svalue + "px;";
				}
				if (document.all) { //IE
					var str = document.selection.createRange().text;
					document.selection.createRange().text = "<span style='" + selectvalue + "'>" + str + "</span>";
				} else { //Firefox
					var el = $(this).parents("td").find("#box").get(0);
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
			$(".subbtn_font_color").click(function() {
				var svalue = $(this).parents("td").find("#color").val();

				if (document.all) { //IE
					var str = document.selection.createRange().text;
					document.selection.createRange().text = "<span style='color:#" + svalue + "'>" + str + "</span>";
				} else { //Firefox
					var el = $(this).parents("td").find("#box").get(0);
					var sPos = el.selectionStart;
					var ePos = el.selectionEnd;
					var str = el.value.substring(sPos, ePos);
					el.value =
						el.value.substring(0, sPos) +
						"<span style='color:#" + svalue + "'>" + str + "</span>" +
						el.value.substr(ePos);
				}
			});


			// 関連する記事
			$(".subbtn_rec_blog").click(function() {
				var svalue = $(this).parents("td").find("#r_blog").val();
				var selectvalue = "";
				var blog_title = "";
				var blog_lead_sentence = "";
				var blog_up_file1 = "";
				var blog_no = "";
				var slug = "";
				var blog_date = "";
				var link_url = "";
				var cl_type = "";
				switch (svalue) {
					<?php foreach ($blog_rec_arr as $key => $value) : ?>
						case "<?php echo $key ?>":
							blog_title = "<?php echo preg_replace('/"/', '\"', $value['title']) ?>";
							blog_lead_sentence = "<?php echo mb_strimwidth(preg_replace('/"/', '\"', strip_tags($value['lead_sentence'])), 0, 190, "...", "UTF-8") ?>";
							blog_up_file1 = "/cad/up_file/<?php echo $value['up_file1'] ?>";
							blog_no = "<?php echo $key ?>";
							slug = "<?php echo $value['slug'] ?>";
							blog_date = "<?php echo $value['blog_date'] ?>";
							link_url = "/cad/blog/detail/<?php echo $value['slug'] ?>";
							break;
						<?php endforeach ?>
					case "modeling":
						blog_title = "3Dモデリングサービス";
						blog_lead_sentence = "ファッション3Dのモデリングとは、これまでに2D（CAD）のみで作図してきたパターン（型紙）を3Dモデルと連動し、パターン作成～商品画像までワンストップで制作できるサービスです。";
						blog_up_file1 = "/cad/assets/img/modeling/modeling-img01_cl.png";
						blog_no = "";
						slug = "";
						blog_date = "";
						link_url = "/cad/modeling/";
						cl_type = "lp";
						break;
					case "service":
						blog_title = "パターンメイキング・グレーディング";
						blog_lead_sentence = "迅速・リーズナブル・高品質」をモットーに、パターンメイキングからグレーディングの外注サービスを提供しています。急ぎのご相談から、パターンサンプル作成、小ロット対応までお気軽にご相談下さい。";
						blog_up_file1 = "/cad/assets/img/price/price_wp_cl.jpg";
						blog_no = "";
						slug = "";
						blog_date = "";
						link_url = "/cad/service/";
						cl_type = "lp";
						break;
				}

				selectvalue = "<a href='" + link_url + "' class='cardlink'>";
				selectvalue += "<figure class='cardlink__img'><img src='" + blog_up_file1 + "' alt=''></figure>";
				selectvalue += "<summary class='cardlink__box'>";
				if (blog_date) {
					selectvalue += "<div class='cardlink__box__time'>";
					selectvalue += "<span>関連記事</span>";
					selectvalue += "<time>" + blog_date + "</time>";
					selectvalue += "</div>";
				}
				selectvalue += "<div class='cardlink__box__ttl'>" + blog_title + "</div>";
				selectvalue += "<div class='cardlink__box__txt'>" + blog_lead_sentence + "</div>";
				selectvalue += "</summary>";
				selectvalue += "</a>";

				if (document.all) { //IE
					var str = document.selection.createRange().text;
					document.selection.createRange().text = selectvalue;
				} else { //Firefox
					var el = $(this).parents("td").find("#box").get(0);
					var sPos = el.selectionStart;
					var ePos = el.selectionEnd;
					var str = el.value.substring(sPos, ePos);
					el.value =
						el.value.substring(0, sPos) + selectvalue +
						el.value.substr(ePos);
				}
			});






			// 太字
			$(".subbtn_bold").click(function() {
				if (document.all) { //IE
					var str = document.selection.createRange().text;
					document.selection.createRange().text = "<span style=font-weight:bold;>" + str + "</span>";
				} else { //Firefox
					var el = $(this).parents("td").find("#box").get(0);
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
			$(".subbtn_ank").click(function() {
				var link_text = $(this).parents("td").find("#ank_txt").val();
				var svalue = $(this).parents("td").find("#l_type").val();
				var selectvalue = "";
				if (svalue == 2) {
					selectvalue = " target='_blank'";
				}
				if (document.all) { //IE
					var str = document.selection.createRange().text;
					document.selection.createRange().text = "<a href='" + link_text + "'" + selectvalue + ">" + str + "</a>";
				} else { //Firefox
					var el = $(this).parents("td").find("#box").get(0);
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


	<div id="contents">

		<h2><?php echo $main_title; ?><?php echo $page_title_sub_list[$act_type_key]; ?></h2>
		<p class="stext">下記項目を記入の上、「<?php echo $type_comment_list[$act_type_key]; ?>」ボタンをクリックしてください。<br />
			（※は入力必須項目です）<br />
			登録後、当社担当者が内容確認の上本掲載をさせていただきます。
		</p>
		<?php
		if ($_POST['act'] == "err") {
			echo "<p style=\"color:#990000;\">" . Arr2Val($err_mess) . "</p>";
			echo $err_count;
		}
		?>

		<form action="<?php echo $now_page; ?>?t=<?php echo time(); ?>" method="post" name="FORM1" enctype="multipart/form-data">
			<script type="text/javascript">
				$(function() {
					$("#soat_able").sortable();
					$('#soat_able').bind('sortstop', function() {
						// 		alert();
						return true;
					});
				});
			</script>
			<table class="Tblform">
				<tr>
					<th>日時<span>※</span></th>
					<td>
						<input type="text" name="blog_date" value="<?php echo $_POST['blog_date']; ?>" size="15" autocomplete="off" class="calender">
					</td>
				</tr>
				<tr>
					<th>ブログタイトル<span>※</span></th>
					<td>

						<textarea name="title" cols="60" rows="5" class="form_color_r"><?php echo $_POST['title']; ?></textarea>
					</td>
				</tr>
				<tr>
					<th>タイトル下テキスト</th>
					<td>
						<textarea name="comment" cols="60" rows="5" class="form_color_r"><?php echo $_POST['comment']; ?></textarea>
					</td>
				</tr>
				<tr>
					<th>スラッグ<span>※</span></th>
					<td>
						<input type="text" name="slug" value="<?php echo $_POST['slug']; ?>" class="form_color_r">
					</td>
				</tr>
				<tr>
					<th>カテゴリ<span>※</span></th>
					<td class="tag_style">
						<?php
						foreach ($item_list['blog_category'] as $key => $value) {
							$ckecked = "";
							$clss_ckecked = "";
							if (in_array($key, (array)$_POST['category'])) {
								$clss_ckecked = "selected";
								$ckecked = " checked";
							}
						?>
							<input type="checkbox" name="category[]" id="category<?php echo $key; ?>" value="<?php echo $key; ?>" <?php echo $ckecked; ?> /><label for="category<?php echo $key; ?>" class="<?php echo $clss_ckecked; ?>"><?php echo $value; ?></label>
						<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<th>カテゴリおすすめ</th>
					<td class="tag_style">
						<?php
						foreach ($item_list['blog_category'] as $key => $value) {
							$ckecked = "";
							$clss_ckecked = "";
							if (in_array($key, (array)$_POST['category_recommend'])) {
								$clss_ckecked = "selected";
								$ckecked = " checked";
							}
						?>
							<input type="checkbox" name="category_recommend[]" id="category_recommend<?php echo $key; ?>" value="<?php echo $key; ?>" <?php echo $ckecked; ?> /><label for="category_recommend<?php echo $key; ?>" class="<?php echo $clss_ckecked; ?>"><?php echo $value; ?></label>
						<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<th>関連する資料<span>※</span></th>
					<td>
						<select name="material_no" id="" class="form_color_r" style="max-width: 570px;">
							<option value="0">
								<?php echo SelectView("material_no", $material_arr, ""); ?>
						</select>
					</td>
				</tr>
				<tr>
					<th>CTA表示</th>
					<td class="tag_style">
						<?php
						foreach ($cta_veiw_list as $key => $value) {
							$ckecked = "";
							$clss_ckecked = "";
							if (in_array($key, (array)$_POST['cta_flg'])) {
								$clss_ckecked = "selected";
								$ckecked = " checked";
							}
						?>
							<input type="checkbox" name="cta_flg[]" id="cta_flg<?php echo $key; ?>" value="<?php echo $key; ?>" <?php echo $ckecked; ?> /><label for="cta_flg<?php echo $key; ?>" class="<?php echo $clss_ckecked; ?>"><?php echo $value; ?></label>
						<?php
						}
						?>
					</td>
				</tr>
				<?php
				for ($i = 1; $i <= $_POST['up_file_cnt']; $i++) {
					$up_file_key = "up_file" . $i;
					$upfile_key = "upfile" . $i;
					$up_file_del_key = "up_file_del" . $i;
					$alt_key = "alt" . $i;
				?>
					<tr>
						<th><?php echo $upfile_title_list[$i]; ?></th>
						<td>
							<input type="file" name="<?php echo $upfile_key; ?>" size="40">
							<?php if ($_POST[$up_file_key] != "") { ?>
								<br><a href="<?php echo $up_file_path . $_POST[$up_file_key]; ?>" target="_blank"><?php echo $_POST[$up_file_key]; ?></a>
								<input type="hidden" name="<?php echo $up_file_key; ?>" value="<?php echo $_POST[$up_file_key]; ?>">
								　<input type="checkbox" name="<?php echo $up_file_del_key; ?>[]" value="1">ファイルを削除
							<?php } ?>
						</td>
					</tr>
					<tr>
						<th>ALTタグ</th>
						<td>
							<input type="text" name="<? echo $alt_key; ?>" value="<?php echo $_POST[$alt_key]; ?>" size="50">
						</td>
					</tr>
				<?php
				}
				?>
				<tr>
					<th>リード文</th>
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
								for ($f = $fontsize_min; $f <= $fontsize_max; $f++) {
									echo "<option value=\"" . $f . "\">" . $f . "px\n";
								}
								?>
							</select>
							<input type="button" value="文字サイズ" class="subbtn subbtn_font_size">

							<input type="text" class="color" id="color" name="color0" /><input type="button" value="フォントカラー" class="subbtn subbtn_font_color">
						</p>

						<textarea name="lead_sentence" cols="60" rows="5" class="form_color_r" id="box"><?php echo $_POST['lead_sentence']; ?></textarea>
					</td>
				</tr>
				<tr>
					<th>リード文と目次の間のCTA表示</th>
					<td class="tag_style">
						<?php
						foreach ($cta_veiw_list as $key => $value) {
							$ckecked = "";
							$clss_ckecked = "";
							if (in_array($key, (array)$_POST['cta_flg_second'])) {
								$clss_ckecked = "selected";
								$ckecked = " checked";
							}
						?>
							<input type="checkbox" name="cta_flg_second[]" id="cta_flg_second<?php echo $key; ?>" value="<?php echo $key; ?>" <?php echo $ckecked; ?> /><label for="cta_flg_second<?php echo $key; ?>" class="<?php echo $clss_ckecked; ?>"><?php echo $value; ?></label>
						<?php
						}
						?>
					</td>
				</tr>
				<tbody id="soat_able">
					<?php
					if (empty($division_keys)) {
						$division_keys = array();
						for ($i = 1; $i <= $_POST['block_cnt']; $i++) {
							$division_keys[] = $i;
						}
					}
					foreach ($division_keys as $i) {
						// for ($i=1; $i <= $_POST['block_cnt']; $i++) {
						// 	$division_key = "division" . $i;
						$title_key = "title" . $i;
						$up_file_key = "up_file_block" . $i;
						$upfile_key = "upfile_block" . $i;
						$up_file_del_key = "up_file_del_block" . $i;
						$contents_commnt_key = "contents_commnt" . $i;
						$blog_image_view_key = "blog_image_view" . $i;
						$inner_cnt_key = "inner_cnt" . $i;
						$innner_cnt_add_key = "innnercntadd_" . $i;
						$innner_alt_key = "innner_alt" . $i;


						if (empty($_POST[$inner_cnt_key])) {
							$_POST[$inner_cnt_key] = "1";
						}
					?>
						<tr>
							<th>
								段落<?php echo $i; ?>
								<input type="hidden" name="division_key[]" value="<?= $i ?>" />
							</th>
							<td style="padding: 1px;">

								<table class="Tblform" style="margin: 0px;">

									<tr>
										<th>タイトル</th>
										<td>
											<textarea name="<?php echo $title_key; ?>" cols="60" rows="2" class="form_color_r"><?php echo $_POST[$title_key]; ?></textarea>
										</td>
									</tr>
									<tr>
										<th>段落下画像</th>
										<td>
											<input type="file" name="<?php echo $upfile_key; ?>" size="40">
											<?php if ($_POST[$up_file_key] != "") { ?>
												<br><a href="<?php echo $up_file_path . $_POST[$up_file_key]; ?>" target="_blank"><?php echo $_POST[$up_file_key]; ?></a>
												<input type="hidden" name="<?php echo $up_file_key; ?>" value="<?php echo $_POST[$up_file_key]; ?>">
												　<input type="checkbox" name="<?php echo $up_file_del_key; ?>[]" value="1">ファイルを削除
											<?php } ?>
										</td>
									</tr>
									<tr>
										<th>ALTタグ</th>
										<td>
											<input type="text" name="<?php echo $innner_alt_key; ?>" value="<?php echo $_POST[$innner_alt_key]; ?>" size="50">
										</td>
									</tr>
									<tr>
										<th>画像表示位置</th>
										<td>
											<select name="<?php echo $blog_image_view_key; ?>" id="" class="form_color_r">
												<option value="">
													<?php echo SelectView($blog_image_view_key, $item_list['blog_image_view'], ""); ?>
											</select>
										</td>
									</tr>
									<tr>
										<th>段落下文章</th>
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
													for ($f = $fontsize_min; $f <= $fontsize_max; $f++) {
														echo "<option value=\"" . $f . "\">" . $f . "px\n";
													}
													?>
												</select>
												<input type="button" value="文字サイズ" class="subbtn subbtn_font_size">

												<input type="text" class="color" id="color" name="color0" /><input type="button" value="フォントカラー" class="subbtn subbtn_font_color">
											</p>

											<p style="margin-bottom:5px;">
												<select id="r_blog" name="rec_blog" style="max-width: 400px;">
													<?php
													foreach ($cl_arr as $key => $value) {
														echo "<option value=\"" . $key . "\">" . $value['title'] . "\n";
													}
													?>
												</select>
												<input type="button" value="カードリンクの挿入" class="subbtn subbtn_rec_blog">
											</p>

											<textarea name="<?php echo $contents_commnt_key; ?>" cols="60" rows="5" class="form_color_r" id="box"><?php echo $_POST[$contents_commnt_key]; ?></textarea>
										</td>
									</tr>

									<tbody id="soat_able_div_<?= $i ?>">
										<script type="text/javascript">
											$(function() {
												$("#soat_able_div_<?= $i ?>").sortable();
												$('#soat_able_div_<?= $i ?>').bind('sortstop', function() {
													$(this).find("tr:last th").append($(this).find("p.midashi_add"));
													return true;
												});
											});
										</script>
										<?php
										if (empty($inner_division_keys[$i])) {
											$inner_division_keys[$i] = $_POST["inner_division_key"][$i];
											if (empty($inner_division_keys[$i])) {
												$inner_division_keys[$i] = array();
												for ($ix = 1; $ix <= $_POST[$inner_cnt_key]; $ix++) {
													$inner_division_keys[$i][] = $ix;
												}
											}
										}
										$tmp_idx = 0;
										foreach ($inner_division_keys[$i] as $i2) {
											$tmp_idx++;
											// 	for($i2 = 1;$i2 <= $_POST[$inner_cnt_key];$i2++){
											$inner_title_key = "inner_title" . $i . "_" . $i2;
											$inner_comment_key = "inner_comment" . $i . "_" . $i2;
											$inner_blog_image_view_key = "inner_blog_image_view" . $i . "_" . $i2;
											$up_file_key = "up_file_inner" . $i . "_" . $i2;
											$upfile_key = "upfile_inner" . $i . "_" . $i2;
											$up_file_del_key = "up_file_del_inner" . $i . "_" . $i2;
											$url_key = "url" . $i . "_" . $i2;
											$up_file_alt_key = "up_file_alt" . $i . "_" . $i2;
										?>
											<tr>
												<th>見出し<?php echo $i2; ?>
													<?php
													if (count($inner_division_keys[$i]) == $tmp_idx) {
													?>
														<p class="midashi_add"><button type="submit" name="innner_cnt_add" value="<?php echo $i; ?>">見出しを追加</button>
															<input type="hidden" name="<?php echo $inner_cnt_key; ?>" value="<?php echo $_POST[$inner_cnt_key]; ?>" />
														</p>
													<?php
													}
													?>
													<input type="hidden" name="inner_division_key[<?= $i ?>][]" value="<?= $i2 ?>" />
												</th>
												<td>
													<p>■タイトル</p>
													<p style="margin-bottom: 10px;"><textarea name="<?php echo $inner_title_key; ?>" cols="60" rows="2" class="form_color_r"><?php echo $_POST[$inner_title_key]; ?></textarea></p>

													<p>■見出し画像</p>
													<p style="margin-bottom: 10px;">
														<input type="file" name="<?php echo $upfile_key; ?>" size="40">
														<?php if ($_POST[$up_file_key] != "") { ?>
															<br><a href="<?php echo $up_file_path . $_POST[$up_file_key]; ?>" target="_blank"><?php echo $_POST[$up_file_key]; ?></a>
															<input type="hidden" name="<?php echo $up_file_key; ?>" value="<?php echo $_POST[$up_file_key]; ?>">
															　<input type="checkbox" name="<?php echo $up_file_del_key; ?>[]" value="1">ファイルを削除
														<?php } ?>
													</p>

													<p>■ALTタグ</p>
													<p style="margin-bottom: 10px;">
														<input type="text" name="<?php echo $up_file_alt_key; ?>" value="<?php echo $_POST[$up_file_alt_key]; ?>" size="50">
													</p>

													<p>■画像表示位置</p>
													<p style="margin-bottom:0;">
														<select name="<?php echo $inner_blog_image_view_key; ?>" id="" class="form_color_r">
															<option value="">
																<?php echo SelectView($inner_blog_image_view_key, $item_list['blog_image_view'], ""); ?>
														</select>
													</p>

													<p>■コメント</p>
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
															for ($f = $fontsize_min; $f <= $fontsize_max; $f++) {
																echo "<option value=\"" . $f . "\">" . $f . "px\n";
															}
															?>
														</select>
														<input type="button" value="文字サイズ" class="subbtn subbtn_font_size">

														<input type="text" class="color" id="color" name="color0" /><input type="button" value="フォントカラー" class="subbtn subbtn_font_color">
													</p>

													<p style="margin-bottom:5px;">
														<select id="r_blog" name="rec_blog" style="max-width: 400px;">
															<?php
															foreach ($cl_arr as $key => $value) {
																echo "<option value=\"" . $key . "\">" . $value['title'] . "\n";
															}
															?>
														</select>
														<input type="button" value="カードリンクの挿入" class="subbtn subbtn_rec_blog">
													</p>

													<p style="margin-bottom: 10px;"><textarea name="<?php echo $inner_comment_key; ?>" cols="60" rows="5" class="form_color_r" id="box"><?php echo $_POST[$inner_comment_key]; ?></textarea></p>
												</td>
											</tr>
										<?php
										}
										?>
									</tbody>

								</table>

							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
				<tr>
					<th>右カラム関連する記事</th>
					<td>
						<select name="right_column[]" multiple style="height:300px;">
							<option value="">
								<?php
								foreach ($blog_list_arr as $key => $value) {
									$ckecked = "";
									if (in_array($key, (array)$_POST['right_column'])) {
										$ckecked = " selected";
									}
								?>
							<option value="<?php echo $key; ?>" <?php echo $ckecked; ?>><?php echo strip_tags($value); ?>
							<?php
								}
							?>
						</select>

					</td>
				</tr>
				<tr>
					<th>関連する記事タイトル</th>
					<td>
						<input type="text" name="rec_main_title" value="<?php echo $_POST['rec_main_title']; ?>" size="50" placeholder="〇〇〇の関連記事はこちら">
					</td>
				</tr>
				<?php for ($i = 1; $i <= $_POST['rec_cnt']; $i++) {
					$title_key = "rec_title" . $i;
					$url_key = "rec_url" . $i;
				?>
					<tr>
						<th>関連する記事<?php echo $i; ?></th>
						<td>
							<p style="margin-bottom: 7px;">タイトル：<input type="text" name="<?php echo $title_key; ?>" value="<?php echo $_POST[$title_key]; ?>" size="70"></p>
							<p>ＵＲＬ　：<input type="text" name="<?php echo $url_key; ?>" value="<?php echo $_POST[$url_key]; ?>" size="70"></p>
						</td>
					</tr>
				<?php } ?>
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

			<div class="formbtn" style="margin-bottom:10px;">
				<p class="bl"><button type="submit" name="block_cnt_add" value="1">段落を追加</button></p>
			</div>

			<div class="formbtn">
				<span>
					<p class="gr"><button type="button" onClick="location.href='<?php echo $now_page; ?>?t=<?php echo time(); ?>'" name="btn1">一覧ページにもどる</button></p>
				</span>

				<span>
					<p class="grn"><button type="submit" name="btn2">登録内容を確認する</button></p>
				</span>
				<input type="hidden" name="act" value="conf">
				<input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">
				<input type="hidden" name="block_cnt" value="<?php echo $_POST['block_cnt']; ?>">
				<?php
				if ($_POST['type'] == "upd") {
					echo "<input type=\"hidden\" name=\"blog_no\" value=\"" . $_POST['blog_no'] . "\">";
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
if ($_POST['act'] == "conf") {
	// var_dump($_POST);
?>
	<style>
		a .blog_flexbox_bnr {
			display: flex;
			justify-content: space-between;
			padding: 10px;
			border: 3px solid #fc9400;
			margin-bottom: 40px;
			background: rgba(252, 148, 0, .2);
		}

		.blog_flexbox_bnr .ttl {
			color: #099ee3;
			font-weight: bold;
			margin-bottom: 10px;
		}

		.blog_flexbox_bnr .date {
			margin-bottom: 10px;
			font-size: 14px;
		}

		.blog_flexbox_bnr .txt {
			font-weight: bold;
			font-size: 14px;
		}

		.blog_flexbox_bnr_l {
			width: 20%;
		}

		.blog_flexbox_bnr_l img {
			object-fit: cover;
			height: 148px;
			width: 100%;
		}

		.blog_flexbox_bnr_r {
			width: 78%;
		}

		@media (max-width: 768px) {
			.blog_flexbox_bnr {
				display: block !important;
				justify-content: initial;
			}

			.blog_flexbox_bnr_l {
				width: 100%;
				margin-bottom: 20px;
				text-align: center;
			}

			.blog_flexbox_bnr_r {
				width: 100%;
			}

			.blog_flexbox_bnr_l img {
				height: auto;
			}
		}
	</style>
	<div id="contents">

		<h2><?php echo $main_title; ?><?php echo $page_title_sub_list[$act_type_key]; ?></h2>
		<p class="stext">登録内容を確認の上、「<?php echo $type_comment_list[$act_type_key]; ?>」ボタンをクリックしてください。
		</p>

		<table class="Tblform">
			<tr>
				<th>日時<span>※</span></th>
				<td><?php echo $_POST['blog_date']; ?></td>
			</tr>
			<tr>
				<th>ブログタイトル<span>※</span></th>
				<td><?php echo Nr2Br($_POST['title']); ?></td>
			</tr>
			<tr>
				<th>タイトル下テキスト</th>
				<td><?php echo Nr2Br($_POST['comment']); ?></td>
			</tr>
			<tr>
				<th>スラッグ<span>※</span></th>
				<td><?php echo $_POST['slug']; ?></td>
			</tr>
			<tr>
				<th>カテゴリ<span>※</span></th>
				<td>
					<?php
					foreach ((array)$_POST['category'] as $value) {
						echo $item_list['blog_category'][$value] . "<br />";
					}
					?>
			</tr>
			<tr>
				<th>カテゴリおすすめ</th>
				<td>
					<?php
					foreach ((array)$_POST['category_recommend'] as $value) {
						echo $item_list['blog_category'][$value] . "<br />";
					}
					?>
			</tr>
			<tr>
				<th>関連する資料<span>※</span></th>
				<td><?php echo $material_arr[$_POST['material_no']]; ?></td>
			</tr>
			<tr>
				<th>CTA表示</th>
				<td>
					<?php
					foreach ((array)$_POST['cta_flg'] as $value) {
						echo $cta_veiw_list[$value] . "<br />";
					}
					?>
			</tr>
			<tr>
				<th>リード文と目次の間のCTA表示</th>
				<td>
					<?php
					foreach ((array)$_POST['cta_flg_second'] as $value) {
						echo $cta_veiw_list[$value] . "<br />";
					}
					?>
			</tr>
			<?php
			for ($i = 1; $i <= $_POST['up_file_cnt']; $i++) {
				$up_file_key = "up_file" . $i;
				$alt_key = "alt" . $i;
			?>
				<tr>
					<th><?php echo $upfile_title_list[$i]; ?></th>
					<td>
						<?php if ($_POST[$up_file_key]) { ?>
							<a href="<?php echo $up_file_path . $_POST[$up_file_key]; ?>" target="_blank"><?php echo $_POST[$up_file_key]; ?></a>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th>ALTタグ</th>
					<td>
						<? echo $_POST[$alt_key]; ?>
					</td>
				</tr>
			<?php
			}
			?>
			<tr>
				<th>リード文</th>
				<td><?php echo Nr2Br($_POST['lead_sentence']); ?></td>
			</tr>

			<?php
			$division_keys = $_POST["division_key"];
			foreach ($division_keys as $i) {
				// for ($i=1; $i <= $_POST['block_cnt']; $i++) {
				$title_key = "title" . $i;
				$up_file_key = "up_file_block" . $i;
				$upfile_key = "upfile_block" . $i;
				$up_file_del_key = "up_file_del_block" . $i;
				$contents_commnt_key = "contents_commnt" . $i;
				$blog_image_view_key = "blog_image_view" . $i;
				$inner_cnt_key = "inner_cnt" . $i;
				$innner_cnt_add_key = "innnercntadd_" . $i;
				$innner_alt_key = "innner_alt" . $i;

			?>
				<tr>
					<th>
						段落<?php echo $i; ?>
						<input type="hidden" name="division_key[]" value="<?= $i ?>" />
					</th>
					<td style="padding: 1px;">

						<table class="Tblform" style="margin: 0px;">






							<tr>
								<th>タイトル</th>
								<td><?php echo Nr2Br($_POST[$title_key]); ?></td>
							</tr>
							<tr>
								<th>段落下画像</th>
								<td>
									<?php if ($_POST[$up_file_key]) { ?>
										<a href="<?php echo $up_file_path . $_POST[$up_file_key]; ?>" target="_blank"><?php echo $_POST[$up_file_key]; ?></a>
									<?php } ?>
								</td>
							</tr>
							<tr>
								<th>ALTタグ</th>
								<td>
									<? echo $_POST[$innner_alt_key]; ?>
								</td>
							</tr>
							<tr>
								<th>画像表示位置</th>
								<td><?php echo itemView($_POST[$blog_image_view_key], $item_list['blog_image_view']); ?></td>
							</tr>
							<tr>
								<th>段落下文章</th>
								<td><?php echo Nr2Br($_POST[$contents_commnt_key]); ?></td>
							</tr>
							<?php
							$inner_division_keys = $_POST["inner_division_key"][$i];
							foreach ($inner_division_keys as $i2) {
								// 	for($i2 = 1;$i2 <= $_POST[$inner_cnt_key];$i2++){
								$inner_title_key = "inner_title" . $i . "_" . $i2;
								$inner_comment_key = "inner_comment" . $i . "_" . $i2;
								$inner_blog_image_view_key = "inner_blog_image_view" . $i . "_" . $i2;
								$up_file_key = "up_file_inner" . $i . "_" . $i2;
								$upfile_key = "upfile_inner" . $i . "_" . $i2;
								$url_key = "url" . $i . "_" . $i2;
								$up_file_alt_key = "up_file_alt" . $i . "_" . $i2;


							?>
								<tr>
									<th>見出し<?php echo $i2; ?></th>
									<td>
										<p>■タイトル</p>
										<p style="margin-bottom: 10px;"><?php echo Nr2Br($_POST[$inner_title_key]); ?></p>
										<p>■見出し画像</p>
										<p style="margin-bottom: 10px;">
											<?php if ($_POST[$up_file_key]) { ?>
												<a href="<?php echo $up_file_path . $_POST[$up_file_key]; ?>" target="_blank"><?php echo $_POST[$up_file_key]; ?></a>
											<?php } ?>
										</p>
										<p>■ALTタグ</p>
										<p style="margin-bottom: 10px;">
											<?php echo $_POST[$up_file_alt_key]; ?>
										</p>
										<p>■画像表示位置</p>
										<p style="margin-bottom:0;">
											<?php echo itemView($_POST[$inner_blog_image_view_key], $item_list['blog_image_view']); ?>
										</p>
										<p>■コメント</p>
										<div style="margin-bottom: 10px;"><?php echo Nr2Br($_POST[$inner_comment_key]); ?></div>
									</td>
								</tr>
							<?php
							}
							?>

						</table>
					</td>
				</tr>
			<?php
			}
			?>
			<tr>
				<th>右カラム関連する記事</th>
				<td>
					<?php foreach ((array)$_POST['right_column'] as $key) : ?>
						<p><?php echo $blog_list_arr[$key]; ?></p>
					<?php endforeach; ?>
				</td>
			</tr>
			<tr>
				<th>関連する記事タイトル</th>
				<td><?php echo $_POST['rec_main_title']; ?></td>
			</tr>
			<?php for ($i = 1; $i <= $_POST['rec_cnt']; $i++) {
				$title_key = "rec_title" . $i;
				$url_key = "rec_url" . $i;
			?>
				<tr>
					<th>関連する記事<?php echo $i; ?></th>
					<td>
						<p style="margin-bottom: 7px;">タイトル：<?php echo $_POST[$title_key]; ?></p>
						<p>ＵＲＬ　：
							<?php if (!empty($_POST[$url_key])) : ?>
								<a href="<?php echo $_POST[$url_key]; ?>" target="_blank"><?php echo $_POST[$url_key]; ?></a>
							<?php endif; ?>
						</p>
					</td>
				</tr>
			<?php } ?>
			<tr>
				<th>meta description</th>
				<td><?php echo NrDel($_POST['description']); ?></td>
			</tr>
			<tr>
				<th>meta keywords</th>
				<td><?php echo NrDel(preg_replace("/\n/", ",", $_POST['keywords'])); ?></td>
			</tr>

		</table>

		<div class="formbtn">
			<form id="regist_form" name="regist_form" action="<?php echo $now_page; ?>" method="post">
				<p class="gr"><button type="submit">前のページにもどる</button></p>
				<input type="hidden" name="act" value="add">
				<?php
				$arr_leave_out = array("act", "del", "act2");
				echo HiddenEncodeViewJSON($_POST, $arr_leave_out);
				?>
			</form>
			<form id="regist_form" name="regist_form" action="<?php echo $now_page; ?>" method="post">
				<p class="grn"><button type="submit">完了画面へ</button></p>
				<input type="hidden" name="act" value="end">
				<?php
				$arr_leave_out = array("act", "del", "act2");
				echo HiddenEncodeViewJSON($_POST, $arr_leave_out);
				?>
			</form>
		</div>

	</div><!-- contents -->
<?php
}
//-----------------------------------------------------------------------------------------//
//完了画面
//-----------------------------------------------------------------------------------------//
if ($_POST['act'] == "end") {

	/*キーの設定*/
	$act_type_key = $_POST['act'] . "_" . $_POST['type'];
	if (!empty($_POST['category'])) {
		$category = implode(",", $_POST['category']);
	}
	if (!empty($_POST['category_recommend'])) {
		$category_recommend = implode(",", $_POST['category_recommend']);
	}
	if (!empty($_POST['related_service'])) {
		$related_service = implode(",", $_POST['related_service']);
	}
	if (!empty($_POST['related_service_recommend'])) {
		$related_service_recommend = implode(",", $_POST['related_service_recommend']);
	}


	//現在日付を取得
	$now_date_time = date("Y/m/d H:i:s", time());

	$jsonPostVals = HiddenDecodeViewJSON($_POST);
	if (!empty($jsonPostVals)) {
		foreach ($jsonPostVals as $key => $value) {
			$_POST[$key] = $value;
		}
	}

	if (!empty($_POST['cta_flg'])) {
		$_POST['cta_flg'] = "1";
	} else {
		$_POST['cta_flg'] = "0";
	}

	if (!empty($_POST['cta_flg_second'])) {
		$_POST['cta_flg_second'] = "1";
	} else {
		$_POST['cta_flg_second'] = "0";
	}



	if ($_POST['type'] == "regist") {

		//SQLを作成
		$sql = "INSERT INTO blog (";
		$sql .= " blog_type";
		$sql .= ",category";
		$sql .= ",category_recommend";
		$sql .= ",related_service";
		$sql .= ",related_service_recommend";
		$sql .= ",material_no";
		$sql .= ",blog_date";
		$sql .= ",title";
		$sql .= ",comment";
		$sql .= ",slug";
		$sql .= ",education_name";
		// $sql .= ",product_name";
		$sql .= ",up_file1";
		$sql .= ",lead_sentence";
		$sql .= ",rec_main_title";
		$sql .= ",description";
		$sql .= ",keywords";
		$sql .= ",add_date";
		$sql .= ",upd_date";
		$sql .= ",alt1";
		$sql .= ",right_column";
		$sql .= ",cta_flg";
		$sql .= ",product_name";
		$sql .= ") VALUES (";
		$sql .= " :blog_type";
		$sql .= ",:category";
		$sql .= ",:category_recommend";
		$sql .= ",:related_service";
		$sql .= ",:related_service_recommend";
		$sql .= ",:material_no";
		$sql .= ",:blog_date";
		$sql .= ",:title";
		$sql .= ",:comment";
		$sql .= ",:slug";
		$sql .= ",:education_name";
		// $sql .= ",:product_name";
		$sql .= ",:up_file1";
		$sql .= ",:lead_sentence";
		$sql .= ",:rec_main_title";
		$sql .= ",:description";
		$sql .= ",:keywords";
		$sql .= ",:add_date";
		$sql .= ",:upd_date";
		$sql .= ",:alt1";
		$sql .= ",:right_column";
		$sql .= ",:cta_flg";
		$sql .= ",:product_name";
		$sql .= ")";


		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':blog_type', $blog_type, PDO::PARAM_STR);
		$stmt->bindParam(':category', implode(",", (array)$_POST['category']), PDO::PARAM_STR);
		$stmt->bindParam(':category_recommend', implode(",", (array)$_POST['category_recommend']), PDO::PARAM_STR);
		$stmt->bindParam(':related_service', $related_service, PDO::PARAM_STR);
		$stmt->bindParam(':related_service_recommend', $related_service_recommend, PDO::PARAM_STR);
		$stmt->bindValue(':material_no', $_POST['material_no'], PDO::PARAM_INT);
		$stmt->bindParam(':blog_date', $_POST['blog_date'], PDO::PARAM_STR);
		$stmt->bindParam(':title', Nr2Br($_POST['title']), PDO::PARAM_STR);
		$stmt->bindParam(':comment', Nr2Br($_POST['comment']), PDO::PARAM_STR);
		$stmt->bindParam(':slug', $_POST['slug'], PDO::PARAM_STR);
		$stmt->bindParam(':education_name', Nr2Br($_POST['education_name']), PDO::PARAM_STR);
		// $stmt->bindParam(':product_name', Nr2Br($_POST['product_name']), PDO::PARAM_STR);
		$stmt->bindParam(':up_file1', $_POST['up_file1'], PDO::PARAM_STR);
		$stmt->bindParam(':lead_sentence', Nr2Br($_POST['lead_sentence']), PDO::PARAM_STR);
		$stmt->bindParam(':rec_main_title', $_POST['rec_main_title'], PDO::PARAM_STR);
		$stmt->bindParam(':description', NrDel($_POST['description']), PDO::PARAM_STR);
		$stmt->bindParam(':keywords', NrDel(preg_replace("/\n/", ",", $_POST['keywords'])), PDO::PARAM_STR);
		$stmt->bindParam(':add_date', $now_date_time, PDO::PARAM_STR);
		$stmt->bindParam(':upd_date', $now_date_time, PDO::PARAM_STR);
		$stmt->bindParam(':alt1', $_POST['alt1'], PDO::PARAM_STR);
		$stmt->bindParam(':right_column', implode(",", $_POST['right_column']), PDO::PARAM_STR);
		$stmt->bindParam(':cta_flg', $_POST['cta_flg'], PDO::PARAM_STR);
		$stmt->bindParam(':product_name', $_POST['cta_flg_second'], PDO::PARAM_STR);


		$stmt->execute();

		$_POST['blog_no'] = $pdo->lastInsertId();
		// echo $_POST[blog_no];
	}
	if ($_POST['type'] == "upd") { //更新処理

		$sql = "UPDATE blog SET";
		$sql .= " blog_date = :blog_date";
		$sql .= ",category = :category";
		$sql .= ",category_recommend = :category_recommend";
		$sql .= ",related_service = :related_service";
		$sql .= ",related_service_recommend = :related_service_recommend";
		$sql .= ",material_no = :material_no";
		$sql .= ",title = :title";
		$sql .= ",comment = :comment";
		$sql .= ",slug = :slug";
		$sql .= ",education_name = :education_name";
		$sql .= ",product_name = :product_name";
		$sql .= ",up_file1 = :up_file1";
		$sql .= ",lead_sentence = :lead_sentence";
		$sql .= ",rec_main_title = :rec_main_title";
		$sql .= ",description = :description";
		$sql .= ",keywords = :keywords";
		$sql .= ",upd_date = :upd_date";
		$sql .= ",alt1 = :alt1";
		$sql .= ",right_column = :right_column";
		$sql .= ",cta_flg = :cta_flg";
		$sql .= ",product_name = :product_name";
		$sql .= " WHERE blog_no = :blog_no";

		// echo $sql;

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':blog_date', $_POST['blog_date'], PDO::PARAM_STR);
		$stmt->bindParam(':category', implode(",", (array)$_POST['category']), PDO::PARAM_STR);
		$stmt->bindParam(':category_recommend', implode(",", (array)$_POST['category_recommend']), PDO::PARAM_STR);
		$stmt->bindParam(':related_service', $related_service, PDO::PARAM_STR);
		$stmt->bindParam(':related_service_recommend', $related_service_recommend, PDO::PARAM_STR);
		$stmt->bindValue(':material_no', $_POST['material_no'], PDO::PARAM_INT);
		$stmt->bindParam(':title', Nr2Br($_POST['title']), PDO::PARAM_STR);
		$stmt->bindParam(':comment', Nr2Br($_POST['comment']), PDO::PARAM_STR);
		$stmt->bindParam(':slug', $_POST['slug'], PDO::PARAM_STR);
		$stmt->bindParam(':education_name', Nr2Br($_POST['education_name']), PDO::PARAM_STR);
		$stmt->bindParam(':product_name', Nr2Br($_POST['product_name']), PDO::PARAM_STR);
		$stmt->bindParam(':up_file1', $_POST['up_file1'], PDO::PARAM_STR);
		$stmt->bindParam(':lead_sentence', Nr2Br($_POST['lead_sentence']), PDO::PARAM_STR);
		$stmt->bindParam(':rec_main_title', $_POST['rec_main_title'], PDO::PARAM_STR);
		$stmt->bindParam(':description', NrDel($_POST['description']), PDO::PARAM_STR);
		$stmt->bindParam(':keywords', NrDel(preg_replace("/\n/", ",", $_POST['keywords'])), PDO::PARAM_STR);
		$stmt->bindParam(':upd_date', $now_date_time, PDO::PARAM_STR);
		$stmt->bindParam(':alt1', $_POST['alt1'], PDO::PARAM_STR);
		$stmt->bindParam(':right_column', implode(",", $_POST['right_column']), PDO::PARAM_STR);
		$stmt->bindParam(':cta_flg', $_POST['cta_flg'], PDO::PARAM_STR);
		$stmt->bindParam(':product_name', $_POST['cta_flg_second'], PDO::PARAM_STR);
		$stmt->bindValue(':blog_no', $_POST['blog_no'], PDO::PARAM_INT);

		$stmt->execute();


		$sql = "DELETE FROM blog_other WHERE blog_no = :blog_no";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':blog_no', $_POST['blog_no'], PDO::PARAM_INT);

		$stmt->execute();

		$sql = "DELETE FROM blog_item WHERE blog_no = :blog_no";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':blog_no', $_POST['blog_no'], PDO::PARAM_INT);

		$stmt->execute();
	}

	if ($_POST['type'] == "regist" or $_POST['type'] == "upd") {

		$division_keys = $_POST["division_key"];
		foreach ($division_keys as $i) {
			// 		for ($i=1; $i <= $_POST['block_cnt']; $i++) {
			$title_key = "title" . $i;
			$up_file_key = "up_file_block" . $i;
			$contents_commnt_key = "contents_commnt" . $i;
			$blog_image_view_key = "blog_image_view" . $i;
			$inner_cnt_key = "inner_cnt" . $i;
			$innner_cnt_add_key = "innnercntadd_" . $i;
			$innner_alt_key = "innner_alt" . $i;

			if (!empty($_POST[$title_key])) {
				if (empty($_POST[$blog_image_view_key])) {
					$_POST[$blog_image_view_key] = "1";
				}
				//SQLを作成
				$sql = "INSERT INTO blog_other (";
				$sql .= " blog_no";
				$sql .= ",subtitle";
				$sql .= ",up_file1";
				$sql .= ",blog_image_view";
				$sql .= ",subcomment";
				$sql .= ",up_file_alt1";
				$sql .= ") VALUES (";
				$sql .= " :blog_no";
				$sql .= ",:subtitle";
				$sql .= ",:up_file1";
				$sql .= ",:blog_image_view";
				$sql .= ",:subcomment";
				$sql .= ",:up_file_alt1";
				$sql .= ")";

				// echo $_POST['blog_no'];

				$stmt = $pdo->prepare($sql);
				$stmt->bindValue(':blog_no', $_POST['blog_no'], PDO::PARAM_INT);
				$stmt->bindParam(':subtitle', Nr2Br($_POST[$title_key]), PDO::PARAM_STR);
				$stmt->bindParam(':up_file1', $_POST[$up_file_key], PDO::PARAM_STR);
				$stmt->bindParam(':blog_image_view', $_POST[$blog_image_view_key], PDO::PARAM_STR);
				$stmt->bindParam(':subcomment', Nr2Br($_POST[$contents_commnt_key]), PDO::PARAM_STR);
				$stmt->bindParam(':up_file_alt1', Nr2Br($_POST[$innner_alt_key]), PDO::PARAM_STR);

				$stmt->execute();

				$_POST['blog_other_no'] = $pdo->lastInsertId();
				// echo $_POST[blog_other_no];
			}
			$inner_division_keys = $_POST["inner_division_key"][$i];
			foreach ($inner_division_keys as $i2) {
				// 			for($i2 = 1;$i2 <= $_POST[$inner_cnt_key];$i2++){
				$inner_title_key = "inner_title" . $i . "_" . $i2;
				$inner_comment_key = "inner_comment" . $i . "_" . $i2;
				$inner_blog_image_view_key = "inner_blog_image_view" . $i . "_" . $i2;
				$up_file_key = "up_file_inner" . $i . "_" . $i2;
				$upfile_key = "upfile_inner" . $i . "_" . $i2;
				$url_key = "url" . $i . "_" . $i2;
				$up_file_alt_key = "up_file_alt" . $i . "_" . $i2;

				if (!empty($_POST[$inner_title_key])) {
					if (empty($_POST[$inner_blog_image_view_key])) {
						$_POST[$inner_blog_image_view_key] = "1";
					}
					//SQLを作成
					$sql = "INSERT INTO blog_other (";
					$sql .= " blog_no";
					$sql .= ",parent_id";
					$sql .= ",subtitle";
					$sql .= ",up_file1";
					$sql .= ",blog_image_view";
					$sql .= ",subcomment";
					$sql .= ",up_file_alt1";
					$sql .= ") VALUES (";
					$sql .= " :blog_no";
					$sql .= ",:parent_id";
					$sql .= ",:subtitle";
					$sql .= ",:up_file1";
					$sql .= ",:blog_image_view";
					$sql .= ",:subcomment";
					$sql .= ",:up_file_alt1";
					$sql .= ")";

					// echo $sql;

					$stmt2 = $pdo->prepare($sql);
					$stmt2->bindValue(':blog_no', $_POST['blog_no'], PDO::PARAM_INT);
					$stmt2->bindValue(':parent_id', $_POST['blog_other_no'], PDO::PARAM_INT);
					$stmt2->bindParam(':subtitle', Nr2Br($_POST[$inner_title_key]), PDO::PARAM_STR);
					$stmt2->bindParam(':up_file1', $_POST[$up_file_key], PDO::PARAM_STR);
					$stmt2->bindParam(':blog_image_view', $_POST[$inner_blog_image_view_key], PDO::PARAM_STR);
					$stmt2->bindParam(':subcomment', Nr2Br($_POST[$inner_comment_key]), PDO::PARAM_STR);
					$stmt2->bindParam(':up_file_alt1', Nr2Br($_POST[$up_file_alt_key]), PDO::PARAM_STR);

					$stmt2->execute();
				}
			}
		}
		for ($i = 1; $i <= $_POST['rec_cnt']; $i++) {
			$title_key = "rec_title" . $i;
			$url_key = "rec_url" . $i;
			if (!empty($_POST[$title_key]) and !empty($_POST[$url_key])) {
				$sql = "INSERT INTO blog_item (";
				$sql .= " blog_no";
				$sql .= ",title";
				$sql .= ",url";
				$sql .= ") VALUES (";
				$sql .= " :blog_no";
				$sql .= ",:title";
				$sql .= ",:url";
				$sql .= ")";

				$stmt_item = $pdo->prepare($sql);

				$stmt_item->bindValue(':blog_no', $_POST['blog_no'], PDO::PARAM_INT);
				$stmt_item->bindParam(':title', $_POST[$title_key], PDO::PARAM_STR);
				$stmt_item->bindParam(':url', $_POST[$url_key], PDO::PARAM_STR);

				$stmt_item->execute();
			}
		}
	}

	if ($_POST['type'] == "del") { //削除処理

		$sql = "UPDATE blog SET";
		$sql .= " del_flg = '1'";
		$sql .= " WHERE blog_no = :blog_no";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':blog_no', $_POST['blog_no'], PDO::PARAM_INT);

		$stmt->execute();
	}
	include("../include/xml_discharge.php");
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