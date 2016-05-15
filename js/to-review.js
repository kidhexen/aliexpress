
	jQuery(function($){
		
		var obj = {
			mbtn 	: '#aliproduct',
			modal 	: 'ae_modal_1',
			close 	: 'a.media-modal-close',
			content	: '.media-modal-content .media-frame'
		},
		imgsize = {
			'thumb' 	: '_50x50.jpg',
			'medium' 	: '_220x220.jpg',
			'full' 		: ''
		},
		act = {	
			review			: $('form.review'),
			categoryId		: '[name="categories"]',
			keywords		: '[name="keywords"]',
			priceFrom		: '[name="pricefrom"]',
			priceTo			: '[name="priceto"]',
			promotionFrom	: '[name="promotionfrom"]',
			promotionTo		: '[name="promotionto"]',
			creditScoreFrom	: '[name="creditScoreFrom"]',
			creditScoreTo	: '[name="creditScoreTo"]',
			send			: 'form.review [name="search-submit"]',
			content			: '#request-content',
			output			: '#request-data',
			load			: '#request-data .load',
			back 			: '#back-to-search a',
			shortcode 		: '#indert-shortcode',
			setup			: 'button.setup',
			inner			: '.media-frame-content .inner-content',
			mcontent		: '.media-frame-content .modal-content-single',
			layout			: '#layout',
			alignment		: '#alignment',
			title			: 'input[name="title"]',
			size			: '#img-size'
		};
		
		$(document).on('click', '#'+obj.modal+' '+act.setup, ae_setup_product);
		$(document).on('click', '#'+obj.modal+' '+act.back, ae_back_search);
		$(document).on('click', '#'+obj.modal+' '+act.shortcode, ae_save_shortcode);
		
		$(document).on('change', '#'+obj.modal+' '+act.size, function(){
			var size = $(this).val(),
				mc = $('#'+obj.modal+' '+act.mcontent),
				path = mc.find('[name="title"]').data('image');
			
			size = imgsize[size];
				
			mc.find('.type-view img').attr('src', path+''+size);
		});
		
		$(document).on('change', '#'+obj.modal+' '+act.alignment, function(){
			var align = $(this).val();
			
			$('#'+obj.modal+' '+act.mcontent+' .type-view').
				removeClass('text-right text-left text-center').
				addClass('text-'+align);
		});
		
		$(document).on('keyup', '#'+obj.modal+' '+act.title, function(){

			var mc 			= $('#'+obj.modal+' '+act.mcontent),
				title 		= $(this).val();
			
			mc.find('h3 a.link').html(title);
		});
		
		$(document).on('change', '#'+obj.modal+' '+act.layout, function(){
			var size = $(this).val(),
				mc = $('#'+obj.modal+' '+act.mcontent);
				
			mc.find('.type-view').hide();
			mc.find('.type-view#'+size).show();
		});
		
		$(document).on('change', '#'+obj.modal+' '+act.layout, function(){
			var size = $(this).val(),
				mc = $('#'+obj.modal+' '+act.mcontent);
				
			mc.find('.type-view').hide();
			mc.find('.type-view#'+size).show();
		});
		
		$(document).on('click', obj.mbtn, ae_open_modal);
		
		$(document).on('click', '#'+obj.modal+' '+obj.close, ae_close_modal);
		$(document).mouseup(
			function (e){
				var container = $('#'+obj.modal+' .media-modal');
				
				if (!container.is(e.target) && container.has(e.target).length === 0){
					ae_close_modal();
				}
			}
		);
		
		/* review */
		$(document).on( 'click', act.send, function(e) {
			
			e.preventDefault();

			ajaxReview( 1 );
			
		});
		
		function ae_setup_product(e) {
			
			e.preventDefault();
			
			var th = $(this).parents('tr'),
				url = th.data('url'),
				image = th.data('image'),
				price = th.data('price'),
				title = th.find('span.this_title').text(),
				mc = $('#'+obj.modal+' '+act.mcontent);

			$.ajaxQueue({
				url		: ajaxurl,
				data	: {action : 'ae_get_promotion', link:url},
				type	: "POST",
				success	: function(data){

					var response = $.parseJSON(data);

					if( typeof response.error == 'undefined' ) {

						mc.find('a.link').attr('href', response.success);
						mc.find('.thumb a.link').html('<img src="'+image+'_220x220.jpg" class="img-responsive">');
						mc.find('.content-inner .thumb').html('<img src="'+image+'_220x220.jpg" class="img-responsive">');
						mc.find('h3 a.link').html(title);
						mc.find('p.price span').html(price);

						mc.find('[name="title"]').val(title).data('image', image);
						mc.find('[name="img-size"] option[value="medium"]').attr("selected","selected");
						mc.find('[name="alignment"] option[value="left"]').attr("selected","selected");
						mc.find('[name="layout"] option[value="img-left-text-right"]').attr("selected","selected");

						mc.find('.type-view').hide();
						mc.find('.type-view#img-left-text-right').show();

						$('#'+obj.modal+' '+act.inner).hide();
						mc.show();
					}
				}
			});
		}
		
		function ae_back_search(e) {
			
			e.preventDefault();
			
			$('#'+obj.modal+' '+act.mcontent).hide();
			$('#'+obj.modal+' '+act.inner).show();
		}
		
		function ae_save_shortcode(e) {
			
			var id = 'content',
				editor = tinyMCE.get(id),
				textArea = $('textarea#' + id),
				content = '';
			
			var mc 			= $('#'+obj.modal+' '+act.mcontent),
				h 			= $('#'+obj.modal),
				link		= mc.find('a.link').attr('href'),
				title 		= mc.find('[name="title"]').val(),
				price 		= mc.find('p.price span').html(),
				image 		= mc.find('[name="title"]').data('image'),
				size 		= mc.find('[name="img-size"]').val(),
				align		= mc.find('[name="alignment"]').val(),
				layout 		= mc.find('[name="layout"]').val(),
				target		= ( mc.find('[name="target"]:checked').length > 0 ) ? 1 : 0,
				nofollow	= ( mc.find('[name="nofollow"]:checked').length > 0 ) ? 1 : 0;
			
			content = '[aebox title="'+title+'" price="'+price+'" url="'+link+'" image="'+image+'" size="'+size+'" align="'+align+'" layout="'+layout+'" target="'+target+'" nofollow="'+nofollow+'"]';
			
			e.preventDefault();
			
			$('#'+obj.modal+' '+act.mcontent).hide();
			$('#'+obj.modal+' '+act.inner).show();
			
			if (textArea.length > 0 && textArea.is(':visible')) {
				var pos = textArea.getCursorPosition(); 
				textArea.setCursorPosition(pos);
				textArea.insertAtCursor(content);				
			}
			else {
				editor.execCommand('mceInsertContent',false, content);
			}
			
			mc.hide();
			h.hide();
		}
		
		function ae_open_modal( ) {

			if( $('#'+obj.modal).length === 0 ) {
			
				var content = $('script[type="text/html"]#tmpl-media-modal').html();
				
				$('body').append('<div id="'+obj.modal+'">'+content+'</div>');
			}
			else
				$('#'+obj.modal).show();
			
			$.ajaxQueue({
				url		: ajaxurl,
				data	: {action : 'ae_review_form'},
				type	: "POST",
				success	: function(data){
					$('#'+obj.modal+' .media-modal-content').html('<div class="media-frame mode-select wp-core-ui">'+data+'</div>');
				}
			}).done(slider_form);
		}
		
		function ae_close_modal( ) {
			
			if( $('#'+obj.modal).length != 0 ) {
				
				$('#'+obj.modal).hide();
				
				$('#'+obj.modal+' '+obj.content).remove();
			}
		}
		
		function slider_form( ){
			if( ($('[name="promotionfrom"]').length > 0 &&
				$('[name="promotionfrom"]').val() != '') ||
				($('[name="creditScoreFrom"]').length > 0 && 
				$('[name="creditScoreFrom"]').val() != '')
			) {
				var promotionfrom 	= $( '[name="promotionfrom"]' ).val(),
					promotionto 	= $( '[name="promotionto"]' ).val(),
					creditScoreFrom = $( '[name="creditScoreFrom"]' ).val(),
					creditScoreTo 	= $( '[name="creditScoreTo"]' ).val();
			}
			else {
				var promotionfrom 	= 0,
					promotionto 	= 1000,
					creditScoreFrom = 5,
					creditScoreTo 	= 1000;
			}
			
			$( "#slider-promotion" ).slider({
				range: true,
				min: 0,
				step: 100,
				max: 10000,
				values: [ promotionfrom, promotionto ],
				slide: function( event, ui ) {
					$( '[name="promotionfrom"]' ).val( ui.values[ 0 ] );
					$( '[name="promotionto"]' ).val( ui.values[ 1 ] );
				}
			});
			
			$( "#slider-credit" ).slider({
				range: true,
				min: 0,
				step: 100,
				max: 10000,
				values: [ creditScoreFrom, creditScoreTo ],
				slide: function( event, ui ) {
					$( '[name="creditScoreFrom"]' ).val( ui.values[ 0 ] );
					$( '[name="creditScoreTo"]' ).val( ui.values[ 1 ] );
				}
			});

			$( '[name="promotionfrom"]' ).val( $( "#slider-promotion" ).slider( "values", 0 ) );
			$( '[name="promotionto"]' ).val( $( "#slider-promotion" ).slider( "values", 1 ) );
			$( '[name="creditScoreFrom"]' ).val( $( "#slider-credit" ).slider( "values", 0 ) );
			$( '[name="creditScoreTo"]' ).val( $( "#slider-credit" ).slider( "values", 1 ) );
		}
		
		function ajaxReview(page){
			
			var total = 0,
				categoryId = $('#'+obj.modal+' '+act.categoryId).val();
			
			$.ajaxQueue({
				url:  ajaxurl,
				data: {
					action: 		'ae_review_show', 
					categoryId:		categoryId,
					keywords: 		$('#'+obj.modal+' '+act.keywords).val(),
					priceFrom: 		$('#'+obj.modal+' '+act.priceFrom).val(),
					priceTo: 		$('#'+obj.modal+' '+act.priceTo).val(),
					promotionFrom: 	$('#'+obj.modal+' '+act.promotionFrom).val(), 
					promotionTo: 	$('#'+obj.modal+' '+act.promotionTo).val(),
					creditScoreFrom:$('#'+obj.modal+' '+act.creditScoreFrom).val(), 
					creditScoreTo: 	$('#'+obj.modal+' '+act.creditScoreTo).val(),
					page_no:		page
				},
				type: "POST",
				beforeSend: function(){
					loading();
					$('#'+obj.modal+' '+act.load).show();
				},
				success: function(data){
					
					var response = $.parseJSON(data);

					if( typeof response.error != 'undefined' ) {
						
						$('#'+obj.modal+' '+act.load).hide();
						
						var before = (typeof response.before != 'undefined') ? response.before : '';
						$('#'+obj.modal+' '+act.content).html(before+''+response.error).show();
						
						return false;
					}

					total = response.result.totalResults;
					
					$('#'+obj.modal+' '+act.load).hide();
					
					var output = '<div class="advanced-settings">';
						output += response.before;
						output += '<div id="pagination-info" class=""></div>';
						output += '<table cellpadding="0" cellspasing="0" class="table table-hover advanced-result" id="items-list-result">';
						output += '<thead><tr>';
						
						$.each(response.header, function(i,str){
							output += '<th>'+str+'</th>';
						});
						
						output += '</tr></thead>';	
						output += '<tbody>';
						
						$.each(response.result.products, function(i,str){
							var rate = 8,
								commission = parseFloat( (str.salePrice).replace('US $', '') )*( rate/100 );

							commission = commission.toFixed(2);
							
							output += ' <tr id="product-'+str.productId+'" data-item="'+str.productId+'" data-package="'+str.packageType+'" data-price="'+str.originalPrice+'" data-lot="'+str.lotNum+'" data-url="'+str.productUrl+'" data-image="'+str.imageUrl+'" data-sale="'+str.salePrice+'" data-category="'+categoryId+'" class="each"> \
										<td class="thumb"><img src="'+str.imageUrl+'_220x220.jpg" class="img-responsive"></td> \
										<td class="title"><span class="this_title">'+str.productTitle+'</span><p style="padding-top:5px"> \
										<button type="button" class="setup btn btn-small red-bg btn-xs">Setup</button></p></td> \
										<td class="price">'+str.salePrice+'/'+str.packageType+'</td> \
										<td class="rate">'+rate+'%</td> \
										<td class="commission">US $'+commission+'</td> \
										<td class="volume">'+str.volume+'</td> \
										<td class="score">'+str.evaluateScore+'</td> \
									</tr>';
						});
						
						output += '</tbody>';
					
					output += "</table>";
					output += "</div>";
					
					$('#'+obj.modal+' '+act.content).html(output).show();
				}
			}).done(function(){
				
				reviewPagination( '#pagination-info', total, page );
			});
		}
		
		function loading() {
			
			$('#'+obj.modal+' '+act.output).show();
			$('#'+obj.modal+' '+act.load).show();
			$('#'+obj.modal+' '+act.content).hide();
		}
		
		function reviewPagination( id, numItems, current ){
			
			var perPage = 20;
			
			if( numItems > 10000 ) numItems = 10000;

			$(id).pagination({
				items: numItems,
				itemsOnPage: perPage,
				currentPage: current,
				cssStyle: "light-theme text-center",

				onPageClick: function(pageNumber) {
				
					$('#'+obj.modal+' '+act.content).html('');
			
					ajaxReview( pageNumber );
				}
			});
		}
		
	});