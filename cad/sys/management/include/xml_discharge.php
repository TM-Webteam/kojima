<?php
/*ファイルの読み込み テスト確認用*/
require("../../../include/dbconn.php");
// 日付の取得
$now_date = date("Y-m-d", time());
/**
 * ブログのカテゴリ
 */
// カテゴリ一覧の取得
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
$sql .= " item_column_name = 'blog_category'";
$sql .= " and T1.del_flg = '0'";
$sql .= " order by T1.sort_no ";

$stmt = $pdo->prepare($sql);
$stmt->execute();
while ($PG_REC_MAT = $stmt->fetch(PDO::FETCH_ASSOC)) {
  if (!empty($PG_REC_MAT['slug'])) {
    $discharge['blog_category'] .= "    <url>\n";
    $discharge['blog_category'] .= "        <loc>https://www.kojima-iryo.com/cad/blog/detail/category/" . $PG_REC_MAT['slug'] . "</loc>\n";
    $discharge['blog_category'] .= "        <lastmod>" . $now_date . "</lastmod>\n";
    $discharge['blog_category'] .= "        <changefreq>daily</changefreq>\n";
    $discharge['blog_category'] .= "        <priority>0.8</priority>\n";
    $discharge['blog_category'] .= "    </url>\n";
  }
}

/**
 * ブログ記事
 */
// 一覧の取得
$sql = "SELECT";
$sql .= " *";
$sql .= " FROM";
$sql .= " blog";
$sql .= " WHERE";
$sql .= " del_flg = '0'";
$sql .= " order by blog_date ";

$stmt = $pdo->prepare($sql);
$stmt->execute();
while ($PG_REC_MAT = $stmt->fetch(PDO::FETCH_ASSOC)) {
  if (!empty($PG_REC_MAT['slug'])) {
    $discharge['blog_detail'] .= "    <url>\n";
    $discharge['blog_detail'] .= "        <loc>https://www.kojima-iryo.com/cad/blog/detail/" . $PG_REC_MAT['slug'] . "</loc>\n";
    $discharge['blog_detail'] .= "        <lastmod>" . $now_date . "</lastmod>\n";
    $discharge['blog_detail'] .= "        <changefreq>daily</changefreq>\n";
    $discharge['blog_detail'] .= "        <priority>0.8</priority>\n";
    $discharge['blog_detail'] .= "    </url>\n";
  }
}

$fp = fopen("../include/sitemap.txt", "r");
while (!feof($fp)) {
  $value = fgets($fp, 4096);
  $value = preg_replace("/\r/", "", $value);
  foreach ($discharge as $post_key => $post_value) {
    $value = preg_replace("/<!--$post_key-->/", $post_value, $value);
  }
  $line_sitemap .= $value;
}
fclose($fp);

$fp = fopen("../../../sitemap.xml", "w");
fwrite($fp, $line_sitemap);
fclose($fp);
// chmod($file, 0775);

// print_r($line_sitemap);
