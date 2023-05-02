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
$pan[0]["title"] = "小島衣料の強み";


?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="keywords" content="パターン　短納期,パターン　料金">
  <meta name="description" content="国内のみならず海外拠点をもつキャパシティーの大きさを強みに迅速・低価格・豊富な実績をもとにした高品質サービスを実現しています。">
  <meta name="author" content="">
  <title>小島衣料の概要・強み | 小島衣料CADサービス</title>
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
  <meta name="twitter:title" content="小島衣料の概要・強み | 小島衣料CADサービス">
  <meta name="twitter:image:src" content="">

  <!-- Open Graph data -->
  <meta property="og:title" content="小島衣料の概要・強み | 小島衣料CADサービス">
  <meta property="og:description" content="国内のみならず海外拠点をもつキャパシティーの大きさを強みに迅速・低価格・豊富な実績をもとにした高品質サービスを実現しています。">
  <meta property="og:type" content="website">
  <meta property="og:url" content="">
  <meta property="og:image" content="">
  <meta property="og:image:width" content="">
  <meta property="og:image:height" content="">
  <meta property="og:site_name" content="">

  <link rel="stylesheet" href="<?php echo $url_path; ?>/assets/css/main.css">
  <link rel="stylesheet" href="<?php echo $url_path; ?>/assets/css/main3.css">
  <script src="//kitchen.juicer.cc/?color=Z+x+canRRXU=" async></script>
</head>

<body class="home page">


  <?php include("../include/header.php"); ?>

  <div class="top_img strengths">
    <img src="<?php echo $url_path; ?>/assets/img/strengths/head_img.jpg" class="pc-only">
    <img src="<?php echo $url_path; ?>/assets/img/strengths/head_img_sp.jpg" class="sp-only">
    <div class="top_img__headline">
      <h1>短納期・低価格・豊富な実績をもとにした小島衣料のCADサービス</h1>
      <p>国内のみならず海外拠点をもつ<br class="sp-only">キャパシティーの大きさを強みに<br>迅速・低価格・豊富な実績をもとにした<br class="sp-only">高品質サービスを実現しています。</p>
    </div>
  </div>

  <section class="floating-start">
    <div class="background_dark_gr">
      <div class="container">
        <div class="heading-primary mb-50">
          <h2 class="heading-primary__ttl">パターン、グレーティング、<br class="sp-only">3Dモデリング<br>低価格・高品質な外注なら<br class="sp-only">「小島衣料」へ</h2>
        </div>
        <ul class="anc">
          <li><a href="#anc01">短納期</a></li>
          <li><a href="#anc02">低価格</a></li>
          <li><a href="#anc03">豊富な実績</a></li>
        </ul>
      </div>
    </div>
  </section>

  <section>
    <div class="container strengths_num">

      <div id="anc01" class="anc-space">
        <h2><span>強み<span>1</span></span>急ぎの納期にも対応</h2>
        <div class="flex_box strengths_num__box">
          <div class="col_2">
            <img src="<?php echo $url_path; ?>/assets/img/strengths/strengths_img01.jpg">
          </div>
          <div class="col_2">
            <p>経験豊富なスタッフがパターン作成～グレーディングまで対応。海外拠点もあるため、サンプル作成、小ロットにも短納期で対応が可能です。</p>
            <a class="btn-arrow stre_btn" href="<?php echo $url_path; ?>/contact/">納期問合せはこちら</a>
          </div>
        </div>
      </div>
      
      <div id="anc02" class="anc-space">
        <h2><span>強み<span>2</span></span>リーズナブル（低価格）</h2>
        <div class="flex_box strengths_num__box">
          <img src="<?php echo $url_path; ?>/assets/img/strengths/strengths_img02.jpg" class="sp-only">
          <div class="col_2 left_txt">
            <p>料金も低価格でご提供させて頂いております。海外拠点も含め多くのキャパシティを保有しているため、リーズナブルな料金体系を実現しています。</p>
            <a class="btn-arrow stre_btn" href="<?php echo $url_path; ?>/contact/">お見積り依頼･料金確認はこちら</a>
          </div>
          <div class="col_2">
            <img src="<?php echo $url_path; ?>/assets/img/strengths/strengths_img02.jpg" class="pc-only">
          </div>
        </div>
      </div>
      
      <div id="anc03" class="anc-space">
        <h2><span>強み<span>3</span></span>豊富な実績</h2>
        <div class="flex_box strengths_num__box">
          <div class="col_2">
            <img src="<?php echo $url_path; ?>/assets/img/strengths/strengths_img03.jpg">
          </div>
          <div class="col_2">
            <p>国内大手アパレルメーカーのナショナルブランドをはじめ、様々なジャンルの洋服のパターンメイキング・グレーディング業務をサポートしています。</p>
            <a class="btn-arrow stre_btn" href="<?php echo $url_path; ?>/case/">実績はこちら</a>
          </div>
        </div>
      </div>
      
    </div>
  </section>

  <section>
    <div class="background_dark_gr">
      <div class="container">
        <div class="heading-primary">
          <h2 class="heading-primary__ttl">国内のみならず海外拠点をもつ<br>キャパシティーの大きさ</h2>
        </div>
      </div>

      <div class="container">
        <div class="flex_box strengths_pic__box">
          <div class="col_2">
            <a href="/cad/blog/detail.php?b_no=5">
              <img src="<?php echo $url_path; ?>/assets/img/strengths/strengths_img04.jpg">
              <h3>サービス提供体制</h3>
              <p>中国 湖北省 / 中国 上海 / ミャンマ－ ヤンゴン の3箇所に小島専属のCADセンタ－があります。</p>
            </a>
          </div>
          <div class="col_2">
            <a href="/cad/blog/detail.php?b_no=4">
              <img src="<?php echo $url_path; ?>/assets/img/strengths/strengths_img05.jpg">
              <h3>上海CADセンターのご案内</h3>
              <p>海外3拠点の内、一番歴史が長く、総合力のある拠点です。</p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="page_contact_bg">
      <div class="container">
        <div class="heading-primary">
          <h2 class="heading-primary__ttl white">急ぎのご相談から、<br class="sp-only">サンプル作成、<br class="pc-only">小ロット対応まで<br class="sp-only">お気軽にご相談下さい。</h2>
        </div>
        <div>
          <div class="container_footer_contact_form">
            <div class="container">
              <div class="heading-primary">
                <h2 class="heading-primary__ttl">納期問合せ・<br class="sp-only">お見積り依頼フォーム</h2>
                <p class="heading-primary__ttl__dec">以下に必要事項をご記入の上、確認画面ボタンをクリックしてください。<br>後ほど担当者より折り返しご連絡をさせて頂きます。<br>
                  <span>※は必須項目です</span><br><br>
                  ～ご入力が面倒な方、お急ぎの方へ～<br>お電話でも承ります。お気軽にご連絡下さい。<br class="sp-only">（TEL：03-5642-6155）<br>
                </p>
              </div>

              <?php if ($_POST['act'] == "err") { ?>
                <div class="error-form-box">
                  <p><?php echo Arr2Val($err_mess); ?></p>
                </div>
              <?php } ?>
            </div>
            <form action="/cad/contact/" method="post" name="form1">
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
                  <tr class="tw-all">
                    <th>会社名<span>※</span></th>
                    <td><input type="text" name="company_name" value="<?php echo $_POST['company_name'] ?>"></td>
                  </tr>
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
            </form>
          </div>
        </div>
      </div>
  </section>

  <?php include("../include/floatingBtn.php"); ?>

  <?php include("../include/footer.php"); ?>

</body>

</html>