jQuery(function($){
	$.fn.extend({
		
		//$("#mytextarea").setCursorPosition(5)
		setCursorPosition: function(position){
			if(this.length == 0) return this;
			return $(this).setSelection(position, position);
		},
		
		//$("#mytextarea").setSelection(0,5);
		setSelection: function(selectionStart, selectionEnd) {
			if(this.length == 0) return this;
			input = this[0];

			if (input.createTextRange) {
				var range = input.createTextRange();
				range.collapse(true);
				range.moveEnd('character', selectionEnd);
				range.moveStart('character', selectionStart);
				range.select();
			} else if (input.setSelectionRange) {
				input.focus();
				input.setSelectionRange(selectionStart, selectionEnd);
			}

			return this;
		},
		
		//$("#mytextarea").focusEnd()
		focusEnd: function(){
			this.setCursorPosition(this.val().length);
			return this;
		},
		
		//pos = $("#mytextarea").getCursorPosition();
		getCursorPosition: function() {
			var el = $(this).get(0);
			var pos = 0;
			if('selectionStart' in el) {
				pos = el.selectionStart;
			} else if('selection' in document) {
				el.focus();
				var Sel = document.selection.createRange();
				var SelLength = document.selection.createRange().text.length;
				Sel.moveStart('character', -el.value.length);
				pos = Sel.text.length - SelLength;
			}
			return pos;
		},
		
		//$("#mytextarea").setCursorPosition(5);
		//$("#mytextarea").insertAtCursor(" world!");
		insertAtCursor: function(myValue) {
			return this.each(function(i) {
				if (document.selection) {
				  //For browsers like Internet Explorer
				  this.focus();
				  sel = document.selection.createRange();
				  sel.text = myValue;
				  this.focus();
				}
				else if (this.selectionStart || this.selectionStart == '0') {
				  //For browsers like Firefox and Webkit based
				  var startPos = this.selectionStart;
				  var endPos = this.selectionEnd;
				  var scrollTop = this.scrollTop;
				  this.value = this.value.substring(0, startPos) + myValue + 
								this.value.substring(endPos,this.value.length);
				  this.focus();
				  this.selectionStart = startPos + myValue.length;
				  this.selectionEnd = startPos + myValue.length;
				  this.scrollTop = scrollTop;
				} else {
				  this.value += myValue;
				  this.focus();
				}
			})
		}
	});
});