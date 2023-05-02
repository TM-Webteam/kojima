<?php
//DB接続ファイルインクルード
include("../include/dbconn.php");
//設定ファイルインクルード
include("../include/config.php");
//リストファイルインクルード
include("../include/list.php");
//関数ファイルインクルード
include("../include/convert.php");




if ($_REQUEST['c_no'] != "") {
  $sql = "SELECT";
  $sql .= " *";
  $sql .= " FROM";
  $sql .= " item_m";
  $sql .= " WHERE";
  $sql .= " del_flg = '0'";
  $sql .= " and item_m_no = :c_no";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':c_no', $_REQUEST['c_no'], PDO::PARAM_INT);
  $stmt->execute();
  $slug_c = $stmt->fetch(PDO::FETCH_ASSOC);
  header("HTTP/1.1 301 Moved Permanently");
  header('Location: http://' . $_SERVER['SERVER_NAME'] . '/cad/blog/detail/category/' . $slug_c['slug']);
}


// アイテムの取得
$sql = "SELECT";
$sql .= " T1.*";
$sql .= ",T2.item_column_name";
$sql .= " FROM";
$sql .= " item_m T1";
$sql .= " LEFT JOIN";
$sql .= " item_l T2";
$sql .= " ON";
$sql .= " (T1.item_l_no = T2.item_l_no)";
$sql .= " WHERE";
$sql .= " T1.del_flg = '0'";
$sql .= " and T1.slug = :slug";
$sql .= " ORDER BY T1.item_l_no,T1.sort_no";

$stmt_itm = $pdo->prepare($sql);
$stmt_itm->bindParam(':slug', $_REQUEST['v3'], PDO::PARAM_STR);
$stmt_itm->execute();
$find_category = '';
$PG_REC_MAT = $stmt_itm->fetch(PDO::FETCH_ASSOC);
$find_category = $PG_REC_MAT['item_m_no'];
$item_list[$PG_REC_MAT['item_column_name']][$PG_REC_MAT['slug']] = $PG_REC_MAT['item_m_name'];
$item_name_list[$PG_REC_MAT['slug']] = $PG_REC_MAT['item_m_name'];
if (!empty($PG_REC_MAT['color'])) {
  $item_color_list[$PG_REC_MAT['slug']] = $PG_REC_MAT['color'];
}
if (!empty($PG_REC_MAT['description'])) {
  $item_description_list[$PG_REC_MAT['slug']] = $PG_REC_MAT['description'];
}
if (!empty($PG_REC_MAT['lead_sentence'])) {
  $item_lead_sentence_list[$PG_REC_MAT['slug']] = $PG_REC_MAT['lead_sentence'];
}
if (!empty($PG_REC_MAT['meta_title'])) {
  $item_meta_title_list[$PG_REC_MAT['slug']] = $PG_REC_MAT['meta_title'];
}
if (!empty($PG_REC_MAT['keywords'])) {
  $item_keywords_list[$PG_REC_MAT['slug']] = $PG_REC_MAT['keywords'];
}

$pan[0]["title"] = "パターンメイキング・グレーディングBlog";
$pan[0]["url"] = "/cad/blog/";
$pan[1]["title"] = $item_meta_title_list[$_REQUEST['v3']];


// 事例の取得（おすすめ以外）*****************************************************************

// 表示する件数
$page_view = 10;

// ページの設定
if (empty($_REQUEST['p'])) {
  $_REQUEST['p'] = 1;
}

$query = "&slug=" . $_REQUEST['v3'];

$sql = "SELECT";
$sql .= " *";
$sql .= " FROM";
$sql .= " blog";
$sql .= " WHERE";
$sql .= " del_flg = '0'";
$sql .= " and display_flg = 'open'";
$sql .= " and FIND_IN_SET(:category,category)";
if (!empty($blog_rec['blog_no'])) {
  $sql .= " and blog_no != :blog_no";
}
$sql .= " ORDER BY blog_date DESC,blog_no desc";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(':category', $find_category, PDO::PARAM_STR);

if (!empty($blog_rec['blog_no'])) {
  $stmt->bindParam(':blog_no', $blog_rec['blog_no'], PDO::PARAM_INT);
}

$stmt->execute();

$row_num = $stmt->rowCount();


$pagenation = createPageNation($page_view, $_REQUEST['p'], $row_num, $query);

$sql .= " limit " . $page_view;
$sql .= " offset " . $pagenation[1];


$stmt = $pdo->prepare($sql);
$stmt->bindParam(':category', $find_category, PDO::PARAM_STR);
// $stmt->bindParam(':slug', $_REQUEST['v3'], PDO::PARAM_STR);

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
  <meta name="keywords" content="<?php echo $item_keywords_list[$_REQUEST['v3']] ?>">
  <meta name="description" content="<?php echo $item_description_list[$_REQUEST['v3']] ?>">
  <meta name="author" content="">

  <title><?php echo $item_meta_title_list[$_REQUEST['v3']] ?></title>
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
  <meta name="twitter:title" content="<?php echo $item_meta_title_list[$_REQUEST['v3']] ?> | 小島衣料CADサービス | ">
  <meta name="twitter:image:src" content="">

  <!-- Open Graph data -->
  <meta property="og:title" content="<?php echo $item_meta_title_list[$_REQUEST['v3']] ?> | 小島衣料CADサービス | ">
  <meta property="og:description" content="<?php echo $item_description_list[$_REQUEST['v3']] ?>">
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

<body class="home page blog">



  <?php include("../include/header.php"); ?>

  <div class="container">
    <div class="col-2-main">
      <div class="left-container">

        <div class="cat_detail">
          <h1><?php echo $item_meta_title_list[$_REQUEST['v3']] ?></h1>
          <p><?php echo $item_lead_sentence_list[$_REQUEST['v3']] ?></p>
        </div>
        <section>


          <?php foreach ($blog_arr as $key => $value) :
            $category_arr = explode(",", $value['category']);
          ?>
            <div class="archive_box">

              <div class="flex_box mb15 a-center fS">
                <div class="archive_date"><?php echo preg_replace("/-/", ".", $value['blog_date']) ?></div>
                <?php foreach ($category_arr as $cate_value) : ?>
                  <a href="<?php echo $url_path; ?>/blog/detail/category/<?php echo $item_slug_count[$cate_value] ?>">
                    <div class="ar-cat">
                      <?php echo $item_name_list[$cate_value] ?>
                    </div>
                  </a>
                <?php endforeach ?>
              </div>

              <a href="<?php echo $url_path; ?>/blog/detail/<?php echo $value['slug'] ?>" class="flex_box wrap">
                <div class="archive_img"><img src="<?php echo $url_path; ?>/up_file/<?php echo $value['up_file1'] ?>"></div>
                <div class="archive_dec">
                  <h2><?php echo $value['title'] ?></h2>
                  <p><?php echo $value['lead_sentence'] ?></p>
                  <div class="mt15 txt-link"><span>記事の続きを読む</span></div>
                </div>
              </a>

            </div>

          <?php endforeach ?>


        </section>
      </div>

      <?php include("../include/sidebar.php"); ?>

    </div>
  </div>

  <?php include("../include/floatingBtn.php"); ?>

  <?php include("../include/footer_contact.php"); ?>

  <?php include("../include/footer.php"); ?>
  
</body>

</html>