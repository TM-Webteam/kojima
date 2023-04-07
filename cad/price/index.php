<?php
//DB接続ファイルインクルード
include("../include/dbconn.php");
//設定ファイルインクルード
include("../include/config.php");
//リストファイルインクルード
include("../include/list.php");
//関数ファイルインクルード
include("../include/convert.php");

/**
 * パンくず設定
 ********************************************************************/
$pan[0]["title"] = "パターンメイキング・グレーディング料金表";
//---------------------------------------------------------//
//エラーチェック
//---------------------------------------------------------//
if ($_POST['act'] == 'conf' or $_POST['act'] == 'fin') {

  //エラーメッセージ初期化
  $err_mess = array();

  //入力チェック
  $err_mess[] = SelectChk($_POST['service_outsorcing'], "外注を検討されているサービス");
  $err_mess[] = SelectChk($_POST['situation_now'], "現在のご検討状況をお聞かせください");
  if (!empty($_POST['situation_now'])) {
    if (in_array("4", $_POST['situation_now'])) {
      $err_mess[] = InputChk($_POST['situation_now_other'], "現在のご検討状況をお聞かせください(その他)");
    }
  }

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
  // $url = 'https://www.marke-media.net/sys/management_tm_kojima/form/price.php';
  $url = 'https://marketing.tmedia.jp/sys/management_tm_kojima/form/price.php';

  $service_outsorcing = itemView($_POST['service_outsorcing'], $service_outsorcing, "、");
  $situation_now = itemView($_POST['situation_now'], $situation_now, "、");
  if (in_array("4", $_POST['situation_now'])) {
    $situation_now .= "（" . $_POST['situation_now_other'] . "）";
  }

  $data = array(
    "site_type" => "price",
    "site_kind" => "kojima",
    "service_outsorcing" => $service_outsorcing,
    "situation_now" => $situation_now,
    "company_name" => $_POST['company_name'],
    "name" => $_POST['name'],
    "email" => $_POST['email'],
    "tel" => $_POST['tel'],
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
  <meta name="keywords" content="パターン　メイキング,マーキング　外注 ">
  <meta name="description" content="パターンメイキング・グレーディングをはじめとする各種業務の料金単価表がダウンロードできます。">
  <meta name="author" content="">
  <title>パターンメイキング・グレーディング３Dモデリングサービス料金表 | 小島衣料CADサービス | </title>
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
  <meta name="twitter:title" content="パターンメイキング・グレーディング外注サービス | 小島衣料CADサービス | サイトタイトル">
  <meta name="twitter:image:src" content="">

  <!-- Open Graph data -->
  <meta property="og:title" content="パターンメイキング・グレーディング外注サービス | 小島衣料CADサービス | サイトタイトル">
  <meta property="og:description" content="迅速・リーズナブル・高品質」をモットーに、パターンメイキングからグレーディングの外注サービスを提供しています。急ぎのご相談から、パターンサンプル作成、小ロット対応までお気軽にご相談下さい。">
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

<body class="home page" id="price">


  <?php include("../include/header.php"); ?>
  <?php
  if ($_POST['act'] == "" or $_POST['act'] == "err") {
  ?>
    <section>
      <div class="container pt20_sp mt60_pc flex_box fw_wrap">
        <div class="priceboxs_l">
          <div class="heading-primary">
            <h1 class="heading-primary__ttl">パターンメイキング・グレーディング<br>３Dモデリングサービス料金表</h2>
          </div>
          <div class="wpimg_box">
            <img src="<?php echo $url_path; ?>/assets/img/price/price_wp.jpg" style="border:1px solid #ccc;">
          </div>
          <div class="txt_box">
            <p class="ttl">パターンメイキング・グレーディング・３Dモデリングをはじめとする各種業務の料金単価表がダウンロードできます。</p>
            <p class="blackbox">以下業務の料金単価をご案内しています。</p>
            <div class="ul_box">
              <ul>
                <li>パターンメイキング（PM）</li>
                <li>グレーディング（GR）</li>
                <li>トワル作成</li>
                <li>仕様書（PS）</li>
                <li>サンプル作成（SP）</li>
              </ul>
              <ul>
                <li>出力（OUTPUT）</li>
                <li>入力（INPUT）</li>
                <li>マーキング（MR）</li>
                <li>パターン修正</li>
                <li>３Dモデリングサービス</li>
              </ul>
            </div>
          </div>
          <div class="tac price_btn">
            <p>詳細のお見積りや納期のご確認をされたい方はこちらからの方がスムーズです。</p>
            <a class="btn-arrow" href="/cad/contact/">納期問合せ・見積り依頼</a>
          </div>
        </div>

        <div class="priceboxs_r">
          <div class="price_form_box">
            <p class="tac mb40">料金表ダウンロードご希望の方は、下記フォームに必要事項をご記入の上、送信ボタンを押してください。</p>
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
                  <tr class="tw-all">
                    <th>電話番号<span>必須</span></th>
                    <td><input type="tel" name="tel" value="<?php echo $_POST['tel'] ?>" placeholder="ハイフンを入れてご入力ください。例）03-1234-5678"></td>
                  </tr>
                  <tr>
                    <th>現在のご検討状況をお聞かせください<span>必須</span></th>
                    <td>
                      <?php foreach ($situation_now as $key => $value) :
                        if (!empty($_POST['situation_now'])) {
                          $checked = "";
                          if (in_array($key, $_POST['situation_now'])) {
                            $checked = " checked";
                          }
                        }

                      ?>
                        <p>
                          <input type="checkbox" id="situation_now<?php echo $key; ?>" name="situation_now[]" value="<?php echo $key; ?>" <?php echo $checked ?> />
                          <label for="situation_now<?php echo $key; ?>"><?php echo $value ?></label>
                          <?php if ($key == "4") : ?>
                            <input type="text" name="situation_now_other" class="in_text" value="<?php echo $_POST['situation_now_other'] ?>">
                          <?php endif ?>
                        </p>
                      <?php endforeach ?>
                    </td>
                  </tr>
                  <tr>
                    <th>外注を検討されているサービス（複数選択可）<span>必須</span></th>
                    <td>
                      <div class="service_ichiran">
                        <div class="box">
                          <?php foreach ($service_outsorcing as $key => $value) :
                            if (!empty($_POST['service_outsorcing'])) {
                              $checked = "";
                              if (in_array($key, $_POST['service_outsorcing'])) {
                                $checked = " checked";
                              }
                            }
                          ?>
                            <?php if ($key < 6 or $key == 11) { ?>
                              <p>
                                <input type="checkbox" id="service_outsorcing<?php echo $key; ?>" name="service_outsorcing[]" value="<?php echo $key; ?>" <?php echo $checked ?> />
                                <label for="service_outsorcing<?php echo $key; ?>"><?php echo $value ?></label>
                              </p>
                            <?php } ?>
                          <?php endforeach ?>
                        </div>
                        <div class="box">
                          <?php foreach ($service_outsorcing  as $key => $value) :
                            if (!empty($_POST['service_outsorcing'])) {
                              $checked = "";
                              if (in_array($key, $_POST['service_outsorcing'])) {
                                $checked = " checked";
                              }
                            }
                          ?>
                            <?php if ($key >= 6 and $key != 11) { ?>
                              <p>
                                <input type="checkbox" id="service_outsorcing<?php echo $key; ?>" name="service_outsorcing[]" value="<?php echo $key; ?>" <?php echo $checked ?> />
                                <label for="service_outsorcing<?php echo $key; ?>"><?php echo $value ?></label>
                              </p>
                            <?php } ?>
                          <?php endforeach ?>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr class="tw-all">
                    <th>その他知りたい情報がございましたらご記入ください（任意）</th>
                    <td><textarea rows="10" name="comment"><?php echo $_POST['comment'] ?></textarea></td>
                  </tr>
                </table>
              </div>
              <p class="agree_dec">
                料金表ダウンロードは「<a href="http://www.kojima-iryo.com/privacy.html" target="_blank" style="display: inline;">個人情報の取扱いについて</a>」への同意が必要です。内容をご確認の上、ご同意いただける場合「同意する」にチェックをして、「上記に同意して確認画面へ進む」をクリックしてください。
              </p>
              <p class="agree_dec__agree">
                <input type="checkbox" id="check10" name="terms[]" value="1" />
                <label for="check10">同意する</label>
              </p>
              <a class="btn-arrow red" href="javascript:document.form1.submit()">
                確認画面へ進む
              </a>
              <input type="hidden" name="act" value="conf">
              <input type="hidden" name="mode" value="<?php echo $_POST['mode']; ?>">
            </form>

          </div>
        </div>
      </div>
    <?php
  }
  if ($_POST['act'] == "conf") {

    $service_outsorcing = itemView($_POST['service_outsorcing'], $service_outsorcing, "、");
    $situation_now = itemView($_POST['situation_now'], $situation_now, "、");
    if (in_array("4", $_POST['situation_now'])) {
      $situation_now .= "（" . $_POST['situation_now_other'] . "）";
    }
    ?>
      <div class="container">
        <div class="heading-primary">
          <h2 class="heading-primary__ttl">料金表<br class="sp-only">ダウンロードフォーム</h2>
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
          <tr class="tw-all">
            <th>電話番号<span>必須</span></th>
            <td><?php echo $_POST['tel'] ?></td>
          </tr>
          <tr>
            <th>現在のご検討状況をお聞かせください<span>必須</span></th>
            <td><?php echo $situation_now ?></td>
          </tr>
          <tr>
            <th>外注を検討されているサービス<span>必須</span></th>
            <td><?php echo $service_outsorcing ?></td>
          </tr>
          <tr class="tw-all">
            <th>ご相談・お問合せ内容</th>
            <td><?php echo Nr2Br($_POST['comment']) ?></td>
          </tr>
        </table>
      </div>

      <div class="formBtnarea">
        <form action="" method="post" name="form1">
          <a class="btn-arrow gray" href="javascript:document.form1.submit()">
            前画面に戻る
          </a>
          <?php
          $arr_leave_out = array("act", "del", "act2");
          echo HiddenView($arr_leave_out);
          ?>
        </form>
        <form action="" method="post" name="form2">
          <a class="btn-arrow red" href="javascript:document.form2.submit()">
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
    </div>
    </section>

    <?php include("../include/footer_contact.php"); ?>


    <?php include("../include/footer.php"); ?>

</body>

</html>