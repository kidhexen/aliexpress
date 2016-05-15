<?php
	
/**
* Add menu items to admin_menu
*/
add_action('admin_menu', 'ae_admin_menu');

function ae_admin_menu( ) {

    if ( function_exists('add_menu_page') ) {
        add_menu_page( __( 'AliPlugin', 'ae' ), __( 'AliPlugin', 'ae' ), 'activate_plugins', 'aliplugin', 'ae_admin_index_form', plugins_url( 'aliplugin/img/logo.png') );
        //if( ae_check_db_fields() > 0)
        //   add_menu_page( __( 'AliPlugin Check', 'ae' ), __( 'AliPlugin Check', 'ae' ), 'activate_plugins', 'alimigrate', 'ae_admin_migrate_ali', plugins_url( 'aliplugin/img/database.png') );
    }
}

function ae_admin_index_form( ) {
    $obj = new AliExpressSettings();

    try {
        $obj->getTemplate();
    }
    catch( Exception $e ) { }
}

function ae_admin_migrate_ali( ) {

    ?>
        <h2><span class="fa fa-database"></span> <?php _e('AliPlugin Migrate', 'ae') ?></h2>
        <div class="description"><?php _e('For proper operation of the plugin necessary to make changes to the database.', 'ae') ?></div>
        <form action="" method="POST">

            <?php wp_nonce_field( 'ae_migrate_action', 'ae_migrate' ); ?>
            <div class="item-group">
                <?php _e('Number of necessary changes', 'ae') ?>: <?php echo ae_check_db_fields() ?>
            </div>
            <div class="item-group">
                <button class="btn orange-bg" name="migrate_submit"><span class="fa fa-database"></span> <?php _e('Amend', 'ae')?></button>
            </div>
        </form>
    <?php

}

?>