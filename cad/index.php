<?php
//DB接続ファイルインクルード
include("include/dbconn.php");
//設定ファイルインクルード
include("include/config.php");
//リストファイルインクルード
include("include/list.php");
//関数ファイルインクルード
include("include/convert.php");

$pan[0]["title"] = "";

$sql = "SELECT";
$sql .= " *";
$sql .= " FROM";
$sql .= " blog";
$sql .= " WHERE";
$sql .= " del_flg = '0'";
$sql .= " and display_flg = 'open'";
$sql .= " and new_flg = 'open'";
$sql .= " ORDER BY blog_date DESC";
$sql .= " limit 3";

$stmt_blg = $pdo->query($sql);

while ($PG_REC_MAT = $stmt_blg->fetch(PDO::FETCH_ASSOC)) {
  $blog_arr[$PG_REC_MAT['blog_no']] = $PG_REC_MAT;
}
// var_dump($blog_arr);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="keywords" content="パターン外注,グレーディング　外注 ">
  <meta name="description" content="パターン外注からグレーディング外注まで小島衣料CADサービスまでご依頼ください。昭和27年創業の確かな実績をもってサポートいたします。パターン作成の外注、グレーディングの外注における急ぎのご依頼から、小ロット対応までお気軽にご相談下さい。">
  <meta name="author" content="">
  <title>パターン作成・グレーディングの小島衣料</title>
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
  <meta name="twitter:title" content="パターン作成・グレーディングの小島衣料 | 小島衣料CADサービス">
  <meta name="twitter:image:src" content="">

  <!-- Open Graph data -->
  <meta property="og:title" content="パターン作成からグレーディングの外注まで | 小島衣料CADサービス">
  <meta property="og:description" content="パターン作成からグレーディングまで。昭和27年創業の小島衣料の確かな実績がサポートいたします。パターン作成の外注、グレーディングの外注における急ぎのご相談から、小ロット対応までお気軽にご相談下さい。">
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

<body class="home top">


  <?php include("./include/header.php"); ?>

  <div class="fadeslide">
    <div class="top_img">
      <img src="<?php echo $url_path; ?>/assets/img/top/main_img.jpg" class="pc-only">
      <img src="<?php echo $url_path; ?>/assets/img/top/main_img_sp.jpg" class="sp-only">
      <div class="top_img__headline">
        <p class="dec">from pattern creation to grading.</p>
        <h1>パターン作成から<br>グレーディングまで。</h1>
        <p>昭和27年創業の確かな実績がサポート。<br>丁寧な仕事で高品質、安心・信頼をご提供します。</p>
      </div>
      <div class="top_img__overlay mv_btn_area">
        <p class="ttl">急ぎの案件・小ロットの案件についてもお気軽にご相談下さい。</p>
        <div class="btn_box">
          <div class="btn_boxs mb30_sp">
            <p>納期の確認・詳細の見積りが必要な方はこちら</p>
            <a href="<?php echo $url_path; ?>/contact/" class="btn-arrow">
              納期問合せ・見積り依頼（無料）</a>
          </div>
          <div class="btn_boxs">
            <p>まずは外注費用の目安を知りたい方はこちら</p>
            <a href="<?php echo $url_path; ?>/price/" class="btn-arrow blue">
              料金表ダウンロード</a>
          </div>
        </div>
      </div>
    </div>
    <div class="top_img modeling">
      <img src="<?php echo $url_path; ?>/assets/img/top/main_img02.jpg" class="pc-only">
      <img src="<?php echo $url_path; ?>/assets/img/top/main_img02_sp.jpg" class="sp-only">
      <div class="top_img__headline">
        <h1>サンプル作成にコストと時間を<br>費やしているアパレル業界の皆様へ<br>3Dモデリングサービス</h1>
        <p>サンプル作成にコストと時間を大幅削減！<br>3Dの各色サンプルを手軽に作成します。</p>
      </div>
      <div class="top_img__overlay mv_btn_area">
        <p class="ttl">3Dモデリングサービスにご興味のある方はこちら</p>
        <div class="btn_box">
          <div class="btn_boxs mb30_sp">
            <a href="<?php echo $url_path; ?>/modeling/" class="btn-arrow">
              3Dモデリングサービス</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- <div class="top_img">
  <img src="<?php echo $url_path; ?>/assets/img/top/main_img.jpg" class="pc-only">
  <img src="<?php echo $url_path; ?>/assets/img/top/main_img_sp.jpg" class="sp-only">
  <div class="top_img__headline">
    <p class="dec">from pattern creation to grading.</p>
    <h1>パターン作成から<br>グレーディングまで。</h1>
    <p>昭和27年創業の確かな実績がサポート。<br>丁寧な仕事で高品質、安心・信頼をご提供します。</p>
  </div>
  <div class="top_img__overlay mv_btn_area">
    <p class="ttl">急ぎの案件・小ロットの案件についてもお気軽にご相談下さい。</p>
    <div class="btn_box">
      <div class="btn_boxs mb30_sp">
        <p>納期の確認・詳細の見積りが必要な方はこちら</p>
        <a href="<?php echo $url_path; ?>/contact/" class="btn-arrow">
          納期問合せ・見積り依頼（無料）</a>
      </div>
      <div class="btn_boxs">
        <p>まずは外注費用の目安を知りたい方はこちら</p>
        <a href="<?php echo $url_path; ?>/price/" class="btn-arrow blue">
          料金表ダウンロード</a>
      </div>
    </div>
  </div>
</div> -->

  <!-- <--20200525 KOJIMA-61 改善施策　コロナ需要強化モジュール追加-->
  <section class="floating-start">
    <div class="background_dark_gr">
      <div class="container">
        <div class="heading-primary mb-15">
          <h2 class="heading-primary__ttl">【新型コロナ対策】<br>パターン・グレーディング外注承ります！</h2>
          <p class="fwb mt0">自宅にいながらパターン・グレーディング作業のご依頼が可能です。</p>
          <p class="mt25">✔お急ぎ・小ロット案件対応<br>✔プロッター出力・デリバリー対応<br>✔お客様のイメージを忠実にカタチにします</p>
        </div>
        <div class="tac">
          <p class="corona_txt">小島衣料CADサービスにお任せください！</p>
          <a class="btn-arrow" href="<?php echo $url_path; ?>/contact/">
            お問合せ・ご依頼はこちら
          </a>
        </div>
      </div>
    </div>
  </section>
  <!-- <--20200525 KOJIMA-61 改善施策　コロナ需要強化モジュール追加 end-->

  <section>
    <div class="background_gr_yarn">
      <div class="container">
        <div class="heading-primary">
          <h2 class="heading-primary__ttl">納期、価格、品質において<br>以下のようなニーズ・課題を<br class="sp-only">感じていませんか?</h2>
        </div>
        <div class="flex_box">
          <div class="yarn-img">
            <img src="<?php echo $url_path; ?>/assets/img/top/yarn-img-left.png">
            <p><span>短納期</span>で<br>パターンメイキングを<br>依頼したい</p>
          </div>
          <div class="yarn-img center">
            <p class="pc-only">サイズ展開の多い<br>グレーディングを<br><span>コストを抑えて</span>依頼したい</p>
            <img src="<?php echo $url_path; ?>/assets/img/top/yarn-img-center.png">
            <p class="sp-only">サイズ展開の多い<br>グレーディングを<br><span>コストを抑えて</span>依頼したい</p>
          </div>
          <div class="yarn-img right">
            <img src="<?php echo $url_path; ?>/assets/img/top/yarn-img-right.png">
            <p>イメージ通りのものが<br><span>仕上がってこない</span></p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="background_over_bgtop">
      <div class="container">
        <div class="heading-primary">
          <h2 class="heading-primary__ttl white">小島衣料にお任せください。</h2>
        </div>
        <p>迅速、リーズナブル、高品質のサービス。<br><span>急ぎのご相談から、サンプル作成、<br class="sp-only">小ロット対応</span>までお気軽にご相談下さい。</p>

        <div class="flex_box">
          <div class="col_2">
            <a href="<?php echo $url_path; ?>/service/#grading">
              <img src="<?php echo $url_path; ?>/assets/img/top/over-img_01.jpg">
              <div class="over_p">
                <p>グレーディング</p>
              </div>
            </a>
          </div>
          <div class="col_2">
            <a href="<?php echo $url_path; ?>/service/#pattern">
              <img src="<?php echo $url_path; ?>/assets/img/top/over-img_02.jpg">
              <div class="over_p">
                <p>パターンメイキング</p>
              </div>
            </a>
          </div>
          <div class="col_2">
            <a href="<?php echo $url_path; ?>/service/#marking">
              <img src="<?php echo $url_path; ?>/assets/img/top/over-img_03.jpg">
              <div class="over_p">
                <p>マーキング</p>
              </div>
            </a>
          </div>
          <div class="col_2">
            <a href="<?php echo $url_path; ?>/service/#plotter">
              <img src="<?php echo $url_path; ?>/assets/img/top/over-img_04.jpg">
              <div class="over_p">
                <p>プロッター出力・デリバリー</p>
              </div>
            </a>
          </div>
        </div>
        <a class="btn-arrow" href="<?php echo $url_path; ?>/service/">
          サービス詳細はこちら
        </a>
      </div>
    </div>
  </section>
  <section>
    <div class="background_gr_check">
      <div class="container">
        <div class="heading-primary">
          <h2 class="heading-primary__ttl">実績・事例</h2>
          <p>国内大手アパレルメーカーの<br class="sp-only">ナショナルブランドをはじめ、様々なジャンルの洋服の<br>パターンメイキング・グレーディング・<br class="sp-only">マーキング業務を承っております。</p>
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
              <li>MNインターファッション</li>
            </ul>
          </div>
          <div class="col_3">
            <ul>
              <li>三共生興</li>
              <!-- <li>三井物産アイファッション</li> -->
              <li>丸紅ファッションリンク</li>
              <li>他１２０社 etc..<br>（順不同・敬称略）</li>
            </ul>
          </div>
        </div>
        <a class="btn-arrow" href="<?php echo $url_path; ?>/case/">
          事例一覧を見る
        </a>
      </div>
    </div>
  </section>
  <section>
    <div class="top_contact_bg top_contact">
      <div class="container">
        <div class="heading-primary">
          <h2 class="heading-primary__ttl white">急ぎのご相談から、<br class="sp-only">サンプル作成、<br class="pc-only">小ロット対応まで<br class="sp-only">お気軽にご相談下さい。</h2>
        </div>
        <div class="btn_box">
          <div class="btn_boxs mb30_sp">
            <p>納期の確認・詳細の見積りが必要な方はこちら</p>
            <a class="btn-arrow white" href="<?php echo $url_path; ?>/contact/">納期問合せ・見積り依頼（無料）</a>
          </div>
          <div class="btn_boxs">
            <p>まずは外注費用の目安を知りたい方はこちら</p>
            <a href="<?php echo $url_path; ?>/price/" class="btn-arrow blue_border">料金表ダウンロード</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="background_gr">
      <div class="container">
        <div class="heading-primary">
          <h2 class="heading-primary__ttl">パターンメイキング・<br class="sp-only">グレーディングBlog</h2>
          <p>小島衣料のパターンメイキング・グレーディング業務に関する情報を配信しています。</p>
        </div>
        <div class="flex_box">
          <?php foreach ($blog_arr as $key => $value) : ?>
            <div class="col_3">
              <a href="blog/detail.php?b_no=<?php echo $value['blog_no'] ?>"><img src="<?php echo $url_path; ?>/up_file/<?php echo $value['up_file1'] ?>"></a>
              <p><a href="blog/detail.php?b_no=<?php echo $value['blog_no'] ?>"><?php echo $value['title'] ?></a></p>
            </div>
          <?php endforeach ?>
        </div>
        <a class="btn-arrow" href="<?php echo $url_path; ?>/blog/">
          ブログ一覧を見る
        </a>
      </div>
    </div>
  </section>

  <section>
    <div class="background_dark_gr">
      <div class="container">
        <div class="heading-primary">
          <h2 class="heading-primary__ttl">小島衣料について</h2>
          <p>お客様ブランドの厳しい品質基準をクリアしてきた中で積み上げた技術や実績を元に、<br>お客様のイメージを忠実にカタチにするだけでなく、ワンランク上のモノづくりをご提供します。</p>
        </div>
      </div>
      <div class="flex_box">
        <div class="col_2">
          <img src="<?php echo $url_path; ?>/assets/img/top/about_img01.jpg">
        </div>
        <div class="col_2">
          <h3>ジャパンクオリティのサービスを<br>低価格・短納期・高品質に対応できる体制を<br>整えています。</h3>
          <p>2003年よりアパレルCAD等縫製周辺事業を展開。<br>
            日本人スタッフの指導のもと、国外にネットワ－クを構築し、<br>
            外注パターン部門としてパターン作成/グレ－ディング/入・出力作業/<br>サンプル作成等々
            一般的な外注パターン業務を行っています。</p>
        </div>
      </div>
      <div class="container">
        <a class="btn-arrow" href="<?php echo $url_path; ?>/strengths/">
          小島衣料の概要・強み
        </a>
      </div>
    </div>
  </section>

  <section>
    <div class="background_gr">
      <div class="container">
        <div class="heading-primary">
          <h2 class="heading-primary__ttl">パターンメイキング・グレーディングを外注する際の留意点</h2>
        </div>
        <p>近年のアパレル製造業の動きとして、多品種少量生産化が進んでいるため、製造のアウトソーシングが常態化してきています。良質なパターンメイキングやグレーディングの外注先を選定することができれば、業務の効率化にもつながり生産性も高まります。</p><br>
        <p>そのためパターンメイキング・グレーディング会社の選び方も重要になってきます。</p><br>
        <p>「短納期にも対応できるキャパシティーを担保しているか」「多様なデザイン・サイズ展開にも対応してくれるか」「過去にどのようなパターンメイキング・グレーディング業務実績を出しているか」といった点を確認しながら選定していくことをお勧めいたします。</p><br>
        <p>以下でもパターンメイキング・グレーディング会社の選び方についてご紹介していますのでご覧ください。</p><br>
        <ul class="link_txt_ico">
          <li><a href="<?php echo $url_path; ?>/service/" class="a_link">【どこに外注しても同じ!?】パターン作成･グレーディング会社の選び方</a></li>
        </ul>
      </div>
    </div>
  </section>

  <section class="floatingBtn index">
    <div class="floatingBtn__box">
      <a href="<?php echo $url_path; ?>/contact/?utm_source=2023&utm_medium=banner&utm_campaign=follow_banner"><img src="<?php echo $url_path; ?>/assets/img/common/btn-floating001.png" alt="納期問合せ 見積り依頼"></a>
      <a href="<?php echo $url_path; ?>/price/?utm_source=2023&utm_medium=banner&utm_campaign=follow_banner"><img src="<?php echo $url_path; ?>/assets/img/common/btn-floating002.png" alt="料金ダウンロード"></a>
      <a href="<?php echo $url_path; ?>/leaflet/"><img src="<?php echo $url_path; ?>/assets/img/common/btn-floating003.png" alt="CADサービス資料ダウンロード"></a>
    </div>
  </section>

  <?php include("./include/footer.php"); ?>

</body>

</html>