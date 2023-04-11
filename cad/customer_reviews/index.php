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
$pan[0]["title"] = "お客様の声";


?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="keywords" content="パターンメイキング　外注,グレーディング　外注">
  <meta name="description" content="小島衣料のパターンメイングサービス・グーレディング外注サービスをご利用いただいたお客様の声をご紹介します。">
  <meta name="author" content="">
  <title>パターンメイキング・グレーディングお客様の声 | 小島衣料CADサービス</title>
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
  <meta name="twitter:title" content="パターンメイキング・グレーディングお客様の声 | 小島衣料CADサービス">
  <meta name="twitter:image:src" content="">

  <!-- Open Graph data -->
  <meta property="og:title" content="パターンメイキング・グレーディングお客様の声 | 小島衣料CADサービス">
  <meta property="og:description" content="小島衣料のパターンメイングサービス・グーレディング外注サービスをご利用いただいたお客様の声をご紹介します。">
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
    <img src="<?php echo $url_path; ?>/assets/img/customer_reviews/head_img.png" class="pc-only">
    <img src="<?php echo $url_path; ?>/assets/img/customer_reviews/head_img_sp.png" class="sp-only">
    <div class="top_img__headline">
      <h1>パターンメイキング・<br class="sp-only">グレーディング外注サービス「お客様の声」</h1>
      <p>小島衣料のパターンメイングサービス・グーレディング外注サービスを<br>ご利用いただいたお客様の声をご紹介します。</p>
    </div>
  </div>

  <section class="background_gr_check floating-start">


    <div class="container pt20_sp mt60_pc">
      <h2 class="heading-primary__ttl mb40">カテゴリを選択</h2>
      <ul class="customer_reviews">
        <li style="background-color: #ff9500;" class="customer_reviews_category_items" id="about_pattern"><button class="js1">パターンメイキングに関して</button></li>
        <li style="background-color: #ff5476;" class="customer_reviews_category_items" id="about_grating"><button class="js2">グレーディングに関して</button></li>
        <li style="background-color: #893bff;" class="customer_reviews_category_items" id="about_price"><button class="js3">納期・料金に関して</button></li>
        <li style="background-color: #21a8ff;" class="customer_reviews_category_items" id="other"><button class="js4">その他</button></li>
      </ul>
      <div class="flex_box strengths_num__box fw_wrap">
        <div class="col_2 background_dark_gr customer_reviews_box_f items about_grating about_price">
          <p class="mb15"><span>無理難題にもご相談に乗っていただき感謝しています。</span></p>
          <p>ダイレクトメールがきっかけでした。<br>色々と客先からの無理難題にもご相談に乗っていただき感謝しています。<br>型紙作成のみならず、サンプル作成及び型入れ等まで幅広く対応して頂き非常に助かっております。しかも非常にリーズナブル。<br>今後とも宜しくお願い致します。<br><br>アパレルODM会社　K様</p>
        </div>
        <div class="col_2 background_dark_gr customer_reviews_box_f items about_pattern about_grating other">
          <p class="mb15"><span>多岐にわたりクイックに対応いただいております。</span></p>
          <p>パターンメーキングからグレーディングに加え、<br>ミャンマー（ヤンゴン）現地での型紙切り出し～工場までの配送手配などを多岐にわたりクイックに対応いただいております。<br>縫製工場が母体であるので、仕様面含めその他諸々の状況を踏まえた対応いただいており助かっております。<br>今後ともよろしくお願いいたします。<br><br>繊維商社　T様</p>
        </div>
        <div class="col_2 background_dark_gr customer_reviews_box_f items about_grating about_price">
          <p class="mb15"><span>今後とも末永くよろしくお願いします！</span></p>
          <p>グレーディングもカット出しも、いつも急な依頼になってしまうのですが、迅速にご対応いただき、とても助けて頂いております。<br>グレーディングは納品前にダブルチェックしてくださっているので、いつも問題なくスムーズに量産に進めております。<br>今後とも末永くよろしくお願いします！<br><br>フリーパターンナー　Y様</p>
        </div>
        <div class="col_2 background_dark_gr customer_reviews_box_f items about_grating about_price">
          <p class="mb15"><span>細かく相談にのっていただいて大変助かっています。</span></p>
          <p>急な依頼にもご対応いただき、タイトなスケジュールも相談させてただいたり、弊社がグレーディングに詳しくない中ピッチ等、細かく相談にのっていただいて大変助かっています。<br>また、弊社の間違いや、不明点があった際は必ず連絡をいただけるので大変助かります。<br><br>デザイナ－ズアパレル会社　K様</p>
        </div>
        <div class="col_2 background_dark_gr customer_reviews_box_f items about_grating about_price">
          <p class="mb15"><span>急ぎの納期の相談も快く応じて下さり、いつも感謝しております。</span></p>
          <p>グレーディングをお願いしています。<br>急ぎの納期の相談も快く応じて下さり、いつも感謝しております。<br>また、変則的なパターン形状のグレーディングや細かい箇所にも気を使って頂き、安心してお任せしています。<br>これからも宜しくお願い致します。<br><br>総合アパレル会社　M様</p>
        </div>
        <div class="col_2 background_dark_gr customer_reviews_box_f items about_pattern">
          <p class="mb15"><span>アドバイスくださり、感謝しております。</span></p>
          <p>いつも突然の依頼に快く応じて頂いた上に、パターンに詳しくない我々の為に、最善のパターンが出来る様、色々アドバイスを下さる事に、感謝しております。<br>これからのよろしくお願い申し上げます。<br><br>婦人服地　製品企画会社　Y様</p>
        </div>
        <div class="col_2 background_dark_gr customer_reviews_box_f items about_pattern about_price">
          <p class="mb15"><span>タイトなスケジュールの依頼でも、いつも快く引き受けて下さりとても助かっております。</span></p>
          <p>トワル画像も細かく撮って送って下さるので、イメージも湧きやすくて
            サンプルの完成度を高めること出来ていると感じております。<br>限られた時間の中でも、妥協せずに修正に付き合って下さるのも本当にありがたいです。<br>もう少し、、、ほんのりと、、、など、ニュアンスでお伝えしてもしっかりと反映して下さり、パタンナーさんも日本のご担当者様もバランス感覚に優れたお方なのだろうなと、安心して依頼が出来ます。<br>今後とも、宜しくお願い致します！<br><br>総合アパレル会社　I様</p>
        </div>
        <div class="col_2 background_dark_gr customer_reviews_box_f items about_pattern">
          <p class="mb15"><span>急な依頼や細かい修正にいつも柔軟に対応頂きありがとうございます。</span></p>
          <p>仕様の不明点やサイズの調整が必要な箇所等、都度確認しながら対応頂けるので、上りも良く修正も少なく済みとても助かっています。<br>今後とも宜しくお願い致します。<br><br>ファッション企画会社　T様</p>
        </div>
        <div class="col_2 background_dark_gr customer_reviews_box_f items about_price">
          <p class="mb15"><span>どんな依頼でもクイックに対応、納品頂きいつも感謝しております。</span></p>
          <p>また、困った事があった場合でも相談に親身になって頂き、解決までの糸口をご提案して頂けるのも御社の魅力のひとつです。<br>今後ともどうぞ宜しくお願い致します。<br><br>総合アパレル会社　S様</p>
        </div>
        <div class="col_2 background_dark_gr customer_reviews_box_f items about_price">
          <p class="mb15"><span>急な依頼、短納期にも対応していただけるので非常に助かっています。</span></p>
          <p>アパレルからの急なスケジュール変更にも対応していただけるので助かっています。弊社からの依頼指示の不明確な点を細かく確認していただいたり仕様面のアドバイスもしていただけるので頼りにさせていただいています。今後ともよろしくお願いいたします。<br><br>アパレル専門商社　A様</p>
        </div>
        <div class="col_2 background_dark_gr customer_reviews_box_s items other">
          <p class="mb15"><span>日本の長期休みの間も有効的に仕事を進めることが出来て助かっています。</span></p>
          <p>中国パターンというと工場パターンのようなイメージをもちがちですが仕様面も丁寧で国内パターンに何も劣らずシルエットも綺麗に仕上がります。<br>量も質もどちらもバランスよく対応してくださり感謝しています。<br><br>繊維専門商社　T様</p>
        </div>
        <div class="col_2 background_dark_gr customer_reviews_box_s items about_pattern about_grating">
          <p class="mb15"><span>難しいデザインのグレーディングもミスなく、常に正確なパターンアップ。</span></p>
          <p>グレーディングとパターン出力で依頼させていただいておりますが、いつも迅速かつ丁寧に対応してくださり、とても感謝しております。<br>難しいデザインのグレーディングもミスなく、どんなデザインでも常に正確なパターンアップです。ありがとうございます！<br><br>フリーパターンナー　T様</p>
        </div>
        <div class="col_2 background_dark_gr customer_reviews_box_s items about_pattern">
          <p class="mb15"><span>パタンナーさんがイメージになるように根気よく、対応して下さる。</span></p>
          <ul>
            <li>写真でトワルチェックをする場合、拡大写真だったり、ボウタイなどは風合いの近いもので実際の雰囲気が出せるようにして下さる。</li>
            <li>サンプル班の縫製がとてもきれい。</li>
            <li>国内の方はもちろんですが、現地の担当の方がとてもしっかりされているから、安心して納品までをお願いできる。</li>
          </ul><br><br>
          <p>総合アパレル会社　N様</p>
        </div>
        <div class="col_2 background_dark_gr customer_reviews_box_s items other">
          <p class="mb15"><span>いつもきめ細かく正確にご対応頂けるので、大変心強いです。</span></p>
          <p>どうもありがとうございます。<br>これからもよろしくお願い致します。<br><br>アパレル専門商社　S様</p>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="background_dark_gr">
      <div class="container">
        <div class="heading-primary customer_reviews_contact_box">
          <p style="margin-top: 0px;">小島衣料は、国内大手アパレルメーカーのナショナルブランドをはじめ、<br>様々なジャンルの洋服のパターンメイキング・グレーディング業務をサポートしています。</p>
          <p class="mb20"><span>実績・事例ページもご覧ください。</span></p>
          <a class="btn-arrow" href="<?php echo $url_path; ?>/case/">実績・事例はこちら</a>
        </div>
      </div>
    </div>
  </section>

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
</script>
<script type="text/javascript">
  $(function() {
    $('.js1').on('click', function() {
      $('.items').addClass('dis_none');
      $('.js1').addClass('bgc_white fc_orange');
      $('.about_pattern').removeClass('dis_none');
      $('.js2').removeClass('bgc_white fc_pink');
      $('.js3').removeClass('bgc_white fc_purple');
      $('.js4').removeClass('bgc_white fc_blue');
      $('.js5').removeClass('bgc_white fc_green');
    });
    $('.js2').on('click', function() {
      $('.items').addClass('dis_none');
      $('.js2').addClass('bgc_white fc_pink');
      $('.about_grating').removeClass('dis_none');
      $('.js1').removeClass('bgc_white fc_orange');
      $('.js3').removeClass('bgc_white fc_purple');
      $('.js4').removeClass('bgc_white fc_blue');
      $('.js5').removeClass('bgc_white fc_green');
    });
    $('.js3').on('click', function() {
      $('.items').addClass('dis_none');
      $('.js3').addClass('bgc_white fc_purple');
      $('.about_price').removeClass('dis_none');
      $('.js1').removeClass('bgc_white fc_orange');
      $('.js2').removeClass('bgc_white fc_pink');
      $('.js4').removeClass('bgc_white fc_blue');
      $('.js5').removeClass('bgc_white fc_green');
    });
    $('.js4').on('click', function() {
      $('.items').addClass('dis_none');
      $('.js4').addClass('bgc_white fc_blue');
      $('.other').removeClass('dis_none');
      $('.js1').removeClass('bgc_white fc_orange');
      $('.js2').removeClass('bgc_white fc_pink');
      $('.js3').removeClass('bgc_white fc_purple');
      $('.js5').removeClass('bgc_white fc_green');
    });
  });
</script>

</html>