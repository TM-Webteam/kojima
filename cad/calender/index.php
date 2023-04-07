<?php
//DB接続ファイルインクルード
include ("../include/dbconn.php");
//設定ファイルインクルード
include ("../include/config.php");
//リストファイルインクルード
include ("../include/list.php");
//関数ファイルインクルード
include ("../include/convert.php");

$pan[0]["title"] = "パターン作成・グレーディング業務の年間休日カレンダー";
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
<title>パターン作成・グレーディング業務の年間休日カレンダー</title>
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
<meta name="twitter:title" content="パターン作成・グレーディング業務の年間休日カレンダー | 小島衣料CADサービス">
<meta name="twitter:image:src" content="">

<!-- Open Graph data -->
<meta property="og:title" content="パターン作成・グレーディング業務の年間休日カレンダー | 小島衣料CADサービス">
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




<div class="container">
  <div class="heading-primary">
    <h2 class="heading-primary__ttl">2019年度　各国年間休日スケジュール</h2>
    <p class="cal_left">弊社では多くの場合、海外協力会社などの経験豊富なスタッフにより実際の作業を行っております。<br>
      このため、各国独自の休暇期間中などは納期が延びる場合もあります。<br>
      下記休日カレンダーをご参考お願いいたします。
    <a class="btn-arrow" href="../pdf/calendar.pdf" target="_blank">
      カレンダーPDFダウンロードはこちら
    </a>
    </p>
  </div>
</div>


<section>
  <div class="container">
    <div class="flex_box calender_box">
      <div class="col_2">
        <h3>■中国</h3>
        <table>
          <tr>
            <th>月</th>
            <th>日(曜)</th>
            <th>内容</th>
          </tr>
          <tr>
            <th>1月</th>
            <td>1日(火)</td>
            <td>新年</td>
          </tr>
          <tr>
            <th>2月</th>
            <td>4日(月)～10日(日)</td>
            <td>旧暦の正月 (春節)</td>
          </tr>
          <tr>
            <th>4月</th>
            <td>5日(金)～7日(日)</td>
            <td>清明節</td>
          </tr>
          <tr>
            <th>5月</th>
            <td>1日(水)～4日(土)</td>
            <td>労働節</td>
          </tr>

          <tr>
            <th>6月</th>
            <td>7日(金)～9日(日)</td>
            <td>端午節</td>
          </tr>
          <tr>
            <th>9月</th>
            <td>13日(金)～15日(日)</td>
            <td>中秋節</td>
          </tr>
          <tr>
            <th>10月</th>
            <td> 1日(火)～7日(月)</td>
            <td>国慶節</td>
          </tr>
        </table>
      </div>

      <div class="col_2">
        <h3>■ミャンマー</h3>
        <table>
          <tr>
            <th>月</th>
            <th>日(曜)</th>
            <th>内容</th>
          </tr>
          <tr>
            <th rowspan="2">1月</th>
            <td>1日(日)</td>
            <td>新年</td>
          </tr>
          <tr>
            <td>4日(金)</td>
            <td>独立記念日</td>
          </tr>
          <tr>
            <th>2月</th>
            <td>12日(火)</td>
            <td>連邦の日</td>
          </tr>
          <tr>
            <th rowspan="3">3月</th>
            <td>2日(土)</td>
            <td>農民の日</td>
          </tr>
          <tr>
            <td>20日(水)</td>
            <td>タバウンの満月のお祭り</td>
          </tr>
          <tr>
            <td>27日(水)</td>
            <td>国軍の日</td>
          </tr>
          <tr>
            <th>4月</th>
            <td>13日(土)～17日(水)</td>
            <td>水祭り + ミャンマーの新年</td>
          </tr>
          <tr>
            <th rowspan="2">5月</th>
            <td>1日(水)</td>
            <td>メーデー</td>
          </tr>
          <tr>
            <td>18日(土)</td>
            <td>カゾンの満月のお祭り</td>
          </tr>
          <tr>
            <th rowspan="2">7月</th>
            <td>16日(火)</td>
            <td>ワソの満月のお祭り</td>
          </tr>
          <tr>
            <td>19日(金)</td>
            <td>殉職者の日</td>
          </tr>
          <tr>
            <th>10月</th>
            <td>12日(土)～14日(月)</td>
            <td>タディンギットの満月のお祭り</td>
          </tr>
          <tr>
            <th rowspan="2">11月</th>
            <td>10日(日)、11日(月)</td>
            <td>タザウンモンの満月のお祭り</td>
          </tr>
          <tr>
            <td>21日(木)</td>
            <td>ナショナルデー (国民の休日)</td>
          </tr>
          <tr>
            <th rowspan="3">12月</th>
            <td>25日(水)</td>
            <td>クリスマス</td>
          </tr>
          <tr>
            <td>26日(木)</td>
            <td>カイン新年</td>
          </tr>
          <tr>
            <td>31日(火)</td>
            <td>国際的な新年</td>
          </tr>
        </table>
      </div>
    </div>

  </div>
</section>

<?php include ("../include/footer_contact.php"); ?>

<?php include ("../include/footer.php"); ?>

   </body>
</html>
