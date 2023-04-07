<?php
//DB接続ファイルインクルード
include("../include/dbconn.php");
//設定ファイルインクルード
include("../include/config.php");
//リストファイルインクルード
include("../include/list.php");
//関数ファイルインクルード
include("../include/convert.php");
$pan[0]["title"] = "メールマガジン新規登録";


//---------------------------------------------------------//
//エラーチェック
//---------------------------------------------------------//
if ($_POST['act'] == 'conf' or $_POST['act'] == 'fin') {

  //エラーメッセージ初期化
  $err_mess = array();

  //入力チェック

  $err_mess[] = InputChk($_POST['company_name'], "会社名");
  if ($_POST['mode'] == "personal") {
    $err_mess[] = InputChk($_POST['personal_company_name'], "会社名");
  }
  $err_mess[] = InputChk($_POST['name'], "お名前");
  $err_mess[] = MailChk($_POST['email'], "メールアドレス", "1");
  if ($_POST['email'] != "" and $_POST['mode'] != "personal") {
    list($mail1, $mail2) = explode("@", $_POST['email']);
    $mail_err_flg = "none";
    foreach ($free_mail_list as $key => $val) {
      if ($mail2 == $key) {
        $mail_err_flg = "done";
      }
    }
    if ($mail_err_flg == "done") {
      $err_mess[] = 'フリーメールアドレスは使用できません。<br>フリーアドレスの方は<a href="javascript:document.myform.submit()" class="f_add_link">こちら</a>よりご登録お願いします。<br>';
    }
    if ($_POST['terms'] == "") {
      $err_mess[] = "メールマガジンのご登録には「個人情報の取扱いについて」への同意が必要です。<br />\n";
    }
  }
  //エラーチェック
  foreach ($err_mess as $err_key) {
    if ($err_key != "") {
      $_POST['act'] = "err";
      $_POST['type'] = "regist";
      break;
    }
  }
}
//--------------------------------------------------------------------------//
//完了画面
//--------------------------------------------------------------------------//
if ($_POST['act'] == "fin") {

  //$url = 'https://mmtest.intrakun.com/sys/management_tm_halmek_hld/form/wpdl.php';
  // $url = 'https://www.marke-media.net/sys/management_tm_kojima/form/mailmagazine.php';
  $url = 'https://marketing.tmedia.jp/sys/management_tm_kojima/form/mailmagazine.php';

  $data = array(
    "site_type" => "kmailmaga",
    "site_kind" => "kojima",
    "contact_type" => $contact_type,
    "company_name" => $_POST['company_name'],
    "name" => $_POST['name'],
    "email" => $_POST['email'],
    "url_type" => $_SESSION['url_type'],
    "company_id" => $_SESSION['company_id'],
    "personal_company_name" => $_POST['personal_company_name'],
  );

  $options = array(
    'http' => array(
      'method'  => 'POST',
      'content' => json_encode($data),
      'header' =>  "Content-Type: application/json\r\n" .
        "Accept: application/json\r\n"
    )
  );

  $context  = stream_context_create($options);
  $sql_insert = file_get_contents($url, false, $context);
  $sql_insert = json_decode($sql_insert, true);
  //   var_dump($sql_insert);
  // exit;
  //URL作成
  $appli_thanks = "./thanks.php";
  //完了画面へ遷移
  header("Location:$appli_thanks");
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="robots" content="noindex">
  <meta name="keywords" content="パターン　外注,グレーディング　外注,マーキング　外注 ">
  <meta name="description" content="小島衣料CADサービスでは、月2回「グレーディング」「パターンメイキング」「3Dモデリング」に関するトレンド情報やお役立ち情報を発信しています。">
  <meta name="author" content="">
  <title>メールマガジン　新規登録</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
  <!-- Favicons -->
  <!-- <link rel="apple-touch-icon" sizes="152x152" href="/assets/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon/favicon-16x16.png">
<link rel="manifest" href="/assets/img/favicon/site.webmanifest">
<link rel="mask-icon" href="/assets/img/favicon/safari-pinned-tab.svg" color="#110058">
<link rel="shortcut icon" href="/assets/img/favicon/favicon.ico">
<meta name="msapplication-TileColor" content="#110058">
<meta name="msapplication-config" content="/assets/img/favicon/browserconfig.xml">
<meta name="theme-color" content="#110058"> -->

  <!-- Schema.org markup for Google+ -->
  <meta itemprop="name" content="">
  <meta itemprop="image" content="">

  <!-- Twitter Card data -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="メールマガジン　新規登録">
  <meta name="twitter:image:src" content="">

  <!-- Open Graph data -->
  <meta property="og:title" content="メールマガジン　新規登録">
  <meta property="og:description" content="小島衣料CADサービスでは、月2回「グレーディング」「パターンメイキング」「3Dモデリング」に関するトレンド情報やお役立ち情報を発信しています。">
  <meta property="og:type" content="website">
  <meta property="og:url" content="">
  <meta property="og:image" content="">
  <meta property="og:image:width" content="">
  <meta property="og:image:height" content="">
  <meta property="og:site_name" content="">

  <link rel="stylesheet" href="<?php echo $url_path; ?>/assets/css/main.css">
  <link rel="stylesheet" href="<?php echo $url_path; ?>/assets/css/form.css">
  <link rel="stylesheet" href="<?php echo $url_path; ?>/assets/css/main3.css">
  <script src="//kitchen.juicer.cc/?color=Z+x+canRRXU=" async></script>
</head>

<body class="home page blog">
  <?php include("../include/header.php"); ?>
  <?php
  if ($_POST['act'] == "" or $_POST['act'] == "err") {
  ?>


    <div class="container">
      <div class="heading-primary">
        <h2 class="heading-primary__ttl">メールマガジン　新規登録</h2>
        <p class="heading-primary__ttl__dec">小島衣料CADサービスでは、月2回「グレーディング」「パターンメイキング」「3Dモデリング」に関するトレンド情報やお役立ち情報を発信しています。ご興味のある方は、1分で終わる必要事項をご入力の上、送信ボタンを押してください。
        </p>
      </div>

      <div class="flex_box mb40">
        <div class="mm-menu">
          <table>
            <tr>
              <th>配信頻度</th>
              <td>月2回程度</td>
            </tr>
            <tr>
              <th>購読料金</th>
              <td>無料</td>
            </tr>
            <tr>
              <th>内容</th>
              <td>
                <p>以下のような内容を配信します。</p>
                <ul>
                  <li>アパレルトレンドニュース</li>
                  <li>3Dモデリング</li>
                  <li>グレーディング/パターンメイキング</li>
                </ul>
              </td>
            </tr>
          </table>
        </div>
        <div class="mm-img">
          <p>＜メールの一例＞</p>
          <img src="<?php echo $url_path; ?>/assets/img/common/mail-sample.jpg" alt="メールの一例">
        </div>
      </div>

      <?php if ($_POST['act'] == "err") { ?>
        <form action="" name="myform" method="post">
          <div class="error-form-box">
            <p><?php echo Arr2Val($err_mess); ?></p>
          </div>
          <?php
          $arr_leave_out = array("act", "del", "act2");
          echo HiddenView($arr_leave_out);
          ?>
          <input type="hidden" name="mode" value="personal">
        </form>
      <?php } ?>
    </div>
    <form action="" method="post" name="form1">
      <div class="contact_form">
        <table>
          <?php if ($_POST['mode'] == "personal") : ?>
            <tr class="tw-all">
              <th>分類</th>
              <td>個人</td>
              <input type="hidden" name="company_name" value="個人">
            </tr>
            <tr class="tw-all">
              <th>会社名<span>必須</span></th>
              <td><input type="text" name="personal_company_name" value="<?php echo $_POST['personal_company_name'] ?>" placeholder="会社名がない方はお手数ですが、「なし」と記入してください。"></td>
            </tr>
          <?php else : ?>
            <tr class="tw-all">
              <th>会社名<span>必須</span></th>
              <td><input type="text" name="company_name" value="<?php echo $_POST['company_name'] ?>"></td>
            </tr>
          <?php endif; ?>
          <tr class="tw-all">
            <th>お名前<span>必須</span></th>
            <td><input type="text" name="name" value="<?php echo $_POST['name'] ?>"></td>
          </tr>
          <tr class="tw-all">
            <th>メールアドレス<span>必須</span></th>
            <td><input type="email" name="email" value="<?php echo $_POST['email'] ?>"></td>
          </tr>
        </table>
      </div>
      <p class="agree_dec">
        メールマガジンのご登録には「<a href="http://www.kojima-iryo.com/privacy.html" target="_blank">個人情報の取扱いについて</a>」への同意が必要です。<br class="pc-only">内容をご確認の上、ご同意いただける場合「同意する」にチェックをして、<br class="pc-only">「上記に同意して確認画面へ進む」をクリックしてください。
      </p>
      <p class="agree_dec__agree">
        <input type="checkbox" id="check10" name="terms[]" value="1" />
        <label for="check10">同意する</label>
      </p>
      <a class="btn-arrow" href="javascript:document.form1.submit()">
        確認画面へ進む
      </a>
      <input type="hidden" name="act" value="conf">
      <input type="hidden" name="mode" value="<?php echo $_POST['mode']; ?>">
    </form>

  <?php
  }
  if ($_POST['act'] == "conf") {

  ?>


    <div class="container">
      <div class="heading-primary">
        <h2 class="heading-primary__ttl">メールマガジン　新規登録</h2>
        <p class="heading-primary__ttl__dec">ご記入したフォーム内容をご確認の上、送信ボタンを押してください。</p>
      </div>
    </div>
    <div class="contact_form">
      <table>
        <?php if ($_POST['mode'] == "personal") : ?>
          <tr class="tw-all">
            <th>分類</th>
            <td><?php echo $_POST['company_name'] ?></td>
          </tr>
          <tr class="tw-all">
            <th>会社名<span>必須</span></th>
            <td><?php echo $_POST['personal_company_name'] ?></td>
          </tr>
        <?php else : ?>
          <tr class="tw-all">
            <th>会社名<span>必須</span></th>
            <td><?php echo $_POST['company_name'] ?></td>
          </tr>
        <?php endif; ?>
        <tr class="tw-all">
          <th>お名前<span>必須</span></th>
          <td><?php echo $_POST['name'] ?></td>
        </tr>
        <tr class="tw-all">
          <th>メールアドレス<span>必須</span></th>
          <td><?php echo $_POST['email'] ?></td>
        </tr>
      </table>
    </div>

    <div class="formBtnarea">
      <form action="" method="post" name="form1">
        <a class="btn-arrow bgGray" href="javascript:document.form1.submit()">
          前画面に戻る
        </a>
        <?php
        $arr_leave_out = array("act", "del", "act2");
        echo HiddenView($arr_leave_out);
        ?>
      </form>
      <form action="" method="post" name="form2">
        <a class="btn-arrow" href="javascript:document.form2.submit()">
          送信
        </a>
        <?php
        $arr_leave_out = array("act", "del", "act2");
        echo HiddenView($arr_leave_out);
        ?>
        <input type="hidden" name="act" value="fin">
      </form>
    </div>
  <?php
  }
  ?>

  <?php include("../include/footer.php"); ?>

</body>

</html>