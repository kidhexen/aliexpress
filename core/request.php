<?php
	
	/**
	 * get quantity goods by filter param in category
	 */
	add_action( 'wp_ajax_ae_total_sheduled', 'ae_get_total_sheduled' );
	function ae_get_total_sheduled() {
		
		$result = ae_get_total_by_filter( );

		if( isset($result['error']) )
			echo '<strong>0</strong>';
		else
			echo '<strong>' . $result['result'] . '</strong>';
		
		die();
	}
	
	/**
	 * get quantity goods by filter param in category
	 */
	add_action( 'wp_ajax_ae_total_goods_in_cat', 'ae_get_total_goods' );
	function ae_get_total_goods( ) {
		
		$result = ae_get_total_by_filter( );
		
		if( isset($result['error']) ) {
			?>
				<div class="bulk-settings">
					<button type="button" class="close" data-dismiss="bulk-settings"><span aria-hidden="true">×</span><span class="sr-only"><?php _e("Close", 'ae') ?></span></button>
					<div class="alert alert-danger"><?php echo $result['error'] ?></div>
				</div>
			<?php
			die();
		}
		
		?>
		<div class="bulk-settings import-settings">
			<button type="button" class="close" data-dismiss="bulk-settings"><span aria-hidden="true">×</span><span class="sr-only"><?php _e("Close", 'ae') ?></span></button>
			
			<form action="" method="POST" id="import-bulk">
				<div class="row">
					<div class="col-md-12 col-sm-24">
						<div class="count-total">
							<?php _e("Total number of Products available for importing", 'ae') ?>: <strong><?php echo $result['result'] ?></strong>
							<p><em><?php _e('You can not upload more than 10,000 Products at once.', 'ae')?></em></p>
						</div>

						<div class="item-group item-control clearfix">
							<label class="col-sm-6" for="quantity"><?php _e("Choose the number of products to import", 'ae') ?></label>
							<div class="col-sm-14">
								<input type="text" class="" name="quantity" id="quantity">
							</div>
						</div>
						<?php
                            $obj = new AliExpressSettings();

                            $obj->tmplDropDownCat();
                        ?>
						<div class="item-group item-control clearfix">
							<label class="col-sm-6 mt20" for="unitType">
								<?php _e("Unit Type", 'ae') ?>
							</label>
							<div class="col-sm-14 mt20">
								<select id="unitType" name="unitType" class="w100">
									<option value="">---</option>
									<option value="piece"><?php _e('Piece', 'ae') ?></option>
									<option value="lot"><?php _e('Lot', 'ae') ?></option>
								</select>
                                <p><em><?php _e('Import products with checked unit type', 'ae')?></em></p>
							</div>
						</div>
						<div class="item-group item-control clearfix">
							<label class="col-sm-6 mt20" for="fs"><?php _e("Free Shipping", 'ae') ?></label>
							<div class="col-sm-14 mt20">
								<input type="checkbox" id="fs" name="fs" value="1">
                                <em><?php _e('Import products with free shipping option only', 'ae')?></em>
							</div>
						</div>
						<div class="item-group">
							<button class="btn orange-bg" name="bulk-import" data-gage="<?php echo $result['result'] ?>"><span class="fa fa-cloud-download"></span> <?php _e("Import Now", 'ae') ?></button> 
							<button name="btn-close" class="btn green-bg"><span class="fa fa-close"></span> <?php _e("Search Again", 'ae') ?></button> 
							<button name="btn-stop" class="btn grey-bg" style="display:none"><span class="fa fa-stop"></span> <?php _e("Stop Import", 'ae') ?></button> 
							<input type="hidden" name="status" value="0">
						</div>
					</div>
					<div class="col-md-12 col-sm-24">
						<div class="form-control-import">
							<div class="row">
								<div class="col-sm-12">
									<div class="counter-item text-center">
										<span id="total-success">0</span>
										<h4><?php _e('Successfully imported', 'ae') ?></h4>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="counter-item text-center">
										<span id="total-fail">0</span>
										<h4><?php _e('Could not be imported', 'ae') ?></h4>
									</div>
								</div>
							</div>
						</div>
						
						<label class="descript"><?php _e("Overall Progress", 'ae') ?> <span class="loader" style="display:none"></label>
						<div class="progress" id="total-progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0">0%</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<?php
		die();
	}
	
	function ae_get_total_by_filter( ) {
		
		$categoryId 		= $_POST['categoryId'];
        $ourcat 		    = isset($_POST['ourcat']) ? $_POST['ourcat'] : '';
		$keywords 			= $_POST['keywords'];
		$priceFrom 			= $_POST['priceFrom'];
		$priceTo 			= $_POST['priceTo'];
		$promotionFrom 		= $_POST['promotionFrom'];
		$promotionTo 		= $_POST['promotionTo'];
		$creditScoreFrom 	= $_POST['creditScoreFrom'];
		$creditScoreTo 		= $_POST['creditScoreTo'];
		$status 		    = isset($_POST['status']) ? $_POST['status'] : '';

		$obj = new AliExpressInsert();
		$result = $obj->getTotalByCategory( 
			$categoryId, 
			array( 
				'keywords' 				=> $keywords,
				'originalPriceFrom' 	=> ae_floatvalue($priceFrom), 
				'originalPriceTo' 		=> ae_floatvalue($priceTo),
				'volumeFrom' 			=> intval($promotionFrom),
				'volumeTo' 				=> intval($promotionTo),
				'startCreditScore' 		=> intval($creditScoreFrom),
				'endCreditScore' 		=> intval($creditScoreTo),
                'ourcat'		        => $ourcat,
                'status'                => $status
			)
		);
					
		return $result;
	}
	
	/**
	*	Selective import
	*/
	add_action( 'wp_ajax_ae_advanced_show', 'ae_advanced_show' );
	function ae_advanced_show( ) {
		
		$categoryId 		= $_POST['categoryId'];
		$keywords 			= $_POST['keywords'];
		$priceFrom 			= $_POST['priceFrom'];
		$priceTo 			= $_POST['priceTo'];
		$promotionFrom 		= $_POST['promotionFrom'];
		$promotionTo 		= $_POST['promotionTo'];
		$creditScoreFrom 	= $_POST['creditScoreFrom'];
		$creditScoreTo 		= $_POST['creditScoreTo'];
		$page_no 			= $_POST['page_no'];
		$sort 				= $_POST['sort'];
        $bigsale 			= $_POST['bigsale'];

        $bigsale = $bigsale == 'y' ? 'y' : '';
		$result = array();
		
		$obj = new AliExpressInsert();
		
		$search = $obj->searchByCategory(
			$categoryId,
			$page_no,
			array( 
				'keywords' 				=> $keywords,
				'originalPriceFrom' 	=> ae_floatvalue($priceFrom), 
				'originalPriceTo' 		=> ae_floatvalue($priceTo),
				'volumeFrom' 			=> intval($promotionFrom),
				'volumeTo' 				=> intval($promotionTo),
				'startCreditScore' 		=> intval($creditScoreFrom),
				'endCreditScore' 		=> intval($creditScoreTo),
				'sort' 					=> strip_tags($sort),
                'bigsale'               => $bigsale
			)
		);
			
		if( isset($search['error']) ) {
			
			$result['error'] = '<div class="alert alert-danger">' . $search['error'] . '</div>';
			
			$result['before'] = '<button type="button" class="close" data-dismiss="advanced-settings"><span aria-hidden="true">×</span><span class="sr-only">' . __("Close", 'ae') . '</span></button>';
			
			echo json_encode($result);
			die();
		}
		
		$total = isset( $search['result']->totalResults ) ? $search['result']->totalResults : 0;
		
		$result['title'] = __('Select Products to Import', 'ae');
		
		$result['before'] = '<button type="button" class="close" data-dismiss="advanced-settings"><span aria-hidden="true">×</span><span class="sr-only">' . __("Close", 'ae') . '</span></button>';
		
		$result['total'] = '<div class="count-total">' . __("Total number of Products available for importing", 'ae') . ': <strong>' . $total . '</strong> 
								<p><em>' . __('You can upload not more than 10,000 Products at once.', 'ae') . '</em></p>
							</div>';

		$result['sort'] = array(
			'title' 	=> __('Sort by: '),
			'price' 	=> array( 'title' => __('Unit Price', 'ae'), 'value' => 'orignalPriceDown,orignalPriceUp' ),
			'volume' 	=> array( 'title' => __('Volume', 'ae'), 'value' => 'volumeDown' ),
			'latest' 	=> array( 'title' => __('Latest', 'ae'), 'value' => 'validTimeDown' ),
		);
		
		$result['header'] = array( 
			'<span class="fa fa-1 fa-square-o mass-checked"></span>',
			__("Thumbnail", 'ae'),
			__("Title", 'ae'),
			__("Unit Price", 'ae'),
			
			__("Rate", 'ae') . 
			' <span class="fa fa-question-circle color-white" title="' . 
			__("Your commission is calculated based on your Affiliate Level", 'ae') . '"></span>',
			
			__("Commission", 'ae') . 
			' <span class="fa fa-question-circle color-white" title="' . 
			__("Commission you will earn", 'ae') . '"></span>',
			
			__("Volume", 'ae') . 
			' <span class="fa fa-question-circle color-white" title="' . 
			__("The amount of purchases of the product over the last 30-day period", 'ae') . '"></span>',

			__("Rating", 'ae') . 
			' <span class="fa fa-question-circle color-white" title="' . 
			__("Average star rating of the product on a 5-star scale", 'ae') . '"></span>'
		);
		
		//$result['info'] = '<div style="margin-top:20px">' . __('Successfully imported', 'ae') . ': <span id="total-success" class="label label-success">0</span> ' . __('Could not be imported', 'ae') . ': <span id="total-fail" class="label label-danger">0</span></div><label class="descript" style="padding-top:20px">' . __("Overall Progress", 'ae') . '</label>';
		
		$result['info'] = '<div class="form-control-import">
											<div class="row">
												<div class="col-sm-12">
													<div class="counter-item text-center">
														<span id="total-success">0</span>
														<h4>' . __('Successfully imported', 'ae') . '</h4>
													</div>
												</div>
												<div class="col-sm-12">
													<div class="counter-item text-center">
														<span id="total-fail">0</span>
														<h4>' . __('Could not be imported', 'ae') . '</h4>
													</div>
												</div>
											</div>
										</div>';
		
		
		$result['result'] = $search['result'];
		
		echo json_encode( $result );
		die();
	}

	/**
	*	By IDs import
	*/
	add_action( 'wp_ajax_ae_search_by_id_show', 'ae_search_by_id_show' );
	function ae_search_by_id_show( ) {

		$ids = $_POST['ids'];
		$ids = explode(",", $ids);

		$result = array();

		$obj = new AliExpressInsert();

		$search = $obj->searchByProductIDs( $ids );

		if( isset($search['error']) ) {

			$result['error'] = '<div class="alert alert-danger">' . $search['error'] . '</div>';

			$result['before'] = '<button type="button" class="close" data-dismiss="advanced-settings"><span aria-hidden="true">×</span><span class="sr-only">' . __("Close", 'ae') . '</span></button>';

			echo json_encode($result);
			die();
		}

		$result['totalResults'] = isset( $search['result'] ) ? count($search['result']) : 0;

		$result['title'] = __('Select Products to Import', 'ae');

		$result['before'] = '<button type="button" class="close" data-dismiss="advanced-settings"><span aria-hidden="true">×</span><span class="sr-only">' . __("Close", 'ae') . '</span></button>';

		$result['total'] = '<div class="count-total">' . __("Total number of Products available for importing", 'ae') . ': <strong>' . $result['totalResults'] . '</strong></div>';

		$result['header'] = array(
			'<span class="fa fa-1 fa-square-o mass-checked"></span>',
			__("Thumbnail", 'ae'),
			__("Title", 'ae'),
			__("Unit Price", 'ae'),

			__("Rate", 'ae') .
			' <span class="fa fa-question-circle color-white" title="' .
			__("Your commission is calculated based on your Affiliate Level", 'ae') . '"></span>',

			__("Commission", 'ae') .
			' <span class="fa fa-question-circle color-white" title="' .
			__("Commission you will earn", 'ae') . '"></span>',

			__("Volume", 'ae') .
			' <span class="fa fa-question-circle color-white" title="' .
			__("The amount of purchases of the product over the last 30-day period", 'ae') . '"></span>',

			__("Rating", 'ae') .
			' <span class="fa fa-question-circle color-white" title="' .
			__("Average star rating of the product on a 5-star scale", 'ae') . '"></span>'
		);

		$result['info'] = '<div class="form-control-import">
											<div class="row">
												<div class="col-sm-12">
													<div class="counter-item text-center">
														<span id="total-success">0</span>
														<h4>' . __('Successfully imported', 'ae') . '</h4>
													</div>
												</div>
												<div class="col-sm-12">
													<div class="counter-item text-center">
														<span id="total-fail">0</span>
														<h4>' . __('Could not be imported', 'ae') . '</h4>
													</div>
												</div>
											</div>
										</div>';


		$result['result'] = $search['result'];

		echo json_encode( $result );
		die();
	}

	/**
	*	Get count of products
	*/
	add_action( 'wp_ajax_ae_count_products', 'ae_count_products' );
	function ae_count_products( ) {

		global $wpdb;

		$count = $wpdb->get_var("SELECT count(`id`) as `con` FROM `{$wpdb->prefix}ae_products` WHERE `post_id` <> 0");

		echo intval($count);
		die();
	}

	/**
	 *	Update products one by one
	 */
	add_action( 'wp_ajax_ae_update_products', 'ae_update_products' );
	function ae_update_products( ) {

		global $wpdb;

		$from = abs( intval($_POST['position']) ) * 20 - 20;
		$delete = get_site_option('ae-delete');
		$insert = new AliExpressInsert();
		$pub = new AliExpressPublish();

		$result = $insert->updateLinks( $from, 20 );

		if( !$result ) { echo 0; die(); }

		if( count($result) > 0 ) {

			print_r($result);

			foreach($result as $key => $val){
				$pub->setId( $key );
				$post = $pub->getDetails();

				if( !empty($post) ) {
					if( $delete == 1 ) {
						wp_delete_post( $post->post_id, true );
						$wpdb->delete( $wpdb->prefix . "ae_products", array( 'post_id' => $post->post_id ), array( '%d' ) );
						print_r( " Delete product ID: " . $post->post_id );
					}
					else{
						$wpdb->update(
							$wpdb->prefix . "ae_products",
							array( 'availability' => 0 ),
							array( 'post_id' => $post->post_id ),
							array( '%d' ),
							array( '%d' )
						);
					}
				}
			}
			die();
		}

		echo $_POST['position'];

		die();
	}

	/**
	*	For Review
	*/
	add_action( 'wp_ajax_ae_review_show', 'ae_review_show' );
	function ae_review_show( ) {
		
		$categoryId 		= $_POST['categoryId'];
		$keywords 			= $_POST['keywords'];
		$priceFrom 			= $_POST['priceFrom'];
		$priceTo 			= $_POST['priceTo'];
		$promotionFrom 		= $_POST['promotionFrom'];
		$promotionTo 		= $_POST['promotionTo'];
		$creditScoreFrom 	= $_POST['creditScoreFrom'];
		$creditScoreTo 		= $_POST['creditScoreTo'];
		$page_no 			= $_POST['page_no'];
		
		$result = array();
		
		$obj = new AliExpressInsert();
		
		$search = $obj->searchByCategory(
			$categoryId,
			$page_no,
			array( 
				'keywords' 				=> $keywords,
				'originalPriceFrom' 	=> ae_floatvalue($priceFrom), 
				'originalPriceTo' 		=> ae_floatvalue($priceTo),
				'volumeFrom' 			=> intval($promotionFrom),
				'volumeTo' 				=> intval($promotionTo),
				'startCreditScore' 		=> intval($creditScoreFrom),
				'endCreditScore' 		=> intval($creditScoreTo)
			) 
		);
			
		if( isset($search['error']) ) {
			
			$result['error'] = '<div class="alert alert-danger">' . $search['error'] . '</div>';
			
			$result['before'] = '<button type="button" class="close" data-dismiss="advanced-settings"><span aria-hidden="true">×</span><span class="sr-only">' . __("Close", 'ae') . '</span></button>';
			
			echo json_encode($result);
			die();
		}

		$total = isset( $search['result']->totalResults ) ? $search['result']->totalResults : 0;
		
		$result['before'] = '<div class="count-total">' . __('Total number of Products available for importing', 'ae') . ' <strong>' . $total . '</strong></div>';
	
		$result['header'] = array( 
			__("Thumbnail", 'ae'),
			__("Title", 'ae'),
			__("Unit Price", 'ae'),
			
			__("Rate", 'ae') . 
			' <span class="fa fa-question-circle color-white" title="' .
			__("Your commission is calculated based on your Affiliate Level", 'ae') . '"></span>',
			
			__("Commission", 'ae') . 
			' <span class="fa fa-question-circle color-white" title="' .
			__("Commission you will earn", 'ae') . '"></span>',
			
			__("Volume", 'ae') . 
			' <span class="fa fa-question-circle color-white" title="' .
			__("The amount of purchases of the product over the last 30-day period", 'ae') . '"></span>',

			__("Rating", 'ae') . 
			' <span class="fa fa-question-circle color-white" title="' .
			__("Average star rating of the product on a 5-star scale", 'ae') . '"></span>'
		);
		
		$result['info'] = '<div style="margin-top:20px">' . __('Successfully imported', 'ae') . ': <span id="total-success" class="label label-success">0</span> ' . __('Could not be imported', 'ae') . ': <span id="total-fail" class="label label-danger">0</span></div><label class="descript" style="padding-top:20px">' . __("Overall Progress", 'ae') . '</label>';
		
		$result['result'] = $search['result'];
		
		echo json_encode( $result );
		die();
	}
	
	/**
	*	Bulk import
	*/
	add_action( 'wp_ajax_ae_bulk_import_step1', 'ae_bulk_import_step1' );
	function ae_bulk_import_step1( ) {
		
		$categoryId 		= $_POST['categoryId'];
        $ourcat 		    = isset($_POST['ourcat']) ? $_POST['ourcat']: '';
        $status 		    = $_POST['status'];
		$keywords 			= $_POST['keywords'];
		$priceFrom 			= $_POST['priceFrom'];
		$priceTo 			= $_POST['priceTo'];
		$promotionFrom 		= $_POST['promotionFrom'];
		$promotionTo 		= $_POST['promotionTo'];
		$creditScoreFrom 	= $_POST['creditScoreFrom'];
		$creditScoreTo 		= $_POST['creditScoreTo'];
		$page_no 			= $_POST['page_no'];
        $bigsale 			= $_POST['bigsale'];
        $bigsale            = $bigsale == 'y' ? 'y' : '';
		$size 				= $_POST['size'];
		$unitType 			= (isset($_POST['unitType']) &&
		                        in_array($_POST['unitType'], array('piece', 'lot'))
								) ? $_POST['unitType'] : '';
		$cc 				= absint($_POST['cc']);
		$fs 				= absint($_POST['fs']);
		$fs                 = ($fs == 1) ? true : false;

		$result = array();
		
		$pos = ceil($size/$cc);
		
		$limit = $now = $size - $page_no * $cc;
		if( $now < 0 )
			$now = $cc - ($page_no * $cc - $size);
			
		elseif( $now == 0 && $pos > $cc ) {
			
			$result['end'] = '1';
			
			echo json_encode($result);
			die();
		}
		
		$obj = new AliExpressInsert();
		$obj->set_frees($fs);
		$obj->set_unit_type($unitType);

		$search = $obj->searchByCategory(

			$categoryId,
			$page_no,
			array( 
				'keywords' 				=> $keywords,
				'originalPriceFrom' 	=> ae_floatvalue($priceFrom), 
				'originalPriceTo' 		=> ae_floatvalue($priceTo),
				'volumeFrom' 			=> intval($promotionFrom),
				'volumeTo' 				=> intval($promotionTo),
				'startCreditScore' 		=> intval($creditScoreFrom),
				'endCreditScore' 		=> intval($creditScoreTo),
                'bigsale'               => $bigsale
			),
			$cc
		);
		
		if( isset($search['error']) ) {
			
			$result['error'] 	= 'Error: Page ' . $page_no . ' Category: ' . $categoryId . ' Message: ' . $search['error'];
			$result['fail'] 	= $now;
			$result['success']	= 0;
			
			echo json_encode($result);
			die();
		}

		$i = $fail = $success = 0;
		
		$arguments = $search['result']->products;
		
		$ddd = array();
		
		foreach( $arguments as $data ) {
			
			$i++;
			
			if( $limit < 0 && $i > $now ) continue;
			
			$args['lotNum'] 			= intval( $data->lotNum );
			$args['packageType'] 		= strip_tags( $data->packageType );
			$args['imageUrl'] 			= strip_tags( $data->imageUrl );
			$args['productId'] 			= intval( $data->productId );
			$args['price'] 				= strip_tags( $data->originalPrice );
			$args['validTime'] 			= ae_dbdate( $data->validTime );
			$args['subject'] 			= strip_tags( $data->productTitle );
			$args['productUrl'] 		= strip_tags( $data->productUrl );
			$args['promotionVolume'] 	= intval( $data->volume );
			$args['evaluateScore'] 		= strip_tags( $data->evaluateScore );
			$args['salePrice'] 			= strip_tags( $data->salePrice );
			
			$obj->insertOneItem( intval( $categoryId ), $args);
		
			$details = $obj->getDetailById( $args['productId'] );

			if( !$details || isset($details['error']) ){
                $fail++;
            }
            else {
                $pub = new AliExpressPublish($args['productId'], $ourcat, $status);

                $published = $pub->Published();

                if (!$published)
                    $fail++;
                elseif (is_array($published) && isset($published['error']))
                    $fail++;
                else
                    $success++;
            }
		}
		
		$result = array( 'fail' => $fail, 'success' => $success );
		
		echo json_encode( $result );
		die();
	}
	
	/* publlish products */
	add_action('wp_ajax_ae_publish_product', 'ae_publish_product');
	function ae_publish_product( ) {
	
		$args = array();
		
		$category_id 				= intval( $_POST['categoryAE'] );
		$args['lotNum'] 			= intval( $_POST['lotNum'] );
		$args['packageType'] 		= strip_tags( $_POST['packageType'] );
		$args['imageUrl'] 			= strip_tags( $_POST['imageUrl'] );
		$args['productId'] 			= intval( $_POST['productId'] );
		$args['price'] 				= strip_tags( $_POST['price'] );
		$args['validTime'] 			= ae_dbdate( $_POST['actualTime'] );
		$args['subject'] 			= strip_tags( $_POST['subject'] );
		$args['productUrl'] 		= strip_tags( $_POST['productUrl'] );
		$args['promotionVolume'] 	= intval( $_POST['promotionVolume'] );
		$args['evaluateScore'] 		= strip_tags( $_POST['evaluateScore'] );
		$args['salePrice'] 			= strip_tags( $_POST['salePrice'] );
		$owncat			            = isset($_POST['owncat']) ? strip_tags($_POST['owncat']) : '';
        $args['owncat']			    = $owncat;
		$status 			        = isset($_POST['status']) ? strip_tags($_POST['status']) : 'draft';

        $obj = new AliExpressInsert();
		
		$obj->insertOneItem( $category_id, $args );

        $details = $obj->getDetailById( $args['productId'] );

        if( !$details || isset($details['error']) ){
            echo json_encode( array('error' => __('Publish failed', 'ae')) );
            die();
        }

		$pub = new AliExpressPublish( $args['productId'], $owncat,  $status);

		$result = $pub->Published(  );
		
		if( !$result )
			echo json_encode( array('error' => __('Publish failed', 'ae')) );
		elseif( is_array($result) && isset($result['error']) )
			echo json_encode( array('error' => $result['error']) );
		else
			echo json_encode( array( 'success' => __('Publish success', 'ae'), 'post_id' => $result['id'], 'url' => get_permalink($result['id'])) );
		
		die();
	}

	/* publlish products by ID*/
	add_action('wp_ajax_ae_publish_product_id', 'ae_publish_product_id');
	function ae_publish_product_id( ) {

		$args = array();

		$args['lotNum'] 			    = intval( $_POST['lotNum'] );
		$args['packageType'] 		    = strip_tags( $_POST['packageType'] );
		$args['imageUrl'] 			    = strip_tags( $_POST['imageUrl'] );
		$args['productId'] 			    = intval( $_POST['productId'] );
		$args['price'] 				    = strip_tags( $_POST['price'] );
		$args['validTime'] 			    = ae_dbdate( $_POST['actualTime'] );
		$args['subject'] 			    = strip_tags( $_POST['subject'] );
		$args['productUrl'] 		    = strip_tags( $_POST['productUrl'] );
		$args['promotionVolume'] 	    = intval( $_POST['promotionVolume'] );
		$args['evaluateScore'] 		    = strip_tags( $_POST['evaluateScore'] );
		$args['salePrice'] 			    = strip_tags( $_POST['salePrice'] );
		$args['owncat'] 			    = isset($_POST['owncat']) ? strip_tags($_POST['owncat']) : '';
		$status 			            = isset($_POST['status']) ? strip_tags($_POST['status']) : 'draft';

		$obj = new AliExpressInsert();

		$obj->insertOneItemIds( $args );

        $details = $obj->getDetailById( $args['productId'] );

        if( !$details || isset($details['error']) ){
            echo json_encode( array('error' => __('Publish failed', 'ae')) );
            die();
        }

		$pub = new AliExpressPublish( $args['productId'], $args['owncat'], $status );

		$result = $pub->Published( true );

		if( !$result )
			echo json_encode( array('error' => __('Publish failed', 'ae')) );
		elseif( is_array($result) && isset($result['error']) )
			echo json_encode( array('error' => $result['error']) );
		else
			echo json_encode(
				array(
					'success'   => __('Publish success', 'ae'),
					'post_id'   => $result['id'],
					'url'       => get_permalink($result['id'])
				)
			);

		die();
	}
	
	/**
	* get permalink and short code
	*/
	add_action('wp_ajax_ae_permalink_import', 'ae_ajax_get_permalink');
	function ae_ajax_get_permalink( ) {
		
		$products = $_POST['products'];
		
		if( count($products) == 0 ){
			echo json_encode( array('not' => '') );
			die();
		}
		
		$obj = new AliExpressPublish();
		
		$foo = array();
		
		foreach( $products as $product_id ) {
			
			$obj->setId( $product_id );
			
			$details = $obj->getDetails();
		
			if( !empty($details) && !empty($details->post_id) )
				$foo[] = array( 'id' => $product_id, 'url' => get_permalink($details->post_id), 'productUrl' => $details->productUrl, 'post_id' => $details->post_id );
		}
		
		if( count($foo) > 0 )
			echo json_encode( $foo );
		else
			echo json_encode( array('not' => '') ); 
		
		die();
	}
	
	add_action('wp_ajax_ae_review_form', 'ae_review_form');
	function ae_review_form( ) {
		
		include( dirname( __FILE__ ) . '/tmpl.review.php' );
		
		die();
	}
	
	//restore english content
	add_action('wp_ajax_ae_get_description', 'ae_get_description');
	function ae_get_description(){
		
		if( !isset($_POST['post_id']) || empty($_POST['post_id']) ){
			echo 0;
			die();
		}
		
		$obj = new AEProducts();
		$obj->set( intval($_POST['post_id']) );
		
		$content = $obj->getDescription();
		$title = $obj->getTitle();
		
		if( !$content || !$title ) {
			echo 0;
			die();
		}
		
		$foo = array( 'content' => ae_clean_html_style($content), 'title' => $title );
		
		echo json_encode($foo);
		die();
	}
	
	/**
	*	Show the Categories at dropdown menu
	*/
	add_action('wp_ajax_ae_get_dropdowncat', 'ae_get_dropdowncat');
	function ae_get_dropdowncat( ) {
		
		$obj = new AliExpressSettings();
		
		$obj->tmplDropDownCat();
		
		die();
	}
	
	/**
	*	Get promotion links
	*/
	add_action('wp_ajax_ae_get_promotion', 'ae_get_promotion_link');
	function ae_get_promotion_link( ) {

		if( !isset($_POST['link']) || empty($_POST['link']) ) {
			
			echo json_encode( array('error' => __('Wrong Request!', 'ae')) );
			die();
		}

		$obj = new AliExpressInsert();
		
		try {
			$urls = $obj->getPromotionLinks( array($_POST['link']) );
		}
		catch( Exception $e ) {
			echo json_encode( array( 'error' => __('Link', 'ae') . ': ' . $e->getMessage() ) );
			die();
		}

		if(  is_array($urls) && isset($urls['notfound']) ) {
			echo json_encode( array( 'error' => $urls['notfound'] ) );
			die();
		}
		
		$urls = $urls->promotionUrls;

		if( !isset($urls[0]) ) {
			echo json_encode( array( 'error' => $urls['notfound'] ) );
			die();
		}
		
		echo json_encode( array( 'success' => $urls[0]->promotionUrl ) );
		die();
	}

	/**
	*	Set max price
	*/
	add_action('wp_ajax_ae_set_max_price', 'ae_set_max_price');

	/**
	*	Test Connection
	*/
	add_action('wp_ajax_ae_test_connection', 'ae_test_connection');
	function ae_test_connection( ) {
	
		$obj = new AliExpressInsert();
		
		$obj->test_connection();
		
		die();
	}

	/**
	 *
	 */
	add_action('wp_ajax_ae_get_terms_id', 'ae_get_terms_id');
	function ae_get_terms_id( ) {

		$foo = array();

		if( !current_user_can( 'activate_plugins' ) ){ echo json_encode($foo); die(); }

		$terms = get_terms( 'shopcategory', array('orderby' => 'count', 'hide_empty' => 0) );

		if ( !empty( $terms ) && !is_wp_error( $terms ) )
			foreach ( $terms as $term )
				$foo[] = $term->term_id;

		echo json_encode($foo);

		global $wpdb;

		$wpdb->query("TRUNCATE TABLE `{$wpdb->prefix}ae_products`");

		$wpdb->query("DELETE FROM `{$wpdb->options}` WHERE `option_name` like 'term_child-%' OR `option_name` like 'term_parent-%'");

		die();
	}

	/**
	 * 	Delete products and categories
	 */
	add_action('wp_ajax_ae_delete_products_from_terms', 'ae_delete_products_from_terms');
	function ae_delete_products_from_terms( ) {

		global $wpdb;

		if( !current_user_can( 'activate_plugins' ) ){ echo "0"; die(); }

		if( !isset($_POST['term_id']) || empty($_POST['term_id']) ){ echo "0"; die(); }

		$term_id = $_POST['term_id'];

		$wpdb->query(
			$wpdb->prepare(
				"DELETE a,b,c,d
					FROM `{$wpdb->prefix}posts` `a`
						LEFT JOIN `{$wpdb->prefix}term_relationships` `b` ON ( `a`.`ID` = `b`.`object_id` )
						LEFT JOIN `{$wpdb->prefix}postmeta` c ON ( `a`.`ID` = `c`.`post_id` )
						LEFT JOIN `{$wpdb->prefix}term_taxonomy` `d` ON ( `d`.`term_taxonomy_id` = `b`.`term_taxonomy_id` )
						LEFT JOIN `{$wpdb->prefix}terms` `e` ON ( `e`.`term_id` = `d`.`term_id` )
					WHERE
						`e`.`term_id` = '%d' AND
						`a`.`post_type` = 'products'", $term_id
			)
		);

		echo $term_id;

		wp_delete_term( $term_id, 'shopcategory' );

		die();
	}

	add_action('wp_ajax_ae_delete_products_remaining', 'ae_delete_products_remaining');
	function ae_delete_products_remaining(){

		global $wpdb;

		if( !current_user_can( 'activate_plugins' ) ){ echo "0"; die(); }

		$wpdb->query(
			"DELETE p, pm, tr
				FROM `{$wpdb->prefix}posts` `p`
					JOIN `{$wpdb->prefix}term_relationships` `tr` ON ( `p`.`ID` = `tr`.`object_id` )
					JOIN `{$wpdb->prefix}postmeta` `pm` ON ( `p`.`ID` = `pm`.`post_id` )
				WHERE p.post_type = 'products'"
		);

		$wpdb->query(
			"DELETE p, pm
				FROM `{$wpdb->prefix}posts` `p`
					JOIN `{$wpdb->prefix}postmeta` `pm` ON ( `p`.`ID` = `pm`.`post_id` )
				WHERE p.post_type = 'products'"
		);

		$wpdb->query( "DELETE p FROM `{$wpdb->posts}` `p` WHERE p.post_type = 'products'" );

		$wpdb->query(
			"DELETE p FROM `{$wpdb->prefix}options` `p`
				WHERE p.option_name LIKE 'ae_original_title_%' OR
					p.option_name LIKE 'term_parent-%' OR
					p.option_name LIKE 'term_child-%'"
		);

		$wpdb->query("TRUNCATE TABLE `{$wpdb->review}`");

		die();
	}

	add_action('wp_ajax_ae_get_translate', 'ae_get_translate');
	function ae_get_translate( ) {

		$foo = array(
			'bulk_count' 	=> __("You did not indicate how many imported products", 'ae'),
			'bulk_size' 	=> __("You specified a value greater than can be import", 'ae'),
			'pId' 			=> __("Product ID", 'ae'),
			'imNow' 		=> __("Import Now", 'ae'),
			'sAgain' 		=> __("Search Again", 'ae'),
			'progress' 		=> __("Overall Progress", 'ae'),
			'link' 			=> __("Get link", 'ae'),
			'preview' 		=> __("Preview", 'ae'),
			'prev' 			=> __("Prev", 'ae'),
			'next' 			=> __("Next", 'ae'),
			'notfound' 		=> __("This product does not participate in the Affiliate Program", 'ae'),
			'del' 			=> __("Are you sure you want to delete all products?", 'ae')
		);

		echo json_encode( $foo );
		die();
	}

add_action('wp_ajax_ae_translate_item', 'ae_translate_item');
function ae_translate_item( ) {

	if( !current_user_can( 'activate_plugins' ) ){ echo "0"; die(); }

	$type 	= $_POST['type'];
	$id 	= $_POST['item_id'];
	$action = false;
	$lang 	= $_POST['lang'];

	if( $type == 'page' ) {

		$title = get_the_title($id);

		if( !empty($title) ) {

			$orig = get_post_meta($id, 'ae_original_title', true);
			if( empty($orig) ) {
				update_post_meta($id, 'ae_original_title', $title);
				$orig = $title;
			}
			$action = true;
		}
	}
	elseif( $type == 'taxonomy' ) {

		$term = get_term_by('id', $id, 'shopcategory');

		if( $term ) {
			$title = $term->name;

			$orig = get_site_option('ae_original_title_' . $id);
			if( !$orig ) {
				update_site_option('ae_original_title_' . $id, $title);
				$orig = $title;
			}

			$action = true;
		}
	}

	if( !$action ) {
		$foo = array('message' => $id . " " . __('Item not found', 'ae'));
	}
	else {

		include_once __DIR__ . '/../libs/translate/GoogleTranslate.php';

		$tr = new GoogleTranslate();

		$tr->setFromLang($lang)->setToLang(AE_LANG);

		$translated = $tr->translate($title);

		if( $tr->isError() )
			$foo = $tr->getError();
		else {
			$foo = array('title' => $translated, 'o_title' => $orig);

			if( $type == 'page' )
				wp_update_post( array( 'ID' => $id, 'post_title' => $translated ) );

			elseif( $type == 'taxonomy' )
				wp_update_term( $id, 'shopcategory', array('name' => $translated ) );
		}
	}

	echo json_encode( $foo );
	die();
}

add_action('wp_ajax_ae_repair_translate_item', 'ae_repair_translate_item');
function ae_repair_translate_item( ) {

	if (!current_user_can('activate_plugins')) {
		echo "0";
		die();
	}

	$type = $_POST['type'];
	$id = $_POST['item_id'];
	$action = false;

	if( $type == 'page' ) {

		$orig = get_post_meta($id, 'ae_original_title', true);
		if( empty($orig) ) {

			$title = get_the_title($id);

			if( !empty($title) ) {

				update_post_meta($id, 'ae_original_title', $title);
				$orig = $title;

				$action = true;
			}
		}
		else {
			wp_update_post( array( 'ID' => $id, 'post_title' => $orig ) );
			$title = $orig;

			$action = true;
		}
	}
	elseif( $type == 'taxonomy' ) {

		$orig = get_site_option('ae_original_title_' . $id);
		if( !$orig ) {

			$term = get_term_by('id', $id, 'shopcategory');

			if( $term ) {
				$title = $term->name;

				update_site_option('ae_original_title_' . $id, $title);
				$orig = $title;

				$action = true;
			}
		}
		else{
			wp_update_term( $id, 'shopcategory', array('name' => $orig ) );
			$title = $orig;

			$action = true;
		}
	}

	if( !$action )
		$foo = array('message' => $id . " " . __('Item not found', 'ae'));
	else
		$foo = array('title' => $title, 'o_title' => $orig);

	echo json_encode( $foo );
	die();
}

add_action('wp_ajax_ae_save_new_title_item', 'ae_save_new_title_item');
function ae_save_new_title_item( ) {

	if (!current_user_can('activate_plugins')) {
		echo "0";
		die();
	}

	$type = $_POST['type'];
	$id = $_POST['item_id'];
	$title = $_POST['title'];
	$action = false;

	if( $type == 'page' ) {

		if( !empty($title) ) {

			wp_update_post( array( 'ID' => $id, 'post_title' => $title ) );
			$foo = array('success' => 'Page with ' . $id . ' updated');
			$action = true;
		}
	}
	elseif( $type == 'taxonomy' ) {

		if( !empty($title) ) {

			wp_update_term( $id, 'shopcategory', array('name' => $title ) );
			$foo = array('success' => 'Category with ' . $id . ' updated');
			$action = true;
		}
	}

	if( !$action )
		$foo = array('message' => 'Error: update failed, id: ' . $id . ' title: ' . $title);

	echo json_encode( $foo );
	die();
}

add_action('wp_ajax_ae_import_review', 'ae_import_review');
function ae_import_review(){

    $pos = isset($_POST['pos']) && $_POST['pos'] > 0 ? absint($_POST['pos']) : 1;
    $page = isset($_POST['page']) && $_POST['page'] > 0 ? absint($_POST['page']) : 1;
	$star = isset($_POST['star']) && $_POST['star'] <= 5 && $_POST['star'] > 0 ? absint($_POST['star']) : 1;

    global $wpdb;

    $row = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM `{$wpdb->products}` WHERE `post_id` <> 0 LIMIT %d, 1", $pos)
    );

    if( empty($row) ) {
        echo 'end';
        die();
    }

    require( dirname( __FILE__ ) . '/class.AliExpress.Review.php' );
	//include_once __DIR__ . '/../libs/translate/GoogleTranslate.php';

	//$translate = new GoogleTranslate();
	//$translate->setFromLang('')->setToLang(AE_LANG);

    $obj = new Review($row->productId);
    $obj->setNewParams();
    $obj->setPage($page);
    $data = $obj->getReviews();

    if( !$data ) {

        echo json_encode(array(
            'product' => $row->productId,
            'status'  => 'end'
        ));

        die();
    }

    foreach( $data as $key => $val ) {

        if( !ae_check_exists_review( $row->post_id, $val ) && $val['star'] >= $star ) {

	        //$feedback = !empty($val['feedback']) ? $translate->translate($val['feedback']) : '';
	        $feedback = !empty($val['feedback']) ? $val['feedback'] : '';

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
    }

    $review = ae_review_stats( $row->post_id, $row );

    ae_setTimeout(1);

    echo json_encode($review);
    die();
}

add_action('wp_ajax_ae_count_review', 'ae_count_review');
function ae_count_review(){

    $reviews = ae_total_count_reviews();

    echo $reviews;
    die();
}

function ae_review_stats( $post_id, $product ) {

    global $wpdb;

    $row = $wpdb->get_row(
        $wpdb->prepare("SELECT AVG(`star`) `ratings`, COUNT(`id`) `count` FROM `{$wpdb->review}` WHERE `post_id` = '%d'", $post_id)
    );

    $count  = 0;
    $rating = 0;
    $img    = "";

    if( !empty($row) ) {
		
		$th = !has_post_thumbnail($product->post_id);
		if( !has_post_thumbnail($product->post_id) && !empty($product->imageUrl) )
			$img = ae_get_thumb_ali( $product->imageUrl, 'thumb' );
		elseif( $th ) {

			$thumb_id = get_post_thumbnail_id( $post_id );
			$url = wp_get_attachment_image_src( $thumb_id, 'thumbnail' );

			$img = $url[0];
		}
	
        $wpdb->update(
            $wpdb->products,
            array('evaluateScore' => $row->ratings, 'countReview' => $row->count),
            array('post_id' => $post_id),
            array('%f', '%d'),
            array('%d')
        );
        $rating = $row->ratings;
        $count = $row->count;
    }

    return array(
        'productId' => $product->productId,
        'title'     => get_the_title( $post_id ),
        'rating'    => $rating,
        'count'     => $count,
        'thumb'     => $img,
        'status'    => 'ok'
    );
}

function ae_check_exists_review( $post_id, $args ) {

    global $wpdb;

    $var = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT `id`
            FROM `{$wpdb->review}`
            WHERE `post_id` = '%d' AND
                  `date` = '%s' AND
                  `flag` = '%s'",
            $post_id, $args['date'], $args['flag'])
    );

    if( empty($var) ) return false;

    return true;
}

/**
 * Count products
 */
function ae_update_all_products(){

	$count = ae_total_count_products();

	echo empty($count) ? 0 : $count;

	die();
}
add_action('wp_ajax_ae_update_all_products', 'ae_update_all_products');

/**
 * Update products
 */
function ae_update_step_product() {

	global $wpdb;

	$from   = intval($_POST['step']); //текущая позиция
	$count  = intval($_POST['count']); //общее количество
	$len    = intval($_POST['len']); //количество записец за итерацию

	$len    = $len <= 0 ? 1 : $len;

	$delete = get_site_option('ae-delete');

	$current = $len*$from - $len;

	if( $current <= 0 ) { $current = 0; }
	if( $current > $count ) { echo 0; die(); }

	$insert = new AliExpressInsert();
	$pub = new AliExpressPublish();
	
	$result = $insert->updateProductsDetailsMini( $current, $len );

	foreach( $result as $key => $productId ) {

		if( isset($productId['error']) ){

			if( isset($productId['id']) ) {

				if( !empty($productId['post_id']) ) {
					if( $delete == 1 ){
						wp_delete_post($productId['post_id'], true);
						$wpdb->delete( $wpdb->prefix . "ae_products", array( 'post_id' => $productId['post_id'] ), array( '%d' ) );
					}
					else{
						$wpdb->update(
							$wpdb->prefix . "ae_products",
							array( 'availability' => 0, 'quantity' => 0 ),
							array( 'post_id' => $productId['post_id'] ),
							array( '%d', '%d' ),
							array( '%d' )
						);
					}
				}
			}
		}
		else {

			if ($productId) {
				$pub->setId( $productId );
				$pub->updateParametrs();
			}
			
		}
	}

	ae_set_max_price();
}
add_action('wp_ajax_ae_update_step_product', 'ae_update_step_product');

/**
 * Create file to export all products and insert the categories into file
 */
function ae_csv_create() {

	if( !current_user_can('level_9') ) die();

	require_once( dirname(__FILE__) . '/class.AECSV.php');

	$obj = new AECSV( 'export-' . date('Y-m-d-H-i-s') . '.csv' );

	$file = $obj->create_file();

	if( isset($file['url']) ) {

		$obj->setFilePath( $file['file'] );

		$terms = $obj->list_taxonomy();

		if($terms){

			$content = '';

			foreach( $terms as $term )
				$content .= json_encode($term) . "\n";

			$obj->write_content( $content );

			echo json_encode(
				array(
					'path'  => $file['file'],
					'url'   => $file['url'],
					'count' => $obj->count_products()
				)
			);
		}
	}

	die();
}
add_action('wp_ajax_ae_csv_create', 'ae_csv_create');

/**
 * Write into file the data of products
 */
function ae_csv_export_products() {

	if( !current_user_can('level_9') ) die();

	require_once( dirname(__FILE__) . '/class.AECSV.php');

	$obj = new AECSV();

	$filename   = $_POST['file'];
	$len        = $_POST['len'];
	$step       = $_POST['step'];

	$obj->setFilePath( $filename );

	$limit = $len * $step - $len;

	if($limit < 0)
		$limit = 0;

	$posts = $obj->list_product( $limit, $len );

	if( $posts ) {

		$content = '';

		foreach( $posts as $post )
			$content .= json_encode($post) . "\n";

		$obj->write_content( $content );
	}

	die();
}
add_action('wp_ajax_ae_csv_export_products', 'ae_csv_export_products');


/**
 * Return count of reviews
 */
function ae_csv_count_review( ) {

	if( !current_user_can('level_9') ) die();

	require_once( dirname(__FILE__) . '/class.AECSV.php');

	$obj = new AECSV();

	echo $obj->count_reviews();

	die();
}
add_action('wp_ajax_ae_csv_count_review', 'ae_csv_count_review');

/**
 * Write into file the date about review
 */
function ae_csv_export_review() {

	if( !current_user_can('level_9') ) die();

	require_once( dirname(__FILE__) . '/class.AECSV.php');

	$obj = new AECSV();

	$filename   = $_POST['file'];
	$len        = $_POST['len'];
	$step       = $_POST['step'];

	$obj->setFilePath( $filename );

	$limit = $len * $step - $len;

	if($limit < 0)
		$limit = 0;

	$posts = $obj->list_review( $limit, $len );

	if( $posts ) {

		$content = '';

		foreach( $posts as $post )
			$content .= json_encode($post) . "\n";

		$obj->write_content( $content );
	}

	die();
}
add_action('wp_ajax_ae_csv_export_review', 'ae_csv_export_review');

/**
 * Get number of bytes by end of file
 */
function ae_csv_import_count_lines() {
//переименовать в lines и в js
	if( !current_user_can('level_9') ) die();

	require_once( dirname(__FILE__) . '/class.AECSV.php');

	$obj = new AECSV();

	$filename = $_POST['file'];
//нужно передать весь путь полный
	$obj->setFilePath( $filename );

	$num = $obj->get_number_lines();

	$args = array('error' => '', 'num' => 0);

	if( $num > 0 )
		$args['num'] = $num;
	else
		$args['error'] = __("I can't open file", 'ae');

	echo json_encode($args);
	die();
}
add_action('wp_ajax_ae_csv_import_count_lines', 'ae_csv_import_count_lines');

/**
 * Get number of lines by end of file
 */
function ae_csv_import_data() {

	if( !current_user_can('level_9') ) die();

	require_once( dirname(__FILE__) . '/class.AECSV.php');

	$obj = new AECSV();

	$filename = $_POST['file'];
	$bytes    = intval($_POST['bytes']);

	$obj->setFilePath( $filename );

	$num = $obj->import_big_data($bytes);

	$args = array('error' => '', 'bytes' => 0);

	if( $num > 0 )
		$args['bytes'] = $bytes;
	else
		$args['error'] = __("I can't open file", 'ae');

	echo json_encode($args);
	die();
}
add_action('wp_ajax_ae_csv_import_data', 'ae_csv_import_data');

function ae_getFileList() {

    $upload_dir = (object) wp_upload_dir();
    $dir        = $upload_dir->path;
    // массив, хранящий возвращаемое значение
    $retval = array();

    // добавляет конечный слеш, если была возвращена пустота
    if(substr($dir, -1) != "/") $dir .= "/";

    // указать путь до директории и прочитать список вложенных файлов
    $d = @dir($dir) or die("getFileList: Не удалось открыть каталог $dir для чтения");
    while(false !== ($entry = $d->read())) {

        // пропустить скрытые файлы
        if( $entry[0] == "." ) continue;

        if( is_dir($dir . $entry) ) {
            $retval[] = array(
                "name" => $dir . $entry . '/',
                "size" => 0,
                "lastmod" => filemtime($dir . $entry)
            );
        }
        elseif( is_readable($dir . $entry) ) {
            $retval[] = array(
                "name" => $entry,
                "size" => filesize($dir . $entry),
                "lastmod" => filemtime($dir . $entry)
            );
        }
    }
    $d->close();
    function sorta($a, $b) {
        if ($a['lastmod'] < $b['lastmod'])
            return 1;
    }

    usort($retval, 'sorta');

    printf(
        '<table class="table-striped table-bordered table-hover"><th>%s</th><th>%s</th><th>%s</th><th>%s</th>',
        __('Pick', 'ae'), __('Name', 'ae'), __('Size', 'ae'), __('Date', 'ae')
    );

    foreach($retval as $file) {

        printf(
            '<tr>
                <td><input type="radio" name="file_to_input" value="%1$s"></td>
                <td>%1$s</td>
                <td>%2$s</td>
                <td>%3$s</td>
            </tr>',
            $file['name'], $file['size'], date('r', $file['lastmod'])
        );
    }

    echo '</table>';

   // die();
}
add_action('wp_ajax_ae_getFileList', 'ae_getFileList');
