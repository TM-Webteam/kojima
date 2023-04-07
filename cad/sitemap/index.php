<?php 
//DB接続ファイルインクルード
include ("../include/dbconn.php");
//設定ファイルインクルード
include ("../include/config.php");
//リストファイルインクルード
include ("../include/list.php");
//関数ファイルインクルード
include ("../include/convert.php");

$pan[0]["title"] = "サイトマップ";
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">
<title>サイトマップ | 小島衣料CADサービス | </title>
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
<meta name="twitter:title" content="サイトマップ | 小島衣料CADサービス | サイトタイトル">
<meta name="twitter:image:src" content="">

<!-- Open Graph data -->
<meta property="og:title" content="サイトマップ | 小島衣料CADサービス | サイトタイトル">
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
<body class="home page case">
<?php include ("../include/header.php"); ?>

<div class="container">
  <div class="heading-primary">
    <h2 class="heading-primary__ttl">サイトマップ</h2>
  </div>
</div>
<section>
  <div class="container">
    <ul class="list_type_01 sitemap_box">
      <li><a href="<?php echo $url_path; ?>/service">サービス</a></li>
      <li><a href="<?php echo $url_path; ?>/case">実績・事例</a></li>
      <li><a href="<?php echo $url_path; ?>/strengths">小島衣料の強み</a></li>
      <li><a href="<?php echo $url_path; ?>/blog">お役立ち記事</a></li>
      <li><a href="<?php echo $url_path; ?>/contact">納期お問合せ･見積り依頼</a></li>
      <li><a href="<?php echo $url_path; ?>/pdf/calendar.pdf" target="_blank">各国年間スケジュール</a></li>
      <li><a href="http://www.kojima-iryo.com/privacy.html" target="_blank">プライバシーポリシー</a></li>
      <li><a href="http://www.kojima-iryo.com/company.html" target="_blank">会社概要</a></li>
    </ul>
  </div>
</section>

<?php include ("../include/footer.php"); ?>

   </body>
</html>
