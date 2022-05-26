<?php
/*
Plugin Name: Consumer Transaction Amidasu
Plugin URI: 
Description: 特定商取引 ガイドライン 2022年 対応 for WooCommerce
Author: mono96
Version: 1
Author URI: https://mono96.jp
*/
/* ダイレクトアクセス禁止 */
if ( ! defined( 'ABSPATH' ) ) exit;

 /* 会社名などのカスタム部分 */
 /* 問い合わせ窓口 */
 define( 'MY_CONTACT_FORM', 'URL' );
   /* 特定商法:お支払いについて */
 define( 'MY_PAY_METHOD', 'URL' );
   /* 特定商法:商品のお届けについて */
 define( 'MY_DELIVERY_RULE', 'URL' );
   /* 特定商法:連絡窓口 */
 define( 'MY_CONTACT_RURL', 'URL' );
  /* 特定商法:返品に関する特約 */
 define( 'MY_RETURN_RURL', 'URL' );
 /* ここまで：会社名などのカスタム部分 */
 
 /**
 * 定数 定義
 */
define( 'MY_PLUGIN_VERSION', '1.122' );
define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MY_PLUGIN_URL', plugins_url( '/', __FILE__ ) );

 
 /* checkout page に表示 */
add_action('woocommerce_review_order_before_payment','digital_item_no_returns_checkout_message');

function digital_item_no_returns_checkout_message( ) {
       ?>
       <div class="order_before_payment_message">
            <h3 id="order_about_cancel_message">ご注文後のキャンセル・返品について</h3>
                <div class="for_digital_item_message">
                    <ul>
                    <li>弊社では商品に欠陥がある場合を除き、お客様都合での返品・返金は一切お断りさせて頂いております。</li>
       		     <li>動画講座などのデジタル商品は、商品の性質上、購入後のキャンセル・返品は受付できません。</li>
       		     <li>初期不良の際は、商品到着日から7日以内に<a href="<?php echo MY_RETURN_RURL ?>">こちら</a>をご確認の上、<a href="<?php echo MY_CONTACT_FORM ?>">お問い合わせフォーム</a>よりご連絡ください。</li>
       		         </ul>

       		      <ul  class="notice_order_before_payment_message">
       		         <li>お支払い時期について：<br class="sp"><span class="link">詳細は<a href="<?php echo MY_PAY_METHOD ?>">こちらのページ</a>をご覧ください</span></li>
       		         <li>商品のお届け時期について：<br class="sp"><span class="link">詳細は<a href="<?php echo MY_DELIVERY_RULE ?>">こちらのページ</a>をご覧ください</span></li>
       		         <li>連絡窓口について：<br class="sp"><span class="link">詳細は<a href="<?php echo MY_CONTACT_RURL ?>">こちらのページ</a>をご覧ください</span></li>
       		        </ul>
       	</div>
       <?php
}

 /** checkout page キャンセルボタンを表示 
 */
add_action( 'woocommerce_review_order_after_submit', 'checkout_reset_button', 10 );
function checkout_reset_button(){
    echo '<br><br>
    <div class="checkout_reset_button">
    <a class="button alt" style="text-align:center;" href="?cancel=1">'.__("注文を取消", "woocommerce").'</a></div>';
}

add_action( 'template_redirect', 'checkout_reset_cart' );
function checkout_reset_cart() {
    if( ! is_admin() && isset($_GET['cancel']) ) {
        WC()->cart->empty_cart();
        wp_redirect( get_permalink( wc_get_page_id( 'shop' ) ) );
        exit();
    }
}

/*CSS 読み込み*/

/**
 * スクリプト スタイルシートの読み込み
 */
add_action( 'wp_enqueue_scripts', function() {
	/** CSS */
	wp_enqueue_style(
		'my-test-style',
		MY_PLUGIN_URL.'assets/my_ct2022_style.css',
		array(),
		MY_PLUGIN_VERSION
	);
});