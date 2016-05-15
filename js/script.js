
	jQuery( function($) {
        $('#categories').change(function(){
            $('#dropcat').css('border', '1px solid #ddd');
            $('#keywords').css('border', '1px solid #ddd');
        });
        $('#keywords').focus(function(){
            $('#dropcat').css('border', '1px solid #ddd');
            $('#keywords').css('border', '1px solid #ddd');
        });
        $(document).on('change', '#dropcat', function(){
            $('#dropcat').css('border-color', '#ddd');
        });
		var t = {
				bulk			: $('form.bulk'),
				sheduled		: $('form.sheduled'),
				advanced		: $('form.advanced'),
				byproducts		: $('form.byproducts'),
				formremmove		: $('#remove'),
				formupdate		: $('#update'),
				btnremmove		: $('[name="remove"]'),
				update			: $('[name="update_products"]'),
				categoryId		: '[name="categories"]',
				keywords		: '[name="keywords"]',
                bigsale		    : '[name="bigsale"]',
				priceFrom		: '[name="pricefrom"]',
				priceTo			: '[name="priceto"]',
				promotionFrom	: '[name="promotionfrom"]',
				promotionTo		: '[name="promotionto"]',
				creditScoreFrom	: '[name="creditScoreFrom"]',
				creditScoreTo	: '[name="creditScoreTo"]',
				sort			: '[name="sort"]',
				send			: '[name="search-submit"]',
				productId		: '[name="productId"]',
				sendIds			: '[name="search-id-submit"]'
			},
			r = {
				output			: $('#request-data'),
				outputIds		: $('#request-data-by-id'),
				loadIds			: $('#request-data-by-id .load'),
				load			: $('#request-data .load'),
				content			: $('#request-content'),
				contentIds		: $('#request-content-id'),
				apply			: $('#result-apply'),
				formtranslate	: $('#setting-translate'),
				translateaction	: $('a.ae-action'),
				edittranslate	: $('td.can_edited'),
				savetranslate	: 'button[name="save-title"]',
				filters			: '#filters',
				success			: '#total-success',
				fail			: '#total-fail',
				spinner			: 'fa-spinner fa-spin',
				importAdv		: 'button[name="import-now"]',
				translateAdv	: 'button[name="do-translate"]',
				importID		: 'button[name="import-now-ids"]',
				dropcat			: 'select[name="dropcat"]',
				pstatus			: 'select[name="publishstatus"]',
				importBulk		: 'button[name="bulk-import"]',
				searchAgain		: 'button[name="btn-close"]',
				stop			: 'button[name="btn-stop"]',
				status			: '[name="status"]',
				totalShed		: $('#sheduled-filter'),
				filterRes		: $('#filter-result'),
				selectCat		: '#select-cat',
				progressInner	: '.progress-inner'
			},
			s = {
				btn				: $('[name="test_connection"]'),
				app				: $('[name="AppKey"]'),
				track			: $('[name="trackingId"]'),
				method			: $('[name="method"]'),
				content			: $('#testConnection'),
				spinner			: $('#spinner-load'),
				modalcontent	: $('#Modal .tab-content')
			},
			tr = {
				bulk_count	: "You did not indicate how many imported products",
				bulk_size	: "You specified a value greater than can be import",
				pId			: "Product ID",
				imNow		: "Import Now",
				sAgain		: "Search Again",
				progress	: "Overall Progress",
				link		: "Get link",
				preview		: "Preview",
				prev		: "Prev",
				next		: "Next",
				notfound	: "This product does not participate in the Program",
				del			: "Are you sure you want to delete all products?"
			};



		var tt = get_translate();

		if( tt != null )
			tr = tt;

		function get_translate(){

			var tr = null;

			$.ajax({
				url: ajaxurl,
				async: false,
				data: {'action': 'ae_get_translate'},
				type: "POST",
				success: function (response) {
					tr = aetoJSON(response);
				}
			});

			return tr;
		}

		r.totalShed.on( 'click', function(e) {
            if ($("#categories").val()=='' && $('#dropcat').val()=='0'){
                $('#dropcat').css('border', '1px solid red')
                return false;
            }{
                $('#dropcat').css('border', '1px solid #ddd')
            }
			e.preventDefault();

            var  fs          = 0,
                 th 		 = $(this),
                 thform 	 = th.parents('form'),
                 ourcat      = $('#dropcat').val(),
                 status      = thform.find(r.pstatus).val(),
                 unitType    = $('#unitType').val();
            if( $('#fs').is(':checked') )
                fs = 1;
			$.ajaxQueue({
				url:  ajaxurl,
				data: {
					action: 		'ae_total_sheduled',
					categoryId:		t.sheduled.find( t.categoryId ).val(),
					keywords: 		t.sheduled.find( t.keywords ).val(),
					priceFrom: 		t.sheduled.find( t.priceFrom ).val(),
					priceTo: 		t.sheduled.find( t.priceTo ).val(),
					promotionFrom: 	t.sheduled.find( t.promotionFrom ).val(),
					promotionTo: 	t.sheduled.find( t.promotionTo ).val(),
					creditScoreFrom:t.sheduled.find( t.creditScoreFrom ).val(),
					creditScoreTo: 	t.sheduled.find( t.creditScoreTo ).val(),
                    fs:             fs,
                    ourcat:         ourcat,
                    status:         status,
                    unitType:       unitType

				},
				type: "POST",
				success: function(data){
					r.filterRes.html(data);
					r.apply.show();
				}
			});
		});

		/* bulk */
		t.bulk.on( 'click', t.send, function(e) {

			e.preventDefault();
            if ($("#categories").val()=='' && $('#keywords').val()==''){
                $('#keywords').css('border', '1px solid red')
                return false;
            }{
                $('#keywords').css('border', '1px solid #ddd')
            }

			$.ajaxQueue({
				url:  ajaxurl,
				data: {
					action: 		'ae_total_goods_in_cat',
					categoryId:		t.bulk.find( t.categoryId ).val(),
					keywords: 		t.bulk.find( t.keywords ).val(),
					priceFrom: 		t.bulk.find( t.priceFrom ).val(),
					priceTo: 		t.bulk.find( t.priceTo ).val(),
					promotionFrom: 	t.bulk.find( t.promotionFrom ).val(),
					promotionTo: 	t.bulk.find( t.promotionTo ).val(),
					creditScoreFrom:t.bulk.find( t.creditScoreFrom ).val(),
					creditScoreTo: 	t.bulk.find( t.creditScoreTo ).val()
				},
				type: "POST",
				beforeSend: function(){

					t.bulk.find('.load').show();
					aeLoading();
				},
				success: function(data){
					r.load.hide();
					r.content.html(data).show();
				},
				complete: aeScrollDown
			});
		});
		
		$(document).on('click', r.importBulk, function(e){
            if ($("#categories").val()=='' && $('#dropcat').val()=='0'){
                $('#dropcat').css('border', '1px solid red')
                return false;
            }{
                $('#dropcat').css('border', '1px solid #ddd')
            }
			e.preventDefault();
			
			var th 			= $(this),
				gage 		= parseInt( th.data('gage') ),
				thform 		= th.parents('form'),
				quantity 	= thform.find('[name="quantity"]'),
				size 		= quantity.val(),
				cc			= 5,
                fs          = 0,
                ourcat      = $('#dropcat').val(),
                status      = thform.find(r.pstatus).val(),
                unitType    = $('#unitType').val();
                bigsale     = t.bulk.find(t.bigsale);
                bigsale     = ( bigsale[0].checked ) ? 'y' : '';


            if( $('#fs').is(':checked') )
                fs = 1;

			if( size == 0 || size == "" ) {
				
				th.parents('.bulk-settings').find('.count-total').append('<div class="alert alert-danger">'+tr.bulk_count+'</div>');
				
				return false;
			}
			
			if( size > gage || size > 10000) {
				
				th.parents('.bulk-settings').find('.count-total').append('<div class="alert alert-danger">'+tr.bulk_size+'</div>');
				
				return false;
			}

			th.parents('.bulk-settings').find('.count-total .alert').remove();

			thform.find( r.stop ).show();
			thform.find( r.importBulk ).hide();
			
			r.content.find(r.success).text(0);
			r.content.find(r.fail).text(0);
			
			var pos 	= Math.ceil(size/cc),
				step 	= 1,
				st 		= 1,
				len 	= 100/pos;

			thform.find( r.status ).val(0);
			ajax_loader( thform.find('.loader'), true );

			for( var p = 1; p <= pos; p++){
				
				$.ajaxQueue({
					url:  ajaxurl,
					data: {
                        action:		    'ae_bulk_import_step1',
                        categoryId:		t.bulk.find( t.categoryId ).val(),
                        keywords: 		t.bulk.find( t.keywords ).val(),
                        priceFrom: 		t.bulk.find( t.priceFrom ).val(),
                        priceTo: 		t.bulk.find( t.priceTo ).val(),
                        promotionFrom: 	t.bulk.find( t.promotionFrom ).val(),
                        promotionTo: 	t.bulk.find( t.promotionTo ).val(),
                        creditScoreFrom:t.bulk.find( t.creditScoreFrom ).val(),
                        creditScoreTo: 	t.bulk.find( t.creditScoreTo ).val(),
                        bigsale: 	    bigsale,
                        page_no: 		p,
                        size:			size,
                        cc:				cc,
                        fs:             fs,
                        ourcat:         ourcat,
                        status:         status,
                        unitType:       unitType
					}, 
					type: "POST",
					beforeSend: function(e){

						var status = thform.find( r.status ).val();
						
						if( status === '1' ) {

							quantity.val('');
					
							$('#total-progress .progress-bar').css({'width': '100%'}).attr('aria-valuenow', 100).text( "100%" );
							
							thform.find( r.stop ).hide();
							thform.find( r.importBulk ).show();
							thform.find( r.searchAgain ).show();
							ae_set_max_price();
							ajax_loader( thform.find('.loader'), false );

							e.abort();
							return false;
						}
						else{
							
							thform.find( r.searchAgain ).hide();
							
							var per = Math.floor(len*step);
						
							$('#total-progress .progress-bar').css({'width': per+'%'}).attr('aria-valuenow', per).text( per+"%" );
						}
					},
					success: function(data) {

						var obj = aetoJSON(data),
							s 	= parseInt(r.content.find(r.success).text()),
							f 	= parseInt(r.content.find(r.fail).text()),
							vs 	= 0,
							vf 	= 0;
						
						if( typeof obj.success != 'undefined' ) 
							vs 	= parseInt(obj.success);

						if( typeof obj.fail != 'undefined' )
							vf 	= parseInt(obj.fail);
						
						r.content.find(r.success).text(s+vs);
						r.content.find(r.fail).text(f+vf);
						
						step = step + 1;
						if(step <= pos){
							console.log("Position: "+step+' of '+pos);
						}
					},
					complete: function(){
						
						st = st + 1;
						
						if( st > pos ){
							console.log("end");
							thform.find( r.stop ).hide();
							thform.find( r.searchAgain ).show();
							thform.find( r.importBulk ).show();
							ae_set_max_price();
							ajax_loader( thform.find('.loader'), false );
						}
					}
				});
			}
		});

		/**
		 *	Import products by ID
         * @todo запилить импорт со статусом
		 */
		$(document).on('click', r.importID, function(){
			
			var box = $(this).parents('.import-settings'),
				th 	= box.find('table.advanced-result tbody'),
				foo = th.find('[type="checkbox"]:checked');

			var size = foo.length,
				cat = box.find(r.dropcat).val(),
                status = box.find(r.pstatus).val();

			if( size == 0 )
				return false;
			
			var len = 100/size,
				t	= 0,
				cs 	= 0;
			
			r.contentIds.find(r.success).text(0);
			r.contentIds.find(r.fail).text(0);
			r.contentIds.find(r.progressInner).show();
			
			$(r.importID).find('span.fa').addClass(r.spinner);

			ajax_loader( box.find('.loader'), true );

			loadProgress();
			
			$.each( foo, function(){

				var ch 			= $(this).parents('tr'),
					productId 	= $(this).val(),
					packageType = $(this).data('package'),
					price 		= $(this).data('price'),
					lot 		= $(this).data('lot'),
					productUrl 	= $(this).data('url'),
					salePrice 	= $(this).data('sale'),
					actualTime 	= $(this).data('date'),
					imageUrl	= ch.find('td.thumb img').attr('src'),
					subject		= ch.find('td.title .this_title').text(),
					volume		= ch.find('td.volume').text(),
					score		= ch.find('td.score').text(),
					current 	= $(this).parents('.import-settings');
				
				$.ajaxQueue({
					url:  ajaxurl,
					data: {
						action: 			'ae_publish_product_id',
						actualTime:			actualTime,
						evaluateScore:		score,
						lotNum:				lot,
						productUrl:			productUrl,
						promotionVolume:	volume,
						packageType:		packageType,
						price:				price,
						imageUrl:			imageUrl,
						subject:			subject,
						salePrice:			salePrice,
						productId:			productId,
						owncat:				cat,
                        status:             status
					},
					type: "POST",
					beforeSend: function(){
						t 	= t + 1;
						var per = Math.floor(len*t);

						current.find('.progress-bar').css({'width': per+'%'}).attr('aria-valuenow', per).text( per+"%" );
						
						//console.log( "Load position: "+t );
					},
					success: function(data){
						cs = cs + 1;

						var obj = aetoJSON(data),
							s 	= parseInt(r.contentIds.find(r.success).text()),
							f 	= parseInt(r.contentIds.find(r.fail).text());
							
						if( typeof obj.success != 'undefined' ) {
							
							r.contentIds.find(r.success).text(s+1);
							
							var th = ch.find('td.title'),
								title = '<a href="'+obj.url+'"><span class="this_title">'+subject+'</span></a><div class="item-inner-info">'+tr.pId+': '+productId+'</div>',
								code = promotedBtn(productUrl);
								
							th.parents('tr').find('td').addClass('exists');

							th.html(title+' '+code);
						}
						
						if( typeof obj.error != 'undefined' )
							r.contentIds.find(r.fail).text(f+1);
					},
					complete: function() {
						if(cs == size){
							//console.log( "Load is complete" );
							$(r.importID).find('span.fa').removeClass(r.spinner);
							ae_set_max_price();
							ajax_loader( box.find('.loader'), false );
						}
					}
				});
			});
		});

		/**
		 *	Selective import products
		 */
		$(document).on('click', r.importAdv, function(){
            if ($("#categories").val()=='' && $('#dropcat').val()=='0'){
                $('#dropcat').css('border', '1px solid red');
                return false;
            }{
                $('#dropcat').css('border', '1px solid #ddd');
            }
			var box = $(this).parents('.import-settings'),
				th 	= box.find('table.advanced-result tbody'),
				foo = th.find('[type="checkbox"]:checked');

			var size = foo.length,
				cat = $('#dropcat').val(),
                status = box.find(r.pstatus).val();

			if( size == 0 )
				return false;

			var len = 100/size,
				t	= 0,
				cs 	= 0;

			r.content.find(r.success).text(0);
			r.content.find(r.fail).text(0);
			r.content.find(r.progressInner).show();

			$(r.importAdv).find('span.fa').addClass(r.spinner);
			ajax_loader( box.find('.loader'), true );

			loadProgress();

			$.each( foo, function(){

				var ch 			= $(this).parents('tr'),
					productId 	= $(this).val(),
					packageType = $(this).data('package'),
					price 		= $(this).data('price'),
					lot 		= $(this).data('lot'),
					productUrl 	= $(this).data('url'),
					salePrice 	= $(this).data('sale'),
					category 	= $(this).data('category'),
                    freeShippingCountry 	= $(this).data('freeShippingCountry'),
					actualTime 	= $(this).data('date'),
					imageUrl	= ch.find('td.thumb img').attr('src'),
					subject		= ch.find('td.title .this_title').text(),
					volume		= ch.find('td.volume').text(),
					score		= ch.find('td.score').text(),
					current 	= $(this).parents('.import-settings');

				$.ajaxQueue({
					url:  ajaxurl,
					data: {
						action: 						'ae_publish_product',
						categoryAE:						category,
                        freeShippingCountry:			freeShippingCountry,
						actualTime:						actualTime,
						evaluateScore:					score,
						lotNum:							lot,
						productUrl:						productUrl,
						promotionVolume:				volume,
						packageType:					packageType,
						price:							price,
						imageUrl:						imageUrl,
						subject:						subject,
						salePrice:						salePrice,
						productId:						productId,
						owncat:							cat,
                        status:             			status
					},
					type: "POST",
					beforeSend: function(){

						t 	= t + 1;
						var per = Math.floor(len*t);

						current.find('.progress-bar').css({'width': per+'%'}).attr('aria-valuenow', per).text( per+"%" );
						//console.log( "Load position: "+t );
						
					},
					success: function(data){

						cs = cs + 1;
						
						var obj = aetoJSON(data),
							s 	= parseInt(r.content.find(r.success).text()),
							f 	= parseInt(r.content.find(r.fail).text());

						if( typeof obj.success != 'undefined' ) {

							r.content.find(r.success).text(s+1);

							var th = ch.find('td.title'),
								title = '<a href="'+obj.url+'"><span class="this_title">'+subject+'</span></a><div class="item-inner-info">'+tr.pId+': '+productId+'</div>',
								code = promotedBtn(productUrl);

							th.parents('tr').find('td').addClass('exists');

							th.html(title+' '+code);
						}

						if( typeof obj.error != 'undefined' )
							r.content.find(r.fail).text(f+1);
					},
					complete: function() {
						if(cs == size){
							$(r.importAdv).find('span.fa').removeClass(r.spinner);
							ae_set_max_price();
							ajax_loader( box.find('.loader'), false );
						}
					}
				});
			});
		});

		/**
		 *	translate
		 */
		$(document).on('click', r.translateAdv, function(e){

			var btn = $(this),
				box = btn.parents('.import-settings'),
				th 	= box.find('table.advanced-result tbody'),
				foo = th.find('[type="checkbox"]:checked'),
				lang = r.formtranslate.find('select[name="translate_to"]').val();

			var size = foo.length;

			if( size == 0 )
				return false;

			var len = 100/size,
				t	= 0,
				cs 	= 0;

			btn.find('span.fa').addClass(r.spinner);
			ajax_loader( box.find('.loader'), true );

			loadProgress();

			$.each( foo, function(){

				var th 		= $(this),
					type 	= th.data('type'),
					line	= th.parents('tr'),
					item_id	= th.val();

				$.ajaxQueue({
					url:  ajaxurl,
					data: {
						action: 	'ae_translate_item',
						type:		type,
						item_id:	item_id,
						lang:		lang
					},
					type: "POST",
					beforeSend: function(){
						t 	= t + 1;
						var per = Math.floor(len*t);

						box.find('.progress-bar').css({'width': per+'%'}).attr('aria-valuenow', per).text( per+"%" );
					},
					success: function(data){
						cs = cs + 1;

						var obj = aetoJSON(data);
						if( typeof obj.message != 'undefined' ) {
						}
						else {
							line.find('td.original span').text(obj.o_title);
							line.find('td.title span').text(obj.title);
						}

						th.click();
					},
					complete: function() {
						if(cs == size){
							btn.find('span.fa').removeClass(r.spinner);
							ajax_loader( box.find('.loader'), false );

							setTimeout(function(){
								box.find('.progress-bar').css({'width':'0%'}).attr('aria-valuenow', 0).text( "0%" );
							}, 500);
						}
					}
				});
			});

			e.preventDefault();
		});

		r.translateaction.on('click', function(){

			var th = $(this),
				type = th.data('type'),
				doing = th.data('do'),
				line = th.parents('tr');

			if( doing == 'translate' ) {
				th.parents('tr').find('input[type="checkbox"]').click();
				th.parents('.import-settings').find('button[name="do-translate"]').click();
			}
			else if( doing == 'repair' ) {
				var id = th.parents('tr').find('input[type="checkbox"]').val();

				$.ajaxQueue({
					url:  ajaxurl,
					data: {
						action: 	'ae_repair_translate_item',
						type:		type,
						item_id:	id
					},
					type: "POST",
					beforeSend: function(){
						th.find('span.fa').addClass(r.spinner);
					},
					success: function(data){

						var obj = aetoJSON(data);
						if( typeof obj.message != 'undefined' ) {
						}
						else {
							line.find('td.original span').text(obj.o_title);
							line.find('td.title span').text(obj.title);
						}
					},
					complete: function() {
						th.find('span.fa').removeClass(r.spinner);
					}
				});
			}

			return false;
		});

		$(document).click(function() {

			if( r.edittranslate.find('form').length > 0 ){
				var form = r.edittranslate.find('form'),
					text = form.find('input[name="tr-title"]').val();

				form.parents('tr').find('td.can_edited span.item-inner-info').
					html(text+' <span class="this-edit fa fa-pencil-square-o"></span>');
			}
		});

		r.edittranslate.click(function(event) {event.stopPropagation();});

		r.edittranslate.on('click', 'span.this-edit', function() {

			if( $(this).parents('form').find('input').length > 0 ) return false;

			var th 		= $(this).parents('td').find('span.item-inner-info'),
				str 	= th.text(),
				type 	= th.parents('tr').find('input[type="checkbox"]').data('type');

			var form = '<form><input type="text" name="tr-title" value="'+str+'" data-type="'+type+'">' +
				'<button type="submit" name="save-title"><span class="fa fa-floppy-o"></span></button></form>';

			th.html(form);
			$(this).remove();
		});

		r.edittranslate.on('click', r.savetranslate, function(e) {

			e.preventDefault();

			var th 		= $(this).parents('form'),
				text 	= th.find('input[name="tr-title"]'),
				str 	= $.trim(text.val()),
				type 	= text.data('type'),
				line 	= th.parents('tr'),
				id 		= line.find('input[type="checkbox"]').val();

			if( str.length == 0 ){

				text.css({'border':'1px solid #ff0000'});
				return false;
			}

			$.ajaxQueue({
				url:  ajaxurl,
				data: {
					action: 	'ae_save_new_title_item',
					type:		type,
					item_id:	id,
					title:		str
				},
				type: "POST",
				beforeSend: function(){
					th.find('span.item-inner-info span.fa').addClass(r.spinner);
				},
				success: function(data){

					var obj = aetoJSON(data);
					if( typeof obj.message != 'undefined' ) {
						//console.log(obj.message);
						th.find('span.item-inner-info span.fa').removeClass(r.spinner);
					}
					else {
						line.find('td.can_edited span.item-inner-info').html(str);
						line.find('td.can_edited').append('<span class="this-edit fa fa-pencil-square-o"></span>');
					}
				},
				complete: function() {
					//console.log( "New title saved" );
				}
			});
		});

		/* search by products ID */
		t.byproducts.on( 'click', t.sendIds, function(e) {
			
			e.preventDefault();

			ajaxProducts();
			
		});

		/* advanced */
		t.advanced.on( 'click', t.send, function(e) {
            if ($("#categories").val()=='' && $('#keywords').val()==''){
                $('#keywords').css('border', '1px solid red')
                return false;
            }{
                $('#keywords').css('border', '1px solid #ddd')
            }

			e.preventDefault();

			ajaxAdvansed( 1 );

		});

		/* click to sort btn */
		$(document).on('click', r.filters+' a' , function(e) {

			e.preventDefault();

			t.advanced.find(t.sort).val( $(this).data('order') );

			ajaxAdvansed( 1, false );
		});
		
		/* mass checked */
		$(document).on('click', '.import-settings .mass-checked', function(){
			
			var th = $(this).parents('table').find('tbody'),
				current = $(this).parents('.import-settings');
			
			if( $(this).hasClass('that-true') ){
				th.find('[type="checkbox"]').attr('checked', false);
				$(this).removeClass('that-true fa-check-square-o').addClass('fa-square-o');
				current.find('span.count-import').text('(0)');
			}
			else{
			
				th.find('[type="checkbox"]').attr('checked', true);
				
				var count = th.find('[type="checkbox"]:checked').length;
				
				$(this).addClass('that-true fa-check-square-o').removeClass('fa-square-o');
				current.find('span.count-import').text('('+count+')');
			}
		});
		
		$(document).on('click', '.import-settings table tbody [type="checkbox"]', function(){
			
			var th = $(this).parents('tbody'),
				count = th.find('[type="checkbox"]:checked').length,
				countall = th.find('[type="checkbox"]').length,
				current = $(this).parents('.import-settings');
			
			if( count == countall )
				current.find('.mass-checked').addClass('that-true fa-check-square-o').removeClass('fa-square-o');
			else
				current.find('.mass-checked').removeClass('that-true fa-check-square-o').addClass('fa-square-o');
			
			
			count = th.find('[type="checkbox"]:checked').length;
			current.find('span.count-import').text('('+count+')');
		});
		
		/* options */
		$(document).on('click', r.stop, function(e){
			
			e.preventDefault();
			
			var th = $(this).parents('form');
			
			th.find( r.status ).val(1);
		});
		
		$(document).on('click', r.searchAgain, function(e){
			e.preventDefault();
			var current = $(this).parents('.import-settings');
			current.find('button.close').click();
		});
		
		$(document).on('click', '.content-inner button.close', function(){

			t.bulk.find('.load').hide();
			t.advanced.find('.load').hide();
			t.byproducts.find('.load').hide();
			r.output.hide();
			r.outputIds.hide();
			r.load.hide();
			r.loadIds.hide();
			r.content.find('.'+$(this).data('dismiss')).remove();
			r.contentIds.find('.'+$(this).data('dismiss')).remove();
		});

		function ajax_loader( th, action ) {
			if( action === true )
				th.show();
			else
				th.hide();
		}

		function aeLoading() {
			
			r.output.show();
			r.load.show();
			r.content.hide();
		}

		function aeLoadingIds() {

			r.outputIds.show();
			r.loadIds.show();
			r.contentIds.hide();
		}
		
		function aeScrollDown(){
			$('html, body').animate({scrollTop: r.output.offset().top}, 1500);
		}
		
		function aeModalLoading() {
			
			s.spinner.show();
			s.modalcontent.hide();
		}
		
		function aeModalDone() {
			
			s.spinner.hide();
			s.modalcontent.show();
		}

		function loadProgress(){
			$(r.importAdv).parent().find('.loading .progress').show();
		}

		/*
		*	advanced search
		**/
		function ajaxAdvansed(page, scroll, beforeTable){

			var total = 0,
				categoryId = t.advanced.find( t.categoryId ).val(),
                bigsale = t.advanced.find(t.bigsale);

            bigsale = ( bigsale[0].checked ) ? 'y' : '';
			
			$.ajaxQueue({
				url:  ajaxurl,
				data: {
					action: 		'ae_advanced_show', 
					categoryId:		categoryId, 
					keywords: 		t.advanced.find( t.keywords ).val(),
					priceFrom: 		t.advanced.find( t.priceFrom ).val(), 
					priceTo: 		t.advanced.find( t.priceTo ).val(),
					promotionFrom: 	t.advanced.find( t.promotionFrom ).val(), 
					promotionTo: 	t.advanced.find( t.promotionTo ).val(),
					creditScoreFrom:t.advanced.find( t.creditScoreFrom ).val(), 
					creditScoreTo: 	t.advanced.find( t.creditScoreTo ).val(),
					sort: 			t.advanced.find( t.sort ).val(),
                    bigsale:        bigsale,
					page_no:		page
				},
				type: "POST",
				beforeSend: function(){
					aeLoading();
					t.advanced.find('.load').show();
				},
				success: function(data){
					
					var response = aetoJSON(data);
					
					if( typeof response.error != 'undefined' ) {
						
						r.load.hide();
						
						var before = (typeof response.before != 'undefined') ? response.before : '';
						r.content.html(before+''+response.error).show();
						
						return false;
					}
					
					total = response.result.totalResults;

					var filters_menu = ae_get_filters_menu(response.sort);

					r.load.hide();
					
					var output = '<div class="advanced-settings import-settings">';
						
						output += response.before;
						
						output += '<h2>'+response.title+'</h2>\
									<div class="row"> \
										<div class="col-md-12 col-sm-24">\
											<div id="select-cat"></div>\
											<div class="item-group">\
												<button name="import-now" class="btn orange-bg"><span class="fa fa-cloud-download"></span> '+tr.imNow+' <span class="count-import">(0)</span></button> \
												<button name="btn-close" class="btn green-bg"><span class="fa fa-close"></span> '+tr.sAgain+'</button> \
											</div>\
										</div>\
										<div class="col-md-12 col-sm-24">'+response.total+' '+response.info+' \
											<label class="descript">'+tr.progress+' <span class="loader" style="display:none"></span></label> \
											<div class="progress" id="total-progress"> \
												<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0">0%</div> \
											</div> \
										</div>\
									</div>';

						if( typeof beforeTable == 'undefined' || beforeTable === false)
							output += '<div class="beforeTable"><div class="pull-right" id="filters">'+filters_menu+'</div><div id="pagination-info" class="pagination-inner"></div></div>';

						output += '<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover advanced-result" id="items-list-result">';
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
							
							output += ' <tr id="product-'+str.productId+'" data-item="'+str.productId+'" class="each"> \
											<td class="cb"><input type="checkbox" name="cb" value="'+str.productId+'" data-package="'+str.packageType+'" data-price="'+str.originalPrice+'" data-lot="'+str.lotNum+'" data-url="'+str.productUrl+'" data-sale="'+str.salePrice+'" data-category="'+categoryId+'" data-date="'+str.validTime+'"></td> \
											<td class="thumb"><img src="'+str.imageUrl+'_220x220.jpg" class="img-responsive"></td> \
											<td class="title">\
												<span class="this_title">'+str.productTitle+'</span> \
												<div class="item-inner-info">'+tr.pId+': '+str.productId+'</div>\
												'+promotedBtn(str.productUrl)+'\
											</td> \
											<td class="price">'+str.salePrice+'/'+str.packageType+'</td> \
											<td class="rate">'+rate+'%</td> \
											<td class="commission">US $'+commission+'</td> \
											<td class="volume">'+str.volume+'</td> \
											<td class="score">'+str.evaluateScore+'</td> \
										</tr>';
						});
						
						output += '</tbody>';
					
					output += "</table>";

					if( typeof beforeTable == 'undefined' || beforeTable === false)
						output += '<div id="pagination-info" class="pagination-inner"></div>';

					output += "</div>";
					
					r.content.html(output).show();
				}
			}).done(function(){
				if( typeof scroll == 'undefined' || scroll === true )
					aeScrollDown();

				createPagination( '.pagination-inner', total, page );
				getDropdownCat();
				getPermalink( r.content );
			});
		}

		/*
		*	search by product id
		**/
		function ajaxProducts(){

			var total = 0,
				ids = t.byproducts.find(t.productId).val();

			$.ajaxQueue({
				url:  ajaxurl,
				data: {
					action: 'ae_search_by_id_show',
					ids: 	ids
				},
				type: "POST",
				beforeSend: function(){
					aeLoadingIds();
					t.byproducts.find('.load').show();
				},
				success: function(data){

					var response = aetoJSON(data);

					if( typeof response.error != 'undefined' ) {

						r.loadIds.hide();

						var before = (typeof response.before != 'undefined') ? response.before : '';
						r.contentIds.html(before+''+response.error).show();

						return false;
					}

					total = response.totalResults;

					r.loadIds.hide();

					var output = '<div class="advanced-settings import-settings">';

						output += response.before;

						output += '<h2>'+response.title+'</h2>\
									<div class="row"> \
										<div class="col-md-12 col-sm-24">\
											<div id="select-cat"></div>\
											<div class="item-group">\
												<button name="import-now-ids" class="btn orange-bg"><span class="fa fa-cloud-download"></span> '+tr.imNow+' <span class="count-import">(0)</span></button> \
												<button name="btn-close" class="btn green-bg"><span class="fa fa-close"></span> '+tr.sAgain+'</button> \
											</div>\
										</div>\
										<div class="col-md-12 col-sm-24">'+response.total+' '+response.info+' \
											<label class="descript">'+tr.progress+' <span class="loader" style="display:none"></span></label> \
											<div class="progress" id="total-progress"> \
												<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0">0%</div> \
											</div> \
										</div>\
									</div>';

						output += '<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover advanced-result" id="items-list-result">';
						output += '<thead><tr>';

						$.each(response.header, function(i,str){
							output += '<th>'+str+'</th>';
						});

						output += '</tr></thead>';
						output += '<tbody>';

						var list_id = ids.split(',');

						$.each(response.result, function(i,str){

							if( typeof (str.notfound) != 'undefined' ) {
								output += '<tr class="each">\
										<td colspan="9"><div class="alert alert-danger">'+tr.pId+' '+ list_id[i] +' '+tr.notfound+'</div></td>\
									<tr>';

							}
							else {

								var rate = 8,
									commission = parseFloat((str.salePrice).replace('US $', '')) * ( rate / 100 );

								commission = commission.toFixed(2);

								output += '<tr id="product-' + str.productId + '" data-item="' + str.productId + '" class="each"> \
											<td class="cb"><input type="checkbox" name="cb" value="' + str.productId + '" data-package="' + str.packageType + '" data-price="' + str.originalPrice + '" data-lot="' + str.lotNum + '" data-url="' + str.productUrl + '" data-sale="' + str.salePrice + '" data-date="' + str.validTime + '"></td> \
											<td class="thumb"><img src="' + str.imageUrl + '_220x220.jpg" class="img-responsive"></td> \
											<td class="title">\
												<span class="this_title">' + str.productTitle + '</span> \
												<div class="item-inner-info">' + tr.pId + ': ' + str.productId + '</div>\
												' + promotedBtn(str.productUrl) + '\
											</td> \
											<td class="price">' + str.salePrice + '/' + str.packageType + '</td> \
											<td class="rate">' + rate + '%</td> \
											<td class="commission">US $' + commission + '</td> \
											<td class="volume">' + str.volume + '</td> \
											<td class="score">' + str.evaluateScore + '</td> \
										</tr>';
							}
						});

						output += '</tbody>';

					output += "</table>";
					output += "</div>";

					r.contentIds.html(output).show();

				}
			}).done(function(){
				getDropdownCat(true);
				getPermalink( $(r.contentIds) );
			});
		}

		function ae_get_filters_menu( data ){

			var out = '',
				current = t.advanced.find( t.sort ).val();

			$.each(data, function(key, val){

				if( key == 'title'){

					out += '<span class="title">'+val+'</span>';
				}
				else {

					var value = val.value.split(','),
						order = "",
						sorted = "",
						active = "";

					if (in_array(current, value) && value.length > 1) {
						var p = 0;
						$.each(value, function (i, index) {
							p = p + 1;
							if (index != current) {

								order = index;

								if(p == 1)
									sorted = '<span class="fa fa-sort-desc"></span>';
								else
									sorted = '<span class="fa fa-sort-asc"></span>';
							}
							else
								active = 'active';
						});
					}
					else {
						
						sorted = '<span class="fa fa-sort-desc"></span>';

						order = value[0];

						if (order == current)
							active = 'active';
					}

					out += '<a href="#" data-order="' + order + '" class="' + order + ' ' + active + '" id="sort-by-' + key + '">' + val.title + ' '+sorted+'</a> ';
				}
			});

			return out;
		}

		function getPermalink( content ){

			var tu = content.find('#items-list-result tr.each'),
				too = [];

            if( typeof tu == 'undefined') return;

			tu.each(function(){
				
				var id = $(this).data('item');

                if( typeof id != 'undefined')
				    too.push(id);
				
			});

            if(too.length == 0) return;

			$.ajaxQueue({
				url:ajaxurl,
				data:{
					'action':	'ae_permalink_import', 
					'products':	too
				},
				type:"POST",
				success: function(data){
					
					var response = aetoJSON(data);
				
					if( typeof response.not == 'undefined' ) {
					
						$.each(response, function(i, v){

							var th = $('#product-'+v.id+' td.title'),
							title = '<a href="'+v.url+'"><span class="this_title">'+th.find('.this_title').text()+'</span></a><div class="item-inner-info">'+tr.pId+': '+v.id+'</div>',
							//code = '<code>[ali_product id="'+v.post_id+'"]</code>';
							code = promotedBtn(v.productUrl);

							th.html(title+' '+code);
							th.parents('tr').find('td').addClass('exists');
						});
					}
				}
			});
		}
		
		function getDropdownCat( ids ) {
			
			$.ajaxQueue({
				url:ajaxurl,
				data:{'action':'ae_get_dropdowncat'},
				type:"POST",
				success: function(data){
					if( typeof ids == 'undefined' || ids === false )
						r.content.find(r.selectCat).html(data);
					else
						r.contentIds.find(r.selectCat).html(data);
				}
			});
		}
		
		$(document).on('click', 'button.getmodal', function(e){
			
			var th = $(this).parents('tr'),
				type = $(this).data('type');
			
			showPromoted(th, type);
			
			e.preventDefault();
		});
		
		function showPromoted(th, type) {
			
			var modal 	= $('#Modal'),
				img 	= th.find('.thumb img').attr('src'),
				link 	= th.find('.cb [name="cb"]').data('url'),
				title 	= th.find('.this_title').text();

			$.ajaxQueue({
				url:ajaxurl,
				data:{'action':'ae_get_promotion', 'link':link},
				type:"POST",
				beforeSend: aeModalLoading,
				success: function(data){

					var obj = aetoJSON(data);
					
					if( typeof obj.success != 'undefined' ) {
						
						modal.find('.nav li').removeClass('active');
						modal.find('.tab-pane').removeClass('active');
						
						var t = modal.find('#banner'),
							x = '<a href="'+obj.success+'" target="_blank"><img src="'+img+'"/><span style="display:block;">'+title+'</span></a>';
							
						t.find('.thumb span').html('<img src="'+img+'">');
						t.find('.title span').text(title);
						t.find('.code textarea').text(x);
							
						var l = modal.find('#link'),
							c = '<a href="'+obj.success+'" target="_blank">'+title+'</a>';
						
						l.find('.title span').text(title);
						l.find('.code textarea').text(c);
						
						modal.find('.nav li.'+type).addClass('active');
						modal.find('.tab-content #'+type).addClass('active');
					}
					
					if( typeof obj.error != 'undefined' )
						alert(obj.error);
				},
				complete: aeModalDone
			});
		}
		
		function createPagination( id, numItems, current ){
			
			var perPage = 20;
			
			if( numItems > 10000 ) numItems = 10000;

			$(id).pagination({
				items: numItems,
				itemsOnPage: perPage,
				currentPage: current,
				cssStyle: "light-theme",
				prevText: tr.prev,
				nextText: tr.next,

				onPageClick: function(pageNumber) {
				
					r.content.html('');
			
					ajaxAdvansed( pageNumber );
				}
			});
		}
		
		function promotedBtn(url){
			return '<p style="padding-top:5px">\
			<button type="button" class="getmodal btn btn-small red-bg btn-xs" data-toggle="modal" data-target="#Modal" data-type="link">'+tr.link+'</button> &nbsp; \
			<a href="'+url+'" target="_blank">'+tr.preview+'</a></p>';
		}
		
		/**
		 * test connetction
		*/
		s.btn.on('click', function(e){
			
			e.preventDefault();
			
			var app 	= s.app.val(),
				track 	= s.track.val(),
				method 	= s.method.val();

			s.content.show();
			t.formupdate.hide();

			$.ajaxQueue({
				url:ajaxurl,
				data:{'action':'ae_test_connection', 'app': app, 'track': track, 'method': method },
				type:"POST",
				beforeSend: function(){
					var spinner = '<div class="load text-center"><span class="fa fa-cog fa-spin fa-4x"></span></div>';
					s.content.html(spinner);
				},
				success: function(data){
					s.content.html(data);
				}
			});
		});

		/**
		*	Set max price
		*/
		function ae_set_max_price( ) {
			$.ajaxQueue({
				url:ajaxurl,
				data:{'action':'ae_set_max_price'},
				type:"POST",
				success: function(data){}
			});
		}

		/**
		*	Remove All Products
		*/
		t.btnremmove.on('click', function(e){

			e.preventDefault();

			var isDelete = confirm(tr.del);

			if(isDelete)
				ae_remove_all();
		});

		function ae_remove_all( ){

			var progress = t.formremmove.find('#total-progress .progress-bar'),
				step = 0;

			$.ajaxQueue({
				url:	ajaxurl,
				data:	{'action':'ae_get_terms_id'},
				type:	"POST",
				beforeSend: function(){
					t.btnremmove.find('span').addClass(r.spinner);
					progress.css({'width': '0%'}).attr('aria-valuenow', 0).text( "0%" );
				},
				success: function(data) {
					if( data != "" ) {
						data = aetoJSON(data);

						var con = data.length,
							len = 100 / con;

						if (con > 0) {

							$.each(data, function (i, index) {

								$.ajaxQueue({
									url: ajaxurl,
									data: {'action': 'ae_delete_products_from_terms', 'term_id': index},
									type: "POST",
									beforeSend: function () {

										step = i + 1;
										var per = Math.floor(len * step);

										progress.css({'width': per + '%'}).attr('aria-valuenow', per).text(per + "%");

										//console.log("Step: " + step);
									},
									success: function (data) {
										//console.log("Status: " + data);
									},
									complete: function () {
										if (step == con) {
											remove_prodcts();
										}
									}
								});
							});
						}
						else {
							t.btnremmove.find('span').removeClass(r.spinner);
							progress.css({'width': '100%'}).attr('aria-valuenow', 100).text("100%");
						}
					}
					else{
						t.btnremmove.find('span').removeClass(r.spinner);
						progress.css({'width': '100%'}).attr('aria-valuenow', 0).text("100%");
					}
				}
			});
		}

		function remove_prodcts() {

			$.ajaxQueue({
				url: ajaxurl,
				data: {'action': 'ae_delete_products_remaining'},
				type: "POST",
				success: function (data) {
					//console.log("end");
				},
				complete: function () {
					t.btnremmove.find('span').removeClass(r.spinner);
				}
			});
		}

		function in_array(needle, haystack, strict) {	// Checks if a value exists in an array

			var found = false, key, strict = !!strict;

			for (key in haystack) {
				if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
					found = true;
					break;
				}
			}

			return found;
		}

		/**
		 *	Update ALL Products
		 */
		t.update.on('click', function(e){e.preventDefault(); ae_update_all() });

		function ae_update_all( ){

			var progress = t.formupdate.find('#total-progress .progress-bar');

			s.content.hide();
			t.formupdate.show();
			ajax_loader( t.formupdate.find('.loader'), true );

			$.ajaxQueue({
				url:	ajaxurl,
				data:	{'action':'ae_count_products'},
				type:	"POST",
				beforeSend: function(){
					t.update.find('span').addClass(r.spinner);
					progress.css({'width': '0%'}).attr('aria-valuenow', 0).text( "0%" );
				},
				success: function(data) {

					if( data != '0' ) {

						var delta = Math.floor(data/20),
							len = 100 / delta,
							step = 0;

						for( var p = 1; p <= delta; p++ ) {

							$.ajaxQueue({
								url: ajaxurl,
								data: {'action': 'ae_update_products', 'position': p},
								type: "POST",
								beforeSend: function () {

									step = step + 1;

									var per = Math.floor(len * step);

									progress.css({'width': per + '%'}).attr('aria-valuenow', per).text(per + "%");

									//console.log("position : " + step);
								},
								success: function (response) {
									//console.log("status: " + response);
								},
								complete: function () {
									if (step == delta) {
										t.update.find('span').removeClass(r.spinner);
										ae_set_max_price();
										progress.css({'width': '100%'}).attr('aria-valuenow', 100).text("100%");
										ajax_loader( t.formupdate.find('.loader'), false );
									}
								}
							});
						}
					}
					else {
						t.update.find('span').removeClass(r.spinner);
						progress.css({'width': '100%'}).attr('aria-valuenow', 100).text("100%");
						ajax_loader( t.formupdate.find('.loader'), false );
					}
				}
			});
		}

        function aetoJSON(data){

            try {
                var response = $.parseJSON(data);
            }
            catch(e) {
                console.log(data);
                console.log(e);
                return false;
            }

            return response;
        }

	});