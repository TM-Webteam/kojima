<div class="footer">
  <!-- <div class="footer__entry pc-only"><a href="<?php echo $url_path; ?>/mailmagazine/">メールマガジン<br>新規登録はこちら</a></div> -->
  <!-- <?php
  include($_SERVER['DOCUMENT_ROOT'] . "/cad/include/popup_banner.php");
  ?> -->
  <a class="pagetop" href="#"><img src="<?php echo $url_path; ?>/assets/img/common/pagetop.png"></a>
  <div class="footer__main">
    <div class="foot_flex">
      <div class="foot_c_left">
        <h2>小島衣料CADサービス</h2>
        <h3>CSC事業部KCR課（CAD事業）</h3>
        <p>
          本社<br>
          〒502-0006 岐阜県岐阜市粟野西5-684<br>
          TEL 058-237-3033
        </p>
        <p>
          東京<br>
          〒103-0015 東京都中央区日本橋箱崎町17-9 箱崎升喜ビル6F<br>
          TEL 03-5642-6155
        </p>
      </div>
      <div class="foot_c_right">
        <div class="foot_menu">
          <ul>
            <li><a href="<?php echo $url_path; ?>/service">サービス</a></li>
            <li><a href="<?php echo $url_path; ?>/price">料金表</a></li>
            <li><a href="<?php echo $url_path; ?>/contact">納期お問合せ･見積り依頼</a></li>
            <li><a href="<?php echo $url_path; ?>/case">実績・事例</a></li>
            <li><a href="<?php echo $url_path; ?>/strengths">小島衣料の強み</a></li>
            <li><a href="<?php echo $url_path; ?>/customer_reviews">お客様の声</a></li>
            <li><a href="<?php echo $url_path; ?>/qa">Q&A</a></li>
          </ul>
        </div>
        <div class="foot_menu">
          <ul>
            <li><a href="<?php echo $url_path; ?>/blog">お役立ち記事</a></li>
            <li><a href="<?php echo $url_path; ?>/sitemap">サイトマップ</a></li>
            <!-- <li><a href="<?php echo $url_path; ?>/pdf/calendar.pdf" target="_blank">各国年間スケジュール</a></li> -->
            <li><a href="http://www.kojima-iryo.com/privacy.html" target="_blank">プライバシーポリシー</a></li>
            <li><a href="http://www.kojima-iryo.com/company.html" target="_blank">会社概要</a></li>
            <li><a href="<?php echo $url_path; ?>/mailmagazine">メールマガジン登録</a></li>
          </ul>
        </div>
        <div class="foot_c_right__copy">©2019 小島衣料CADサービス All Rights Reserved.</div>
      </div>
    </div>
  </div>
</div><!-- /.footer -->


<script src="<?php echo $url_path; ?>/assets/js/vendor/jquery-3.2.1.min.js"></script>
<script src="<?php echo $url_path; ?>/assets/js/all.min.js"></script>
<script src="<?php echo $url_path; ?>/assets/js/jquery.matchHeight.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/object-fit-images/3.2.3/ofi.js"></script>
<script>
  objectFitImages();
</script>
<script>
  $(function() {
    $('.blog_relation_area .item_txt').matchHeight();
  });

  $(function(){
    var scrollStart = $('.floating-start').offset().top;
    $( window ).on( 'scroll', function() {
      if ( scrollStart < $( this ).scrollTop() ) {
        $( '.floatingBtn' ).addClass( 'block' );
      } else {
        $( '.floatingBtn' ).removeClass( 'block' );
      }
    });
  });
</script>
<!-- <script src="<?php echo $url_path; ?>/assets/js/main.js"></script> -->