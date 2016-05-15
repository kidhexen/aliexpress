<?php 
	
	/**
	*	add shortcode from uploaded products
	*/
	add_shortcode( 'ali_product', 'ae_shortcode_product' );
	function ae_shortcode_product( $attr ) {
		
		if( !isset($attr['id']) ) return;
		
		$post_id = $attr['id'];
		
		$obj = new AEProducts();
		$obj->set( $post_id );
		
		$link 		= get_permalink( $post_id );
		if( !$link ) return;
		
		$price 		= $obj->getPrice();
		if( !$price ) return;
		
		$title		= get_the_title( $post_id );
		$price 		= $obj->getPrice();
		$saleprice 	= $obj->getSalePrice();
		$thumb 		= $obj->getThumb('medium');
		
		ob_start();
		
		?>
			<div class="ae-product-item">
				<div class="item-inner">
					<div class="thumb"><a href="<?php echo $link ?>"><img src="<?php echo $thumb ?>" class="img-responsive"></a></div>
					<div class="content">
						<a href="<?php echo $link ?>">
							<h3><?php echo $title ?></h3>
						</a>
						
						<div class="price">
							<?php 
								echo ( !empty($saleprice) ) ? 
									"<span><strike>" . $price . "</strike></span> <span>" . $saleprice . "</span>" : 
									"<span>" . $price . "</span>";
							?>
						</div>
					</div>
				</div>
			</div>
		<?php
		
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
	}
	
	/**
	*	add shortcode from media button to post
	*/
	add_shortcode( 'aebox', 'ae_shortcode_type_a' );
	function ae_shortcode_type_a( $attr ) {
		
		$defaults = array(
			'title' 	=> '',
			'price' 	=> '',
			'url' 		=> '',
			'image' 	=> '',
			'size' 		=> 'medium',
			'align' 	=> 'left',
			'layout' 	=> 'img-left-text-right',
			'target' 	=> '1',
			'nofollow' 	=> '1'
		);
		
		$args = wp_parse_args( $attr, $defaults );
		
		extract($args, EXTR_OVERWRITE);
		
		if( empty($url) || empty($title) || empty($image) ) return;
		
		$obj = new AEProducts();
		$image = $obj->getSizeImg( $image, $size );

		$n = ($nofollow == 1) ? 'rel="nofollow"' : '';
		$t = ($target == 1) ? '_blank' : '_self';
			
		$btn = '<a class="btn" href="' . $url . '" ' . $n . ' target="' . $t . '">' . __("Buy now", 'ae') . '</a>';
		
		ob_start();

		?>
			<div class="ae-product-box">
				<div class="inner-box clearfix <?php echo "text-" . $align ?>">
				
					<?php switch( $layout ) { 
						
						case "img-left-text-right" : ?>
							<div class="thumb pull-left"><a href="<?php echo $url ?>" class="link" <?php echo ($nofollow == 1) ? 'rel="nofollow"' : '' ?> target="<?php echo ($target == 1) ? '_blank' : '_self' ?>"><img src="<?php echo $image ?>" class="img-responsive"></a></div>
							<div class="content">
								<h3>
									<a href="<?php echo $url ?>" class="link" <?php echo ($nofollow == 1) ? 'rel="nofollow"' : '' ?> target="<?php echo ($target == 1) ? '_blank' : '_self' ?>"><?php echo $title ?></a>
								</h3>
								<p class="price"><?php _e("List Price", 'ae') ?>: <span><?php echo $price ?></span></p>
								<?php echo $btn ?>
							</div>
							<?php break;
						
						case "img-right-text-left" : ?>
							<div class="thumb pull-right"><a href="" class="link" <?php echo ($nofollow == 1) ? 'rel="nofollow"' : '' ?> target="<?php echo ($target == 1) ? '_blank' : '_self' ?>"><img src="<?php echo $image ?>" class="img-responsive"></a></div>
							<div class="content">
								<h3><a href="<?php echo $url ?>" class="link" <?php echo ($nofollow == 1) ? 'rel="nofollow"' : '' ?> target="<?php echo ($target == 1) ? '_blank' : '_self' ?>"><?php echo $title ?></a></h3>
								<p class="price"><?php _e("List Price", 'ae') ?>: <span><?php echo $price ?></span></p>
								<?php echo $btn ?>
							</div>
							<?php break;
						
						case "img-top-text-below" : ?>
							<div class="thumb"><a href="<?php echo $url ?>" class="link" <?php echo ($nofollow == 1) ? 'rel="nofollow"' : '' ?> target="<?php echo ($target == 1) ? '_blank' : '_self' ?>"><img src="<?php echo $image ?>" class="img-responsive"></a></div>
							<div class="content">
								<h3><a href="<?php echo $url ?>" class="link" <?php echo ($nofollow == 1) ? 'rel="nofollow"' : '' ?> target="<?php echo ($target == 1) ? '_blank' : '_self' ?>"><?php echo $title ?></a></h3>
								<p class="price"><?php _e("List Price", 'ae') ?>: <span><?php echo $price ?></span></p>
								<?php echo $btn ?>
							</div>
							<?php break;
						
						case "img-below-text-top" : ?>
							<div class="content">
								<h3><a href="<?php echo $url ?>" class="link" <?php echo ($nofollow == 1) ? 'rel="nofollow"' : '' ?> target="<?php echo ($target == 1) ? '_blank' : '_self' ?>"><?php echo $title ?></a></h3>
								<p class="price"><?php _e("List Price", 'ae') ?>: <span><?php echo $price ?></span></p>
								<?php echo $btn ?>
							</div>
							<div class="thumb"><a href="<?php echo $url ?>" <?php echo ($nofollow == 1) ? 'rel="nofollow"' : '' ?> class="link" target="<?php echo ($target == 1) ? '_blank' : '_self' ?>"><img src="<?php echo $image ?>" class="img-responsive"></a></div>
							<?php break;
						
						case "text-only" : ?>
							<div class="content">
								<h3><a href="<?php echo $url ?>" class="link" <?php echo ($nofollow == 1) ? 'rel="nofollow"' : '' ?> target="<?php echo ($target == 1) ? '_blank' : '_self' ?>"><?php echo $title ?></a></h3>
								<p class="price"><?php _e("List Price", 'ae') ?>: <span><?php echo $price ?></span></p>
								<?php echo $btn ?>
							</div>
							<?php break;
						
						case "image-only" : ?>
							<div class="thumb"><a href="<?php echo $url ?>" class="link" <?php echo ($nofollow == 1) ? 'rel="nofollow"' : '' ?> target="<?php echo ($target == 1) ? '_blank' : '_self' ?>"><img src="<?php echo $image ?>" class="img-responsive"></a></div>
							<?php break;
						
						default : ?>
							
							<div class="thumb pull-left"><a href="<?php echo $url ?>" class="link" <?php echo ($nofollow == 1) ? 'rel="nofollow"' : '' ?> target="<?php echo ($target == 1) ? '_blank' : '_self' ?>"><img src="<?php echo $image ?>" class="img-responsive"></a></div>
							<div class="content">
								<h3>
									<a href="<?php echo $url ?>" class="link" <?php echo ($nofollow == 1) ? 'rel="nofollow"' : '' ?> target="<?php echo ($target == 1) ? '_blank' : '_self' ?>"><?php echo $title ?></a>
								</h3>
								<p class="price"><?php _e("List Price", 'ae') ?>: <span><?php echo $price ?></span></p>
								<?php echo $btn ?>
							</div>
							
							<?php break; ?>
					
					<?php } ?>
				
				</div>
			</div>
		<?php
		
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
	}
?>