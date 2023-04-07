<?php if(!preg_match("/price|contact/", $_SERVER['REQUEST_URI'])): ?>
<div class="problembnr">
    <label for="problembnr_close">
        <input type="checkbox" name="" id="problembnr_close">
        <p class="close"><span>✕</span></p>
        <a href="/cad/price/">
            <div class="rec_wp_bnr">
                <p class="rec_wp_bnr_ttl">パターンメイキング・グレーディング料金表</p>
                <div class="rec_wp_bnr_img"><img src="/cad/assets/img/price/price_wp.jpg"></div>
                <p class="rec_wp_bnr_cta">ダウンロードは<br class="sp-only">こちら</p>
            </div>
        </a>
        <div class="rec_text">
            <p class="rec_text_txt">パターンメイキング・グレーディング料金表をダウンロード</p>
            <p class="cta">OPEN</p>
        </div>
    </label>
</div>
<?php endif ?>




