<?php
//DB接続ファイルインクルード
include("../include/dbconn.php");
//設定ファイルインクルード
include("../include/config.php");
//リストファイルインクルード
include("../include/list.php");
//関数ファイルインクルード
include("../include/convert.php");
$pan[0]["title"] = "3Dモデリング";

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="keywords" content="パターン　メイキング,マーキング　外注 ">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>3Dモデリングサービス | 小島衣料CADサービス | </title>
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
  <meta name="twitter:title" content="3Dモデリングサービス | 小島衣料CADサービス | サイトタイトル">
  <meta name="twitter:image:src" content="">

  <!-- Open Graph data -->
  <meta property="og:title" content="3Dモデリングサービス | 小島衣料CADサービス | サイトタイトル">
  <meta property="og:description" content="">
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

<body class="home page modeling floating-start">

  <?php include("../include/header.php"); ?>


  <div class="top_img service">
    <img src="<?php echo $url_path; ?>/assets/img/modeling/head_img.jpg" class="pc-only">
    <img src="<?php echo $url_path; ?>/assets/img/modeling/head_img.jpg" class="sp-only">
    <div class="top_img__headline modeling">
      <p class="dec_h">サンプル作成にコストと時間を費やしているアパレル業界の皆様へ</p>
      <h1>外注 3Dモデリングサービス</h1>
      <p>サンプル作成にコストと時間を大幅削減！3Dの各色サンプルを手軽に作成します。</p>
    </div>
    <div class="top_img__overlay">
      <div class="flex_box jcC">
        <div class="price-btn mlr30">
          <div class="price-btn__sidebar"><span>お気軽にお問合せください！</span></div>
          <a href="/cad/contact/" class="price-btn__link w380">
            <span>3Dモデリング</span><br>
            納期・見積りを確認する（無料）
          </a>
        </div>
        <div class="price-btn mlr30 last">
          <div class="price-btn__sidebar"><span>料金が一目でわかる！</span></div>
          <a href="/cad/price/" class="price-btn__link w380 bg-y">
            <span>3Dモデリング</span><br>
            料金資料をもらう（無料）
          </a>
          <div class="price-btn__txt">お申し込み後、リアルタイムでお送りいたします！</div>
        </div>
      </div>
      <!-- <a class="btn-arrow" href="<?php echo $url_path; ?>/contact">
      納期問合せ・見積り依頼（無料）
    </a> -->
    </div>
  </div>

  <section class="">
    <div class="container modeling_container_toha">
      <div class="flex_box">
        <div class="col_2">
          <img src="<?php echo $url_path; ?>/assets/img/modeling/modeling-img01.jpg">
        </div>
        <div class="col_2">
          <h3>外注 3Dモデリングサービス</h3>
          <p>ファッション3Dのモデリングとは、これまでに2D（CAD）のみで作図してきたパターン（型紙）を3Dモデルと連動し、パターン作成～商品画像までワンストップで制作できるサービスです。</p>
        </div>
      </div>
    </div>
    </div>
  </section>

  <section>
    <div class="modeling_needs background_dark_gr">
      <div class="container">
        <div class="heading-primary">
          <h2 class="heading-primary__ttl">サンプル作成において<br>以下のようなニーズはございませんか？</h2>
        </div>
        <div class="flex_box">
          <div class="modeling_needs_box">
            <div class="modeling_needs_boxs">
              2Dパターン作成から各色パターン作成までの時間がかかりすぎている・・・
            </div>
            <img src="<?php echo $url_path; ?>/assets/img/modeling/modeling-img08.jpg">
          </div>
          <div class="modeling_needs_box">
            <div class="modeling_needs_boxs">
              ECサイトに各色サンプルを掲載したい。実際の注文が入ってから、各色サンプルを生産したい。
            </div>
            <img src="<?php echo $url_path; ?>/assets/img/modeling/modeling-img09.jpg">
          </div>
          <div class="modeling_needs_box">
            <div class="modeling_needs_boxs">
              3Dモデリングを導入したいが、初期コストがかかりすぎる…
            </div>
            <img src="<?php echo $url_path; ?>/assets/img/modeling/modeling-img10.jpg">
          </div>
          <div class="modeling_needs_box">
            <div class="modeling_needs_boxs">
              社内プレゼン用に、各色サンプルを作成したい。
            </div>
            <img src="<?php echo $url_path; ?>/assets/img/modeling/modeling-img11.jpg">
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="modeling_service">
      <div class="container">
        <div class="heading-primary">
          <h2 class="heading-primary__ttl">大規模な設備投資をせずに、<br>3Dモデリングサービスを外注で実現できます。</h2>
        </div>
      </div>
      <div class="flex_box service_txt_box" id="pattern">
        <div class="col_2">
          <img src="<?php echo $url_path; ?>/assets/img/modeling/modeling-img02.jpg">
        </div>
        <div class="col_2">
          <h3 class="ore">初期投資が不要！</h3>
          <p>お客様が依頼したいときに、依頼したい分だけ低コストで各色の3Dパターンが作成できます。</p>
          <div class="mt25">
            <ul class="service_cta_price">
              <li><a href="/cad/contact/">お見積り依頼はこちら</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="flex_box service_txt_box" id="grading">
        <img src="<?php echo $url_path; ?>/assets/img/modeling/modeling-img03.jpg" class="sp-only">
        <div class="col_2">
          <h3 class="ore">リードタイムが大幅に短縮！</h3>
          <p>2Dのパターン作成後にかかっていた、縫製作業や修正作業の工程をなくすことができるため、3Dのスタイルまで期間を大幅に短縮できます。</p>
        </div>
        <div class="col_2">
          <img src="<?php echo $url_path; ?>/assets/img/modeling/modeling-img03.jpg" class="pc-only">
        </div>
      </div>

      <div class="flex_box service_txt_box" id="marking">
        <div class="col_2">
          <img src="<?php echo $url_path; ?>/assets/img/modeling/modeling-img04.jpg">
        </div>
        <div class="col_2">
          <h3 class="ore">サンプル作成のコストを削減！</h3>
          <p>サンプル作成にかかっていた費用の削減はもちろん、手軽かつスピーディに受注生産ができるようになるため、生産数量と在庫の適正化を実現できます。</p>
        </div>
      </div>

    </div>
  </section>

  <section>
    <div class="background_dark_gr">
      <div class="container">
        <div class="heading-primary mb-15">
          <h2 class="heading-primary__ttl">外注でできる！3Dモデリングサービスの見積り依頼や<br>サンプルの確認はお気軽にお問合わせ下さい。</h2>
        </div>
        <div class="tac">
          <a class="btn-arrow" href="<?php echo $url_path; ?>/contact/">
            お問合せ・ご依頼はこちら
          </a>
        </div>
      </div>
    </div>
  </section>

  <section class="modeling_scene">
    <div>
      <div class="container">
        <div class="heading-primary">
          <h2 class="heading-primary__ttl">様々なシーンで活用できます</h2>
          <p>従来は工数やコストを気にしてできなかった各色の3Dサンプルスタイル画像の作成が手軽に実現できます。</p>
        </div>
      </div>

      <div class="container modeling_container_scene">
        <div class="flex_box">
          <div class="col_2">
            <img src="<?php echo $url_path; ?>/assets/img/modeling/modeling-img05.jpg">
            <h3>ECサイト掲載用に</h3>
            <p>商品のサイズ感や各色パターンを掲載することでECでの購買を後押しします。</p>
          </div>
          <div class="col_2">
            <img src="<?php echo $url_path; ?>/assets/img/modeling/modeling-img06.jpg">
            <h3>社内プレゼン用に</h3>
            <p>時間やコストの関係で準備できなかったカラーバリエーションやパターンバリエーションも手軽に作成できます。</p>
          </div>
          <div class="col_2">
            <img src="<?php echo $url_path; ?>/assets/img/modeling/modeling-img07.jpg">
            <h3>商談ツールに</h3>
            <p>展示会や商談シーンにおいて、3Dサンプルやスタイル画像で商品の魅力を訴求することができます。</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="modeling_option background_dark_gr">
    <div>
      <div class="container">
        <div class="heading-primary">
          <h2 class="heading-primary__ttl">豊富なスタイル画像作成オプション</h2>
          <p>3Dモデリングサービスについて詳しく知りたい方は直接お問合せください！<br>スタイル画像作成をご依頼いただいた場合、以下のオプション加工が可能です。</p>
        </div>
      </div>
      <div class="container modeling_option_box">
        <div class="flex_box flw_wrap flex_sp">
          <div class="col_2">
            <p class="modeling_option_box_items">3Dトワル作成</p>
          </div>
          <div class="col_2">
            <p class="modeling_option_box_items">コーディネート加工</p>
          </div>
          <div class="col_2">
            <p class="modeling_option_box_items">カラーバリエーション<br class="pc-only">展開</p>
          </div>
          <div class="col_2">
            <p class="modeling_option_box_items">アバター加工</p>
          </div>
          <div class="col_2">
            <p class="modeling_option_box_items">柄差し替え</p>
          </div>
          <div class="col_2">
            <p class="modeling_option_box_items">生地差し替え</p>
          </div>
          <div class="col_2">
            <p class="modeling_option_box_items">プレッシャーマッピング<br class="pc-only">画像作成</p>
          </div>
          <div class="col_2">
            <p class="modeling_option_box_items">スケルトン画像作成</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="modeling_service to_price">
      <div class="container">
        <div class="heading-primary">
          <h2 class="heading-primary__ttl">料金表<br>
            パターンメイキング・グレーディング<br>
            ３Dモデリングサービス</h2>
        </div>
        <div class="flex_box service_txt_box" id="pattern">
          <div class="col_2 price_wp_img">
            <img src="<?php echo $url_path; ?>/assets/img/price/price_wp.jpg">
          </div>
          <div class="col_2" id="price">
            <h3>３Dモデリングサービスの料金単価表がダウンロードできます。</h3>
            <div class="txt_box">
              <p class="blackbox">以下業務の料金単価をご案内しています。</p>
              <div class="ul_box">
                <ul>
                  <li>パターンメイキング（PM）</li>
                  <li>パターン修正</li>
                  <li>グレーディング（GR）</li>
                  <li>マーキング</li>
                  <li>トワル作成</li>
                </ul>
                <ul>
                  <li>サンプル作成</li>
                  <li>縫製仕様書作成</li>
                  <li>データ出力（OUTPUT)</li>
                  <li>パターンデリバリー</li>
                  <li>データ変換</li>
                  <li>３Dモデリングサービス</li>
                </ul>
              </div>
            </div>
            <div class="mt25">
              <a class="btn-arrow" href="<?php echo $url_path; ?>/price/">
                料金表はこちら
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include("../include/floatingBtn.php"); ?>

  <?php include("../include/footer_contact.php"); ?>

  <?php include("../include/footer.php"); ?>

  <script>
    $(function() {
      $('.modeling_needs_boxs').matchHeight();
      $('.modeling_option_box_items').matchHeight();
    });
  </script>

</body>

</html>