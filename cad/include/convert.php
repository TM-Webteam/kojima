<?php
//=================================================================//
/*[変換]

[\n\rを<br>に変換]
 変換後文字列 = Nr2Br(文字列)

[<br>を\nに変換]
 変換後文字列 = Br2Nr(文字列)
*/
//=================================================================//
function Nr2Br ($str) {
	$str = preg_replace("/\r/","",$str);
	$str = preg_replace("/\n/","<br>",$str);
	return $str;
}
function Br2Nr ($str) {
	$str = preg_replace("/<br>/","\n",$str);
	$str = preg_replace("/<BR>/","\n",$str);
	$str = preg_replace("/<br \/>/","\n",$str);
	$str = preg_replace("/<BR \/>/","\n",$str);
	return $str;
}
function Br2NrDel ($str) {
	$str = preg_replace("/<br>/","",$str);
	$str = preg_replace("/<BR>/","",$str);
	$str = preg_replace("/<br \/>/","",$str);
	$str = preg_replace("/<BR \/>/","",$str);
	return $str;
}
function NrDel ($str) {
	$str = preg_replace("/\r/","",$str);
	$str = preg_replace("/\n/","",$str);
	return $str;
}
function RDel ($str) {
	$str = preg_replace("/\r/","",$str);
	return $str;
}
function QotDel ($str) {
	$str = preg_replace("/\'/","",$str);
	$str = preg_replace("/\"/","",$str);
	return $str;
}
function SplitChar ($str,$char) {
	$data = array();
	$data = explode($char,$str);
	return $data;
}
/*
 エラーメッセージ = UrlChk (文字列,項目名,必須フラグ)
[同機チェック]
 エラーメッセージ = EqualChk (文字列1,文字列2,項目名)
必須フラグ -> 1:必須
*/
//=================================================================//
function InputChk ($str,$item_name) {
	$str = preg_replace("/ /","",$str);
	$str = preg_replace("/　/","",$str);
	if (!$str) {
		$err_mess = $item_name . "の項目が入力されていません<br>\n";
	}
	return $err_mess;
}
function SelectChk ($str,$item_name) {
	if (!$str) {
		$err_mess = $item_name . "の項目が選択されていません<br>\n";
	}
	return $err_mess;
}
function mSelectChk ($selected=array(), $item_list=array(), $item_name) {
	foreach ($selected as $value) {
		if (array_key_exists($value, $item_list)) {
			return null;
		}
	}

	return $item_name . "の項目が選択されていません<br>\n";
}
function HansujiChk ($str,$item_name,$hflg) {
/*	if ($hflg) {
		InputChk($str,$item_name);
	}*/
	if ($hflg and !$str) {
		$err_mess = $item_name . "の項目が入力されていません<br>\n";
	}
	if ($str) {
//		if (!ereg("/^[0-9]+$/", $str) ) {
		if (!preg_match("/^[0-9]+$/", $str)) {
			$err_mess = $item_name . "の項目は半角数字で入力してください<br>\n";
		}
	}
	return $err_mess;
}
function HansujiChk2 ($str,$item_name,$hflg) {
/*	if ($hflg) {
		InputChk($str,$item_name);
	}*/
	if ($hflg) {
		if($str == ""){
		$err_mess = $item_name . "の項目が入力されていません<br>\n";
		}
	}
	if ($str) {
		if (!preg_match("/^[0-9]+$/", $str) ) {
			$err_mess = $item_name . "の項目は半角数字で入力してください<br>\n";
		}
	}
	return $err_mess;
}
function HaneijiChk ($str,$item_name,$hflg){
/*	if ($hflg) {
		InputChk($str,$item_name);
	}*/
	if ($hflg and !$str) {
		$err_mess = $item_name . "の項目が入力されていません<br>\n";
	}
	if ($str) {
		if (!preg_match("/^[a-zA-Z]+$/",$str)) {
			$err_mess = $item_name . "の項目は半角英字で入力してください<br>\n";
		}
	}
	return $err_mess;
}
function HaneisuChk ($str,$item_name,$hflg) {
/*	if ($hflg) {
		InputChk($str,$item_name);
	}*/
	if ($hflg and !$str) {
		$err_mess = $item_name . "の項目が入力されていません<br>\n";
	}
	if ($str) {
		if (!preg_match("/^[a-zA-Z0-9]+$/",$str)) {
			$err_mess = $item_name . "の項目は半角英数字で入力してください<br>\n";
		}
	}
	return $err_mess;
}
function HaneisuanderChk ($str,$item_name,$hflg) {
/*	if ($hflg) {
		InputChk($str,$item_name);
	}*/
	if ($hflg and !$str) {
		$err_mess = $item_name . "の項目が入力されていません<br>\n";
	}
	if ($str) {
		if (!preg_match("/^[a-zA-Z0-9-]+$/",$str)) {
			$err_mess = $item_name . "の項目は半角英数字と-(ハイフン)で入力してください<br>\n";
		}
	}
	return $err_mess;
}
function ZenhiraChk ($str,$item_name,$hflg) {
/*	if ($hflg) {
		InputChk($str,$item_name);
	}*/
	if ($hflg and !$str) {
		$err_mess = $item_name . "の項目が入力されていません<br>\n";
	}
	if ($str) {
		mb_regex_encoding("UTF-8");
		if (!mb_ereg("^[あ-んー・]+$",$str)) {
			$err_mess = $item_name . "の項目は全角ひらがなで入力してください<br>\n";
		}
	}
	return $err_mess;
}
function ZenkanaChk ($str,$item_name,$hflg) {
/*	if ($hflg) {
		InputChk($str,$item_name);
	}*/
	if ($hflg and !$str) {
		$err_mess = $item_name . "の項目が入力されていません<br>\n";
	}
mb_regex_encoding("UTF-8");
	if ($str) {
		if (!mb_ereg("^[ァ-ヶーヴ・]+$",$str)) {
			$err_mess = $item_name . "の項目は全角カタカナで入力してください<br>\n";
		}
	}
	return $err_mess;
}
function HankanaNG($str,$item_name) {
	if (!mb_ereg("[ｱ-ﾝ]", $str)) {
		$err_mess = $item_name . "の項目は半角カタカナは使えません<br>\n";
	}
	return $err_mess;
}
function LengthChk ($str,$min,$max,$item_name) {
	if ((strlen($str) < $min) || (strlen($str) > $max)) {
		$err_mess = $item_name . "の項目は" . $min . "文字以上" . $max . "文字以下で入力してください<br>\n";
	}
	return $err_mess;
}
function ZipcodeChk ($str1,$str2,$item_name) {
	if ($str1 && $str2) {
		$zip = $str1 . "-" . $str2;
		if (!preg_match("/^[0-9]{3}-?[0-9]{4}$/", $zip)) {
			$err_mess = $item_name . "の項目は半角数字3桁4桁で入力してください<br>\n";
		}
	}else{
		$err_mess = $item_name . "の項目を入力してください<br>\n";
	}
	return $err_mess;
}
function MailChk ($str,$item_name,$hflg) {
	$mail_regex =
		'(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\' .
		'\[\]\000-\037\x80-\xff])|"[^\\\\\x80-\xff\n\015"]*(?:\\\\[^\x80-\xff][' .
		'^\\\\\x80-\xff\n\015"]*)*")(?:\.(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x' .
		'80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|"[^\\\\\x80-' .
		'\xff\n\015"]*(?:\\\\[^\x80-\xff][^\\\\\x80-\xff\n\015"]*)*"))*@(?:[^(' .
		'\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\0' .
		'00-\037\x80-\xff])|\[(?:[^\\\\\x80-\xff\n\015\[\]]|\\\\[^\x80-\xff])*' .
		'\])(?:\.(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,' .
		';:".\\\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\\\x80-\xff\n\015\[\]]|\\\\[' .
		'^\x80-\xff])*\]))*';
/*	if ($hflg) {
		InputChk($str,$item_name);
	}*/
	if ($hflg and !$str) {
		$err_mess = $item_name . "の項目が入力されていません<br>\n";
	}
	if ($str) {
		if(!preg_match("/^$mail_regex$/",$str)){
			$err_mess = "もう一度ご確認のうえ" . $item_name . "を入力してください<br>\n";
		}
	}
	return $err_mess;
}
function UrlChk ($str,$item_name,$hflg) {
/*	if ($hflg) {
		InputChk($str,$item_name);
	}*/
	if ($hflg and !$str) {
		$err_mess = $item_name . "の項目が入力されていません<br>\n";
	}
	if ($str) {
//		if (!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $str)) {
		if (!preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $str)) {
				$err_mess = "もう一度ご確認のうえ" . $item_name . "を入力してください<br>\n";
		}
	}
	return $err_mess;
}
function EqualChk ($str1,$str2,$item_name) {
	if ($str1 != $str2) {
			$err_mess = $item_name . "の同期がとれませんもう一度ご確認ください<br>\n";
	}
	return $err_mess;
}
//=================================================================//
/*[表示処理]
[error表示]
 変換後文字列 = Arr2Val (エラー配列)
[radio表示]
 変換後文字列 = RdioView (項目のname属性,項目内容配列)
[checkbox表示]
 変換後文字列 = CheckView (項目のname属性,項目内容配列)
[Select表示]
 変換後文字列 = SelectView (項目のname属性,項目内容配列)
[checkbox確認表示]
 変換後文字列 = SelectConfView (項目のname属性,項目内容配列,表示の際の区切り文字)
[hidden作成表示]
 変換後文字列 = HiddenView (除外する項目のname属性配列)
[画像アップロード]
 変換後文字列 = UpFileCnv (ファイル名,アップロードするファイル名,サイズ,許可するファイル種別,返すファイル名)
[最大値の取得]
 変換後文字列 = SqlMaxNum (DB接続,テーブル名,項目名,WHERE)
*/
//=================================================================//
function Arr2Val ($arr_err) {
	if ($arr_err) {
		foreach ($arr_err as $val) {
			$err_mess .= $val;
		}
	}
	return $err_mess;
}
function RdioView ($str,$arr_val,$br) {
	if($br != "" and $br != "0"){
		$br_cnt = 0;
	}
	foreach ($arr_val as $key => $value) {
		if ($_POST[$str] == $key) {
			$radio_val .= "<input type=\"radio\" name=\"" . $str . "\" value=\"" . $key . "\" checked> " . $value . "\n";
		}else{
			$radio_val .= "<input type=\"radio\" name=\"" . $str . "\" value=\"" . $key . "\"> " . $value . "\n";
		}
		if($br != "" and $br != "0"){
			$br_cnt++;
			if($br_cnt == $br){
				$radio_val .= "<br>\n";
				$br_cnt = 0;
			}
		}
	}
	return $radio_val;

}
function CheckView ($str,$arr_val,$br) {
	if($br != "" and $br != "0"){
		$br_cnt = 0;
	}
	foreach ($arr_val as $key => $value) {
		$flg = "none";
		if ($_POST[$str] != "") {
			foreach ($_POST[$str] as $val) {
				if($val == $key) { $flg = "done"; }
			}
		}
		if($flg == "done") {
			$check_val .= "<input type=\"checkbox\" name=\"" . $str . "[]\" value=\"" . $key . "\" checked> " . $value . "\n";
		}else{
			$check_val .= "<input type=\"checkbox\" name=\"" . $str . "[]\" value=\"" . $key . "\"> " . $value . "\n";
		}
		if($br != "" and $br != "0"){
			$br_cnt++;
			if($br_cnt == $br){
				$check_val .= "<br>\n";
				$br_cnt = 0;
			}
		}
	}
	return $check_val;
}
function SelectView ($str,$arr_val,$type=null) {
	foreach ($arr_val as $key => $value) {
		if($type == "" or $type == "1"){
			if ($_POST[$str] == $key) {
				$select_val .= "<option value=\"" . $key . "\" selected>" . $value . "</option>\n";
			}else{
				$select_val .= "<option value=\"" . $key . "\">" . $value . "</option>\n";
			}
		}
		if($type == "2"){
			if ($_SESSION[$str] == $key) {
				$select_val .= "<option value=\"" . $key . "\" selected>" . $value . "</option>\n";
			}else{
				$select_val .= "<option value=\"" . $key . "\">" . $value . "</option>\n";
			}
		}
	}
	return $select_val;
}
function SelectConfView ($str,$arr_val,$sp_char) {
	if($_POST[$str] != "") {
		foreach ((array)$_POST[$str] as $val) {
			if ($select_val) {
				$select_val .= $sp_char . $arr_val[$val];
			}else{
				$select_val = $arr_val[$val];
			}
		}
	}
	return $select_val;
}
function HiddenView ($arr_leave_out) {
	$arr_post = array();
	$arr_post_keys = array();
	$arr_post_keys = array_keys($_POST);
	$array_post = array_diff($arr_post_keys,$arr_leave_out);
	foreach ($array_post as $key) {
		if (is_array($_POST[$key])) {
			foreach ($_POST[$key] as $val) {
				$hidden_val .= "<input type=\"hidden\" name=\"" . $key . "[]\" value=\"" . $val . "\">\n";
			}
		}else{
			$hidden_val .= "<input type=\"hidden\" name=\"" . $key . "\" value=\"" . $_POST[$key] . "\">\n";
		}
	}
	return $hidden_val;
}

function HiddenEncodeViewJSON ($post_values, $arr_leave_out) {
	$arr_post = array();
	$arr_post_keys = array();
	$arr_post_keys = array_keys($post_values);
	$array_post = array_diff($arr_post_keys, $arr_leave_out);

	$tmp_array = array();
	foreach ($array_post as $key) {
		$tmp_array[$key] = $post_values[$key];
	}
	$hidden_val = "<input type=\"hidden\" name=\"HiddenViewJSON\" value=\"" 
														. urlencode(json_encode($tmp_array)) . "\">\n";
	return $hidden_val;
}
function HiddenDecodeViewJSON ($post_values) {
	if ($post_values["HiddenViewJSON"] != "") {
		return json_decode(urldecode($post_values["HiddenViewJSON"]), true);
	}
	return null;
}


function ArrView ($str,$sp_char) {
	if($_POST[$str] != "") {
		foreach ($_POST[$str] as $val) {
			if ($select_val) {
				$select_val .= $sp_char . $val;
			}else{
				$select_val = $val;
			}
		}
	}
	return $select_val;
}
function ArrValView ($str,$arr_val,$sp_char1,$sp_char2) {
	if($str != "") {
		$arr_str = array();
		$arr_str = split($sp_char1,$str);
		foreach ($arr_str as $val) {
			if ($str_val) {
				$str_val .= $sp_char2 . $arr_val[$val];
			}else{
				$str_val = $arr_val[$val];
			}
		}
	}
	return $str_val;
}
/**
 * 配列、変数関係なくコードをリスト配列と照合して名前で返す。
 * また、配列の場合は指定の区切り文字で繋げる。
 * 主に確認画面で使用する。
 * @param unknown $str
 * @param unknown $arr
 * @param string $split_item
 * @return Ambigous <string, unknown>
 */
function itemView($str,$arr=array(),$split_item=null) {

	//変数の初期化
	$view_data = "";

	//配列の場合
	if (is_array($str)) {

		//配列初期化
		$arr_data = array();

		foreach ((array) $str AS $key => $val) {
			$arr_data[] = $arr[$val];
		}

		$view_data = implode($split_item,$arr_data);

	//配列ではない場合
	}else{
		$view_data = $arr[$str];
	}

	return $view_data;
}

function UpFileCnv ($str,$name,$size,$type,$re_name) {
	$arr_return = array();
	$file_name = $_FILES[$str]["name"];
	$file_size = $_FILES[$str]["size"];
	$file_temp = $_FILES[$str]["tmp_name"];
	if ($file_size != 0) {
		$image_t = explode(".", $file_name);
		$file_type = $image_t[1];
		$name = $name . "." . $file_type;
		$re_name .= "." . $file_type;
		if ($size) {
			if ($size < $file_size) {
				$arr_return['err_mess'] = $file_name . " : " . $size . "バイトを超えるファイルはアップロード出来ません<br>\n";
				return $arr_return;
			}
		}
		if ($type) {
			$type = array_change_key_case($type);
			$file_type = strtolower($file_type);
			if (!in_array($file_type,$type)) {
				$arr_return['err_mess'] = $file_name . " : ファイルタイプ（" . $file_type . "）はアップロード出来ません<br>\n";
				return $arr_return;
			}
		}
		$err = move_uploaded_file($file_temp,$name);
		if (!$err) {
			$arr_return['err_mess'] = $file_name . " : " . "アップロード出来ません<br>\n";
			return $arr_return;
		}
		$arr_return['file_name'] = $name;
		$arr_return['file_name'] = $re_name;
		chmod($name,0777);
		return $arr_return;
	}
}
function SqlMaxNum ($dbconn,$tb_name,$item_name,$db_where) {
	$sql = "SELECT MAX(" . $item_name . ") FROM " . $tb_name . $db_where;
	$result = mysql_query ($sql);
	$row_num = mysql_num_rows ($result);
	if ($row_num != 0) {
		$arr = mysql_fetch_array ($result,MYSQL_NUM);
		$no = $arr[0] + 1;
	}else{
		$no = 1;
	}
	return $no;
}
function SqlPassWord ($num) {
	$text_code = "0,1,2,3,4,5,6,7,8,9,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";

	$arr_txt = split(",", $text_code);

	$no = "";
	if($num != ""){
		for ($i=1;$i<=$num;$i++){
			srand(time()+$i);
			$no = rand(0, 61);
			$pass .= $arr_txt[$no];
		}
	}
	return $pass;
}
function cmp($c_kind,$c_name){
	if($c_kind != ""){
		if($c_kind == "47"){
			$cmp_name = "株式会社" . $c_name;
			return $cmp_name ;
		}
		if($c_kind == "48"){
			$cmp_name = $c_name . "株式会社";
			return $cmp_name ;
		}
		if($c_kind == "49"){
			$cmp_name = "有限会社" . $c_name;
			return $cmp_name ;
		}
		if($c_kind == "50"){
			$cmp_name = $c_name . "有限会社";
			return $cmp_name ;
		}
		if($c_kind == "166"){
			$cmp_name = "合資会社" . $c_name;
			return $cmp_name ;
		}
		if($c_kind == "167"){
			$cmp_name = $c_name . "合資会社";
			return $cmp_name ;
		}
		if($c_kind == "168"){
			$cmp_name = $c_name;
			return $cmp_name ;
		}
	}else{
		$cmp_name = $c_name;
		return $cmp_name ;
	}
}
function Situation_Cnt($num1,$num2){
	$sit_cnt = "";
	if($num1 > 0){
		$sit_cnt = "有料（固定）";
	}
	if($num2 > 0){
		if($num1 > 0){
			$sit_cnt .= "・";
		}
		$sit_cnt .= "有料（成果）";
	}
	if($sit_cnt == ""){
		$sit_cnt = "無料";
	}
	return $sit_cnt ;
}
function getDays($date_before, $date_after){
	$u_date_before = strtotime($date_before);//日付前をUNIXタイム化
	$u_date_after = strtotime($date_after);//日付後をUNIXタイム化
	$days = ($u_date_after-$u_date_before)/86400 + 1;//差を24（時間）×60（分）×60（秒）で割る
	return $days;
}
/*月末チェック*/
function getMonthEndDay($year, $month) {
	//mktime関数で日付を0にすると前月の末日を指定したことになります
	//$month + 1 をしていますが、結果13月のような値になっても自動で補正されます
	$dt = mktime(0, 0, 0, $month + 1, 0, $year);
	return date("d", $dt);
}

/**
 * 配列を変数に入れる
 * @return string
 */
function arrayColumn($str) {
	if(!empty($str)){
		return $str;
	}
}

/**
 * パスワードを生成する
 * @param number $length
 * @param number $strength
 * @return string
 */
function generatePassword($length=9, $strength=0) {

	$pass_char = '1234567890!#$%()=+*abcdefghijklmnopqrstuvwxyz!#$%()=+*1234567890!#$%()=+*ABCDEFGHIJKLMNOPQRSTUVWXYZ!#$%()=+*';
	return substr(str_shuffle($pass_char), $strength, $length);

}

/**
 * サニタイズを行う
 * 対象：$_POST,$_REQUEST,$_GET
 * @return string
 */
function sanitizeCnv() {

	$array_input = array();
	$array_input[0] = $_POST;
	$array_input[1] = $_REQUEST;
	$array_input[2] = $_GET;

	foreach ($array_input AS $inp => $source) {

		foreach ($source as $key => $val) {
			if(is_array($val)){
				$arr_m = array();
				if ($val != "") {
					foreach ($val as $v) {
						if (!mb_check_encoding($v,'UTF-8')) { $err = "不正な入力をされた可能性が有ります。<br>" . $mess; }
						$v = mb_convert_encoding($v, "UTF-8", "UTF-8");
						$arr_m[] = htmlspecialchars($v,ENT_QUOTES,'UTF-8');
						$arr_m[] = preg_replace("/\?/","",$v);
					}
					$arr_unique = array_unique($arr_m);
					switch ($inp) {
						case 0:
							$_POST[$key] = $arr_unique;
							break;
						case 1:
							$_REQUEST[$key] = $arr_unique;
							break;
						case 2:
							$_GET[$key] = $arr_unique;
							break;
					}
				}
			}else{
				if (!mb_check_encoding($val,'UTF-8')) { $err = "不正な入力をされた可能性が有ります。<br>" . $mess; }
				$val = mb_convert_encoding($val, "UTF-8", "UTF-8");
				switch ($inp) {
					case 0:
						$_POST[$key] = htmlspecialchars($val,ENT_QUOTES,'UTF-8');
						$_POST[$key] = preg_replace("/\,/","，",$_POST[$key]);
						$_POST[$key] = preg_replace("/\?/","",$_POST[$key]);
						break;
					case 1:
						$_REQUEST[$key] = htmlspecialchars($val,ENT_QUOTES,'UTF-8');
						$_REQUEST[$key] = preg_replace("/\,/","，",$_REQUEST[$key]);
						$_REQUEST[$key] = preg_replace("/\?/","",$_REQUEST[$key]);
						break;
					case 2:
						$_GET[$key] = htmlspecialchars($val,ENT_QUOTES,'UTF-8');
						$_GET[$key] = preg_replace("/\,/","，",$_GET[$key]);
						$_GET[$key] = preg_replace("/\?/","",$_GET[$key]);
						break;
				}
			}
		}
	}

	return $err;
}

/**
 * MYSQLescape関数
 *
 * % - パーセント文字。引数は不要です。
 * b - 引数を整数として扱い、 2 進数として表現します。
 * c - 引数を整数として扱い、その ASCII 値の文字として表現します。
 * d - 引数を整数として扱い、 10 進数として表現します。
 * e - 引数を科学記法として扱います (例 1.2e+2)。 精度の指定子は、PHP 5.2.1 以降では小数点以下の桁数を表します。 それより前のバージョンでは、有効数字の桁数 (ひとつ小さい値) を意味していました。
 * E - %e と同じですが、 大文字を使います (例 1.2E+2)。
 * f - 引数を double として扱い、 浮動小数点数として表現します。
 * F - 引数を float として扱い、 浮動小数点数として表現します (ロケールに依存しません)。 PHP 4.3.10 および PHP 5.0.3 以降で使用可能です。
 * g - %e および %f の短縮形。
 * G - %E および %f の短縮形。
 * o - 引数を整数として扱い、 8 進数として表現します。
 * s - 引数を文字列として扱い、表現します。
 * u - 引数を整数として扱い、符号無しの 10 進数として表現します。
 * x - 引数を整数として扱い、16 進数として (小文字で)表現します。
 * X - 引数を整数として扱い、16 進数として (大文字で)表現します。
 *
 * @param unknown_type $value
 * @return string
 */
function escape($value){
	//多重エスケープの防止
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}

	//数値の場合はエスケープし無い
	if (!is_numeric($value)) {
		//クォートする
		$value = "'" . mysql_real_escape_string($value) . "'";
	}else{
		$value = mysql_real_escape_string($value);
	}

	return $value;
}

/**
 * MYSQLでカラムを暗号化するための装飾を行う
 * @param unknown_type $str
 * @param unknown_type $hash
 * @return string
 */
function encColumn ($str,$hash) {
	$str = QotDel($str);
	return "HEX(AES_ENCRYPT(" . $str . ",'" . $hash . "'))";
}

/**
 * MYSQLでカラムを複合化するための装飾を行う
 * @param unknown_type $column
 * @param unknown_type $hash
 * @return string
 */
function decColumn ($column,$hash) {
	$column = QotDel($column);
	return "CONVERT(AES_DECRYPT(UNHEX(" . $column . "),'" . $hash . "') USING utf8)";
}

/**
 * SQLとパラメーターからSQLを生成する
 * @param unknown_type $sql　SQL
 * @param unknown_type $prm　パラメーター配列
 * @return string
 */
function createSQL ($sql,$prm=array()) {

	//はいれつｔを回してエスケープする
	foreach ((array)$prm AS $val) {
		$prms[] = escape($val);
	}

	return vsprintf($sql,$prms);
}

/**
 * SQLを実行する
 * エラーの場合は指定のURLに遷移する
 * 遷移先が指定されていない場合はエラーメッセージを返す
 * @param unknown_type $sql　SQL
 * @param unknown_type $return_url　エラーの場合に遷移するURL
 */
function ExecSQL ($sql,$return_url) {
	//使用禁止
	throw new Exception("DO NOT USE 'ExecSQL(...)' ");
}

define('SQL_DEBUG_FLG', 0);

function pdo_exec_query ($sql, $return_url=null) {
	if (SQL_DEBUG_FLG) {
		error_log($sql);
	}

	global $pdo;
	if ($pdo == null) {
		throw new Exception("PDO OBJECT IS NULL");
	}
	$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

	//SQLを実行
	$stmt = $pdo->query($sql);

	//エラーがある場合
	if (!$stmt) {
		//遷移先がある場合
		if ($return_url != "") {
			header("Location:".$return_url."?err");
			exit;
		}else{
			//遷移先が無い場合はエラーメッセージを返す。
			$info = $pdo->errorInfo();

			error_log($sql."\n".var_export($info, true));
			return "SQL ERROR:".$info[2];
		}
	}

	return array($stmt, $stmt->rowCount());
}
function pdo_fetch_assoc ($stmt) {
	return $stmt->fetch(PDO::FETCH_ASSOC);
}
function pdo_exec_update ($sql, $param=null) {
	if (SQL_DEBUG_FLG) {
		error_log($sql);
		error_log(var_export($param, true));
	}

	global $pdo;
	if ($pdo == null) {
		throw new Exception("PDO OBJECT IS NULL");
	}

	$stmt = $pdo -> prepare($sql);
	return $stmt -> execute($param);
}


/**
 * 基準日からN日後の日付を取得する
 * @param unknown $year　年
 * @param unknown $month　月
 * @param unknown $day　日
 * @param unknown $addDays　N日後
 * @return string　N日後の日付
 */
function computeDate($date, $addDays) {

	//基準日付を分解
	list($year,$month,$day) = explode("-",$date);

	//基準日を秒で取得
	$baseSec = mktime(0, 0, 0, $month, $day, $year);

	//日数×１日の秒数
	$addSec = $addDays * 86400;

	$limitSec = $baseSec + $addSec;

	$nowSec = mktime(0, 0, 0, date("m"), date("d"), date("Y"));

	$targetSec = ($limitSec - $nowSec) / 86400;

	return $targetSec;

}

/**
 * 文字列を*に文字数分変更して返す
 * @param unknown $str　文字列
 * @return string　*に変更した文字列
 */
function convAst($str) {
	$ret = "";
	$len_pass = strlen($str);

	for ($i=0;$i<$len_pass;$i++) {
		$ret .= "*";
	}
	return $ret;
}

function post_json_http($url, $data) {
	if (is_array($data)) {
		$json = json_encode($data);
	}

	$options = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_AUTOREFERER => true,
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

/**
*
**/
function ChkSiteForm ($unique_key,$domain) {

	$err_mess = array();
	$err_flg = 0;
	$url = parse_url($_SERVER['HTTP_REFERER']);
	if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $url['host'], $regs)) {
	    $url_host = $regs['domain'];
	}else{
		$url_host = $url['host'];
	}
	if ($domain != $url_host) { $err_flg = 1; }
	if ($_SESSION['unique_form_key'] != $unique_key OR (empty($_SESSION['unique_form_key']) AND empty($unique_key))) { $err_flg = 1; }

	if ($err_flg == 1) { $err_mess[] = "正常に処理が実行できませんでした、再入力をお願いします。<br />\n"; }

	return $err_mess;

}

/**
 * ページネーションを作成する
 * @param unknown $page_view 1ページに表示する件数
 * @param unknown $p 現在のページ数（$_REQUEST['p']）
 * @param unknown $row_num 最大件数
 * @param unknown $url_query URLにつけるクエリー（?p=の後&から）
 * @return multitype:unknown string number [0]:html [1]:OFFSET値 [2]:LIMIT値
 */
function createPageNation($page_view,$p,$row_num,$url_query=null) {

	//プログラム名を取得
	$now_page = $_SERVER['SCRIPT_NAME'];

	//現在のページがnullなら1ページ目とする
	if ($p == "") { $p = 1; }
	$base_page = $p;

	//現在のページが1ページ目なら読み込み開始のレコードを0とする
	if($base_page == 1){
		$offset = 0;
	}else{
		//現在のページが１ページ目以外なら
		$offset_key = $base_page - 1;
		$offset = $offset_key * $page_view;
	}

	//開始ページの初期値を設定する
	$page_st = $base_page - 5;

	//終了ページの初期値を設定する
	$page_ed = $base_page + 5;

	//開始ページがマイナスの場合
	if ($page_st < 0) {
		$page_st = 0;
		$page_ed = 10;
	}

	//最大（全件）のページ数を取得する
	$max_page_cnt = ceil($row_num / $page_view);

	//最大のページ数より終了ページ数が大きい場合
	if ($max_page_cnt < $page_ed) {
		$page_ed = $max_page_cnt;
		$page_st = $max_page_cnt - 9;
		if($page_st < 0){
			$page_st = "0";
		}
	}

	//全体のページが2ページ以上ある場合に表示する
	if($max_page_cnt > "1"){

		$pagenation_line = "";

		$pagenation_line .= "<div class=\"pager\">\n";
		$pagenation_line .= "<ul class=\"pagination\">\n";
		if ($page_st > 0) {
			$pagenation_line .= "<li class=\"size_70\"><a href=\"".$now_page."?p=1".$url_query."\"><span><< 最初へ</span></a></li>\n";
		}
		if ($base_page > 1) {
			$b_page = $base_page - 1;
			$pagenation_line .= "<li class=\"size_70\"><a href=\"".$now_page."?p=".$b_page.$url_query."\"><span>< 前へ</span></a></li>\n";
		}

		if($row_num > $page_view){
			for ($i=$page_st; $i<$page_ed; $i++) {
				$page_no = $i + 1;
				if ($page_no != $base_page) {
					$pagenation_line .= "<li class=\"\"><a href=\"".$now_page."?p=" . $page_no .$url_query."\"><span>".$page_no."</span></a></li>\n";
				}else{
					$pagenation_line .= "<li class=\"\"><a href=\"".$now_page."?p=" . $page_no .$url_query."\"  class=\"active\"><span>".$page_no."</span></a></li>\n";
				}
			}
		}

		//最後のページの場合は非表示
		if ($max_page_cnt > $base_page) {
			$n_page = $base_page + 1;
			$pagenation_line .= "<li class=\"size_70\"><a href=\"".$now_page."?p=" . $n_page . $url_query."\"><span>次へ ></span></a></li>\n";
		}
		if ($max_page_cnt != $page_ed) {
			$pagenation_line .= "<li class=\"size_70\"><a href=\"".$now_page."?p=" . $max_page_cnt . $url_query."\"<span>最後へ >></span></a></li>\n";
		}

		$pagenation_line .= "</ul>\n";
		$pagenation_line .= "</div>\n";

	}

	return array($pagenation_line,$offset,$page_view);

}
