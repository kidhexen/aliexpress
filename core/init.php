<?php

/**
*	Initialization the custom post type
*/
add_action( 'init', 'ae_init' );
function ae_init( ) {

	if( !ae_get_lic() ) return;

	// describe the type of content
	$args = array(
			'labels' => array(
					'name' 					=> __('Products', 'ae'),
					'singular_name' 		=> __('Item', 'ae'),
					'add_new' 				=> __('Add new', 'ae'),
					'add_new_item' 			=> __('Add a new Item', 'ae'),
					'edit_item' 			=> __('Edit Item', 'ae'),
					'new_item' 				=> __('New Item', 'ae'),
					'all_items' 			=> __('All Items', 'ae'),
					'view_item' 			=> __('View', 'ae'),
					'search_items' 			=> __('Search', 'ae'),
					'not_found' 			=> __('Products not found', 'ae'),
					'not_found_in_trash' 	=> __('Trash is empty', 'ae'),
					'parent_item_colon' 	=> '',
					'menu_name' 			=> __('Products', 'ae')),

			'singular_label'		=> __('Item', 'ae'),
			'public' 				=> true,
			'publicly_queryable'	=> true,
			'show_ui' 				=> true,
			'show_in_menu' 			=> true,
			'query_var'				=> true,
			'rewrite'				=> array( 'slug' => 'products', 'with_front' => false),
			'capability_type'		=> 'post',
			'has_archive'			=> true,
			'hierarchical'			=> false,
			'menu_icon'				=> plugins_url( 'aliplugin/img/shop.png'),
			'supports'				=> array('title', 'editor', 'thumbnail', 'comments'),
		);

	register_post_type( 'products' , $args );

	register_taxonomy( 'shopcategory', array( 'products' ),
		array (

			'labels' => array(
						'name' 				=> __('Categories', 'ae'),
						'singular_name' 	=> __('Category', 'ae'),
						'search_items' 		=> __('Search', 'ae'),
						'all_items' 		=> __('All categories', 'ae'),
						'parent_item' 		=> __('Parent category', 'ae'),
						'parent_item_colon' => __('Parent category: ', 'ae'),
						'edit_item' 		=> __('Edit category', 'ae'),
						'update_item' 		=> __('Update category', 'ae'),
						'add_new_item' 		=> __('Add a new category', 'ae'),
						'new_item_name' 	=> __('The new name of the category', 'ae'),
						'menu_name' 		=> __('Categories', 'ae')
					),
			'public' 			=> true,
			'show_in_nav_menus' => true,
			'hierarchical' 		=> true,
			'show_ui' 			=> true,
			'query_var' 		=> true,
			'rewrite' 			=> array( 'slug' => 'shopcategory' ),
		)
	);
}

//fix a bag in custom terms from WP
add_action( 'init', 'ae_fix_terms_bug' );
function ae_fix_terms_bug( ) {

	if( is_admin() && ae_get_lic() ) {

		$val = get_site_option("shopcategory_children");

		if( $val && !empty($val) )
			delete_option("shopcategory_children");
	}
}

/**
*	add filter to ensure the text Product, or product, is displayed when user updates a product
*/
add_filter( 'post_updated_messages', 'ae_updated_messages' );
function ae_updated_messages( $messages ) {

	global $post, $post_ID;

	$messages['products'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Product updated. <a href="%s">View product</a>', 'ae'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.', 'ae'),
		3 => __('Custom field deleted.', 'ae'),
		4 => __('Product updated.', 'ae'),
		5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s', 'ae'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Product published. <a href="%s">View product</a>', 'ae'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Product saved.', 'ae'),
		8 => sprintf( __('Product submitted. <a target="_blank" href="%s">Preview product</a>', 'ae'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Product scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview product</a>', 'ae'),
		  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Product draft updated. <a target="_blank" href="%s">Preview product</a>', 'ae'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);

	return $messages;
}


function ae_add_meta_box() {

	$post_types = get_post_types( array( 'public' => true ) );

	if ( is_array( $post_types ) ) {
		foreach ( $post_types as $post_type ) {

			if( $post_type != 'products' )
				add_meta_box(
					'ae_seo_metadata',
					__( 'SEO Metadata', 'ae' ),
					'ae_options_meta',
					$post_type,
					'normal',
					'high'
				);
		}
	}
}

function ae_options_meta( ) {

	global $post;

	$description 	= get_post_meta($post->ID, 'description', true);
	$keywords 		= get_post_meta($post->ID, 'keywords', true);
	$noindex		= get_post_meta($post->ID, 'noindex', true);
	$seotitle		= get_post_meta($post->ID, 'seo-title', true);
	$special		= get_post_meta($post->ID, 'special', true);

	?>
	<input type="hidden" name="ae_noncename_aeseo" id="ae_noncename_aeseo" value="<?php echo wp_create_nonce( 'ae_noncename_aeseo' ); ?>" />
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row">
					<label for="seo-title"><?php _e('SEO Title', 'ae') ?>:</label>
				</th>
				<td>
					<input id="seo-title" type="text" value="<?php echo $seotitle ?>" name="seo-title" class="large-text"/>
					<p class="description"><?php _e('Example: Samsung Galaxy Tab 10.1 GT', 'ae') ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="description"><?php _e('SEO Description', 'ae') ?>:</label>
				</th>
				<td>
					<textarea id="description" class="large-text code" name="description"><?php echo $description ?></textarea>
					<p class="description"><?php _e('Example: World Map PU Leather Hard Stand Case For Samsung Galaxy Tab 10.1 GT P7500 P7510 Free Shipping', 'ae') ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="keywords"><?php _e('SEO Keywords', 'ae') ?>:</label>
				</th>
				<td>
					<input id="keywords" type="text" value="<?php echo $keywords ?>" name="keywords" class="large-text"/>
					<p class="description"><?php _e('Example: screen protector', 'ae') ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="noindex"><?php _e('Noindex', 'ae') ?>:</label>
				</th>
				<td>
					<fieldset>
						<label for="noindex">
							<input id="noindex" type="checkbox" value="1" name="noindex" <?php echo ( !empty($noindex) ) ? 'checked="checked"' : '' ?>/> <?php _e("Enable noindex", 'ae') ?>
						</label>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="special"><?php _e('Specials', 'ae') ?>:</label>
				</th>
				<td>
					<fieldset>
						<label for="special">
							<input id="special" type="checkbox" value="1" name="special" <?php echo ( !empty($special) ) ? 'checked="checked"' : '' ?>/> <?php _e("Enable special", 'ae') ?>
						</label>
					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
}

// add a hook to initialize the block when adding products
add_action( "admin_init", 'ae_admin_init' );
function ae_admin_init( ) {

	add_meta_box( "ae", __('Products Option', 'ae'), 'ae_options', 'products', 'normal', 'high' );
	ae_add_meta_box();
}

function ae_options(){

	global $post;

	$edited = get_post_meta($post->ID, 'ae_can_edit', true);
	$edited = ( empty($edited) || $edited == 'can' ) ? true : false;

	$etitle = get_post_meta($post->ID, 'ae_can_edit_title', true);
	$etitle = ( empty($edited) || $edited == 'can' ) ? true : false;

	$noindex = get_post_meta($post->ID, 'ae_noindex', true);
	$noindex = ( !empty($noindex) && $noindex == '1' ) ? true : false;

	$special = get_post_meta($post->ID, 'ae_special', true);
	$special = ( !empty($special) && $special == '1' ) ? true : false;
	
	$seotitle = get_post_meta($post->ID, 'ae_seo-title', true);

	$info = new AEProducts();
	$info->set($post->ID);


	?>
		<input type="hidden" name="ae_noncename_inventory" id="ae_noncename_inventory" value="<?php echo wp_create_nonce( 'ae_noncename_inventory' ); ?>" />
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<label for="seo-title"><?php _e('SEO Title', 'ae') ?>:</label>
					</th>
					<td>
						<input id="seo-title" type="text" value="<?php echo $seotitle ?>" name="seo-title" class="large-text"/>
						<p class="description"><?php _e('Example: Samsung Galaxy Tab 10.1 GT', 'ae') ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="summary"><?php _e('SEO Description', 'ae') ?>:</label>
					</th>
					<td>
						<textarea id="summary" class="large-text code" name="summary"><?php echo $info->getSummary() ?></textarea>
						<p class="description"><?php _e('Example: World Map PU Leather Hard Stand Case For Samsung Galaxy Tab 10.1 GT P7500 P7510 Free Shipping', 'ae') ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="keywords"><?php _e('SEO Keywords', 'ae') ?>:</label>
					</th>
					<td>
						<input id="keywords" type="text" value="<?php echo $info->getKeywords() ?>" name="keywords" class="large-text"/>
						<p class="description"><?php _e('Example: screen protector', 'ae') ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="noindex"><?php _e('Noindex', 'ae') ?>:</label>
					</th>
					<td>
						<fieldset>
							<label for="noindex">
								<input id="noindex" type="checkbox" value="1" name="noindex" <?php echo ( $noindex ) ? 'checked="checked"' : '' ?>/> <?php _e("Enable noindex", 'ae') ?>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="special"><?php _e('Specials', 'ae') ?>:</label>
					</th>
					<td>
						<fieldset>
							<label for="special">
								<input id="special" type="checkbox" value="1" name="special" <?php echo ( $special ) ? 'checked="checked"' : '' ?>/> <?php _e("Enable special", 'ae') ?>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="price"><?php _e('Price', 'ae') ?>:</label>
					</th>
					<td>
						<input id="price" type="text" value="<?php echo $info->getPrice() ?>" name="price" class="regular-text" readonly="readonly"/>
						<p class="description"><?php _e('Example: US $14.98', 'ae') ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="salePrice"><?php _e('Sale Price', 'ae') ?>:</label>
					</th>
					<td>
						<input id="salePrice" type="text" value="<?php echo $info->getSalePrice() ?>" name="salePrice" class="regular-text" readonly="readonly"/>
						<p class="description"><?php _e('Example: US $10.44', 'ae') ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="detailUrl"><?php _e('Affiliate link', 'ae') ?>:</label>
					</th>
					<td>
						<input id="detailUrl" type="text" value="<?php echo $info->getLink() ?>" name="detailUrl" class="regular-text" readonly="readonly"/>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label><?php _e('Availability', 'ae') ?>:</label>
					</th>
					<td>
						<input type="text" value="<?php echo ( $info->getAvailability() == 1 ) ? "in stock" : "not available" ?>" class="regular-text" readonly="readonly"/>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label><?php _e('Commission Rate', 'ae') ?>:</label>
					</th>
					<td>
						<input type="text" value="8%" class="regular-text" readonly="readonly"/>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label><?php _e('Purchase volume', 'ae') ?>:</label>
					</th>
					<td>
						<input type="text" value="<?php echo $info->getPromotion() ?>" class="regular-text" readonly="readonly"/>
						<p class="description"><?php _e("The amount of purchases of the product over the last 30-day period", 'ae') ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label><?php _e('Pieces per package', 'ae') ?>:</label>
					</th>
					<td>
						<input type="text" value="<?php echo $info->getLotNum() ?>" class="regular-text" readonly="readonly"/>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label><?php _e('Way of packaging', 'ae') ?>:</label>
					</th>
					<td>
						<input type="text" value="<?php echo $info->getPackageType() ?>" class="regular-text" readonly="readonly"/>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<h2><?php _e("Images", 'ae') ?></h2>
						<img class="img-responsive" src="<?php echo $info->getThumb( 'medium' )?>">
						<?php

							$images = $info->getImages();

							if( $images ) :

								$images = unserialize( $images );

								if( count($images) > 1 ) :

									foreach( $images as $key => $img ) {
										?>
											<img src="<?php echo $info->getSizeImg( $img, 'thumb' ) ?>" class="img-responsive">
										<?php
									}

								endif;
							endif;
						?>
					</th>
					<td style="vertical-align:top !important">
						<?php

							$attributes = $info->getAttribute();
							$count 	= count( $attributes );

							if( $count && $count > 0 ) :
						?>
								<h2><?php _e("Attributes", 'ae') ?></h2>
								<table class="meta-parametrs">

									<?php foreach( $attributes as $k => $v ) : ?>

										<tr>
											<th><?php echo isset($v['name']) ? $v['name'] . ':' : '' ?></th>
											<td><?php echo isset($v['value']) ? $v['value'] : '' ?></td>
										</tr>

									<?php endforeach ?>

								</table>
						<?php
							endif;
						?>
					</td>
				</tr>
			</tbody>
		</table>
	<?php
}

// add a hook to save the product
add_action( 'save_post', 'ae_save_product', 10, 1 );
function ae_save_product( $post_id ){

	if ( !isset($_POST['ae_noncename_inventory']) ||
		!wp_verify_nonce( $_POST['ae_noncename_inventory'], 'ae_noncename_inventory') ) return;

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;

	if ( !current_user_can( 'edit_page', $post_id ) ) return;

	global $wpdb;

	$foo = array('keywords', 'summary');
	$args = array();

	foreach( $foo as $key ){
		$args[$key] = isset($_POST[$key]) ? strip_tags($_POST[$key]) : "";
	}

	$wpdb->update( $wpdb->prefix . 'ae_products', $args, array( 'post_id' => $post_id ) );

	if( isset($_POST['can_edited']) )
		update_post_meta($post_id, 'ae_can_edit', 'can');
	else
		update_post_meta($post_id, 'ae_can_edit', '');

	if( isset($_POST['can_edited_title']) )
		update_post_meta($post_id, 'ae_can_edit_title', 'can');
	else
		update_post_meta($post_id, 'ae_can_edit_title', '');

	if( isset($_POST['seo-title']) )
		update_post_meta($post_id, 'ae_seo-title', sanitize_text_field($_POST['seo-title']));

	if( isset($_POST['noindex']) )
		update_post_meta($post_id, 'ae_noindex', '1');
	else
		update_post_meta($post_id, 'ae_noindex', '0');
	if( isset($_POST['special']) )
		update_post_meta($post_id, 'ae_special', '1');
	else
		update_post_meta($post_id, 'ae_special', '0');
}

// add a hook to save seo
add_action( 'save_post', 'ae_save_seo', 10, 1 );
function ae_save_seo( $post_id ){

	if ( !isset($_POST['ae_noncename_aeseo']) ||
		!wp_verify_nonce( $_POST['ae_noncename_aeseo'], 'ae_noncename_aeseo') ) return;

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;

	if ( !current_user_can( 'edit_page', $post_id ) ) return;

	$foo = array('keywords', 'description');

	foreach( $foo as $key ) {
		update_post_meta($post_id, $key, strip_tags($_POST[$key]));
	}

	if( isset($_POST['seo-title']) )
		update_post_meta($post_id, 'seo-title', sanitize_text_field($_POST['seo-title']));

	if( isset($_POST['noindex']) )
		update_post_meta($post_id, 'noindex', '1');
	else
		update_post_meta($post_id, 'noindex', '0');
	if( isset($_POST['special']) )
		update_post_meta($post_id, 'special', '1');
	else
		update_post_meta($post_id, 'special', '0');
}

/**
* 	Modify columns title
*/
add_filter("manage_edit-products_columns", "ae_columns");
function ae_columns( $columns ) {

	unset($columns['author']);
	unset($columns['cb']);
	unset($columns['title']);

	return array(
			"cb" 			=> __('Select All', 'wp'),
			"thumb" 		=> __("Thumbnail", 'ae'),
			"title" 		=> __("Title", 'wp'),
			"shopcategory" 	=> __("Category", 'ae'),
			"views" 		=> __("Views", 'ae'),
			"redirects" 	=> __("Redirects", 'ae'),
			"price" 		=> __("Price", 'ae'),
			"quantity" 	    => __("Stock", 'ae'),
		) + $columns;
}

/**
*	Content columns
*/
add_action("manage_products_posts_custom_column", "ae_custom_columns");
function ae_custom_columns( $column ) {

	global $post;

	if ( "thumb" == $column ) {

		if( !empty($post->imageUrl) )
			echo '<img width="110" src="' . $post->imageUrl . '">';
	}
	elseif ( "price" == $column ) {

		echo $post->price;
	}
	elseif ( "views" == $column ) {

		$view = get_post_meta( $post->ID, 'views', true );
		echo !empty( $view ) ? $view : 0;
	}
	elseif ("redirects" == $column) {

		$view = get_post_meta( $post->ID, 'redirects', true );
		echo !empty( $view ) ? $view : 0;
	}
	elseif ( "shopcategory" == $column ) {

		$categories = wp_get_object_terms( $post->ID, 'shopcategory' );

		if ( is_array( $categories ) )
			foreach( $categories as $k => $category )
				echo '<a href="' . admin_url( 'edit-tags.php?action=edit&taxonomy=shopcategory&post_type=products&tag_ID=' . $category->term_id ) . '">' . $category->name . '</a><br />';
	}
	elseif ( "quantity" == $column ) {

		$color = ($post->quantity <= 15) ? '#db0f1a' : '#6adb4b';

        printf('<span style="color:%s">%d</span>', $color, $post->quantity);
	}
}

/**
*	Adding a Taxonomy Filter to Admin List for a Custom Post Type
*/
add_action( 'restrict_manage_posts', 'ae_restrict_manage_posts' );
function ae_restrict_manage_posts( ) {

	global $typenow;

	if ( $typenow == 'products' ) {

		$filters = array( 'shopcategory' );

		foreach ( $filters as $tax_slug ) {

			$tax_obj 	= get_taxonomy( $tax_slug );
			$tax_name 	= $tax_obj->labels->name;

			?>
				<select name="<?php echo strtolower( $tax_slug ) ?>" id="<?php echo strtolower( $tax_slug ) ?>" class="postform">
					<option value=''><?php _e('Show All', 'ae') ?> <?php echo $tax_name ?></option>

					<?php
							ae_generate_taxonomy_options( $tax_slug,
								0, 0,
								( isset( $_GET[ strtolower($tax_slug) ] ) ?
								$_GET[ strtolower($tax_slug) ] : null )
							)
					?>

				</select>
			<?php
		}
	}
}

/**
*	Apply filter for taxonomy
*/
function ae_generate_taxonomy_options( $tax_slug, $parent = '', $level = 0, $selected = null ) {

	$args = array( 'show_empty' => 1 );

	if( !is_null( $parent ) )
		$args = array( 'parent' => $parent );

	$terms 	= get_terms( $tax_slug, $args );
	$tab	= '';

	for( $i = 0; $i < $level; $i++ )
		$tab .= '-- ';

	foreach ( $terms as $term ) {

		echo '<option value=' . $term->slug, $selected == $term->slug ? ' selected="selected"' : '','>' . $tab . $term->name .' (' . $term->count .')</option>';

		ae_generate_taxonomy_options( $tax_slug, $term->term_id, $level+1, $selected );
	}
}

/**
*	Sorting columns for custom post type Products
*/
add_filter( 'manage_edit-products_sortable_columns', 'ae_view_sortable_column' );
function ae_view_sortable_column( $columns ) {

	$columns['views'] 	  = 'views';
	$columns['redirects'] = 'redirects';
	$columns['quantity']  = 'quantity';

	return $columns;
}

/**
*	Request to sorting columns for custom post type Products
*/
add_filter( 'request', 'ae_view_column_orderby' );
function ae_view_column_orderby( $vars ) {

	if ( isset( $vars['orderby'] ) && 'views' == $vars['orderby'] ) {
		$vars = array_merge( $vars, array(
			'meta_key' 	=> 'views',
			'orderby' 	=> 'meta_value_num'
		) );
	}

	if ( isset( $vars['orderby'] ) && 'redirects' == $vars['orderby'] ) {
		$vars = array_merge( $vars, array(
			'meta_key' 	=> 'redirects',
			'orderby' 	=> 'meta_value_num'
		) );
	}

	return $vars;
}


/**
* 	Alter different parts of the query
*
* 	@param array $pieces
* 	@return array $pieces
*/
function ae_query_clauses( $pieces ) {


	$screen = get_current_screen();

	if( !isset($screen->post_type) || $screen->post_type != 'products' || $screen->base != 'edit' ) return $pieces;

	global $wpdb;

	$pieces['join'] = $pieces['join'] . " INNER JOIN `{$wpdb->prefix}ae_products` ON ({$wpdb->posts}.ID = `{$wpdb->prefix}ae_products`.`post_id`) ";
	$pieces['fields'] = $pieces['fields'] . ", price, commissionRate, quantity, imageUrl";
	$pieces['posts_groupby'] = "GROUP BY `{$wpdb->postmeta}`.`post_id`";

	return $pieces;
}

/**
 * Additional order by custom query vars
 *
 * @param $orderby_statement
 *
 * @return string
 */
function ae_query_posts_orderby( $orderby_statement ) {

    global $wpdb;

    $orderby  = get_query_var( 'orderby', false );
    $order    = get_query_var( 'order', false );

    $foo = array('quantity');

    if ( $orderby && in_array($orderby, $foo) ) {

        $order = ( $order == 'ASC' ) ? 'ASC' : 'DESC';

        $orderby_statement = $wpdb->products . '.' . $orderby . ' ' . $order;
    }

    return $orderby_statement;
}

add_action( 'admin_init', 'ae_get_screen' );
function ae_get_screen( ) {

	if( is_admin() ){
		add_filter( 'posts_clauses', 'ae_query_clauses', 20, 1 );
        add_filter( 'posts_orderby', 'ae_query_posts_orderby', 20, 1 );
    }
}

add_action( 'shopcategory_edit_form_fields', 'ae_custom_metabox_taxonomy', 10, 2);
add_action( 'category_edit_form_fields', 'ae_custom_metabox_taxonomy', 10, 2);
add_action( 'post_tag_edit_form_fields', 'ae_custom_metabox_taxonomy', 10, 2);
function ae_custom_metabox_taxonomy($tag, $taxonomy) {

	$noindex = get_site_option( "noindex_$tag->term_id" );

	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="noindex"><?php _e('Noindex', 'ae') ?></label></th>
		<td>
			<fieldset>
				<label for="noindex"><input name="noindex" type="checkbox" id="noindex"
						<?php if( $noindex && !empty($noindex) ) echo 'checked="checked"'; ?> value="1">
					<?php _e('Enable noindex', 'ae') ?>
				</label>
			</fieldset>
		</td>
	</tr>
<?php
}

/**
 * @param $term_id
 * @param $tt_id
 */
function ae_save_custom_metabox_taxonomy( $term_id, $tt_id ) {

	if(isset($_POST['taxonomy'])):

		if (isset($_POST['noindex']))
			update_site_option("noindex_$term_id", '1');
		else
			update_site_option("noindex_$term_id", '0');

	endif;
}
add_action( 'edited_terms', 'ae_save_custom_metabox_taxonomy', 10, 2);
?>