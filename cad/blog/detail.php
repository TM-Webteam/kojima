<?php
//DB接続ファイルインクルード
include("../include/dbconn.php");
//設定ファイルインクルード
include("../include/config.php");
//リストファイルインクルード
include("../include/list.php");
//関数ファイルインクルード
include("../include/convert.php");

$noindex_arr = array("sustainable_fashion_news", "apparel_market_trend", "2rt", "fashion_ec", "fashion_news_on_march", "fashion_news_on_february");

$re_arr = array("fashion_news_on_february", "fashion_news_on_march", "fashion_news_on_april", "fashion_news_on_may", "fashion_news_on_june", "fashion_news_on_july", "bussiness_development", "with-corona", "corona_thefashionindustry", "apparel_market_trend", "apparel_market_trend_tech", "news-fashion-sustainability", "apparel_virtual_shopping", "sustainable_fashion_news", "sustainability", "ec_reinforcement", "worldfashion_growth_prospects", "digital_sustainable", "apparel_newattempt", "environmental_awareness", "apparel_cx", "attention_news_store", "with-corona", "bussiness_development", "apparel_trend_btob", "fashion_ec_needs_strategy", "environmentalprotection_apparel_news");
if (in_array($_REQUEST['v2'], $re_arr)) {
	header("HTTP/1.1 301 Moved Permanently");
	header('Location: /cad/');
}

if ($_REQUEST['b_no'] != "") {
	$sql = "SELECT";
	$sql .= " *";
	$sql .= " FROM";
	$sql .= " blog";
	$sql .= " WHERE";
	$sql .= " del_flg = '0'";
	$sql .= " and display_flg = 'open'";
	$sql .= " and blog_no = :blog_no";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':blog_no', $_REQUEST['b_no'], PDO::PARAM_INT);
	$stmt->execute();
	$slug = $stmt->fetch(PDO::FETCH_ASSOC);
	header("HTTP/1.1 301 Moved Permanently");
	header('Location: http://' . $_SERVER['SERVER_NAME'] . '/cad/blog/detail/' . $slug['slug']);
}

/**
 * 記事情報取得
 */
$sql_updl = "SELECT";
$sql_updl .= " *";
$sql_updl .= ",DATE_FORMAT(blog_date,'%Y年%m月%d日') as blog_date_view";
$sql_updl .= " FROM";
$sql_updl .= " blog";
$sql_updl .= " WHERE";
$sql_updl .= " slug = :slug";
if ($_REQUEST['mode'] != "test") {
	$sql_updl .= " AND display_flg = 'open' ";
}
$sql_updl .= " AND del_flg = 0 ";

$stmt = $pdo->prepare($sql_updl);
$stmt->bindParam(':slug', $_REQUEST['v2'], PDO::PARAM_STR);

$stmt->execute();
$blog_arr = $stmt->fetch(PDO::FETCH_ASSOC);
$category_arr = explode(",", $blog_arr['category']);
// パンくず作成
foreach ($category_arr as $value) {
	$pan[] = "<a href=\"/column/archive.php?c_no=" . $value . "\">" . $item_name_list[$value] . "</a>";
}

/**
 * 関連するブログ
 */
$sql_updl = "SELECT";
$sql_updl .= " *";
$sql_updl .= ",DATE_FORMAT(blog_date,'%Y年%m月%d日') as blog_date_view";
$sql_updl .= " FROM";
$sql_updl .= " blog";
$sql_updl .= " WHERE";
$sql_updl .= " del_flg = 0 ";
$sql_updl .= " AND display_flg = 'open' ";
$sql_updl .= " AND slug != :slug ";
$sql_updl .= " AND blog_no in (" . $blog_arr['right_column'] . ")";
// $sql_updl .= " AND (";
// $c_cnt = 0;
// foreach ($category_arr as $value) {
// 	$c_cnt++;
// 	if ($c_cnt > 1) {
// 		$sql_updl .= " OR";
// 	}
// 	$sql_updl .= " FIND_IN_SET('" . $value . "',category)";
// }
// $sql_updl .= " )";
// $sql_updl .= " order by rand()";
// $sql_updl .= " limit 3";


$stmt = $pdo->prepare($sql_updl);
$stmt->bindParam(':slug', $_REQUEST['v2'], PDO::PARAM_STR);

$stmt->execute();
$blog_rec_cnt = $stmt->rowCount();
while ($blog_rec = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$blog_rec_arr[$blog_rec["blog_no"]] = $blog_rec;
	$not_blog_no[] = $blog_rec["blog_no"];
}

// if($blog_rec_cnt < 3){
// 	$limit_cnt = 3 - $blog_rec_cnt;
// 	$not_blog_no[] = $blog_arr['blog_no'];

// 	$sql_updl = "SELECT";
// 	$sql_updl .= " *";
// 	$sql_updl .= ",DATE_FORMAT(blog_date,'%Y年%m月%d日') as blog_date_view";
// 	$sql_updl .= " FROM";
// 	$sql_updl .= " blog";
// 	$sql_updl .= " WHERE";
// 	$sql_updl .= " del_flg = 0 ";
// 	$sql_updl .= " AND display_flg = 'open' ";
// 	$sql_updl .= " AND blog_no not in (" . implode(",", $not_blog_no) . ")";
// 	$sql_updl .= " order by rand()";
// 	$sql_updl .= " limit ". $limit_cnt;

// 	$stmt = $pdo->prepare($sql_updl);

// 	$stmt->execute();
// 	$blog_rec_cnt = $stmt->rowCount();
// 	while ($blog_rec = $stmt->fetch(PDO::FETCH_ASSOC)) {
// 		$blog_rec_arr[$blog_rec["blog_no"]] = $blog_rec;
// 	}
// }



/**
 * 記事の段落取得
 */
$sql_blg_o = "SELECT";
$sql_blg_o .= " T1.*";
$sql_blg_o .= " FROM";
$sql_blg_o .= " blog_other T1";
$sql_blg_o .= " LEFT JOIN";
$sql_blg_o .= " blog T2";
$sql_blg_o .= " ON";
$sql_blg_o .= " (T1.blog_no = T2.blog_no)";
$sql_blg_o .= " WHERE";
$sql_blg_o .= " T1.blog_no = :blog_no";
$sql_blg_o .= " and T1.parent_id = '0'";
if ($_REQUEST['mode'] != "test") {
	$sql_blg_o .= " and T2.display_flg = 'open'";
}
$sql_blg_o .= " and T2.del_flg = '0'";
$sql_blg_o .= " order by T1.blog_other_no";

$stmt = $pdo->prepare($sql_blg_o);
$stmt->bindParam(':blog_no', $blog_arr['blog_no'], PDO::PARAM_INT);

$stmt->execute();

while ($blg_o = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$blg_o_list[$blg_o["blog_other_no"]] = $blg_o;
}

/**
 * 関連する記事の取得
 */
$sql_rec = "SELECT";
$sql_rec .= " *";
$sql_rec .= " FROM";
$sql_rec .= " blog_item";
$sql_rec .= " WHERE";
$sql_rec .= " blog_no = :blog_no";
$sql_rec .= " order by blog_item_no";

$stmt_rec = $pdo->prepare($sql_rec);
$stmt_rec->bindParam(':blog_no', $blog_arr['blog_no'], PDO::PARAM_INT);

$stmt_rec->execute();

while ($blg_item = $stmt_rec->fetch(PDO::FETCH_ASSOC)) {
	$blg_item_list[$blg_item["blog_item_no"]] = $blg_item;
}

// 閲覧ログの習得
if (!empty($blog_arr['blog_no'])) {
	$log_date_time = date("Y/m/d H:i:s", time());
	$sql = "INSERT INTO blog_log (";
	$sql .= " blog_no";
	$sql .= ",log_date";
	$sql .= ") VALUES (";
	$sql .= " :blog_no";
	$sql .= ",:log_date";
	$sql .= ")";

	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(':blog_no', $blog_arr['blog_no'], PDO::PARAM_INT);
	$stmt->bindParam(':log_date', $log_date_time, PDO::PARAM_STR);

	$stmt->execute();

	// 一ヶ月前のデータを物理削除
	// 削除対応日時
	$del_date = date("Y-m-d H:i:s", strtotime("-1 month"));
	$sql = "DELETE from blog_log";
	$sql .= " where";
	$sql .= " log_date <= :log_date";

	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':log_date', $del_date, PDO::PARAM_STR);

	$stmt->execute();
}

$pan = array();
$pan[0]['title'] = "パターンメイキング・グレーディングBlog";
$pan[0]["url"] = "/cad/blog/";
$pan[1]['title'] = strip_tags($blog_arr['title']);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="keywords" content="<?php echo $blog_arr['keywords'] ?>">
	<meta name="description" content="<?php echo $blog_arr['description'] ?>">
	<meta name="author" content="">
	<?php if (in_array($_REQUEST['v2'], $noindex_arr)) : ?>
		<meta name="robots" content="noindex">
	<?php endif; ?>
	<title><?php echo strip_tags($blog_arr['title']) ?> | パターン作成・グレーディングの小島衣料</title>
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
	<meta name="twitter:title" content="<?php echo strip_tags($blog_arr['title']) ?> | 小島衣料CADサービス | ">
	<meta name="twitter:image:src" content="">

	<!-- Open Graph data -->
	<meta property="og:title" content="<?php echo strip_tags($blog_arr['title']) ?> | 小島衣料CADサービス | ">
	<meta property="og:description" content="<?php echo $blog_arr['description'] ?>">
	<meta property="og:type" content="website">
	<meta property="og:url" content="">
	<meta property="og:image" content="">
	<meta property="og:image:width" content="">
	<meta property="og:image:height" content="">
	<meta property="og:site_name" content="">

	<link rel="stylesheet" href="<?php echo $url_path; ?>/assets/css/main.css">
	<link rel="stylesheet" href="<?php echo $url_path; ?>/assets/css/blog.css">
	<link rel="stylesheet" href="<?php echo $url_path; ?>/assets/css/main3.css">
	<script src="//kitchen.juicer.cc/?color=Z+x+canRRXU=" async></script>
</head>

<body class="home page blog">



	<?php include("../include/header.php"); ?>

	<div class="container">
		<div class="col-2-main">
			<div class="left-container">





				<article class="column-article">
					<header class="column-header">
						<h1 class="column__title"><?php echo $blog_arr['title'] ?></h1>
						<?php
						if (!empty($blog_arr['comment'])) {
						?>
							<p class="title_un_comment"><?php echo $blog_arr['comment']; ?></p>
						<?php
						}
						?>
						<div class="column-meta">
							<ul class="column-meta__categories">
								<?php foreach ($category_arr as $value) : ?>
									<li><a href="/cad/blog/detail/category/<?php echo $item_slug_count[$value]; ?>"><?php echo $item_name_list[$value] ?></a></li>
								<?php endforeach ?>
							</ul>
							<p class="column-meta__postdate"><?php echo $blog_arr['blog_date_view'] ?></p>
						</div>
					</header>
					<?php if (!empty($blog_arr['up_file1'])) : ?>
						<div class="column-article__top-img">
							<img class="column-article__img" src="<?php echo $url_path; ?>/up_file/<?php echo $blog_arr['up_file1'] ?>" alt="<?php echo $blog_arr['alt1'] ?>">
						</div>
					<?php endif ?>
					<section class="column-content">
						<p class="column-article__txt"><?php echo $blog_arr['lead_sentence'] ?></p>
						<?php if ($blog_arr['product_name'] == "1") : ?>
							<div class="blogdetail_cta_above_toc_container">
								<p class="ttl">アパレル業界の業務効率化をサポートする<br>パターンメイキング・グレーディング外注</p>
								<p class="txt">当社のサービスについて下記よりご覧いただけます。</p>
								<div class="ctabox">
									<a class="btn-arrow fcw" href="<?php echo $url_path; ?>/price/">料金表ダウンロード</a>
									<a class="btn-arrow fcw" href="<?php echo $url_path; ?>/service/">サービスの詳細</a>
								</div>
							</div>
						<?php endif ?>
						<div id="toc_container">
							<!-- / プラグインTable of Contents Plusの使用を想定 -->
							<p class="toc_title">目次</p>
							<ul class="toc_list">
								<?php foreach ((array)$blg_o_list as $key => $value) : ?>
									<li><a href="#bd<?php echo $key; ?>">●<?php echo strip_tags($value['subtitle']); ?></a>

										<?php
										$sql_blg_in = "SELECT";
										$sql_blg_in .= " *";
										$sql_blg_in .= " FROM";
										$sql_blg_in .= " blog_other";
										$sql_blg_in .= " WHERE";
										$sql_blg_in .= " blog_no = :blog_no";
										$sql_blg_in .= " and parent_id = :parent_id";
										$sql_blg_in .= " order by blog_other_no";

										$stmt_inm = $pdo->prepare($sql_blg_in);
										$stmt_inm->bindParam(':blog_no', $blog_arr['blog_no'], PDO::PARAM_INT);
										$stmt_inm->bindParam(':parent_id', $value['blog_other_no'], PDO::PARAM_INT);

										$stmt_inm->execute();



										$row_num_blg_in = $stmt_inm->rowCount();

										if ($row_num_blg_in > "0") {
										?>
											<ul class="toc_list pt0">
												<?php
												while ($blg_in = $stmt_inm->fetch(PDO::FETCH_ASSOC)) {
												?>
													<li>・<a href="#bd<?php echo $blg_in['blog_other_no']; ?>"><?php echo $blg_in['subtitle']; ?></a></li>
												<?php } ?>
											</ul>
										<?php } ?>

									</li>
								<?php endforeach ?>
							</ul>

						</div>




						<?php if ($blog_arr['cta_flg'] == "1") : ?>
							<p class="cta_bnr"><a href="/cad/contact/"><img class="column-article__img" src="<?php echo $url_path; ?>/assets/img/blog/blog_bnr_715_220.png" alt=""></a></p>
						<?php endif ?>

						<?php foreach ((array)$blg_o_list as $key => $value) : ?>
							<div id="bd<?php echo $key; ?>" class="bdair"></div>
							<div class="">
								<h2><span><?php echo $value['subtitle']; ?></span></h2>
								<?php if (!empty($value['up_file1']) and $value['blog_image_view'] != "89") : ?>
									<div class="column-article__top-img">
										<img class="column-article__img" src="<?php echo $url_path; ?>/up_file/<?php echo $value['up_file1'] ?>" alt="<?php echo $value['alt1'] ?>">
									</div>
								<?php endif ?>

								<div class="column-article__txt"><?php echo $value['subcomment']; ?></div>
								<?php if (!empty($value['up_file1']) and $value['blog_image_view'] == "89") : ?>
									<div class="column-article__top-img">
										<img class="column-article__img" src="<?php echo $url_path; ?>/up_file/<?php echo $value['up_file1'] ?>" alt="<?php echo $value['alt1'] ?>">
									</div>
								<?php endif ?>

								<?php
								$sql_blg_in = "SELECT";
								$sql_blg_in .= " *";
								$sql_blg_in .= " FROM";
								$sql_blg_in .= " blog_other";
								$sql_blg_in .= " WHERE";
								$sql_blg_in .= " blog_no = :blog_no";
								$sql_blg_in .= " and parent_id = :parent_id";
								$sql_blg_in .= " order by blog_other_no";

								$stmt_inm = $pdo->prepare($sql_blg_in);
								$stmt_inm->bindParam(':blog_no', $blog_arr['blog_no'], PDO::PARAM_INT);
								$stmt_inm->bindParam(':parent_id', $value['blog_other_no'], PDO::PARAM_INT);

								$stmt_inm->execute();
								while ($blg_in = $stmt_inm->fetch(PDO::FETCH_ASSOC)) {
								?>

									<div id="bd<?php echo $blg_in['blog_other_no']; ?>" class="bdair"></div>
									<h3><?php echo $blg_in['subtitle']; ?></h3>
									<?php if (!empty($blg_in['up_file1']) and $blg_in['blog_image_view'] != "89") : ?>
										<div class="column-article__top-img">
											<img class="column-article__img" src="<?php echo $url_path; ?>/up_file/<?php echo $blg_in['up_file1'] ?>" alt="<?php echo $blg_in['alt1'] ?>">
										</div>
									<?php endif ?>
									<div class="column-article__txt"><?php echo $blg_in['subcomment']; ?></div>
									<?php if (!empty($blg_in['up_file1']) and $blg_in['blog_image_view'] == "89") : ?>
										<div class="column-article__top-img">
											<img class="column-article__img" src="<?php echo $url_path; ?>/up_file/<?php echo $blg_in['up_file1'] ?>" alt="<?php echo $blg_in['alt1'] ?>">
										</div>
									<?php endif ?>
								<?php
								}
								?>

							</div>
						<?php endforeach ?>

						<div class="price-btn v2 mtb30">
							<div class="price-btn__sidebar v2"><span>料金が一目でわかる！資料をプレゼント </span></div>
							<a href="/cad/price/" class="price-btn__link v2">
								<span>パターンメイキング・グレーディング</span><br>
								料金資料をもらう（無料）
							</a>
							<div class="price-btn__txt">お申込み後、リアルタイムでお送りいたします！</div>
						</div>
						<?php if (!empty($blog_arr['rec_main_title'])) : ?>
							<div class="relatedItem">
								<div class="relatedItem__ttl"><?php echo $blog_arr['rec_main_title']; ?></div>
								<ul class="relatedItem__box">
									<?php foreach ((array)$blg_item_list as $key => $val) : ?>
										<li class="relatedItem__box--list"><a href="<?php echo $val['url']; ?>"><?php echo $val['title']; ?></a></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
						<div class="blog_bnr_service_lp">
							<a href="https://www.kojima-iryo.com/cad/service/"><img src="<?php echo $url_path; ?>/assets/img/blog/blog_bnr_service_lp02.png"></a>
							<a href="https://www.kojima-iryo.com/cad/modeling/"><img src="<?php echo $url_path; ?>/assets/img/blog/blog_bnr_service_lp01.png"></a>
						</div>


					</section>
					<?php if ($blog_arr['material_no'] == "3") : ?>
						<div class="contact_btn">
							<a href="/cad/service/">
								<div class="contact_btn_inner">
									<p class="text_s">迅速、リーズナブル、高品質。<br>
										小島衣料のパターンメイキング・グレーディング外注!</p>
									<p class="text_s">＞＞詳細はこちら</p>
								</div>
							</a>
						</div>
					<?php endif ?>


				</article>





				</section>
			</div>

			<?php include("../include/sidebar.php");
			?>

		</div>
	</div>
	<?php include("../include/footer_contact.php"); ?>

	<?php include("../include/floatingBtn.php"); ?>
	<?php include("../include/footer.php"); ?>
</body>

</html>