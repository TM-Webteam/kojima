<?php
/*ファイルの読み込み*/
require ("../../../include/dbconn.php");
include ("../../../include/convert.php");
include ("../../../include/list.php");
include("../include/header.php");

$sql_updl = "SELECT";
$sql_updl .= " *";
$sql_updl .= " FROM";
$sql_updl .= " item_l";
$sql_updl .= " WHERE";
$sql_updl .= " item_column_name = :item_column_name";

$stmt = $pdo -> prepare($sql_updl);
$stmt->bindParam(':item_column_name', $_REQUEST['category_type'], PDO::PARAM_STR);

$stmt->execute();
$arr_updl = $stmt->fetch(PDO::FETCH_ASSOC);

//ページタイトル
$main_title = $arr_updl['item_l_name'];

if($_REQUEST['itemIDs'] != ""){
	$item_no = split(",", $_REQUEST['itemIDs']);
	$item_no_new = array_reverse($item_no);
//	$_POST[item_m_no] = $_REQUEST[item_m_no];
	$column_add = array("sort_no");
	$_POST['sort_no'] = 0;
	foreach($item_no as $key){
		if($key != ""){
			$_POST['sort_no']++;

			$sql = "UPDATE item_m SET";
			$sql .= " sort_no = :sort_no";
			$sql .= " WHERE item_m_no = :item_m_no";

			$stmt = $pdo -> prepare($sql);
			$stmt->bindValue(':sort_no', $_POST['sort_no'], PDO::PARAM_INT);
			$stmt->bindValue(':item_m_no', $key, PDO::PARAM_INT);
			$stmt->execute();
		}
	}
	$_POST['act'] = "list";
	$_POST['act2'] = "";
}

if($_POST['act'] == ""){
	$_POST['act'] = "list";
}
if($_POST['act'] == "list"){
	$_POST['type'] = "";
}

/*一覧画面からの各処理********************************************************************/
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

/*変更・削除時の企業情報取得*/
	if($_POST['type'] == "upd" or $_POST['type'] == "del"){
		$sql_updl = "SELECT";
		$sql_updl .= " *";
		$sql_updl .= " FROM";
		$sql_updl .= " item_m";
		$sql_updl .= " WHERE";
		$sql_updl .= " item_m_no = '" . $key_no[1] . "'";

		$stmt = $pdo->query($sql_updl);
		if (!$stmt) {
		  $info = $pdo->errorInfo();
		  exit($info[2]);
		}

		$arr_updl = $stmt->fetch(PDO::FETCH_ASSOC);
		$_POST['item_m_no'] = $arr_updl['item_m_no'];
		$_POST['item_m_name'] = $arr_updl['item_m_name'];
		$_POST['lead_sentence'] = Br2Nr($arr_updl['lead_sentence']);
		// echo $arr_updl[item_m_name];
	}
}


//-----------------------------------------------------------------------------------------
//入力チェック・画像処理
//-----------------------------------------------------------------------------------------
if($_POST['act'] == "conf"){
	$err_mess = array();
	//入力チェック
	$err_mess[] = InputChk($_POST['item_m_name'],"ブログカテゴリ名");

	//エラーチェック
	foreach($err_mess as $err_key){
		if($err_key != ""){
			$_POST['act'] = "err";
//			$_POST[type] = "regist";
			break;
		}
	}

}
/*キーの設定*/
$act_type_key = $_POST['act']."_".$_POST['type'];
/*検索・一覧画面**************************************************************************/
if($_POST['act'] == "list"){
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
	$sql .= " item_column_name = :item_column_name";
	$sql .= " and T1.del_flg = '0'";
	$sql .= " order by T1.sort_no ";


	$stmt = $pdo -> prepare($sql);
	$stmt->bindParam(':item_column_name', $_REQUEST['category_type'], PDO::PARAM_STR);

	$stmt->execute();
	// 件数取得
	$row_num_inq_comp=$stmt->rowCount();
	if (!$stmt) {
	  $info = $pdo->errorInfo();
	  exit($info[2]);
	}




?>

<script>
<!--
jQuery( function() {
    var option={
        stop : function(){
            var data=[];
            $("tr td.key","#sortable tbody").each(function(i,v){
                data.push(v.innerHTML);
            });
            $('#viewSortlist').html(data.toString()).css("background-color","#eee");
        }
    };
    jQuery( '#sortable tbody' ) . sortable(option);
    jQuery( '#sortable tbody' ) . disableSelection();
    jQuery( '#submitSortable,#submitSortable2' ) . click( function() {
        var itemNames = '';
        var itemIDs = '';
        jQuery( '#sortable tbody #test' ) . map( function() {
            itemNames += jQuery( this ) . text() + '\n';
            itemIDs += jQuery( this ) .children( 'span' ) . text() + ',';
        } );
        if( confirm( itemNames + '【この順番でよろしいですか？】' ) ){
            location . href = '?itemIDs=' + itemIDs + '&t=<? echo time(); ?>&item_m_no=<? echo $_REQUEST['item_m_no']; ?>';
        }
    } );
} );
// -->
</script>
<style>
<!--
#sortable td {
    cursor: move;
}
#sortable th {
    cursor: move;
}
#test span {
visibility: hidden;
}
-->
</style>
<div id="contents">

<h2><?php echo $main_title; ?>一覧</h2>
<p class="stext">
修正・変更をされたい場合は「更新」ボタンをクリックして下さい。<br />
削除をされたい場合は「削除」ボタンをクリックして下さい。(削除確認画面が表示されます）
</p>




<form action="<?php echo $now_page; ?>?t=<?php echo time(); ?>" method="post">
<div class="formbtn" style="margin-bottom:0px;">
		<span><p class="or"><button type="button" id="submitSortable" name="add" style="width:180px;padding:5px;">この並び順を送信</button></p></span>
</div>
<strong class="fcRedb"><?php echo $row_num_inq_comp; ?></strong>件
<table class="Tblform_ret" id="sortable">
<tr>
	<th style="width:84%;">カテゴリ名</th>

	<th style="width:8%;"></th>
	<th style="width:8%;"></th>
</tr>
<tbody>
<?php
	while ($PG_REC_MAT = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo "<tr>\n";
		echo "	<td id=\"test\">" . $PG_REC_MAT['item_m_name'] . "<span>" . $PG_REC_MAT['item_m_no'] . "</span></td>\n";
		echo "	<td style=\"text-align:center;\">\n";
		echo "	<input type=\"submit\" name=\"upd:".$PG_REC_MAT['item_m_no']."\" class=\"submit01\" value=\"更新\">\n";
		echo "	</td>\n";
		echo "	<td style=\"text-align:center;\">\n";
		echo "	<input type=\"submit\" name=\"del:".$PG_REC_MAT['item_m_no']."\" value=\"削除\" class=\"submit01\">\n";
		echo "	</td>\n";
		echo "</tr>\n";
	}
?>
</tbody>
</table>


<div class="formbtn">
		<span><p class="or"><button type="button" id="submitSortable2" name="add" style="width:180px;padding:5px;">この並び順を送信</button></p></span>
<p class="grn"><button type="submit" name="add">新規登録はこちら</button></p>
</div>
<input type="hidden" name="act2" value="1">
<input type="hidden" name="category_type" value="<?php echo $_REQUEST['category_type'] ?>">
</form>

</div><!-- contents -->

<?php
}
/*登録画面********************************************************************************/
if($_POST['act'] == "add" or $_POST['act'] == "err"){
	if (empty($_POST['color'])) {
		$_POST['color'] = "#000000";
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
<form action="<?php echo $now_page; ?>?t=<?php echo time(); ?>" method="post" name="mainform" enctype="multipart/form-data">
<table class="Tblform">
<tr>
	<th>ブログカテゴリ名<span>※</span></th>
	<td>
	<input type="text" name="item_m_name" value="<?php echo $_POST['item_m_name']; ?>" class="wide01 form_color_r">
	</td>
</tr>
<tr>
	<th>リード文</th>
	<td>
<textarea name="lead_sentence" cols="60" rows="5" class="form_color_r"><?php echo $_POST['lead_sentence']; ?></textarea>
	</td>
</tr>
</table>

	<div class="formbtn">
		<span><p class="gr"><button type="button" onClick="location.href='<?php echo $now_page; ?>?t=<?php echo time(); ?>&category_type=<?php echo $_POST['category_type'] ?>'" name="btn1">一覧ページにもどる</button></p></span>

		<span><p class="grn"><button type="submit" name="btn2">登録内容を確認する</button></p></span>
	<input type="hidden" name="act" value="conf">
<input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">
<input type="hidden" name="category_type" value="<?php echo $_POST['category_type'] ?>">
<?php
	if($_POST['type'] == "upd"){
		echo "<input type=\"hidden\" name=\"item_m_no\" value=\"".$_POST['item_m_no']."\">";
	}
?>
		</form>
	</div>


</div><!-- contents -->
<?php
}
/*確認画面********************************************************************************/
if($_POST['act'] == "conf"){

?>
<style type="text/css">
	.color_pic{
-webkit-appearance: square-button;
    width: 44px;
    height: 23px;
    background-color: buttonface;
    cursor: default;
    border-width: 1px;
    border-style: solid;
    border-color: rgb(169, 169, 169);
    border-image: initial;
    padding: 1px 2px;
    background-color: buttonface;
    height:21px;
	}
</style>
<div id="contents">

<h2><?php echo $main_title; ?><?php echo $page_title_sub_list[$act_type_key]; ?></h2>
<p class="stext">登録内容を確認の上、「<?php echo $type_comment_list[$act_type_key]; ?>」ボタンをクリックしてください。
</p>

<table class="Tblform">
<tr>
	<th>ブログカテゴリ名<span>※</span></th>
	<td><?php echo $_POST['item_m_name']; ?></td>
</tr>
	<tr>
		<th>リード文</th>
		<td><?php echo Nr2Br($_POST['lead_sentence']); ?></td>
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
/*完了画面********************************************************************************/
if($_POST['act'] == "end"){

	//現在日付を取得
	$now_date = date("Y/m/d H:i:s", time());

	if($_POST['type'] == "regist"){

		//SQLを作成
		$sql = "INSERT INTO item_m (";
		$sql .= " item_l_no";
		$sql .= ",item_m_name";
		$sql .= ",lead_sentence";
		$sql .= ") VALUES (";
		$sql .= " :item_l_no";
		$sql .= ",:item_m_name";
		$sql .= ",:lead_sentence";
		$sql .= ")";

		$stmt = $pdo -> prepare($sql);
		$stmt->bindValue(':item_l_no', $arr_updl['item_l_no'], PDO::PARAM_INT);
		$stmt->bindParam(':item_m_name', $_POST['item_m_name'], PDO::PARAM_STR);
		$stmt->bindParam(':lead_sentence', Nr2Br($_POST['lead_sentence']), PDO::PARAM_STR);

		$stmt->execute();

	}
	if($_POST['type'] == "upd"){//更新処理
		$sql = "UPDATE item_m SET";
		$sql .= " item_m_name = :item_m_name";
		$sql .= ",lead_sentence = :lead_sentence";
		$sql .= " WHERE item_m_no = :item_m_no";

		$stmt = $pdo -> prepare($sql);
		$stmt->bindParam(':item_m_name', $_POST['item_m_name'], PDO::PARAM_STR);
		$stmt->bindParam(':lead_sentence', $_POST['lead_sentence'], PDO::PARAM_STR);
		$stmt->bindValue(':item_m_no', $_POST['item_m_no'], PDO::PARAM_INT);
		$stmt->execute();
	}
	if($_POST['type'] == "del"){//削除処理
		$sql = "UPDATE item_m SET";
		$sql .= " del_flg = '1'";
		$sql .= " WHERE item_m_no = :item_m_no";


		$stmt = $pdo -> prepare($sql);
		// $stmt->bindParam(':del_flg', '1', PDO::PARAM_STR);
		$stmt->bindValue(':item_m_no', $_POST['item_m_no'], PDO::PARAM_INT);
		$stmt->execute();

	}

?>
<div id="contents">

<div class="thanks">
<?php
		echo $type_comment_list[$act_type_key] . "\n";
// echo $sql;
?>
</div>

<form action="<?php echo $now_page; ?>?t=<?php echo time(); ?>" method="post">
<div class="formbtn">
<p class="grn"><button type="submit" name="add">一覧へ戻る</button></p>
</div>
<input type="hidden" name="category_type" value="<?php echo $_POST['category_type'] ?>">
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
