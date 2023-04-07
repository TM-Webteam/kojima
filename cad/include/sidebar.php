<aside>
	<!--   <a href="<?php echo $url_path; ?>/contact">
		<div class="side-blog-bg">
			<p>パターン作成・<br class="pc-only">グレーディングに関する<br>ご相談はお気軽に!</p>
			<h3>納期の問合せ<br>見積り依頼</h3>
		</div>
	</a> -->

	<div class="tac" style="margin-bottom: 30px;">
		<div class="sidebar_link_box">
			<p class="ttl">アパレル業界の皆様へ</p>
			<p class="txt">パターンメイキング・グレーディング業務を低価格でアウトソーシングしませんか?</p>
			<p class="btn01"><a href="<?php echo $url_path; ?>/price/">料金表を見る</a></p>
			<p class="btn02"><a href="<?php echo $url_path; ?>/case/">実績・事例をチェック</a></p>
		</div>
	</div>

	<div>
		<h4>記事カテゴリー</h4>
		<ul class="cat_li">
			<?php foreach ((array)$item_slug as $key => $value) : ?>
				<?php if ($item_count[$key] > "0") : ?>
					<li><a href="<?php echo $url_path; ?>/blog/detail/category/<?= $key ?>"><span><?= $value ?></span></a></li>
				<?php endif ?>
			<?php endforeach ?>
		</ul>
	</div>
	<div class="sidebnr_bnr_3item">
		<h4>アクセスランキング（過去1か月）</h4>
		<?php
		// ランキング
		$sql = "SELECT";
		$sql .= " T1.*";
		$sql .= " ,(select count(*) from blog_log T2 where T2.blog_no = T1.blog_no) as log_cnt";
		$sql .= " FROM";
		$sql .= " blog T1";
		$sql .= " WHERE";
		$sql .= " T1.ranking_flg = 'open'";
		$sql .= " order by log_cnt desc";
		$sql .= " limit 3";
		// echo $sql;
		$stmt = $pdo->prepare($sql);
		// $stmt->bindParam(':blog_no', $_REQUEST['b_no'], PDO::PARAM_INT);
		$stmt->execute();
		$no_cnt = 0;
		while ($ranking = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$no_cnt++;
		?>
			<a href="/cad/blog/detail/<?php echo $ranking['slug']; ?>">
				<div class="sidebnr_flex">
					<p class="item_num"><?php echo $no_cnt; ?></p>
					<p class="item_img"><img src="/cad/up_file/<?php echo $ranking['up_file1']; ?>"></p>
					<p class="item_txt"><?php echo $ranking['title']; ?></p>
				</div>
			</a>
		<?php
		}
		?>
	</div>

	<?php if (!empty($blog_rec_arr)) : ?>
		<div class="p_sticky">
			<div class="sidebnr_relation">
				<h4 class="tac">おすすめ記事</h4>
				<?php
				$b_rec_cnt = 0;
				foreach ($blog_rec_arr as $key => $value) :
					$b_rec_cnt++;
					if ($b_rec_cnt < 3) :
				?>
						<a href="<?php echo $url_path; ?>/blog/detail/<?php echo $value['slug'] ?>" class="sidebnr_relation_flex">
							<p class="item_img"><img src="<?php echo $url_path; ?>/up_file/<?php echo $value['up_file1'] ?>"></p>
							<p class="item_txt"><?php echo $value['title'] ?></p>
						</a>
				<?php
					endif;
				endforeach; ?>

			</div>
			<div><a href="<?php echo $url_path; ?>/service/"><img src="<?php echo $url_path; ?>/assets/img/blog/magazine.jpg" alt="迅速、リーズナブル、高品質。小島衣料のパターンメイキング・グレーディング依頼"></a></div>
		</div>
	<?php else : ?>
		<div class="bnr-fixed"><a href="<?php echo $url_path; ?>/service/"><img src="<?php echo $url_path; ?>/assets/img/blog/magazine.jpg" alt="迅速、リーズナブル、高品質。小島衣料のパターンメイキング・グレーディング依頼"></a></div>

	<?php endif; ?>


	<!-- <div class="sticky tac">
		<div class="sidebar_link_box">
			<p class="ttl">アパレル業界の皆様へ</p>
			<p class="txt">パターンメイキング・グレーディング業務を低価格でアウトソーシングしませんか?</p>
			<p class="btn01"><a href="<?php echo $url_path; ?>/price/">料金表を見る</a></p>
			<p class="btn02"><a href="<?php echo $url_path; ?>/case/">実績・事例をチェック</a></p>
		</div>
	</div> -->
	<!--   <div class="mt30 sticky pc-only">
    <a href="/cad/service">
        <img src="../assets/img/sidebar/sidebnr_215_450.png">
    </a>
  </div>
  <div class="mt30 sp-only">
    <a href="/cad/service">
        <img src="../assets/img/sidebar/sidebnr_728_220.png">
    </a>
  </div> -->
</aside>