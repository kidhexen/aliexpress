	jQuery(function($){

		var tr = {
			not_found	: "The Original of Description not found.",
			panelText 	: 'Translate Into:',
			moreText 	: '42 More Languages »',
			busyText 	: 'Translating page...',
			cancelText 	: 'cancel',
			doneText 	: 'Translated by the',
			undoText 	: 'Undo »'
		};

		$(document).on('click', 'a.translate-this-button', function(e){
			insert_content();
		});
		
		$(document).on('mouseover', 'a.translate-this-button', function(e){
			insert_content();
		});
		
		$(document).on('click', 'a#alirestore', function(e){
			
			e.preventDefault();
			
			$.ajaxQueue({
				url:  ajaxurl,
				data: {
					action: 		'ae_get_description', 
					post_id:		$('[name="post_ID"]').val()
				},
				type: "POST",
				beforeSend: function(){
					aeLoader('show');
				},
				success: function(data){
					
					aeLoader('hide');
					
					if(data != '0'){
						
						var json = $.parseJSON(data);
						
						ae_set_tinymce_content('content', json.content);
						$('[name="post_title"]').val(json.title);
					}
					else
						alert(tr.not_found);
				}
			});
		});
		
		setTimeout(function(){
			TranslateThis({
				GA : false, // Google Analytics tracking
				scope : 'ali-translate-this-content', // ID to confine translation
				wrapper : 'translate-this', // ID of the TranslateThis wrapper
		
				onLoad : function() { 
					$('a.translate-this-button').css({'opacity': '1'});
					console.log('loaded') ;
					aeLoader('hide');
				}, // Callback function
				onClick : function() {aeLoader('show');},
				onComplete : function() {
					setTimeout(function(){
						
						var c = $('#ali-translate-this-content .post_content').html(),
							t = $('#ali-translate-this-content .post_title').html();
						
						$('[name="post_title"]').val(t);
						ae_set_tinymce_content('content', c);
						aeLoader('hide');
					},400);
				},
		
				cookie : false, // Name of the cookie - set to 0 to disable
		
				panelText 	: tr.panelText, // Panel header text
				moreText 	: tr.moreText, // More link text
				busyText 	: tr.busyText,
				cancelText 	: tr.cancelText,
				doneText 	: tr.doneText, // Completion message text
				undoText 	: tr.undoText, // Text for untranslate link
		
				undoLength : 10000, // Time undo link stays visible (milliseconds)
		
		
				ddLangs : [ // Languages in the dropdown
					'ru',
					'ar',
					'it',
					'ja',
					'zh-CN'
				],
		
				noBtn : true, 
				noImg : false, // whether to disable flag imagery
				imgHeight : 12, // height of flag icons
				imgWidth : 8, // width of flag icons
				bgImg : 'http://x.translateth.is/tt-sprite.png',
		
				reparse : true // whether to reparse the DOM for each translation
			});
		}, 100);
		
		function ae_get_tinymce_content(id) {
			var content,
				inputid = id,
				editor = tinyMCE.get(inputid),
				textArea = jQuery('textarea#' + inputid);   
			
			if (textArea.length > 0 && textArea.is(':visible')) {
				content = textArea.val();        
			}
			else {
				content = editor.getContent();
			}
			return content;
		}
		
		function ae_set_tinymce_content(id, str) {
			var inputid = id,
				editor = tinyMCE.get(inputid),
				textArea = jQuery('textarea#' + inputid);   
			
			if (textArea.length > 0 && textArea.is(':visible')) {
				textArea.val(str);        
			}
			else {
				editor.setContent(str);
			}
		}
		
		function insert_content(){
			var c = ae_get_tinymce_content('content'),
				t = $('[name="post_title"]').val();
			$('#ali-translate-this-content .post_content').html(c);
			$('#ali-translate-this-content .post_title').html(t);
		}
		
		function aeLoader(action){
			
			var r = $('#media-progress');
			
			if( action == 'hide' )
				r.hide();
			else if( action == 'show' )
				r.show();
		}
	});