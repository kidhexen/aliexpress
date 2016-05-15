<?php

add_action('init', 'ae_init_db');

function ae_init_db() {

    global $wpdb;

    $wpdb->products     = $wpdb->prefix . "ae_products";
    $wpdb->review       = $wpdb->prefix . "product_review";
}

/**
* Setup the plugin
*/
function ae_install( ) {

	global $wpdb;

	if ( !empty( $wpdb->charset) )
		$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";

	require( dirname( __FILE__ ) . '/sql.php' );
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	foreach($sql as $key)
		dbDelta($key);

	ae_upgrade_sql();

	update_site_option( 'ae-version', AE_VERSION  );

	$foo = array(
		'ae-scheduled' 		=> serialize( array() ),
		'ae-autoupdate'		=> serialize( array() ),
		'ae-auto-current'	=> 0,
		'ae-licensekey'		=> '',
		'ae-currency'		=> serialize( array() ),
		'ae-language'		=> 'en',
		'ae-license'		=> '',
		'ae-delete'		    => 0,
		'ae-method'			=> 'file',
		'ae-max-price'		=> '100',
		'ae-hotdeal'		=> '0',
		'ae-todaysdeal'		=> '0',
		'ae-alibaba'		=> '0',
		'ae-alibaba_href'	=> '',


	);

	foreach( $foo as $key => $str )
		if ( !get_site_option( $key ) )
			update_site_option( $key, $str );

	do_action('ae_switch');
}

add_action('ae_switch', 'ae_switch_theme');
function ae_switch_theme( ) {

	if ( !get_site_option( 'ae_activate_theme' ) ) {
		update_site_option('ae_activate_theme', 1);
		switch_theme('AL1');
	}
}

/**
* Uninstall plugin
*/
function ae_uninstall( ) {
	delete_site_option('ae_activate_theme');
}

add_action( 'admin_menu', 'ae_installed' );
function ae_installed( ){

	if ( !current_user_can('install_plugins') ) return;

	if ( get_site_option( 'ae-version' ) < AE_VERSION )
		ae_install( );
}

function ae_upgrade_sql( ) {

	global $wpdb;

	maybe_add_column($wpdb->prefix . 'ae_products', 'owncat', "ALTER TABLE `{$wpdb->prefix}ae_products` ADD `owncat` INT(1) NOT NULL;");
	maybe_add_column($wpdb->prefix . 'ae_products', 'validTime', "ALTER TABLE `{$wpdb->prefix}ae_products` ADD `validTime` DATETIME NOT NULL;");
	maybe_add_column($wpdb->prefix . 'ae_products', 'productUrl', "ALTER TABLE `{$wpdb->prefix}ae_products` ADD `productUrl` TEXT NOT NULL;");
	maybe_add_column($wpdb->prefix . 'ae_products', 'evaluateScore', "ALTER TABLE `{$wpdb->prefix}ae_products` ADD `evaluateScore` DECIMAL(2,1) NOT NULL;");
	maybe_add_column($wpdb->prefix . 'ae_products', 'storeName', "ALTER TABLE `{$wpdb->prefix}ae_products` ADD `storeName` VARCHAR(255) NOT NULL;");
	maybe_add_column($wpdb->prefix . 'ae_products', 'storeUrl', "ALTER TABLE `{$wpdb->prefix}ae_products` ADD `storeUrl` TEXT NOT NULL;");
	maybe_add_column($wpdb->prefix . 'ae_products', 'storeUrlAff', "ALTER TABLE `{$wpdb->prefix}ae_products` ADD `storeUrlAff` TEXT NOT NULL;");
	maybe_add_column($wpdb->prefix . 'ae_products', 'countReview', "ALTER TABLE `{$wpdb->prefix}ae_products` ADD `countReview` INT(11) NOT NULL;");
	maybe_add_column($wpdb->prefix . 'ae_products', 'sku', "ALTER TABLE `{$wpdb->prefix}ae_products` ADD `sku` TEXT NOT NULL;");
	maybe_add_column($wpdb->prefix . 'ae_products', 'pack', "ALTER TABLE `{$wpdb->prefix}ae_products` ADD `pack` TEXT NOT NULL;");
	maybe_add_column($wpdb->prefix . 'ae_products', 'quantity', "ALTER TABLE `{$wpdb->prefix}ae_products` ADD `quantity` INT(11) unsigned NOT NULL;");
	maybe_add_column($wpdb->prefix . 'ae_products', 'timeleft', "ALTER TABLE `{$wpdb->prefix}ae_products` ADD `timeleft` INT(11) unsigned NOT NULL;");

	$foo = array('productId', 'post_id');
	$too = array();
	$res = $wpdb->get_results("SHOW INDEXES FROM `{$wpdb->prefix}ae_products`");

	if($res) foreach( $res as $r ){
		$too[] = $r->Column_name;
	}

	$result = array_diff ($foo, $too);

	if( count($result) > 0 ){

		foreach($result as $key => $val)
			$wpdb->query("ALTER TABLE `{$wpdb->prefix}ae_products` ADD INDEX `{$val}` (`{$val}`)");
	}
}

function ae_get_lic( ) {

	$foo = get_site_option( 'ae-license' );

	$foo = json_decode( $foo );

	if(	isset($foo->error) && $foo->error == 0 &&
		isset($foo->status) && $foo->status == "valid" )
		return true;

	else
		return false;
}

function ae_activate( ) {

	ae_installed();

	do_action( 'ae_activate' );
}

function ae_deactivate( ) {

	do_action( 'ae_deactivate' );
}

/**
*	Check current template type. Default or Not
*/
//add_action('init', 'ae_template_type');
function ae_template_type( ) {

	$tmpl = get_site_option( 'ae-appearance' );

	$tmpl = ( !empty($tmpl) && $tmpl == 1 ) ? 1 : 0;

	if ( !defined('AE_TMPL') ) define( 'AE_TMPL', $tmpl );
}

/**
 * Get fields from schema
 * @return mixed
 */
function ae_get_db_fields( ) {

    global $wpdb;

    return $wpdb->get_results(
        $wpdb->prepare(
            "SELECT `DATA_TYPE`, `CHARACTER_MAXIMUM_LENGTH`, `COLUMN_NAME`
                  FROM `information_schema`.`COLUMNS`
                  WHERE `TABLE_SCHEMA` = '%s'
                  AND `TABLE_NAME` = '{$wpdb->products}'",
            DB_NAME
        )
    );
}

/**
 * Check count fields which need to update
 * @return int
 */
function ae_check_db_fields( ) {

    $count = 0;
    $cols = ae_get_db_fields();
    $foo = ae_db_queries();
    if( $cols ){
        foreach($cols as $col) {

            if( isset($foo[$col->COLUMN_NAME]) ) {

                if(
                    $col->DATA_TYPE != $foo[$col->COLUMN_NAME]['type'] ||
                    $col->CHARACTER_MAXIMUM_LENGTH < $foo[$col->COLUMN_NAME]['numb']
                ) {
                    $count++;
                }
            }
        }
    }

    return $count;
}

/**
 * Update fields
 * @return bool
 */
function ae_update_db_fields( ) {

    global $wpdb;

    $cols = ae_get_db_fields();
    $foo = ae_db_queries();
    if( $cols ){
        foreach($cols as $col) {

            if( isset($foo[$col->COLUMN_NAME]) ) {

                if(
                    $col->DATA_TYPE != $foo[$col->COLUMN_NAME]['type'] ||
                    $col->CHARACTER_MAXIMUM_LENGTH < $foo[$col->COLUMN_NAME]['numb']
                ) {
                    $wpdb->query($foo[$col->COLUMN_NAME]['query']);
                }
            }
        }
    }

    return true;
}

/**
 * Constant queries
 * @return array
 */
function ae_db_queries( ) {

    global $wpdb;
    return array(
        'price' => array(
            'query' => "ALTER TABLE  `{$wpdb->products}` CHANGE  `price`  `price` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL",
            'type'  => "varchar",
            'numb'  => 40,
        ),
        'salePrice' => array(
            'query' => "ALTER TABLE  `{$wpdb->products}` CHANGE  `salePrice`  `salePrice` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL",
            'type'  => "varchar",
            'numb'  => 40,
        ),
    );
}

/**
 * Change fields
 */
function ae_set_db_changes( ) {

    if ( isset( $_POST['ae_migrate'] ) && wp_verify_nonce( $_POST['ae_migrate'], 'ae_migrate_action' ) ){

        ae_update_db_fields( );

        wp_redirect( admin_url( 'admin.php?page=aliplugin' ) );

        die();
    }
}
add_action('admin_init', 'ae_set_db_changes');