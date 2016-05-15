	
	<div class="media-frame-title">
		<h1><?php _e("Insert Products", 'ae') ?></h1>
	</div>
	<div class="media-frame-content">
		<div class="modal-content-single" style="display:none">
			<div id="back-to-search"><a href="#" class="btn green-bg btn-small btn-xs btn-back"><span class="fa fa-arrow-circle-left"></span> <?php _e("Back", 'ae') ?></a></div>
			<div class="row">
				<div class="col-md-10 col-sm-12">
					<div class="content-inner">
						
						<div class="item-group">
							<div class="row">
								<div class="col-md-24">
									<label for="title"><?php _e('Title', 'ae') ?></label>
									<input type="text" class="item-control-long" id="title" name="title" placeholder="">
								</div>
							</div>
						</div>

						<div class="item-group">
							<div class="row">
								<div class="col-md-24">
									<label><?php _e("Thumbnail", 'ae') ?></label>
									<div class="thumb"></div>
								</div>
							</div>
						</div>
						
						<div class="item-group">
							<div class="row">
								<div class="col-md-24">
									<label for="img-size"><?php _e('Image Size', 'ae') ?></label> 
									<select id="img-size" name="img-size">
										<option value="thumb"><?php _e("Small 50x50", 'ae') ?></option>
										<option value="medium"><?php _e("Medium 220x220", 'ae') ?></option>
										<option value="full"><?php _e("Full Size", 'ae') ?></option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="item-group">
							<div class="row">
								<div class="col-md-24">
									<label for="alignment"><?php _e('Alignment', 'ae') ?></label> 
									<select id="alignment" name="alignment">
										<option value="left"><?php _e("Left", 'ae') ?></option>
										<option value="right"><?php _e("Right", 'ae') ?></option>
										<option value="center"><?php _e("Center", 'ae') ?></option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="item-group">
							<div class="row">
								<div class="col-md-24">
									<label for="layout"><?php _e('Layout', 'ae') ?></label> 
									<select id="layout" name="layout">
										<option value="img-left-text-right"><?php _e("Image on Left, Text on Right", 'ae') ?></option>
										<option value="img-right-text-left"><?php _e("Image on Right, Text on Left", 'ae') ?></option>
										<option value="img-top-text-below"><?php _e("Image on Top, Text on Below", 'ae') ?></option>
										<option value="img-below-text-top"><?php _e("Image on Below, Text on Top", 'ae') ?></option>
										<option value="text-only"><?php _e("Text Only", 'ae') ?></option>
										<option value="image-only"><?php _e("Image Only", 'ae') ?></option>
									</select>
								</div>
							</div>
						</div>
						
						<h2><?php _e("Features", 'ae') ?></h2>
						
						<div class="item-group">
							<div class="row">
								<div class="col-md-24">
									<label for="target">
										<input type="checkbox" id="target" name="target" value="1"> 
										<?php _e('Open in New Window', 'ae') ?>
									</label> 
								</div>
							</div>
						</div>
						
						<div class="item-group">
							<div class="row">
								<div class="col-md-24">
									<label for="nofollow">
										<input type="checkbox" id="nofollow" name="nofollow" value="1"> 
										<?php _e('No Follow', 'ae') ?>
									</label> 
								</div>
							</div>
						</div>
						
						<div class="item-group">
							<button id="indert-shortcode" class="btn blue-bg"><span class="fa fa-share"></span> <?php _e("Save Shortcode", 'ae') ?></button>
						</div>
						
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
				
					<!-- 1 Image on Left, Text on Right -->
					<div class="type-view clearfix" id="img-left-text-right" style="display:none">
						<div class="thumb pull-left"><a href="" class="link" target="_blank"></a></div>
						<div class="content">
							<h3><a href="" class="link" target="_blank"></a></h3>
							<p class="price"><?php _e("List Price", 'ae') ?>: <span></span></p>
							<button class="btn btn-small green-bg"><?php _e("Order now", 'ae') ?></button>
						</div>
					</div>
					
					<!-- 2 Image on Right, Text on Left -->
					<div class="type-view clearfix" id="img-right-text-left" style="display:none">
						<div class="thumb pull-right"><a href="" class="link" target="_blank"></a></div>
						<div class="content">
							<h3><a href="" class="link" target="_blank"></a></h3>
							<p class="price"><?php _e("List Price", 'ae') ?>: <span></span></p>
							<button class="btn btn-small green-bg"><?php _e("Order now", 'ae') ?></button>
						</div>
					</div>
					
					<!-- 3 Image on Top, Text on Below -->
					<div class="type-view clearfix" id="img-top-text-below" style="display:none">
						<div class="thumb"><a href="" class="link" target="_blank"></a></div>
						<div class="content">
							<h3><a href="" class="link" target="_blank"></a></h3>
							<p class="price"><?php _e("List Price", 'ae') ?>: <span></span></p>
							<button class="btn btn-small green-bg"><span class="inline"><?php _e("Order now", 'ae') ?></span></button>
						</div>
					</div>
					
					<!-- 4 Image on Below, Text on Top -->
					<div class="type-view clearfix" id="img-below-text-top" style="display:none">
						<div class="content">
							<h3><a href="" class="link" target="_blank"></a></h3>
							<p class="price"><?php _e("List Price", 'ae') ?>: <span></span></p>
							<button class="btn"><span class="inline"><?php _e("Order now", 'ae') ?></span></button>
						</div>
						<div class="thumb"><a href="" class="link" target="_blank"></a></div>
					</div>
					
					<!-- 5 Text Only -->
					<div class="type-view clearfix" id="text-only" style="display:none">
						<div class="content">
							<h3><a href="" class="link" target="_blank"></a></h3>
							<p class="price"><?php _e("List Price", 'ae') ?>: <span></span></p>
							<button class="btn btn-small green-bg"><span class="inline"><?php _e("Order now", 'ae') ?></span></button>
						</div>
					</div>
					
					<!-- 6 Image Only -->
					<div class="type-view clearfix" id="image-only" style="display:none">
						<div class="thumb"><a href="" class="link" target="_blank"></a></div>
					</div>
				</div>
			</div>
		</div>
		<div class="inner-content">
			<div class="row">
				<div class="col-md-10 col-sm-9">
					<form action="" method="POST" class="review import-step-one">
						<div class="load text-center" style="display:none">
							<span class="fa fa-lock fa-4x"></span>
						</div>
						<div class="content-inner">
							
							<div class="item-group control-group clearfix">
								<label for="alicategories" class="col-md-5 col-sm-5"><?php _e('Select Category', 'ae') ?></label>
								<div class="col-md-15 col-sm-15">
									<?php echo ae_dropdown_categories( 'categories', 'standart' ) ?>
								</div>
							</div>
							<div class="item-group control-group clearfix">
								<label for="keywords" class="col-md-5 col-sm-5"><?php _e('Enter Keywords', 'ae') ?></label>
								<div class="col-md-15 col-sm-15">
									<input type="text" id="keywords" name="keywords" maxlength="50" placeholder="">
									<p><em><?php _e("Leave the field blank to import ALL products from selected category", 'ae')?></em></p>
								</div>
							</div>
							<div class="item-group control-group clearfix">
								<label class="col-md-5 col-sm-5"><?php _e('Commission Rate', 'ae') ?></label>
								<div class="col-md-15 col-sm-15">
									<input type="text" id="amount" value="8%" readonly>
									<p><em><?php _e("Fixed commission for all categories", 'ae') ?></em></p>
								</div>
							</div>
							<div class="item-group control-group clearfix">
								<label class="col-md-5 col-sm-5"><?php _e('Purchase Volume', 'ae') ?></label>
								<div class="col-md-15 col-sm-15">
									<input type="text" class="standart" name="promotionfrom"> -
									<input type="text" class="standart" name="promotionto">
									<p><em><?php _e("The amount of purchases of the product over the last 30-day period", 'ae') ?></em></p>
								</div>
								<div class="col-sm-24">
									<div id="slider-promotion" class="slider-range"></div>
								</div>
							</div>
							<div class="item-group control-group clearfix">
								<label class="col-md-5 col-sm-5"><?php _e('Unit Price', 'ae') ?></label>
								<div class="col-md-15 col-sm-15">
									<input type="text" class="standart" name="pricefrom"> -
									<input type="text" class="standart" name="priceto"> USD
								</div>
							</div>
							<div class="item-group control-group clearfix">
								<label class="col-md-5 col-sm-5"><?php _e('Feedback Score', 'ae') ?></label>
								<div class="col-md-15 col-sm-15">
									<input type="text" class="standart"  name="creditScoreFrom"> -
									<input type="text" class="standart"  name="creditScoreTo">
									<p><em><?php _e("The total number of positive feedback received by a seller", 'ae') ?></em></p>
								</div>
								<div class="col-sm-24">
									<div id="slider-credit" class="slider-range"></div>
								</div>
							</div>
							<div class="item-group">
								<button type="button" name="search-submit" class="btn green-bg"><span class="fa fa-search"></span> <?php _e("Apply Filter", 'ae') ?></button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-13 col-sm-12">
					<div id="request-data" style="display:none">
						<div class="content-inner">
							<div class="load text-center">
								<span class="fa fa-cog fa-spin fa-4x"></span>
							</div>
							<div id="request-content" class="bulk-settings"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>