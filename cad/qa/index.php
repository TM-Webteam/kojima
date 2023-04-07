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
$pan[0]["title"] = "パターンメイキング・グレーディングQ&A集";


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="パターンメイキング　外注,グレーディング　外注">
    <meta name="description" content="小島衣料のパターンメイングサービス・グーレディング外注サービスに関して、納期、料金に関するよくある質問にお答えします。">
    <meta name="author" content="">
    <title>パターンメイキング・グレーディングQ&A集 | 小島衣料CADサービス</title>
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
    <meta name="twitter:title" content="パターンメイキング・グレーディングQ&A集 | 小島衣料CADサービス">
    <meta name="twitter:image:src" content="">

    <!-- Open Graph data -->
    <meta property="og:title" content="パターンメイキング・グレーディングQ&A集 | 小島衣料CADサービス">
    <meta property="og:description" content="小島衣料のパターンメイングサービス・グーレディング外注サービスに関して、納期、料金に関するよくある質問にお答えします。">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta property="og:image:width" content="">
    <meta property="og:image:height" content="">
    <meta property="og:site_name" content="">

    <link rel="stylesheet" href="<?php echo $url_path; ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?php echo $url_path; ?>/assets/css/main3.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <script src="//kitchen.juicer.cc/?color=Z+x+canRRXU=" async></script>
</head>

<body class="home page floating-start">


    <?php include("../include/header.php"); ?>

    <div class="top_img strengths">
        <img src="<?php echo $url_path; ?>/assets/img/qa/head_img.png" class="pc-only">
        <img src="<?php echo $url_path; ?>/assets/img/qa/head_img_sp.png" class="sp-only">
        <div class="top_img__headline">
            <h1>パターンメイキング・グレーディング外注サービス「Q&A」</h1>
            <p>小島衣料のパターンメイングサービス・グーレディング外注サービスに関するQ&A集です。</p>
        </div>
    </div>

    <section class="qa_section">
        <div class="container qa_category_container">
            <h2 class="heading-primary__ttl">カテゴリを選択</h2>
            <ul class="qa_category">
                <?php
                $cont = 0;
                foreach ($item_list['qa_category'] as $key => $value) {
                    $cont++;
                ?>
                    <li class="qa_category_items" style="background-color: <?php echo $item_color_list[$key] ?>;" id="c<?php echo $key ?>"><button style="border:3px solid <?php echo $item_color_list[$key] ?>" class="js<?php echo $cont ?>"><?php echo $value ?></button></li>
                <?php
                }
                ?>

                <!--         <li class="qa_category_items" id="cost"><a href="">料金</a></li>
        <li class="qa_category_items" id="pattern-making"><a href="">パターンメイキング</a></li>
        <li class="qa_category_items" id="grading"><a href="">グレーディング</a></li>
        <li class="qa_category_items" id="other"><a href="">その他サービス</a></li> -->
            </ul>
            <div class="qa_menu items pattern-making">
                <p class="background_dark_gr qa_items_q_title">Q.パターンの出力の依頼は可能ですか？</p>
                <p class="qa_items_a_text">たたみ/巻き、貴社のご希望に添ってパターンの出力をし、出荷まで承っております。<br><br><span class="qa_box_txt_s"><a href="/cad/service/" class="qa_link_s">ご依頼のサービス詳細はこちらから</a></span></p>
            </div>
            <div class="qa_menu items grading">
                <p class="background_dark_gr qa_items_q_title">Q.イレギュラーサイズのグレーディングはご対応いただけますか？</p>
                <p class="qa_items_a_text">ーレギュラーサイズからラージサイズへのグレーディング<br>
                    レディース(ヤング・ミッシー・ミセス)洋服全般承っております。<br>
                    ーその他のサイズのグレーディング<br>
                    ラージサイズ以外にも様々な体型の方のグレーディングにも対応いたします。<br><br><span class="qa_box_txt_s"><a href="/cad/service/" class="qa_link_s">ご依頼のサービス詳細はこちらから</a></span></p>
            </div>
            <div class="qa_menu items pattern-making">
                <p class="background_dark_gr qa_items_q_title">Q.デザイン画以外での依頼は可能ですか？</p>
                <p class="qa_items_a_text">写真やラフ画、サンプル等でも対応しております。<br><br><span class="qa_box_txt_s"><a href="/cad/service/" class="qa_link_s">ご依頼のサービス詳細はこちらから</a></span></p>
            </div>
            <div class="qa_menu items other">
                <p class="background_dark_gr qa_items_q_title">Q.トワルチェックの方法は？</p>
                <p class="qa_items_a_text">既存のお客様は鮮明なトワル画像で対応しております。トワル納品をご希望の方はご相談下さい。<br><br><span class="qa_box_txt_s">詳細については下記までお気軽にお問合せ下さい。<br>【TEL】03-5642-6155 （受付時間：平日10:00～18:00）<br>【メール】<a href="/cad/contact/" class="qa_link_s">納期問合せ・見積もり依頼（無料）</a></span></p>
            </div>
            <div class="qa_menu items other">
                <p class="background_dark_gr qa_items_q_title">Q.どのようなジャンルのパターンが得意ですか？</p>
                <p class="qa_items_a_text">レディス、メンズ、子供服、ユニホ-ム等多様な服種に対応しております。<br><br><span class="qa_box_txt_s"><a href="/cad/service/" class="qa_link_s">・小島衣料のパターンメイキング・グレーディング外注サービス</a></span></p>
            </div>
            <div class="qa_menu items delivery_date">
                <p class="background_dark_gr qa_items_q_title">Q.おおよその納期を教えてください。</p>
                <p class="qa_items_a_text">グレーディングの場合はデータで受取データ送信で中1日～2日。<br>パターンメイキングの場合は1週間～10日程度。ご依頼内容により2～3日でも可能です。<br><br><span class="qa_box_txt_s">詳細については下記までお気軽にお問合せ下さい。<br>【TEL】03-5642-6155 （受付時間：平日10:00～18:00）<br>【メール】<a href="/cad/contact/" class="qa_link_s">納期問合せ・見積もり依頼（無料）</a></span></p>
            </div>
            <div class="qa_menu items delivery_date">
                <p class="background_dark_gr qa_items_q_title">Q.緊急のお願いは可能ですか？</p>
                <p class="qa_items_a_text">できる限りご要望にお応えできるよう努力いたします。その都度ご相談下さい。<br><br><span class="qa_box_txt_s">詳細については下記までお気軽にお問合せ下さい。<br>【TEL】03-5642-6155 （受付時間：平日10:00～18:00）</span></p>
            </div>
            <div class="qa_menu items pattern-making grading">
                <p class="background_dark_gr qa_items_q_title">Q.紙パターンでもグレーディング依頼は可能ですか？</p>
                <p class="qa_items_a_text">はい。紙パターンをデータ化し、必要に応じて文字、仕様図解等も対応いたします。<br><br><span class="qa_box_txt_s"><a href="/cad/service/" class="qa_link_s">ご依頼のサービス詳細はこちらから</a></span></p>
            </div>
            <div class="qa_menu items other">
                <p class="background_dark_gr qa_items_q_title">Q.特殊服の対応は可能ですか？</p>
                <p class="qa_items_a_text">ユニフォームなどで実績があります。</p>
            </div>
            <div class="qa_menu items other">
                <p class="background_dark_gr qa_items_q_title">Q.個人でも依頼することはできますか？</p>
                <p class="qa_items_a_text">はい、可能です。</p>
            </div>
            <div class="qa_menu items pattern-making">
                <p class="background_dark_gr qa_items_q_title">Q.パターン作成を依頼する際に必要なものはありますか？</p>
                <p class="qa_items_a_text">デザイン（絵や写真）素材感、基本寸法などを伺います。</p>
            </div>
            <div class="qa_menu items grading">
                <p class="background_dark_gr qa_items_q_title">Q.グレーディングを依頼する際に必要なものはありますか？</p>
                <p class="qa_items_a_text">弊社規定の依頼書にご記入いただき、仕様書、ピッチ表、展開表等と一緒にご依頼下さい。</p>
            </div>
            <div class="qa_menu items other">
                <p class="background_dark_gr qa_items_q_title">Q.海外発送はしていますか？</p>
                <p class="qa_items_a_text">出力パターンを上海、ヤンゴンから現地で発送しています。<br><br><span class="qa_box_txt_s"><a href="/cad/blog/detail.php?b_no=5" class="qa_link_s">・小島衣料Pmi事業部／海外拠点のご案内</a></span></p>
            </div>
            <div class="qa_menu items cost">
                <p class="background_dark_gr qa_items_q_title">Q.おおよその費用相場を教えて下さい。</p>
                <p class="qa_items_a_text">グレーディングはデータの場合1P＝350円。パタ-ンメイキングはジャケットで24,000円～となります。 <br>詳しくは以下料金表をダウンロードして下さい。<br><br><span class="qa_box_txt_s">詳細については下記までお気軽にお問合せ下さい。<br><a href="/cad/price/" class="qa_link_s">料金表ダウンロード</a><br><br>納期確認、詳細見積りはこちらまでお問合せください。<br><a href="/cad/contact/" class="qa_link_s">納期問合せ・見積もり依頼（無料）</a></span></p>
            </div>
            <div class="qa_menu items other">
                <p class="background_dark_gr qa_items_q_title">Q.お支払い方法は？</p>
                <p class="qa_items_a_text">お客様の締日に合わせてご請求致します。口座振り込みでお支払いお願いします。</p>
            </div>
        </div>
    </section>

    <!-- <section>
  <div class="background_dark_gr">
    <div class="container">
      <div class="heading-primary qa_contact_box">
        <p><span>その他、上記以外のご質問・お問合わせがございましたら以下までお気軽にお問合わせ下さい。
      </div>
    </div>
  </div>
</section> -->

    <?php include("../include/floatingBtn.php"); ?>

    <?php include("../include/footer_contact.php"); ?>

    <?php include("../include/footer.php"); ?>

</body>
<script>
    $('.js1').hover(
        function() {
            $('.js1').css('color', '#ff9500');
        },
        function() {
            $('.js1').css('color', '#fff');
        }
    );
    $('.js2').hover(
        function() {
            $('.js2').css('color', '#ff5476');
        },
        function() {
            $('.js2').css('color', '#fff');
        }
    );
    $('.js3').hover(
        function() {
            $('.js3').css('color', '#893bff');
        },
        function() {
            $('.js3').css('color', '#fff');
        }
    );
    $('.js4').hover(
        function() {
            $('.js4').css('color', '#21a8ff');
        },
        function() {
            $('.js4').css('color', '#fff');
        }
    );
    $('.js5').hover(
        function() {
            $('.js5').css('color', '#2eff51');
        },
        function() {
            $('.js5').css('color', '#fff');
        }
    );
</script>
<script type="text/javascript">
    $(function() {
        $('.js1').on('click', function() {
            $('.items').addClass('dis_none');
            $('.js1').addClass('bgc_white fc_orange');
            $('.delivery_date').removeClass('dis_none');
            $('.js2').removeClass('bgc_white fc_pink');
            $('.js3').removeClass('bgc_white fc_purple');
            $('.js4').removeClass('bgc_white fc_blue');
            $('.js5').removeClass('bgc_white fc_green');
        });
        $('.js2').on('click', function() {
            $('.items').addClass('dis_none');
            $('.js2').addClass('bgc_white fc_pink');
            $('.cost').removeClass('dis_none');
            $('.js1').removeClass('bgc_white fc_orange');
            $('.js3').removeClass('bgc_white fc_purple');
            $('.js4').removeClass('bgc_white fc_blue');
            $('.js5').removeClass('bgc_white fc_green');
        });
        $('.js3').on('click', function() {
            $('.items').addClass('dis_none');
            $('.js3').addClass('bgc_white fc_purple');
            $('.pattern-making').removeClass('dis_none');
            $('.js1').removeClass('bgc_white fc_orange');
            $('.js2').removeClass('bgc_white fc_pink');
            $('.js4').removeClass('bgc_white fc_blue');
            $('.js5').removeClass('bgc_white fc_green');
        });
        $('.js4').on('click', function() {
            $('.items').addClass('dis_none');
            $('.js4').addClass('bgc_white fc_blue');
            $('.grading').removeClass('dis_none');
            $('.js1').removeClass('bgc_white fc_orange');
            $('.js2').removeClass('bgc_white fc_pink');
            $('.js3').removeClass('bgc_white fc_purple');
            $('.js5').removeClass('bgc_white fc_green');
        });
        $('.js5').on('click', function() {
            $('.items').addClass('dis_none');
            $('.js5').addClass('bgc_white fc_green');
            $('.other').removeClass('dis_none');
            $('.js1').removeClass('bgc_white fc_orange');
            $('.js2').removeClass('bgc_white fc_pink');
            $('.js3').removeClass('bgc_white fc_purple');
            $('.js4').removeClass('bgc_white fc_blue');
        });
    });
</script>

</html>