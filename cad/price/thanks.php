<?php 
//DB接続ファイルインクルード
include ("../include/dbconn.php");
//設定ファイルインクルード
include ("../include/config.php");
//リストファイルインクルード
include ("../include/list.php");
//関数ファイルインクルード
include ("../include/convert.php");
$pan[0]["title"] = "料金表ダウンロード";
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="keywords" content="パターン　外注,グレーディング　外注,マーキング　外注 ">
<meta name="description" content="小島衣料ではアパレル外注パターンサービスを行っております。お急ぎで外注先をお探しの方は是非ご相談ください。">
<meta name="author" content="">
<title>料金表ダウンロード| 小島衣料CADサービス | </title>
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
<meta name="twitter:title" content="料金表ダウンロード| 小島衣料CADサービス | サイトタイトル">
<meta name="twitter:image:src" content="">

<!-- Open Graph data -->
<meta property="og:title" content="料金表ダウンロード| 小島衣料CADサービス | サイトタイトル">
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
<?php include ("../include/header.php"); ?>

<div class="container mb40">
  <div class="heading-primary">
    <h2 class="heading-primary__ttl">料金表ダウンロード</h2>
    <p class="heading-primary__ttl__dec tac"><span class="fwb">ありがとうございました。</span><br>
登録いただきましたメールアドレス宛に料金表の資料URLをお送り致しました。<br>
お手数をおかけ致しますが、ご確認をお願い致します。
    </p>
  </div>
  <a class="btn-arrow" href="<?php echo $url_path; ?>">
        TOPに戻る
      </a>
</div>



<?php include ("../include/footer.php"); ?>

   </body>
</html>
