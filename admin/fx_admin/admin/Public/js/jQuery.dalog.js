;(function($,window,document){
	$.fn.extend({
		dialog:function(options){
			var defaults={
				alertBox:0.5,
				closeBtn:'.close',
				modalId:'#open'
			};
			var alertBox=$('<div class="alertBox"></div>')
			$('body').append(alertBox);
			op=$.extend({},defaults,options);
			return this.each(function(){
				$(this).on('click',function(e){
					var modal_id=op.modalId
//					$('.alertBox').click(function(){
//						close_modal(modal_id);
//					});
//					$(op.modalId).click(function(){
//						close_modal(modal_id);
//					});
					var modalHeight=$(modal_id).outerHeight();
					var modalWidth=$(modal_id).outerWidth();
					$('.alertBox').css({
						'display':'block',
						opacity:0
					});
					$('.alertBox').fadeIn(200,op.alertBox);
					$(modal_id).css({
						"display": "block",
						"position": "fixed",
						"opacity": 0,
						"z-index": 11000,
						"left": 50 + "%",
						"margin-left": -(modalWidth / 2) + "px",
						"top": op.top + "px"
					})
					$(modal_id).fadeTo(200,0.5)
					e.preventDefault()
					$(op.closeBtn).on('click',function(){
					close_modal(modal_id)
					e.preventDefault()
				})
			})
			});
			function close_modal(modal_id){
				$('.alertBox').fadeOut(200);
				$(modal_id).fadeOut(200);
			}
		}
	})
})(jQuery,window,document)
