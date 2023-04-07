<?php
/*ファイルの読み込み*/
require ("../../../include/dbconn.php");
include ("../../../include/convert.php");
include ("../../../include/list.php");

session_start();

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

$stmt = $pdo -> prepare($sql_inq_comp);
	
//SQLの実行
$stmt->execute();
//件数の取得
$row_num_user = $stmt->rowCount();

// CSV 一行目**************************************************
$csv_line = "お問合せ日時";
if ($_REQUEST['site_type'] == "contact" OR $_REQUEST['site_type'] == "request") {
	$csv_line .= ",お問合せ種別";
}
if ($_REQUEST['site_type'] == "wpdl") {
	$csv_line .= ",ダウンロードした資料";
}

if ($_REQUEST['site_type'] == "contact" OR $_REQUEST['site_type'] == "request") {
	$csv_line .= ",興味・関心のあるサービス";
}

$csv_line .= ",会社名";
$csv_line .= ",部署名";
$csv_line .= ",お名前";
$csv_line .= ",電話番号";
$csv_line .= ",メールアドレス";
$csv_line .=",貴社のお立場をお聞かせください。";
if ($_REQUEST['site_type'] == "wpdl") {
	$csv_line .=",御社のご状況をお聞かせください。";
}

if ($_REQUEST['site_type'] == "wpdl") {
	$csv_line .= ",詳細説明";
}

// アンケート項目
if ($_REQUEST['site_type'] == "contact" OR $_REQUEST['site_type'] == "request") {
	$csv_line .= ",お問合せ内容";
}
$csv_line .= "\n";
// CSV 一行目**************************************************
while ($PG_MATE = $stmt->fetch(PDO::FETCH_ASSOC)) {

	$csv_line .= $PG_MATE['inquery_date'].",";//お問合せ日時
	if ($_REQUEST['site_type'] == "contact") {
		$csv_line .= "\"" . $PG_MATE['contact_kind']."\","; // お問い合わせ種別
	}
	if($_REQUEST['site_type'] == "request"){
		$csv_line .= "\"" . $PG_MATE['contact_kind2']."\",";
	}
	if($_REQUEST['site_type'] == "wpdl"){
		$csv_line .= "\"" . $PG_MATE['material_name'] . "\",";
	}
	if ($_REQUEST['site_type'] == "contact" OR $_REQUEST['site_type'] == "request") {
		$csv_line .= "\"" . $PG_MATE['service']."\",";
	}
	$csv_line .= "\"" . $PG_MATE['company_name'] . "\",";//会社名
	$csv_line .= "\"" . $PG_MATE['division'] . "\",";//部署名
	$csv_line .= "\"" . $PG_MATE['name'] . "\",";//お名前
	$csv_line .= "\"" . $PG_MATE['tel'] . "\",";//電話番号
	$csv_line .= "\"" . $PG_MATE['email'] . "\",";//メールアドレス

	if ($_REQUEST['site_type'] =="contact" OR $_REQUEST['site_type'] =="request") {
		$csv_line .="\"" . $PG_MATE['standpoint'] . "\",";//あなたの立場をお聞かせ下さい。
	}
	$csv_line .= "\"" . $PG_MATE['standpoint'] . "\",";
	if ($_REQUEST['site_type'] == "wpdl") {
		$csv_line .= "\"" . $PG_MATE['status'] . "\",";
		$csv_line .= "\"" . $PG_MATE['detail_caption'] . "\",";
	}
	if ($_REQUEST['site_type'] =="contact" OR $_REQUEST['site_type'] =="request") {
		$csv_line .= "\"" . $PG_MATE['comment'] . "\",";
	}
	$csv_line .= "\n";//改行
}

	//ファイルの書き込み
	$file = "dl.csv";
	$csv_line = mb_convert_encoding($csv_line, "SJIS-WIN", "utf-8");

$fh=fopen($file,"w");
fwrite($fh,$csv_line);
fclose($fh);
chmod($file, 0777);
header("Pragma: public");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$file);
echo file_get_contents($file);
unlink($file);
?>
