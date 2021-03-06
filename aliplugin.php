<?php
	/**
	*	Plugin Name: AliPlugin
	*	Plugin URI: http://alipartnership.com/
	*	Description: AliPlugin is a WordPress plugin created for AliExpress Affiliate Program
	*	Version: 2.9.6
	*	Text Domain: ae
	*	Domain Path: /lang
	*	Requires at least: WP 4.3.1
	*	Author: Vitaly Kukin & Yaroslav Nevskiy
	*	Author URI: http://yellowduck.me/
	*	License: SHAREWARE
	*/
	
	/**
	*	Version of the plugin
	*/
	if ( !defined('AE_VERSION') ) define( 'AE_VERSION', '2.9.6' );
	if ( !defined('AE_PATH') ) define( 'AE_PATH', plugin_dir_path( __FILE__ ) );
	
	register_theme_directory( AE_PATH . 'templates' );
	
	require( dirname( __FILE__ ) . '/libs/Requests/Requests.php' );
	Requests::register_autoloader();
	
	require( dirname( __FILE__ ) . '/core/setup.php' );
	require( dirname( __FILE__ ) . '/core/class.AliExpress.Request2.php' );
	require( dirname( __FILE__ ) . '/core/class.AliExpress.AdminTpl.php' );
	require( dirname( __FILE__ ) . '/core/class.AliExpress.Settings.php' );
	require( dirname( __FILE__ ) . '/core/class.AliExpress.insertAPI.php' );
	require( dirname( __FILE__ ) . '/core/class.AliExpress.Publication.php' );
	require( dirname( __FILE__ ) . '/core/class.Products.php' );
	require( dirname( __FILE__ ) . '/core/shortcodes.php' );
	require( dirname( __FILE__ ) . '/core/core.php' );
	require( dirname( __FILE__ ) . '/core/cron.php' );
	require( dirname( __FILE__ ) . '/core/init.php' );
	
	if( is_admin() ) :
		require( dirname( __FILE__ ) . '/core/request.php' );
	else :
		require( dirname( __FILE__ ) . '/core/openGraphProtocol.php' );
	endif;
	
	require( dirname( __FILE__ ) . '/core/menu.php' );
	
	register_activation_hook( __FILE__, 'ae_install' );
	register_uninstall_hook( __FILE__, 'ae_uninstall' );
	register_activation_hook( __FILE__, 'ae_activate' );

	if ( !defined('AE_METHOD') ) define( 'AE_METHOD', ae_request_method() );
    if ( !defined('AE_CUR') ) define( 'AE_CUR', ae_get_currency() );
    if ( !defined('AE_LANG') ) define( 'AE_LANG', ae_get_lang() );