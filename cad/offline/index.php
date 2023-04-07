<?php
//DB接続ファイルインクルード
include("../include/dbconn.php");
//設定ファイルインクルード
include("../include/config.php");
//リストファイルインクルード
include("../include/list.php");
//関数ファイルインクルード
include("../include/convert.php");
$pan[0]["title"] = "納期問合せ・お見積り依頼";


//---------------------------------------------------------//
//エラーチェック
//---------------------------------------------------------//
if ($_POST['act'] == 'conf' or $_POST['act'] == 'fin') {

  //エラーメッセージ初期化
  $err_mess = array();

  //入力チェック
  $err_mess[] = SelectChk($_POST['contact_type'], "お問合せ内容");
  if (!empty($_POST['contact_type'])) {
    if (in_array("258", $_POST['contact_type'])) {
      $err_mess[] = InputChk($_POST['contact_type_other'], "お問合せ内容(その他)");
    }
  }
  $err_mess[] = SelectChk($_POST['interested_service'], "問合せしたいサービス");
  if (!empty($_POST['interested_service'])) {
    if (in_array("261", $_POST['interested_service'])) {
      $err_mess[] = InputChk($_POST['interested_service_other'], "問合せしたいサービス(その他)");
    }
  }

  $err_mess[] = SelectChk($_POST['address1'], "都道府県");
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
  }
  // $err_mess[] = InputChk($_POST['tel'],"電話番号");
  if (!preg_match("/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/", $_POST['tel'])) {
    $err_mess[] = "電話番号の項目は半角数字、ハイフンを入れてご入力ください<br>\n";
  }
  if ($_POST['terms'] == "") {
    $err_mess[] = "お問合せ・お見積り依頼には「プライバシーポリシー」への同意が必要です。<br />\n";
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
  $url = 'https://www.marke-media.net/sys/management_tm_kojima/form/offline.php';

  $contact_type = itemView($_POST['contact_type'], $item_list['contact_type'], "、");
  if (in_array("258", $_POST['contact_type'])) {
    $contact_type .= "（" . $_POST['contact_type_other'] . "）";
  }
  $interested_service = itemView($_POST['interested_service'], $item_list['interested_service'], "、");
  if (in_array("261", $_POST['interested_service'])) {
    $interested_service .= "（" . $_POST['interested_service_other'] . "）";
  }

  $data = array(
    "site_type" => "contact",
    "site_kind" => "kojima",
    "contact_type" => $contact_type,
    "interested_service" => $interested_service,
    "address1" => $_POST['address1'],
    "company_name" => $_POST['company_name'],
    "name" => $_POST['name'],
    "email" => $_POST['email'],
    "tel" => $_POST['tel'],
    "reference_item" => itemView($_POST['reference_item'], $item_list['reference_item'], "、"),
    "comment" => $_POST['comment'],
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
  <meta name="description" content="小島衣料ではアパレル外注パターンサービスを行っております。お急ぎで外注先をお探しの方は是非ご相談ください。">
  <meta name="author" content="">
  <title>パターン作成・グレーディング業務に関する納期問合せ</title>
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
  <meta name="twitter:title" content="パターン作成・グレーディング業務に関する納期問合せ| 小島衣料CADサービス">
  <meta name="twitter:image:src" content="">

  <!-- Open Graph data -->
  <meta property="og:title" content="パターン作成・グレーディング業務に関する納期問合せ| 小島衣料CADサービス">
  <meta property="og:description" content="小島衣料ではアパレル外注パターンサービスを行っております。お急ぎで外注先をお探しの方は是非ご相談ください。">
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
        <h2 class="heading-primary__ttl">納期問合せ・<br class="sp-only">お見積り依頼フォーム<span style="color:#ff0000;">［オフライン］</span></h2>
        <p class="heading-primary__ttl__dec">以下に必要事項をご記入の上、確認画面ボタンをクリックしてください。<br>後ほど担当者より折り返しご連絡をさせて頂きます。
        </p>
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
          <tr>
            <th>お問合せ内容<span>※</span></th>
            <td>
              <?php foreach ($item_list['contact_type'] as $key => $value) :
                if (!empty($_POST['contact_type'])) {
                  $checked = "";
                  if (in_array($key, $_POST['contact_type'])) {
                    $checked = " checked";
                  }
                }

              ?>
                <p>
                  <input type="checkbox" id="check<?php echo $key; ?>" name="contact_type[]" value="<?php echo $key; ?>" <?php echo $checked ?> />
                  <label for="check<?php echo $key; ?>"><?php echo $value ?></label>
                  <?php if ($key == "258") : ?>
                    <input type="text" name="contact_type_other" class="in_text" value="<?php echo $_POST['contact_type_other'] ?>">
                  <?php endif ?>
                </p>
              <?php endforeach ?>

            </td>
          </tr>
          <tr>
            <th>問合せしたいサービス<span>※</span></th>
            <td>
              <?php foreach ($item_list['interested_service'] as $key => $value) :
                if (!empty($_POST['interested_service'])) {
                  $checked = "";
                  if (in_array($key, $_POST['interested_service'])) {
                    $checked = " checked";
                  }
                }

              ?>
                <p>
                  <input type="checkbox" id="check<?php echo $key; ?>" name="interested_service[]" value="<?php echo $key; ?>" <?php echo $checked ?> />
                  <label for="check<?php echo $key; ?>"><?php echo $value ?></label>
                  <?php if ($key == "261") : ?>
                    <input type="text" name="interested_service_other" class="in_text" value="<?php echo $_POST['interested_service_other'] ?>">
                  <?php endif ?>
                </p>
              <?php endforeach ?>

            </td>
          </tr>
          <tr class="tw-all">
            <th>都道府県<span>※</span></th>
            <td>
              <select name="address1">
                <option value="">
                  <?php echo SelectView("address1", $address_code, "") ?>
              </select>
            </td>
          </tr>
          <?php if ($_POST['mode'] == "personal") : ?>
            <tr class="tw-all">
              <th>分類</th>
              <td>個人</td>
              <input type="hidden" name="company_name" value="個人">
            </tr>
            <tr class="tw-all">
              <th>会社名<span>※</span></th>
              <td><input type="text" name="personal_company_name" value="<?php echo $_POST['personal_company_name'] ?>" placeholder="会社名がない方はお手数ですが、「なし」と記入してください。"></td>
            </tr>
          <?php else : ?>
            <tr class="tw-all">
              <th>会社名<span>※</span></th>
              <td><input type="text" name="company_name" value="<?php echo $_POST['company_name'] ?>"></td>
            </tr>
          <?php endif; ?>
          <tr class="tw-all">
            <th>お名前<span>※</span></th>
            <td><input type="text" name="name" value="<?php echo $_POST['name'] ?>"></td>
          </tr>
          <tr class="tw-all">
            <th>メールアドレス<span>※</span></th>
            <td><input type="email" name="email" value="<?php echo $_POST['email'] ?>"></td>
          </tr>
          <tr class="tw-all">
            <th>電話番号<span>※</span></th>
            <td><input type="tel" name="tel" value="<?php echo $_POST['tel'] ?>" placeholder="ハイフンを入れてご入力ください。例）03-1234-5678"></td>
          </tr>
          <tr>
            <th>いずれかおもちの方は教えてください</th>
            <td>
              <?php foreach ($item_list['reference_item'] as $key => $value) :
                if (!empty($_POST['reference_item'])) {
                  $checked = "";
                  if (in_array($key, $_POST['reference_item'])) {
                    $checked = " checked";
                  }
                }

              ?>
                <p>
                  <input type="checkbox" id="check<?php echo $key; ?>" name="reference_item[]" value="<?php echo $key; ?>" <?php echo $checked ?> />
                  <label for="check<?php echo $key; ?>"><?php echo $value ?></label>
                </p>
              <?php endforeach ?>

            </td>
          </tr>
          <tr class="tw-all">
            <th>ご相談・お問合せ内容</th>
            <td><textarea rows="20" name="comment"><?php echo $_POST['comment'] ?></textarea></td>
          </tr>
        </table>
      </div>
      <p class="agree_dec">
        お問合せ・お見積り依頼には「<a href="http://www.kojima-iryo.com/privacy.html" target="_blank">個人情報の取扱いについて</a>」への同意が必要です。<br class="pc-only">内容をご確認の上、ご同意いただける場合「同意する」にチェックをして、<br class="pc-only">「上記に同意して確認画面へ進む」をクリックしてください。
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

    $contact_type = itemView($_POST['contact_type'], $item_list['contact_type'], "、");
    if (in_array("258", $_POST['contact_type'])) {
      $contact_type .= "（" . $_POST['contact_type_other'] . "）";
    }
    $interested_service = itemView($_POST['interested_service'], $item_list['interested_service'], "、");
    if (in_array("261", $_POST['interested_service'])) {
      $interested_service .= "（" . $_POST['interested_service_other'] . "）";
    }


  ?>


    <div class="container">
      <div class="heading-primary">
        <h2 class="heading-primary__ttl">納期問合せ・<br class="sp-only">お見積り依頼フォーム<span style="color:#ff0000;">［オフライン］</span></h2>
        <p class="heading-primary__ttl__dec">ご記入したフォーム内容をご確認の上、送信ボタンを押してください。</p>
      </div>
    </div>
    <div class="contact_form">
      <table>
        <tr>
          <th>お問合せ内容<span>※</span></th>
          <td><?php echo $contact_type ?></td>
        </tr>
        <tr>
          <th>問合せしたいサービス<span>※</span></th>
          <td><?php echo $interested_service ?></td>
        </tr>
        <tr class="tw-all">
          <th>都道府県<span>※</span></th>
          <td><?php echo itemView($_POST['address1'], $address_code, "") ?></td>
        </tr>
        <?php if ($_POST['mode'] == "personal") : ?>
          <tr class="tw-all">
            <th>分類</th>
            <td><?php echo $_POST['company_name'] ?></td>
          </tr>
          <tr class="tw-all">
            <th>会社名<span>※</span></th>
            <td><?php echo $_POST['personal_company_name'] ?></td>
          </tr>
        <?php else : ?>
          <tr class="tw-all">
            <th>会社名<span>※</span></th>
            <td><?php echo $_POST['company_name'] ?></td>
          </tr>
        <?php endif; ?>
        <tr class="tw-all">
          <th>お名前<span>※</span></th>
          <td><?php echo $_POST['name'] ?></td>
        </tr>
        <tr class="tw-all">
          <th>メールアドレス<span>※</span></th>
          <td><?php echo $_POST['email'] ?></td>
        </tr>
        <tr class="tw-all">
          <th>電話番号<span>※</span></th>
          <td><?php echo $_POST['tel'] ?></td>
        </tr>
        <tr>
          <th>いずれかおもちの方は教えてください</th>
          <td><?php echo itemView($_POST['reference_item'], $item_list['reference_item'], "、") ?></td>
        </tr>
        <tr class="tw-all">
          <th>ご相談・お問合せ内容</th>
          <td><?php echo Nr2Br($_POST['comment']) ?></td>
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