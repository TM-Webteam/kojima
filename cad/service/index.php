<?php
//DB接続ファイルインクルード
include ("../include/dbconn.php");
//設定ファイルインクルード
include ("../include/config.php");
//リストファイルインクルード
include ("../include/list.php");
//関数ファイルインクルード
include ("../include/convert.php");
$pan[0]["title"] = "サービス紹介";

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="keywords" content="パターン　メイキング,マーキング　外注 ">
<meta name="description" content="迅速・リーズナブル・高品質」をモットーに、パターンメイキングからグレーディングの外注サービスを提供しています。急ぎのご相談から、パターンサンプル作成、小ロット対応までお気軽にご相談下さい。">
<meta name="author" content="">
<title>パターンメイキング・グレーディング外注サービス | 小島衣料CADサービス | </title>
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
<link rel="stylesheet" href="<?php echo $url_path; ?>/assets/css/main3.css">
<script src="//kitchen.juicer.cc/?color=Z+x+canRRXU=" async></script>
</head>
<body class="home page">

<?php include ("../include/header.php"); ?>


<div class="top_img service">
  <img src="<?php echo $url_path; ?>/assets/img/service/head_img.jpg" class="pc-only">
  <img src="<?php echo $url_path; ?>/assets/img/service/head_img_sp.jpg" class="sp-only">
  <div class="top_img__headline sp-p350">
    <p class="dec_ore">アパレルメーカー・商社の皆様へ</p>
    <p class="dec_h">迅速、リーズナブル、高品質。</p>
    <h1>小島衣料の<br class="sp-only">パターンメイキング・<br class="sp-only">グレーディング外注依頼</h1>
    <p>急ぎの案件・小ロットの案件についても<br class="sp-only">お気軽にご相談下さい。</p>
  </div>
  <div class="top_img__overlay mv_btn_area">
    <div class="btn_box mt0">
      <div class="btn_boxs mb30_sp">
        <a href="<?php echo $url_path; ?>/contact/" class="btn-arrow w90p">納期・見積りを依頼する</a>
      </div>
      <div class="btn_boxs mb30_sp">
        <a href="<?php echo $url_path; ?>/price/" class="btn-arrow blue w90p">【無料】料金表をもらう</a>
      </div>
      <div class="btn_boxs">
        <a href="<?php echo $url_path; ?>/leaflet/" class="btn-arrow white v2 w90p">【無料】サービス資料をもらう</a>
      </div>
    </div>
    <!-- <div class="flex_box jcC">
      <div class="price-btn mlr30">
        <div class="price-btn__sidebar"><span>お気軽にお問合せください！</span></div>
        <a href="/cad/contact/" class="price-btn__link w380">
          <span>パターンメイキング・グレーティング外注</span><br>
          納期・見積りを確認する（無料）
        </a>
      </div>
      <div class="price-btn mlr30 last">
        <div class="price-btn__sidebar"><span>料金が一目でわかる！</span></div>
        <a href="/cad/price/" class="price-btn__link w380 bg-y">
          <span>パターンメイキング・グレーティング外注</span><br>
          料金資料をもらう（無料）
        </a>
        <div class="price-btn__txt">お申し込み後、リアルタイムでお送りいたします！</div>
      </div>
    </div> -->
  </div>
</div>


<section class="floating-start">
  <div class="container">
    <div class="heading-primary">
      <h2 class="heading-primary__ttl">服種やサイズ問わず<br class="sp-only">幅広く対応可能です。</h2>
      <p>レディース・メンズ・子供服はもちろんユニフォーム、イレギュラーサイズなど<br>すべてのアイテムに対応。</p>
    </div>
    <div class="flex_box wrap">
      <div class="service-icon">
        <img src="<?php echo $url_path; ?>/assets/img/service/service-img01.png">
        <p>レディース</p>
      </div>
      <div class="service-icon">
        <img src="<?php echo $url_path; ?>/assets/img/service/service-img02.png">
        <p>メンズ</p>
      </div>
      <div class="service-icon">
        <img src="<?php echo $url_path; ?>/assets/img/service/service-img03.png">
        <p>子供服</p>
      </div>
      <div class="service-icon">
        <img src="<?php echo $url_path; ?>/assets/img/service/service-img04.png">
        <p>ユニフォーム</p>
      </div>
      <div class="service-icon">
        <img src="<?php echo $url_path; ?>/assets/img/service/service-img05.png">
        <p>イレギュラーサイズ</p>
      </div>
      <div class="service-icon">
        <img src="<?php echo $url_path; ?>/assets/img/service/service-img06.png">
        <p>その他</p>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="background_dark_gr">
    <div class="container">
      <div class="heading-primary">
        <h2 class="heading-primary__ttl">サービスラインナップ</h2>
        <p>パタ－ンメイキング・グレ－ディング・マーキング・縫製仕様書・サンプル作成まで。</p>
      </div>
    </div>
    <div class="flex_box service_txt_box" id="pattern">
      <div class="col_2">
        <img src="<?php echo $url_path; ?>/assets/img/service/service-img07.jpg">
      </div>
      <div class="col_2">
        <h3 class="ore">パターンメイキング外注・縫製仕様書作成依頼</h3>
        <p>デザイナーの求めるイメージを汲み取り、正確に形にしていきます。レディス、メンズ、ユニフォーム、子供服等全てのアイテムに対応いたします。</p>
        <div class="wh_box">
          <ul>
            <li>トワル～縫製仕様書まで作成します。</li>
            <li>デザイン画は写真やラフ画、サンプル抜きにも対応。</li>
            <li>画像トワルチェックにて対応いたします。</li>
            <li>ご希望がございましたらサンプル作成・小ロット生産も承っております。</li>
          </ul>
        </div>
        <!-- <div class="mt25 w90p">
          <div class="price-btn">
            <div class="price-btn__sidebar"><span>料金が一目でわかる！</span></div>
            <a href="<?php echo $url_path; ?>/price/" class="price-btn__link">
              <span>パターンメイキング・グレーティング外注</span><br>
              料金資料をもらう（無料）
            </a>
            <div class="price-btn__txt">お申込み後、リアルタイムでお送りいたします！</div>
          </div>
        </div> -->
      </div>
    </div>
    <div class="flex_box service_txt_box" id="grading">
      <img src="<?php echo $url_path; ?>/assets/img/service/service-img08.jpg" class="sp-only">
      <div class="col_2 left_txt">
        <h3 class="ore">グレーティング外注</h3>
        <p>マスタ－パタ－ンのデータ入力から対応（紙で頂いたパターンのデータ入力も承ります）。サイズ修正、別寸（オーダーサイズ）等ご要望に応じたグレーディングをご提供いたします。</p>
        <div class="wh_box">
          <p>【入力】</p>
          <ul>
            <li>紙パターンをデータ化します。</li>
            <li>文字、仕様図解等も入力します。</li>
          </ul>
          <p>【グレーディング】</p>
          <ul>
            <li>データでのご依頼、又は紙パターン入力からも対応いたします。</li>
            <li>縮率入れ、縫い代変更などにも対応。</li>
            <li>サイズ修正、別寸（オーダーサイズ）等ご要望に応じます。</li>
            <li>ユカ＆アルファでの対応も可能です。</li>
            <li>英語の縫製仕様書作成も対応致します。</li>
          </ul>
        </div>
        <!-- <div class="mt25 w90p">
          <div class="price-btn">
            <div class="price-btn__sidebar"><span>料金が一目でわかる！</span></div>
            <a href="<?php echo $url_path; ?>/price/" class="price-btn__link">
              <span>パターンメイキング・グレーティング外注</span><br>
              料金資料をもらう（無料）
            </a>
            <div class="price-btn__txt">お申込み後、リアルタイムでお送りいたします！</div>
          </div>
        </div> -->
      </div>
      <div class="col_2">
        <img src="<?php echo $url_path; ?>/assets/img/service/service-img08.jpg" class="pc-only">
      </div>
    </div>

    <div class="flex_box service_txt_box" id="marking">
      <div class="col_2">
        <img src="<?php echo $url_path; ?>/assets/img/service/service-img09.jpg">
      </div>
      <div class="col_2">
        <h3 class="ore">マーキング</h3>
        <p>パタンナーが作ったパターンを、ご要望にあわせて、効率よく、無駄なくマーキングいたします。</p>
        <div class="wh_box">
          <ul>
            <li>生地用尺出し、生産用マーキングを行います。</li>
            <li>無駄のない裁断シートを作成します。</li>
          </ul>
        </div>
        <!-- <div class="mt25 w90p">
          <div class="price-btn">
            <div class="price-btn__sidebar"><span>料金が一目でわかる！</span></div>
            <a href="<?php echo $url_path; ?>/price/" class="price-btn__link">
              <span>パターンメイキング・グレーティング外注</span><br>
              料金資料をもらう（無料）
            </a>
            <div class="price-btn__txt">お申込み後、リアルタイムでお送りいたします！</div>
          </div>
        </div> -->
      </div>
    </div>

    <div class="flex_box service_txt_box" id="plotter">
    <img src="<?php echo $url_path; ?>/assets/img/service/service-img10.jpg" class="sp-only">
      <div class="col_2 left_txt">
        <h3 class="ore">プロッター出力・デリバリー</h3>
        <p>アパレルCADの入出力サービス他デリバリーも承ります。</p>
        <div class="wh_box">
          <ul>
            <li>パターン出力</li>
          </ul>
          <p class="li_dec">たたみ/巻き、貴社のご希望に添って出力、出荷いたします。</p>
          <ul>
            <li>海外デリバリー</li>
          </ul>
          <p class="li_dec">中国、ミャンマー各拠点で出力、カットしてデリバリーいたします。</p>
        </div>
        <!-- <div class="mt25 w90p">
          <div class="price-btn">
            <div class="price-btn__sidebar"><span>料金が一目でわかる！</span></div>
            <a href="<?php echo $url_path; ?>/price/" class="price-btn__link">
              <span>パターンメイキング・グレーティング外注</span><br>
              料金資料をもらう（無料）
            </a>
            <div class="price-btn__txt">お申込み後、リアルタイムでお送りいたします！</div>
          </div>
        </div> -->
      </div>
      <div class="col_2">
        <img src="<?php echo $url_path; ?>/assets/img/service/service-img10.jpg" class="pc-only">
      </div>
    </div>
  </div>
</section>

<!-- <section>
  <div class="background_gr_check">
    <div class="container">
      <div class="heading-primary">
        <h2 class="heading-primary__ttl">豊富なパターンメイキング・グレーディング実績</h2>
        <p>国内大手アパレルメーカーのナショナルブランドをはじめ、様々なジャンルの洋服の<br>パターンメイキング・グレーディング・マーキング業務を承っております。</p>
      </div>
      <div class="flex_box zirei">
        <div class="col_3">
          <ul>
            <li>バロックジャパンリミテッド</li>
            <li>TATRASINTERNATIONAL</li>
            <li>ア－バンリサ－チ</li>
            <li>三陽商会</li>
          </ul>
        </div>
        <div class="col_3">
          <ul>
            <li>AKIRA　NAKA</li>
            <li>ANAYI</li>
            <li>蝶理</li>
            <li>日鉄物産</li>
          </ul>
        </div>
        <div class="col_3">
          <ul>
            <li>三共生興</li>
            <li>丸紅ファッションリンク</li>
            <li>他１２０社 etc..<br>（順不同・敬称略）</li>
          </ul>
        </div>
      </div>
      <div class="price-btn v2">
        <div class="price-btn__sidebar v2"><span>料金が一目でわかる！資料をプレゼント </span></div>
        <a href="<?php echo $url_path; ?>/price/" class="price-btn__link v2">
          <span>パターンメイキング・グレーディング</span><br>
          料金資料をもらう（無料）
        </a>
        <div class="price-btn__txt">お申込み後、リアルタイムでお送りいたします！</div>
      </div>
    </div>
  </div>
</section> -->

<!-- <section>
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
        <?php foreach ($item_list['contact_type'] as $key => $value):
          if (!empty($_POST['contact_type'])) {
            $checked = "";
            if (in_array($key, $_POST['contact_type'])) {
              $checked = " checked";
            }
          }

         ?>
                  <p>
                    <input type="checkbox" id="check<?php echo $key; ?>" name="contact_type[]" value="<?php echo $key; ?>"<?php echo $checked ?> />
                    <label for="check<?php echo $key; ?>"><?php echo $value ?></label>
          <?php if ($key == "258"): ?>
            <input type="text" name="contact_type_other" class="in_text" value="<?php echo $_POST['contact_type_other'] ?>">
          <?php endif ?>
                  </p>
        <?php endforeach ?>

                </td>
              </tr>
              <tr>
                <th>問合せしたいサービス<span>※</span></th>
                <td>
        <?php foreach ($item_list['interested_service'] as $key => $value):
          if (!empty($_POST['interested_service'])) {
            $checked = "";
            if (in_array($key, $_POST['interested_service'])) {
              $checked = " checked";
            }
          }

         ?>
                  <p>
                    <input type="checkbox" id="check<?php echo $key; ?>" name="interested_service[]" value="<?php echo $key; ?>"<?php echo $checked ?> />
                    <label for="check<?php echo $key; ?>"><?php echo $value ?></label>
          <?php if ($key == "261"): ?>
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
          <?php echo SelectView("address1",$address_code,"") ?>
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
</section> -->

<section class="cta-btn">
  <a href="<?php echo $url_path; ?>/contact/" class="core cta-btn__link">
    <div class="cta-btn__link--img"><img src="<?php echo $url_path; ?>/assets/img/common/mail.svg" alt="納期・見積りを依頼する"></div>
    <div class="cta-btn__link--txt"><span>&ensp;納期・見積りを依頼する</span></div>
  </a>
  <a href="<?php echo $url_path; ?>/price/" class="core cta-btn__link">
    <div class="cta-btn__link--img"><img src="<?php echo $url_path; ?>/assets/img/common/price.svg" alt="【無料】料金表をもらう"></div>
    <div class="cta-btn__link--txt"><span>【無料】料金表をもらう</span></div>
  </a>
  <a href="<?php echo $url_path; ?>/leaflet/" class="core cta-btn__link">
    <div class="cta-btn__link--img"><img src="<?php echo $url_path; ?>/assets/img/common/doc.svg" alt="【無料】サービス詳細資料をもらう"></div>
    <div class="cta-btn__link--txt"><span>【無料】サービス詳細資料をもらう</span></div>
  </a>
</section>

<?php include("../include/floatingBtn.php"); ?>

<?php include ("../include/footer.php"); ?>

</body>
</html>
