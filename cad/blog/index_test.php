<?php
//DB接続ファイルインクルード
include ("../include/dbconn.php");
//設定ファイルインクルード
include ("../include/config.php");
//リストファイルインクルード
include ("../include/list.php");
//関数ファイルインクルード
include ("../include/convert.php");

$pan[0]["title"] = "パターンメイキング・グレーディングお役立ちBlog";


// 記事の取得（おすすめ）*****************************************************************
$sql = "SELECT";
$sql .= " *";
$sql .= " FROM";
$sql .= " blog";
$sql .= " WHERE";
$sql .= " del_flg = '0'";
$sql .= " and display_flg = 'open'";
$sql .= " and pickup_flg = 'open'";
$sql .= " ORDER BY rand()";
$sql .= " limit 1";

$stmt = $pdo -> prepare($sql);

$stmt->execute();

$blog_rec = $stmt->fetch(PDO::FETCH_ASSOC);
$category_rec_arr = explode(",", $blog_rec['category']);

// 事例の取得（おすすめ以外）*****************************************************************

// 表示する件数
$page_view = 10;

// ページの設定
if (empty($_REQUEST['p'])) {
  $_REQUEST['p'] = 1;
}

$query = "";

$sql = "SELECT";
$sql .= " *";
$sql .= " FROM";
$sql .= " blog";
$sql .= " WHERE";
$sql .= " del_flg = '0'";
$sql .= " and display_flg = 'open'";
if (!empty($blog_rec['blog_no'])) {
  $sql .= " and blog_no != :blog_no";
}
$sql .= " ORDER BY blog_date DESC,blog_no desc";

$stmt = $pdo -> prepare($sql);


if (!empty($blog_rec['blog_no'])) {
  $stmt->bindParam(':blog_no', $blog_rec['blog_no'], PDO::PARAM_INT);
}

$stmt->execute();

$row_num = $stmt->rowCount();


$pagenation = createPageNation($page_view,$_REQUEST['p'],$row_num,$query);

$sql .= " limit " . $page_view;
$sql .= " offset " . $pagenation[1];


$stmt = $pdo -> prepare($sql);


if (!empty($blog_rec['blog_no'])) {
  $stmt->bindParam(':blog_no', $blog_rec['blog_no'], PDO::PARAM_INT);
}

$stmt->execute();

while ($blog = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $blog_arr[$blog['blog_no']] = $blog;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="keywords" content="パターン　作成,マーキング　外注,縫製仕様書　作成 ">
<meta name="description" content="小島衣料のパターンメイキング・グレーディング業務に関する情報を配信しています。パターン作成・グレーディング・マーキング・縫製仕様書作成までお気軽にご相談下さい。">
<meta name="author" content="">
<title>パターンメイキング・グレーディングお役立ちBlog</title>
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
<meta name="twitter:title" content="パターンメイキング・グレーディングお役立ちBlog | 小島衣料CADサービス">
<meta name="twitter:image:src" content="">

<!-- Open Graph data -->
<meta property="og:title" content="パターンメイキング・グレーディングお役立ちBlog | 小島衣料CADサービス">
<meta property="og:description" content="小島衣料のパターンメイキング・グレーディング業務に関する情報を配信しています。パターン作成・グレーディング・マーキング・縫製仕様書作成までお気軽にご相談下さい。">
<meta property="og:type" content="website">
<meta property="og:url" content="">
<meta property="og:image" content="">
<meta property="og:image:width" content="">
<meta property="og:image:height" content="">
<meta property="og:site_name" content="">

<link rel="stylesheet" href="<?php echo $url_path; ?>/assets/css/main.css">
<link rel="stylesheet" href="<?php echo $url_path; ?>/assets/css/main3.css">

 </head>
<body class="home page blog">

<?php include ("../include/header.php"); ?>

<div class="top_img">
  <img src="<?php echo $url_path; ?>/assets/img/blog/head_img.jpg" class="pc-only">
  <img src="<?php echo $url_path; ?>/assets/img/blog/head_img_sp.jpg" class="sp-only">
  <div class="top_img__headline">
    <h1>パターンメイキング・グレーディングBlog</h1>
    <p>小島衣料のパターンメイキング・<br class="sp-only">グレーディング業務に関する情報を<br class="sp-only">配信しています。</p>
  </div>
</div>
<div class="container">
  <div class="col-2-main">
    <div class="left-container">
      <section>

<?php foreach ($blog_arr as $key => $value):
  $category_arr = explode(",", $value['category']);
 ?>
        <div class="archive_box">

          <?php foreach ($category_arr as $cate_value): ?>
          <a href="<?php echo $url_path; ?>/blog/category.php?c_no=<?php echo $cate_value ?>">
            <div class="ar-cat">
              <?php echo $item_name_list[$cate_value] ?>
            </div>
          </a>
          <?php endforeach ?>
          <h2><a href="<?php echo $url_path; ?>/blog/detail.php?b_no=<?php echo $value['blog_no'] ?>"><?php echo $value['title'] ?></a></h2>
          <div class="flex_box wrap">
            <div class="archive_img">
              <a href="<?php echo $url_path; ?>/blog/detail.php?b_no=<?php echo $value['blog_no'] ?>"><img src="<?php echo $url_path; ?>/up_file/<?php echo $value['up_file1'] ?>"></a>
            </div>
            <div class="archive_dec">
              <p><?php echo $value['lead_sentence'] ?></p>
              <div class="flex_box mt30 a-center">
                <div class="archive_date">
                  <?php echo preg_replace("/-/",".",$value['blog_date']) ?>
                </div>
                <a class="btn-arrow more" href="<?php echo $url_path; ?>/blog/detail.php?b_no=<?php echo $value['blog_no'] ?>">記事の続きを読む</a>
              </div>
            </div>
          </div>
        </div>

<?php endforeach ?>


<?php echo $pagenation[0] ?>

        <div class="pager">
          <ul class="pagination">
            <li class="pre"><a href="#"><span></span></a></li>
            <li><a href="#" class="active"><span>1</span></a></li>
            <li><a href="#"><span>2</span></a></li>
            <li><a href="#"><span>3</span></a></li>
            <li><a href="#"><span>4</span></a></li>
            <li><a href="#"><span>5</span></a></li>
            <li class="more"><span>･･･</span></li>
            <li><a href="#"><span>50</span></a></li>
            <li class="next"><a href="#"><span></span></a></li>
          </ul>
        </div>
      </section>
    </div>

<?php include ("../include/sidebar.php"); ?>

  </div>
</div>
<?php include ("../include/footer_contact.php"); ?>


<?php include ("../include/footer.php"); ?>
   </body>
</html>
