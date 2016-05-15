<?php
/**
*	Localization
*/
add_action('init', 'ae_lang_init');
function ae_lang_init() {

	load_plugin_textdomain( 'ae', false, dirname( plugin_basename( __FILE__ ) ) . '/../lang/' );
}

if( !function_exists('pr') ) {

	function pr( $any ) {

		print_r( "<pre>" );
		print_r( $any );
		print_r( "</pre>" );
	}
}

/**
*	XML Objects to Array
*/
function ae_xml2array ( $xmlObject, $out = array() ) {

	foreach ( (array) $xmlObject as $index => $node )
		$out[$index] = ( is_object ( $node ) ) ? ae_xml2array ( $node ) : $node;

	return $out;
}

/**
*	XML Objects to Array
*/
function ae_obj2array ( $obj, $out = array() ) {

	return ae_xml2array( $obj, $out );
}

/**
*	Array to Objects
*/
function ae_array2object( $array = array() ) {

	if ( empty( $array ) || !is_array( $array ) )
		return false;

	$data = new stdClass;

	foreach ( $array as $akey => $aval )
		$data->{$akey} = $aval;

	return $data;
}

/**
*	Parse any str to float
*/
function ae_floatvalue( $value ) {

	$value = preg_replace("/[^0-9,.]/", "", $value);
	$value = str_replace(',', '.', $value);
	return number_format( floatval($value), 2, '.', '' );
}

/**
*	Array to url
*/
function ae_array2url( $foo = false, $s = '&' ) {

	if( is_array( $foo ) ){

		$url = array();

		foreach ( $foo as $key => $str ) {
			$url[] .= $key . "=" . $str;
		}

		return implode( $s, $url );
	}
	else
		return "";
}

/**
*	Convert date to DB datetime
*/
function ae_dbdate( $value ) {
	return date( "Y-m-d H:i:s", strtotime( $value ) );
}

function ae_unserialize( $str ) {

    if( !$str )
        return false;

    try{
        $list = unserialize($str);
    }
    catch( Exception $e ) {
        return false;
    }

    return $list;
}

function ae_diff_date( $date1, $date2 ) {

    $diff = abs($date2 - $date1);
    $days = floor($diff/(60*60*24));

    return $days;
}

function ae_translate_any_str( $str, $to, $from = 'en' ) {
 
	include_once dirname(__FILE__) . '/../libs/translate/GoogleTranslate.php';

	$tr = new GoogleTranslate();

	$tr->setFromLang($from)->setToLang($to);

	$translated = $tr->translate($str);

	return ( $tr->isError() ) ? $str : $translated;
}

/**
*	Remove style attribute from HTML tags
*/
function ae_clean_html_style( $str ) {

    $str = trim($str);

    if( empty($str) ) return '';

	$domd = new DOMDocument();
	libxml_use_internal_errors(true);
	$domd->loadHTML($str);
	libxml_use_internal_errors(false);

	$domx = new DOMXPath($domd);
	$items = $domx->query('//div[@style="max-width:650px;overflow:hidden;font-size:0;clear:both"]');

	foreach($items as $item) {
		$item->parentNode->removeChild($item);
	}

	$str = $domd->saveHTML();
	$str = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $str);
	$str = preg_replace('/(<[^>]+) class=".*?"/i', '$1', $str);
	$str = preg_replace('/(<[^>]+) width=".*?"/i', '$1', $str);
	$str = preg_replace('/(<[^>]+) height=".*?"/i', '$1', $str);
	$str = preg_replace('/(<[^>]+) alt=".*?"/i', '$1', $str);
	$str = preg_replace('/^<!DOCTYPE.+?>/', '$1', str_replace( array('<html>', '</html>', '<body>', '</body>'), '', $str));
	$str = preg_replace("/<\/?div[^>]*\>/i", "", $str);

	$str = preg_replace('#(<a.*?>).*?(</a>)#', '$1$2', $str);
	$str = preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', $str);
	$str = preg_replace("/<\/?h1[^>]*\>/i", "", $str);
	$str = preg_replace("/<\/?strong[^>]*\>/i", "", $str);
	$str = preg_replace("/<\/?span[^>]*\>/i", "", $str);

	$str = str_replace(' &nbsp; ', '', $str);
	$str = str_replace('&nbsp;', ' ', $str);

	$pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";
	$str = preg_replace($pattern, '', $str);

	$str = str_replace( array('<img', '<table'), array('<img class="img-responsive"', '<table class="table table-bordered'), $str);

	$str = force_balance_tags( $str );

	return $str;
}

/**
*	Set TimeOut
*	$value - is seconds
*/
function ae_setTimeout( $value ) {

	$start_time = time();

	while(true) {
		if ( (time() - $start_time) > $value ) {
			return false;
		}
	}
}

/**
 * \n to <br> parser
 *
 * @param $content
 *
 * @return mixed|void
 */
function ae_nl2br_content( $content ) {
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]>', $content);
	return $content;
}

/**
 * Set timer to supersale
 */
function ae_session_sale() {

    $now    = strtotime('now');

    $limit  = 16578;
    $define = 0;

    $timer = isset($_COOKIE['ae_supersale']) ? $now - intval($_COOKIE['ae_supersale']) : 0;

    if( $timer > 86400 || $timer == 0 ) {

        setcookie("ae_supersale", $now, time()+86400, "/");
        $define = $limit;
    }
    elseif( $timer < $limit ) {
        $define = $limit - $timer;
    }

    if ( !defined('AE_SALE') ) define( 'AE_SALE', $define );
}
add_action('init', 'ae_session_sale');

/**
 * Get timer to supersale
 * @return bool|string
 */
function ae_get_timer( $time = false ) {

    if( $time && $time > 0 ) {

        $now = strtotime('now');

        $diff = ae_diff_date($now, $time);

        if( $now < $time && $diff >= 1 )
            return array(
                'type' => 'day',
                'value' => $diff
            );
    }

    if ( defined('AE_SALE') && AE_SALE > 0 ) {
        return array(
            'type' => 'time',
            'value' => gmdate('H:i:s', AE_SALE)
        );
    }

    return false;
}

add_filter('admin_footer_text', 'ae_footer_admin_queries');
function ae_footer_admin_queries(){
	echo get_num_queries().' queries in '.timer_stop(0).' seconds. ' . PHP_EOL;
}

/**
*	Get request method
*/
function ae_request_method( ) {

	$var = get_site_option('ae-method');

	return !empty( $var ) ? $var : 'file';
}

/**
*	add scripts and styles to forntend
*/
add_action('wp_enqueue_scripts', 'ae_load_outside');
function ae_load_outside( ) {

	wp_register_style( 'ae-plugin-style', plugins_url('/aliplugin/css/style-outside.css'), "", '1.1' );

	wp_enqueue_style( 'ae-plugin-style' );
	wp_register_script( 'fotorama-js', plugins_url( '/aliplugin/js/fotorama.js' ), array('jquery'), '4.6.4' );
	wp_register_style( 'fotorama-css', plugins_url('/aliplugin/css/fotorama.css'), "", '4.6.4' );
	wp_enqueue_script('fotorama-js');
	wp_enqueue_style('fotorama-css');
}

/**
*	add scripts and styles to admin
*/
add_action('admin_print_scripts', 'ae_plugin_load_admin');
function ae_plugin_load_admin(){

	wp_register_script( 'ajaxQueue', plugins_url( '/aliplugin/js/jquery.ajaxQueue.min.js' ), array( 'jquery' ), '0.1.2' );
	wp_register_script( 'textarea', plugins_url( '/aliplugin/js/jquery.textarea.js' ), array( 'jquery' ), '0.1.2' );
	wp_register_script( 'bootstrap', plugins_url( '/aliplugin/js/bootstrap.min.js' ), array( 'jquery' ), '3.0' );
	wp_register_script( 'pag', plugins_url( '/aliplugin/js/pag.js' ), array( 'jquery' ), '1.6' );
	wp_register_script( 'range', plugins_url( '/aliplugin/js/slider.range.js' ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-slider', 'jquery-ui-widget', 'jquery-ui-mouse' ), '1.6' );
	wp_register_script( 'ae-script', plugins_url( '/aliplugin/js/script.js' ), array( 'bootstrap', 'range', 'ajaxQueue', 'pag' ), '1.1' );
	wp_register_script( 'ae_review', plugins_url( '/aliplugin/js/to-review.js' ), array( 'bootstrap', 'ajaxQueue', 'jquery-ui-core', 'jquery-ui-slider', 'jquery-ui-widget', 'jquery-ui-mouse', 'pag', 'textarea' ), '0.1.3' );

	wp_register_script( 'ae-percentageloader', plugins_url( '/aliplugin/js/percentageloader.js' ), array( 'jquery'), '0.2' );
	wp_register_script( 'ae-review-import', plugins_url( '/aliplugin/js/importReview.js' ), array( 'ajaxQueue', 'ae-percentageloader' ), '0.1.3' );
	wp_register_script( 'ae-loader-action', plugins_url( '/aliplugin/js/jquery.LoaderAction.js' ), array( 'ajaxQueue', 'ae-percentageloader' ), '1.1' );
	wp_register_script( 'ae-csv', plugins_url( '/aliplugin/js/jquery.csv.js' ), array( 'ajaxQueue', 'ae-percentageloader' ), '1.1' );
	wp_register_script( 'plupload-js', plugins_url( '/aliplugin/libs/plupload/plupload.full.min.js' ), array('jquery'), '4.6.4' );

	wp_register_style( 'bootstrap', plugins_url('/aliplugin/css/bootstrap.min.css'), "", '3.0' );
	wp_register_style( 'bootstrap-theme', plugins_url('/aliplugin/css/bootstrap-theme.min.css'), array('bootstrap'), '3.0' );
	wp_register_style( 'font-awesome', plugins_url('/aliplugin/css/font-awesome.min.css'), array(), '4.0' );
	wp_register_style( 'ae-style-admin', plugins_url('/aliplugin/css/style-all-admin.css'), '', '1.3' );
	wp_register_style( 'ae-style-inside', plugins_url('/aliplugin/css/style-inside.css'), '', '1.3' );

	wp_register_style( 'jquery-ui', plugins_url('/aliplugin/css/jquery-ui.min.css'), '', '1.11.2' );
	wp_register_style( 'jquery-ui-theme', plugins_url('/aliplugin/css/jquery-ui.theme.min.css'), array('jquery-ui'), '1.11.2' );
	wp_register_style( 'ae-style', plugins_url('/aliplugin/css/style.css'), array('font-awesome', 'bootstrap-theme', 'jquery-ui-theme'), '1.5' );

	wp_register_script( 'translateth', plugins_url( '/aliplugin/js/translate-this.js' ), '', '1.0' );
	wp_register_script( 'ae_translate', plugins_url( '/aliplugin/js/to-translate.js' ), array('ajaxQueue', 'translateth'), '0.1.2' );

	wp_enqueue_style( 'ae-style-admin' );

	$screen = get_current_screen();

	if( $screen->id == 'toplevel_page_aliplugin' && isset($_GET['aepage']) && $_GET['aepage'] == 'review' ) {

        wp_enqueue_style( 'ae-style' );
        wp_enqueue_script( 'ae-review-import' );
    }
	elseif(isset($_GET['aepage']) && $_GET['aepage'] == 'CSV' ) {

		wp_enqueue_style( 'ae-style' );
		wp_enqueue_script('plupload-js');
        wp_enqueue_script( 'ae-csv' );

	}
	elseif(isset($_GET['aepage']) && $_GET['aepage'] == 'updates' ) {

		wp_enqueue_style( 'ae-style' );
        wp_enqueue_script( 'ae-loader-action' );
	}
	elseif( $screen->id == 'toplevel_page_aliplugin' ) {

		wp_enqueue_script( 'ae-script' );
		wp_enqueue_style( 'ae-style' );
	}
	elseif( $screen->id == 'toplevel_page_alimigrate' ) {

		wp_enqueue_script( 'bootstrap' );
		wp_enqueue_style( 'ae-style' );
	}
	elseif( isset($screen->post_type) && $screen->post_type == 'post' ) {
		wp_enqueue_script( 'ae_review' );
		wp_enqueue_style( 'ae-style' );
		wp_enqueue_style( 'ae-style-inside' );
	}
	elseif( isset($screen->post_type) && $screen->post_type == 'products' ) {
		wp_enqueue_script( 'ae_translate' );
	}
	else{
		wp_enqueue_style( 'ae-style-inside' );
	}


}
add_action('admin_enqueue_scripts', 'chrome_fix');
function chrome_fix() {
	if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Chrome' ) !== false )
		wp_add_inline_style( 'wp-admin', '#adminmenu { transform: translateZ(0); }' );
}
add_action('admin_head', 'ae_review_module');
function ae_review_module( ){

	$screen = get_current_screen();

	if( !isset($screen->post_type) || $screen->post_type != 'post' ) return;

	add_action('media_buttons', 'ae_add_media_button', 15);
}

add_action('admin_head', 'ae_translate_module');
function ae_translate_module( ){

	$screen = get_current_screen();

	if( !isset($screen->post_type) || $screen->post_type != 'products' ) return;

	add_action('media_buttons', 'ae_add_translate_button', 15);
}

/**
*	Add scripts and style for Review
*/
function ae_media_js_scripts() {

	wp_register_script( 'ae_review', plugins_url( '/aliplugin/js/to-review.js' ), array( 'bootstrap', 'ajaxQueue', 'jquery-ui-core', 'jquery-ui-slider', 'jquery-ui-widget', 'jquery-ui-mouse', 'pag', 'textarea' ), '0.1.4' );

	wp_enqueue_script( 'ae_review' );
	wp_enqueue_style( 'ae-style' );
}

/**
*	Add new button for Review
*/
function ae_add_media_button( ) {

	echo '<a href="#" id="aliproduct" class="button"><img src="' . plugins_url( 'aliplugin/img/logo.png') . '">' . __("AliPlugin", 'ae') . '</a>';
}

/**
*	Add new button for Translate
*/
function ae_add_translate_button( ) {

	?>
		<div id="translate-this" style="display:inline-block">
			<a class="translate-this-button" href="http://www.translatecompany.com/translate-this/"  style="opacity:.25"><img src="<?php echo plugins_url( 'aliplugin/img/translate.png') ?>"><?php _e("Translate", 'ae') ?></a>
		</div>
		<a class="button" id="alirestore" href="#"><img src="<?php echo plugins_url( 'aliplugin/img/restore.png') ?>"><?php _e("Restore", "ae") ?></a>
		<div id="media-progress"><img src="<?php echo plugins_url( 'aliplugin/img/ajax-loader.gif') ?>"></div>
		<div id="ali-translate-this-content" style="display:none">
			<div class="post_title"></div>
			<div class="post_content"></div>
		</div>
	<?php
}

/**
*	Add custom thumbnail size. Only for admin page.
*/
add_image_size( 'admin-thumb', 90, 90, true );

/**
*	List categories from AliExpress
*/
function ae_list_categories( ) {

	return array(
		array("ali_id" => '', "name" => __("All Categories", 'ae')),
		array("ali_id" => 3, "name" => __("Apparel & Accessories", 'ae')),
		array("ali_id" => 34, "name" => __("Automobiles & Motorcycles", 'ae')),
		array("ali_id" => 1501, "name" => __("Baby Products", 'ae')),
		array("ali_id" => 66, "name" => __("Beauty & Health", 'ae')),
		array("ali_id" => 7, "name" => __("Computer & Networking", 'ae')),
		array("ali_id" => 13, "name" => __("Construction & Real Estate", 'ae')),
		array("ali_id" => 44, "name" => __("Consumer Electronics", 'ae')),
		array("ali_id" => 100008578, "name" => __("Customized Products", 'ae')),
		array("ali_id" => 5, "name" => __("Electrical Equipment & Supplies", 'ae')),
		array("ali_id" => 502, "name" => __("Electronic Components & Supplies", 'ae')),
		array("ali_id" => 2, "name" => __("Food", 'ae')),
		array("ali_id" => 1503, "name" => __("Furniture", 'ae')),
		array("ali_id" => 200003655, "name" => __("Hair & Accessories", 'ae')),
		array("ali_id" => 42, "name" => __("Hardware", 'ae')),
		array("ali_id" => 15, "name" => __("Home & Garden", 'ae')),
		array("ali_id" => 6, "name" => __("Home Appliances", 'ae')),
		array("ali_id" => 200003590, "name" => __("Industry & Business", 'ae')),
		array("ali_id" => 36, "name" => __("Jewelry & Watch", 'ae')),
		array("ali_id" => 39, "name" => __("Lights & Lighting", 'ae')),
		array("ali_id" => 1524, "name" => __("Luggage & Bags", 'ae')),
		array("ali_id" => 21, "name" => __("Office & School Supplies", 'ae')),
		array("ali_id" => 509, "name" => __("Phones & Telecommunications", 'ae')),
		array("ali_id" => 30, "name" => __("Security & Protection", 'ae')),
		array("ali_id" => 322, "name" => __("Shoes", 'ae')),
		array("ali_id" => 200001075, "name" => __("Special Category", 'ae')),
		array("ali_id" => 18, "name" => __("Sports & Entertainment", 'ae')),
		array("ali_id" => 1420, "name" => __("Tools", 'ae')),
		array("ali_id" => 26, "name" => __("Toys & Hobbies", 'ae')),
		array("ali_id" => 1511, "name" => __("Watches", 'ae'))
	);
}

/**
 * Search parent category name by ali id
 * @param $id
 * @return bool
 */
function ae_search_category_by_id( $id ){

	$foo = ae_list_categories();

	foreach( $foo as $key => $val ) {
		if( $val['ali_id'] == $id )
			return $val['name'];
	}

	return false;
}

add_action("init", "ae_move_page");
function ae_move_page( ) {

	$foo = array("dash", "conf", "bulk", "advanced", "scheduled");

	if( isset($_GET['page']) && isset($_GET['aepage']) &&
		$_GET['page'] == 'aliplugin' && in_array($_GET['aepage'], $foo) && !ae_get_lic() ) {

			wp_redirect(admin_url( 'admin.php?page=aliplugin' ));
	}
}

/**
*	Show categories in drop down list
*/
function ae_dropdown_categories( $name = 'alicategories', $class = "", $selected = "" ) {

	$categories = ae_list_categories();

	$output = '<select name="' . $name . '" id="' . $name . '" class="' . $class . '">';

	foreach( $categories as $category ) {

		$select = ( $category['ali_id'] == $selected ) ? 'selected="selected"' : '';

		$output .= '<option value="' . $category['ali_id'] . '" ' . $select . '>' . $category['name'] . '</option>';
	}

	$output .= '</select>';

	return $output;
}

/**
*	return object array with details from product (AliExpress)
*/
function ae_product_detail( $post_id ) {

	$pub = new AliExpressPublish( );

	$result = $pub->getDetailsByPost( $post_id );

	return $result;
}

/**
*	Get option by params
*/
function ae_search_option( $name = '', $value = '' ) {

	if( $name == '' && $value == '' ) return false;

	global $wpdb;

	if( $name == '' )
		return $wpdb->get_var(
			$wpdb->prepare("SELECT `option_name` FROM `{$wpdb->options}` WHERE `option_value` = '%s'", $value)
		);

	elseif( $value == '' )
		return $wpdb->get_var(
			$wpdb->prepare("SELECT `option_value` FROM `{$wpdb->options}` WHERE `option_name` = '%s'", $name)
		);

	else {

		$name 	= esc_html( $name );
		$value 	= esc_html( $value );

		return $wpdb->get_var(
			"SELECT `option_name`
			FROM `{$wpdb->options}`
			WHERE `option_name` LIKE '{$name}%' AND
				`option_value` = '{$value}'"
		);
	}
}
/**
 *	Reser Views and Redirects by All Products
 */
function reset_counts( ) {

	global $wpdb;
	return $wpdb->query(
		$wpdb->prepare(
			"DELETE FROM $wpdb->postmeta
   WHERE meta_key = %s
   OR meta_key = %s",
			'views', 'redirects'
		)
	);

}

/**
*	Count Views by All Products
*/
function ae_total_count_views( ) {

	global $wpdb;

	$var = $wpdb->get_var(
		"SELECT SUM(`meta_value`) as `sum`
		FROM `{$wpdb->postmeta}`
		WHERE `meta_key` = 'views'"
	);

	return empty($var) ? 0 : $var;
}

/**
*	Count Redirects by All Products
*/
function ae_total_count_redirects( ) {

	global $wpdb;

	$var = $wpdb->get_var(
		"SELECT SUM(`meta_value`) as `sum`
		FROM `{$wpdb->postmeta}`
		WHERE `meta_key` = 'redirects'"
	);

	return empty($var) ? 0 : $var;
}

/**
*	Sort and show viewest products
*/
function ae_sort_total_admin( $per ) {

	$posts = get_posts(
		array(
			'post_type' 		=> 'products',
			'posts_per_page' 	=> $per,
			'meta_key'			=> 'views',
			'orderby'   		=> 'meta_value_num',
			'order'      		=> 'DESC'
		)
	);

	return $posts;
}

/**
*	Return the title for archive
*/
function ae_single_cat_title( ) {

	global $wp_query;

	if( is_post_type_archive( 'products' ) )
		_e('Products', 'ae');

	elseif( isset($wp_query->queried_object->name) )
		echo $wp_query->queried_object->name;
}

/**
*	Show category hierarchical
*/
function ae_the_catigories( $args = array(), $taxonomy = 'shopcategory', $class = "", $role = "tablist" ) {

	$defaults = array(
		'show_option_all'    => '',
		'orderby'            => 'name',
		'order'              => 'ASC',
		'style'              => 'list',
		'show_count'         => 0,
		'hide_empty'         => 1,
		'use_desc_for_title' => 1,
		'child_of'           => 0,
		'feed'               => '',
		'feed_type'          => '',
		'feed_image'         => '',
		'exclude'            => '',
		'exclude_tree'       => '',
		'include'            => '',
		'hierarchical'       => 1,
		'title_li'           => '',
		'show_option_none'   => __( 'No categories', 'ae' ),
		'number'             => null,
		'echo'               => 1,
		'depth'              => 0,
		'current_category'   => 0,
		'pad_counts'         => 0,
		'taxonomy'           => $taxonomy,
		'walker'             => null
	);

	$args = wp_parse_args( $args, $defaults );

	echo '<ul class="' . $class . '" role="' . $role . '">';

	wp_list_categories( $args );

	echo '</ul>';
}

/**
*	license admin form
*/
function ae_license_post( ) {

	if( isset($_POST['license_submit']) ) {

		$license = $_POST['licensekey'];

		if( $license != "" ) {

			update_site_option( 'ae-licensekey', $license );

			ae_request( array('key' => $license, 'site' => get_bloginfo('url')) );
		}
	}
}

/**
*	CURL to server
*/
function ae_request( $args = array() ) {

	$api_parameters = ae_array2url( $args );

	if( function_exists('curl_init') ) {

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, "http://alipartnership.com/?rest" );
		curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $api_parameters );

		$response = curl_exec( $ch );
		curl_close( $ch );
	}
	else{
		/* create request */
		$request = "http://alipartnership.com/?rest" . '&' . $api_parameters;
		$response = file_get_contents($request);
	}

	if( !$response ) {
		echo "<div id='message' class='updated below-h2'><p>";

		if( function_exists('curl_init') )
			echo ( __("failed: ", "ae") . curl_error( $ch ) . '(' . curl_errno( $ch ) . ')' );
		else
			_e("failed to connection", "ae");

		echo "</p></div>";
	}
	else {
		$foo = json_decode( $response );
		$msg = $foo->msg;
		if($foo->error == 0)
			update_site_option('ae-license', $response);

		echo "<div id='message' class='updated below-h2'><p>" . $msg . "</p></div>";
	}
}

function type_license( ) {

	$foo = get_site_option( 'ae-license' );

	if( !empty($foo) ) {
		$foo = json_decode($foo);

		if( isset($foo->type) )
			printf( __('License type: %s', 'ae'), $foo->type);
	}
}

/**
 * Get list of status to import Products
 *
 * @return array
 */
function ad_constant_status( ) {
	return array(
		'publish'   => __('Publish', 'ae'),
		'draft'     => __('Draft', 'ae')
	);
}

/**
*	When we delete product
*/
add_action( 'before_delete_post', 'ae_delete_product' );
function ae_delete_product( $post_id ) {

	global $post_type, $wpdb;

	if ( $post_type != 'products' ) return;

	$wpdb->delete( $wpdb->products, array( 'post_id' => $post_id ), array( '%d' ) );

	$wpdb->delete( $wpdb->review, array( 'post_id' => $post_id ), array( '%d' ) );
}

/**
*	When we delete taxonomy
*/
add_action( 'delete_shopcategory', 'ae_delete_category', 3 );
function ae_delete_category( $term, $tt_id = '', $deleted_term = '' ) {

	$term_child  = ae_search_option( 'term_child-', $term );
	$term_parent = ae_search_option( 'term_parent-', $term );

	if( $term_parent )
		delete_site_option( $term_parent );

	if( $term_child )
		delete_site_option( $term_child );
}

/**
*	Handler to open product page
*/
add_action('wp', 'ae_count_views');
function ae_count_views( ) {

	if( !is_singular( 'products' ) ) return;

	global $post;

	$views = get_post_meta($post->ID, 'views', true);
	$views = empty($views) ? 1 : $views + 1;

	update_post_meta($post->ID, 'views', $views);
}

/**
* Handler to redirect by link to aliexpress
*/
add_action('wp', 'ae_redirect_aliexpress');
function ae_redirect_aliexpress() {

	if( !isset($_POST['ali-item-direct']) ) return;

	if( !filter_var($_POST['ali-item-direct'], FILTER_VALIDATE_URL) ) return;

	wp_redirect($_POST['ali-item-direct']);
	exit;
}

/**
*	Handler to click Buy now
*/
add_action('wp', 'ae_click_buy_now');
function ae_click_buy_now( ) {

	if( !isset($_POST['ae_submit']) ) return;

	if( !isset($_POST['product_id']) || $_POST['product_id'] == '' ) return;

	$post_id = intval( $_POST['product_id'] );

	$info = new AEProducts();
	$info->set( $post_id );

	$url = $info->getLink();

	if( !filter_var($url, FILTER_VALIDATE_URL) ) return;

	$redirects = get_post_meta($post_id, 'redirects', true);
	$redirects = empty($redirects) ? 1 : $redirects + 1;

	update_post_meta($post_id, 'redirects', $redirects);

	wp_redirect( $url );
	exit;
}

function ae_updparam(){
	return array( 'api_url' => 'http://alipartnership.com/?plugins_upd', 'plugin_slug' => 'aliplugin' );
}

/**
*	Take over the update check
*/
add_filter('pre_set_site_transient_update_plugins', 'ae_check_plugin_update');
function ae_check_plugin_update( $checked_data ) {

	global $wp_version;

	$foo 			= ae_updparam();
	$api_url 		= $foo['api_url'];
	$plugin_slug 	= $foo['plugin_slug'];

	//Comment out these two lines during testing.
	if ( empty($checked_data->checked) )
		return $checked_data;

	$args = array(
		'slug' 		=> $plugin_slug,
		'version' 	=> $checked_data->checked[$plugin_slug .'/'. $plugin_slug .'.php'],
		'key' 		=> get_site_option( 'ae-licensekey' ),
		'site' 		=> get_bloginfo( 'url' )
	);

	$request_string = array(

		'body' => array(
			'action' 	=> 'basic_check',
			'request' 	=> serialize( $args ),
			'api-key' 	=> md5( get_bloginfo('url') )
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
	);

	// Start checking for an update
	$raw_response = wp_remote_post( $api_url, $request_string );

	if ( !is_wp_error($raw_response) && ($raw_response['response']['code'] == 200) ){
		//pr($raw_response);
		$response = unserialize($raw_response['body']);
	}

	if ( isset($response) && is_object($response) && !empty($response) )
		$checked_data->response[$plugin_slug .'/'. $plugin_slug .'.php'] = $response;

	return $checked_data;
}

/**
*	Take over the Plugin info screen
*/
add_filter('plugins_api', 'ae_plugin_api_call', 10, 3);
function ae_plugin_api_call( $def, $action, $args ) {

	global $wp_version;

	$foo 			= ae_updparam();
	$api_url 		= $foo['api_url'];
	$plugin_slug 	= $foo['plugin_slug'];

	if ( !isset($args->slug) || ($args->slug != $plugin_slug) ) return false;

	// Get the current version
	$plugin_info 		= get_site_transient('update_plugins');
	$current_version 	= $plugin_info->checked[$plugin_slug .'/'. $plugin_slug .'.php'];
	$args->version 		= $current_version;
	$args->key 			= get_site_option( 'ae-licensekey' );
	$args->site 		= get_bloginfo( 'url' );

	$request_string = array(
		'body' => array(
			'action' 	=> $action,
			'request' 	=> serialize( $args ),
			'api-key' 	=> md5( get_bloginfo('url') )
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
	);

	$request = wp_remote_post( $api_url, $request_string );

	if ( is_wp_error($request) ) {
		$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>', 'ae'), $request->get_error_message());

	}
	else {

		$res = unserialize($request['body']);

		if ($res === false)
			$res = new WP_Error('plugins_api_failed', __('An unknown error occurred', 'ae'), $request['body']);
	}

	return $res;
}


/**
*	Converter currency gy google
*/
function ae_convertCurrency( $amount = 1, $from = 'USD', $to ) {

	$url  = "https://www.google.com/finance/converter?a=" . $amount . "&from=" . $from . "&to=" . $to;

	$obj = new AliExpressJSONAPI2();
	$data = $obj->request_data($url);

	if( $data === false )
		return false;

	preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);

	$converted = preg_replace("/[^0-9.]/", "", $converted[1]);

	$converted = round($converted, 2);

	return $converted;
}

/**
*	Currency Codes
*/
function ae_currency_codes( ) {

	$too = array(
		'AUD' => __('Australian Dollar (A$)', 'ae'),
		'BRL' => __('Brazilian Real (R$)', 'ae'),
		'BGN' => __('Bulgarian lev (BGN)', 'ae'),
		'CAD' => __('Canadian Dollar (CA$)', 'ae'),
		'CNY' => __('Chinese Yuan (CN¥)', 'ae'),
		'CZK' => __('Czech Republic Koruna (CZK)', 'ae'),
		'EUR' => __('Euro (€)', 'ae'),
		'IDR' => __('Indonesian rupiah (Rp)', 'ae'),
		'ILS' => __('Israeli New Sheqel (₪)', 'ae'),
		'INR' => __('Indian Rupee (₹)', 'ae'),
		'GBP' => __('British Pound Sterling (£)', 'ae'),
		'NGN' => __('Nigerian naira (₦)', 'ae'),
		'NZD' => __('New Zealand dollar (NZ$)', 'ae'),
		'NOK' => __('Norwegian Krone (NOK)', 'ae'),
		'MYR' => __('Malaysian Ringgit (MYR)', 'ae'),
		'MXN' => __('Peso mexicano (MXN)', 'ae'),
		'PHP' => __('Philippine peso (₱)', 'ae'),
		'PLN' => __('Polish Zloty (PLN)', 'ae'),
		'RUB' => __('Russian Ruble (RUB)', 'ae'),
		'SAR' => __('Saudi Riyal (SAR)', 'ae'),
		'THB' => __('Thailand Baht (THB)', 'ae'),
		'KRW' => __('South Korean Won (₩)', 'ae'),
		'AED' => __('United Arab Emirates Dirham (AED)', 'ae'),
		'USD' => __('US Dollar ($)', 'ae'),
		'ZAR' => __('South African Rand (ZAR)', 'ae'),
	);

	asort($too);

	return $too;
}

/**
*	Get current currency value
*/
function ae_get_currency( ) {

	$args = get_site_option('ae-currency');
	$args = ( !$args ) ? false : unserialize($args);

	if(
		!isset($args['currency']) || !isset($args['value']) || !isset($args['enabled']) ||
		empty($args['currency']) || empty($args['value']) || $args['enabled'] == 0
	) return false;

	$currency 	= $args['currency'];
	$round		= empty($args['round']) ? 0 : $args['round'];
	$foo = ae_currency_codes();

	if( !isset($foo[$currency]) )
		return false;

	if ( !defined('AE_CV') ) define( 'AE_CV', $args['value'] );
	if ( !defined('AE_RD') ) define( 'AE_RD', $round );

	return $currency;
}

/**
* Get currency symbol
*/
function ae_get_currency_symbol( $cur ) {

	$foo = array(
		'AED' => array( 'symbol' => 'AED', 'pos' => 'before' ),
		'AUD' => array( 'symbol' => 'A$', 'pos' => 'before' ),
		'BGN' => array( 'symbol' => 'BGN', 'pos' =>'after'),
		'BRL' => array( 'symbol' => 'R$', 'pos' => 'before' ),
		'CAD' => array( 'symbol' => 'CA$', 'pos' => 'before' ),
		'CNY' => array( 'symbol' => '¥', 'pos' => 'after' ),
		'CZK' => array( 'symbol' => 'Kč', 'pos' => 'after' ),
		'EUR' => array( 'symbol' => '€', 'pos' => 'after' ),
		'MXN' => array( 'symbol' => 'MXN', 'pos' => 'after' ),
		'IDR' => array( 'symbol' => 'Rp', 'pos' => 'after' ),
		'ILS' => array( 'symbol' => '₪', 'pos' => 'after' ),
		'INR' => array( 'symbol' => '₹', 'pos' => 'after' ),
		'GBP' => array( 'symbol' => '£', 'pos' => 'before' ),
		'NGN' => array( 'symbol' => '₦', 'pos' => 'after' ),
		'NZD' => array( 'symbol' => 'NZ$', 'pos' => 'after' ),
		'NOK' => array( 'symbol' => 'kr', 'pos' => 'after' ),
		'MYR' => array( 'symbol' => 'RM', 'pos' => 'before' ),
		'PHP' => array( 'symbol' => '₱', 'pos' => 'before' ),
		'PLN' => array( 'symbol' => 'zl', 'pos' => 'after' ),
		'RUB' => array( 'symbol' => 'руб.', 'pos' => 'after' ),
		'SAR' => array( 'symbol' => 'SR', 'pos' => 'after' ),
		'THB' => array( 'symbol' => '฿', 'pos' => 'after' ),
		'KRW' => array( 'symbol' => '₩', 'pos' => 'before' ),
		'USD' => array( 'symbol' => '$', 'pos' => 'before' ),
		'ZAR' => array( 'symbol' => 'R', 'pos' => 'before' ),
	);

	if( isset($foo[$cur]) ) return $foo[$cur];

	return $cur;
}

/**
*	Convert currency
*/
function ae_get_price( $price, $output = true ) {

	if( !AE_CUR ) return $price;

	$foo = ae_get_currency_symbol( AE_CUR );

	if( !is_array($foo) ) return $price;

	$price = preg_replace("/[^0-9,.]/", "", $price);
	$price	= ae_floatvalue($price);

	$to = (AE_RD == 1) ? 0 : 2;

	$price	= round( $price*AE_CV, $to );

	if( $output )
		return ( $foo['pos'] == 'before' ) ?
			$foo['symbol'] . " " . $price :
			$price . ' ' . $foo['symbol'];

	return $price;
}

/**
*	Default price
*/
function ae_get_default_price( $price, $symbol = true ) {

	if( !AE_CUR ) return $price;

	$foo = ae_get_currency_symbol( AE_CUR );

	if( !is_array($foo) ) return $price;

	$price 	= preg_replace("/[^0-9,.]/", "", $price);
	$price 	= ae_floatvalue($price);

	$to 	= (AE_RD == 1) ? 0 : 2;

	$price	= round( $price/AE_CV, $to );

	if( $symbol )
		return ( $foo['pos'] == 'before' ) ?
			$foo['symbol'] . " " . $price :
			$price . ' ' . $foo['symbol'];
	else
		return $price;
}

/**
*	Set max price
*/
function ae_set_max_price( ) {
	global $wpdb;

	$var = $wpdb->get_var("SELECT MAX( CAST( SUBSTRING_INDEX(`price`, '$', -1) AS DECIMAL(10, 2) ) ) FROM `{$wpdb->prefix}ae_products`");

	if( !empty($var) )
		update_site_option( 'ae-max-price', $var );
}

/**
 * List languages
 * @return bool
 */
function ae_list_lang() {

	return array(
		'en' => __('English', 'ae'),
		'ar' => __('Arabic', 'ae'),
		'de' => __('German', 'ae'),
		'es' => __('Spanish', 'ae'),
		'fr' => __('French', 'ae'),
		'it' => __('Italian', 'ae'),
		'id' => __('Bahasa Indonesia', 'ae'),
		'ja' => __('Japanese', 'ae'),
		'ko' => __('Korean', 'ae'),
		'nl' => __('Netherlandish', 'ae'),
		'pt' => __('Portuguese (Brasil)', 'ae'),
		'ru' => __('Russian', 'ae'),
		'th' => __('Thai', 'ae'),
		'tr' => __('Turkish', 'ae'),
		'vi' => __('Vietnamese', 'ae'),
		'he' => __('Hebrew', 'ae')		
	);
}

/**
 * Get current language
 * @return bool|mixed|string
 */
function ae_get_lang( ) {

	$foo = ae_list_lang();

	$lang = get_site_option('ae-language');
	$lang = ( $lang  && isset($foo[$lang]) ) ? $lang : 'en';

	if( $lang == 'en' ) return 'en';

	return $lang;
}

/**
 * Get picture by post or page
 * @param $post_id
 * @param string $size
 * @return mixed
 */
function aeGetThumb( $post_id, $size = 'thumbnail' ) {

	if( !has_post_thumbnail($post_id) ) {

		$args = array(
			'post_type' => 'attachment',
			'numberposts' => 1,
			'post_status' => null,
			'post_parent' => $post_id
		);

		$attachments = get_posts( $args );

		if ( $attachments ) {

			$img = wp_get_attachment_image_src( $attachments[0]->ID, $size, false );

			return $img[0];
		}
	}
	else {
		$thumb_id = get_post_thumbnail_id( $post_id );
		$url = wp_get_attachment_image_src( $thumb_id, $size );

		return $url[0];
	}
}

/**
 * @param $text
 * @return mixed|string|void
 */
function ae_get_post_excerpt( $text ) {

	$text = strip_shortcodes( $text );
	$text = apply_filters( 'the_content', $text );
	$text = str_replace( ']]>', ']]>', $text );

	$excerpt_length = apply_filters( 'excerpt_length', 55 );
	$text           = wp_trim_words( $text, $excerpt_length, ' ...' );
	return $text;
}

/**
 * Get image from product
 * @param $original
 * @param string $size
 * @return bool|string
 * @todo допилить проверку на наличие у записи миниатюры, если нет, юрать ту что у али
 */
function ae_get_thumb_ali( $original, $size = '') {

	if( $original == '' )
		return false;

	return ae_get_size_img( $original, $size );
}

/**
 * List Image Size
 * @param $url
 * @param string $size
 * @return string
 */
function ae_get_size_img( $url, $size = 'medium' ) {

	$foo = array(
		'thumb' 	=> '_50x50.jpg',
		'medium' 	=> '_220x220.jpg',
		'large' 	=> '_350x350.jpg'
	);

	if( !isset( $foo[$size] ) ) return $url;

	return $url . $foo[$size];
}



/**
 * Count Products by All Products
 * @return int
 */
function ae_total_count_products( ) {

	global $wpdb;

	$var = $wpdb->get_var( "SELECT count(`id`) as `con` FROM `{$wpdb->products}` WHERE `post_id` <> 0" );

	return empty($var) ? 0 : $var;
}

/**
 * Count Reviews by All Products
 * @return int
 */
function ae_total_count_reviews( ) {

	global $wpdb;

	$var = $wpdb->get_var( "SELECT sum(`countReview`) as `con` FROM `{$wpdb->products}`" );

	return empty($var) ? 0 : $var;
}
/**
 * Get list Reviews by ID
 *
 * @param $post_id
 * @return bool|mixed
 */
function ae_Review( $post_id ) {

    require( dirname(__FILE__) . '/class.AliExpress.Review.php' );


    $obj = new Review();

    return $obj->listReviews( $post_id );
}
/**
 * Get reviews star
 *
 * @param $post_id
 * @return bool|mixed
 */
function ae_getStat( $arrayOfObjs ) {

    $stat = array(
        'positive' => 0,
        'neutral' => 0,
        'negative' => 0,
        'stars' => array(
            '1' => array('count' => 0, 'percent' => 0 ),
            '2' => array('count' => 0, 'percent' => 0 ),
            '3' => array('count' => 0, 'percent' => 0 ),
            '4' => array('count' => 0, 'percent' => 0 ),
            '5' => array('count' => 0, 'percent' => 0 ),
            )
    );

    if( !$arrayOfObjs || empty($arrayOfObjs) )
        return $stat;

    $count = 0;
    foreach( $arrayOfObjs as $review ){
        if((int)$review->star > 0){
            $stat['stars'][(int)$review->star]['count']++;
            $count++;
        }

    }

    foreach($stat['stars'] as $key => $value)
        $stat['stars'][$key]['percent'] =  round( $value['count'] / $count * 100, 1);

    $stat['positive'] = round( ($stat['stars'][4]['percent'] + $stat['stars'][5]['percent']), 1);
    $stat['neutral'] = round( ($stat['stars'][3]['percent']), 1);
    $stat['negative'] = round( ($stat['stars'][1]['percent'] + $stat['stars'][2]['percent']), 1);

    return $stat;
}
	
function ae_averageStar( $arrayOfObjs ) {

    if( !$arrayOfObjs || empty($arrayOfObjs) )
        return array(0,0);

    $star = array();
    $count= 0;

    foreach( $arrayOfObjs as $review ){
        if($review->star > 0){
            $star[]= $review->star;
            $count++;

            }
    }

    $average = round( array_sum($star)/$count , 1);

    return array($average, $count);
}

function ae_renderStarRating( $rating ) {

    $full_stars = floor( $rating );
    $half_stars = ceil( $rating - $full_stars );
    $empty_stars = 5 - $full_stars - $half_stars;

    echo str_repeat( '<span class="b-social-icon dib b-social-icon-star"></span>', $full_stars );
    echo str_repeat( '<span class="b-social-icon dib b-social-icon-star"></span>', $half_stars );
    echo str_repeat( '<span class="b-social-icon dib b-social-icon-star-empty"></span>', $empty_stars);
}
/*
Sheduled Review 
*/
function ae_schedule_review( $pos, $count, $count_settings, $star) {

    global $wpdb;

    $results = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM `{$wpdb->products}` WHERE `post_id` <> 0 LIMIT %d, %d", $pos, $count)
    );

	if( !$results ) {
        return false;
    }

	require_once( dirname( __FILE__ ) . '/class.AliExpress.Review.php' );
	include_once __DIR__ . '/../libs/translate/GoogleTranslate.php';
	require_once( dirname( __FILE__ ) . '/request.php' );

	foreach( $results as $row ) {

		ae_set_review_by_product( $row, $count_settings, $star );
	}
}

function ae_set_review_by_product( $row, $count_settings, $star ) {

	global $wpdb;

	$translate = new GoogleTranslate();
	$translate->setFromLang('')->setToLang(AE_LANG);

	$obj = new Review($row->productId);
	$obj->setNewParams();
	$obj->setPage(1);
	$data = $obj->getReviews();

	if( !$data ) {

		return false;
	}

	foreach( $data as $key => $val ) {

		if( !ae_check_exists_review( $row->post_id, $val ) && $val['star'] >= $star ) {

			$feedback = !empty($val['feedback']) ? $translate->translate($val['feedback']) : '';

			$wpdb->insert(
				$wpdb->review,
				array(
					'post_id'   => $row->post_id,
					'name'      => $val['name'],
					'feedback'  => $feedback,
					'date'      => $val['date'],
					'flag'      => $val['flag'],
					'star'      => $val['star']
				),
				array(
					'%d', '%s', '%s', '%s', '%s', '%f'
				)
			);
		}
		$result = $wpdb->get_results($wpdb->prepare("SELECT count(`id`) as `con` FROM `{$wpdb->review}` WHERE `post_id`=%d", $row->post_id));
		$result = current($result);
		$current_count = $result->con;
		if( $current_count > $count_settings){
			$count_settings_corrective = $current_count - $count_settings;
			$wpdb->get_results($wpdb->prepare("DELETE FROM `{$wpdb->review}` WHERE `post_id`=%d ORDER BY `id` ASC LIMIT %d", $row->post_id, $count_settings_corrective));
		}
	}
}
/**
 * Validate is URL
 * @param $url
 * @return int
 */
function ae_is_url($url) {
    return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

