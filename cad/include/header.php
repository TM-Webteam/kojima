<?php
if ($_REQUEST['n'] != '' && $_REQUEST['c'] != '') {
  $_SESSION['url_type'] = $_REQUEST['n'];
  $_SESSION['company_id'] = $_REQUEST['c'];

  $url = 'https://www.marke-media.net/sys/management_tm_kojima/form/throw_log.php';

  $data = array(
    "url_type" => $_SESSION['url_type'],
    "company_id" => $_SESSION['company_id'],
    "add_date" => $now_date,
  );

  $options = array(
    'http' => array(
      'method'  => 'POST',
      'content' => json_encode($data),
      'header' =>  "Content-Type: application/json\r\n" .
        "Accept: application/json\r\n"
    )
  );

  $context  = stream_context_create($options);
  $sql_insert = file_get_contents($url, false, $context);
  $sql_insert = json_decode($sql_insert, true);
}
?>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119686150-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());
  gtag('config', 'UA-119686150-1');
</script>

<script type="text/javascript">
  var _trackingid = 'LFT-12025-1';
  (function() {
    var lft = document.createElement('script');
    lft.type = 'text/javascript';
    lft.async = true;
    lft.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//track.list-finder.jp/js/ja/track.js';
    var snode = document.getElementsByTagName('script')[0];
    snode.parentNode.insertBefore(lft, snode);
  })();
</script>
<!-- User Heat Tag -->
<script type="text/javascript">
  (function(add, cla) {
    window['UserHeatTag'] = cla;
    window[cla] = window[cla] || function() {
      (window[cla].q = window[cla].q || []).push(arguments)
    }, window[cla].l = 1 * new Date();
    var ul = document.createElement('script');
    var tag = document.getElementsByTagName('script')[0];
    ul.async = 1;
    ul.src = add;
    tag.parentNode.insertBefore(ul, tag);
  })('//uh.nakanohito.jp/uhj2/uh.js', '_uhtracker');
  _uhtracker({
    id: 'uhwOOZtllr'
  });
</script>
<!-- End User Heat Tag -->
<header class="header">
  <div class="header__container">
    <div class="header__wrap">
      <div class="header__upper">
        <div class="header__logo_box">
          <a href="<?php echo $url_path; ?>/" class="header__logo">
            小島衣料CADサービス<br class="pc-only"><span class="pc-only fwn">パターン作成・グレーディング業務なら小島衣料</span>
          </a>
          <p class="header__desc sp-only">
            パターン作成・グレーディング業務なら小島衣料
          </p>
        </div>
        <div id="nav-toggle" class="sp-only">
          <div>
            <span></span>
            <span></span>
            <span></span>
            <span class="m_txt"></span>
          </div>
        </div>

        <div id="gloval-nav">
          <nav>
            <ul>
              <li><a href="<?php echo $url_path; ?>/">トップページ</a></li>
              <li><a href="<?php echo $url_path; ?>/service">サービス</a></li>
              <li><a href="<?php echo $url_path; ?>/case">実績・事例</a></li>
              <li><a href="<?php echo $url_path; ?>/strengths">小島衣料の強み</a></li>
              <li><a href="<?php echo $url_path; ?>/qa">Q&A</a></li>
              <li><a href="<?php echo $url_path; ?>/blog">お役立ち記事</a></li>
              <li><a href="<?php echo $url_path; ?>/price">料金表</a></li>
              <li><a href="<?php echo $url_path; ?>/modeling">3Dモデリング</a></li>
              <li><a href="<?php echo $url_path; ?>/leaflet">CADサービス資料</a></li>
            </ul>
            <div class="cta-banner">
              <!--               <div class="cta-banner__body">
                <p class="cta-banner__ttl">
                  【東京】03-5642-6155
                </p>
              </div> -->
              <!--               <div class="cta-banner__bottom_sp">
                <a href="<?php echo $url_path; ?>/contact">納期問合せ・見積り依頼</a>
              </div> -->
              <div class="cta-banner__bottom_sp">
                <a href="/cad/mailmagazine/" class="">メールマガジン登録</a>
              </div>
              <!-- <div class="cta-banner__bottom_sp">
                <a href="" class="a_disable">【東京】03-5642-6155</a>
              </div> -->
            </div>

          </nav>
        </div>
      </div>
      <div class="header__main pc-only">

        <div class="nav js-nav g-nav">
          <ul class="nav__list">
          <li class="nav__item g-nav__multi">
              <a href="<?php echo $url_path; ?>/service" class="nav__link"><span>サービス</span></a>
              <div class="g-nav__full">
                <div class="mega__parent"><a href="<?php echo $url_path; ?>/service">サービス</a></div>
                <div class="mega__child">
                  <div class="megaBox__ttl"><a href="<?php echo $url_path; ?>/service">CADサービス</a></div>
                  <div class="megaBox__ttl"><a href="<?php echo $url_path; ?>/modeling">3Dモデリング</a></div>
                </div>
              </div>
            </li>
            <li class="nav__item"><a href="<?php echo $url_path; ?>/case" class="nav__link"><span>実績・事例</span></a></li>
            <li class="nav__item"><a href="<?php echo $url_path; ?>/strengths" class="nav__link"><span>小島衣料の強み</span></a></li>
            <li class="nav__item"><a href="<?php echo $url_path; ?>/qa" class="nav__link"><span>Q&A</span></a></li>
            <li class="nav__item"><a href="<?php echo $url_path; ?>/customer_reviews" class="nav__link"><span>お客様の声</span></a></li>
            <li class="nav__item g-nav__multi">
              <a href="<?php echo $url_path; ?>/blog" class="nav__link"><span>お役立ち記事</span></a>
              <div class="g-nav__full">
                <div class="mega__parent"><a href="<?php echo $url_path; ?>/blog">お役立ち記事</a></div>
                <div class="mega__child">
                  <?php foreach ((array)$item_slug as $key => $value) : ?>
                    <?php if ($item_count[$key] > "0") : ?>
                      <div class="megaBox__ttl"><a href="<?php echo $url_path; ?>/blog/detail/category/<?= $key ?>"><?= $value ?></a></div>
                    <?php endif ?>
                  <?php endforeach ?>

                </div>
              </div>
            </li>
            <li class="nav__item"><a href="<?php echo $url_path; ?>/price" class="nav__link"><span>料金表</span></a></li>
            <li class="nav__item"><a href="<?php echo $url_path; ?>/leaflet" class="nav__link"><span>CADサービス資料</span></a></li>
          </ul>
        </div>
        <!-- /.nav -->
      </div>
      <!-- <div class="header__entry pc-only"><a href="<?php echo $url_path; ?>/mailmagazine/">メールマガジンの<br>ご登録はこちら</a></div> -->
      <!-- <div class="cta-banner pc-only">
        <div class="cta-banner__body">
          <p class="cta-banner__ttl">
            【東京】<br class="tablet-only">03-5642-6155
          </p>
        </div>
      </div> -->
      <!-- /.cta-banner -->
    </div>
    <div class="breadcrumb">
      <ol itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb__list">
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb__item home">
          <a href="<?php echo $url_path; ?>/" itemtype="http://schema.org/Thing" itemprop="item" class="breadcrumb__link">
            <span itemprop="name">ホーム</span>
            <meta itemprop="position" content="1">
          </a>
        </li>
        <?php if (!empty($pan[0]["title"])) : ?>
          <?php if (!empty($pan[0]["url"])) :
            $pan_url = $pan[0]["url"];
            $pan_class = " home";
          ?>

          <?php else :
            $pan_url = "#";
            $pan_class = "";
          ?>

          <?php endif ?>
          <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb__item<?php echo $pan_class; ?>">
            <a href="<?php echo $pan_url; ?>" itemtype="http://schema.org/Thing" itemprop="item" class="breadcrumb__link">
              <span itemprop="name"><?php echo $pan[0]["title"] ?></span>
              <meta itemprop="position" content="2">
            </a>
          </li>
        <?php endif ?>

        <?php if (!empty($pan[1]["title"])) : ?>
          <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb__item">
            <a href="#" itemtype="http://schema.org/Thing" itemprop="item" class="breadcrumb__link">
              <span itemprop="name"><?php echo $pan[1]["title"] ?></span>
              <meta itemprop="position" content="3">
            </a>
          </li>
        <?php endif ?>

      </ol>
      <!-- <div class="cta-banner__bottom pc-only">
        <a href="<?php echo $url_path; ?>/contact">納期問合せ<br class="tablet-only">・見積り依頼</a>
      </div> -->
      <div class="cta-banner__bottom pc-only">
        <a href="/cad/mailmagazine/" class="">メールマガジン登録</a>
      </div>
      <!-- <div class="cta-banner__bottom pc-only">
        <a href="" class="a_disable">【東京】03-5642-6155</a>
      </div> -->
    </div>
    <!-- /.breadcrumb -->
  </div>
</header>
<!-- /.header -->