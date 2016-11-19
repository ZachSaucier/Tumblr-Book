$('.library-entry').each(function(){
	var entry = $(this);
	var more = entry.find('.more');
	var control = entry.find('.slide-control');
	
	more.hide();
	control.click(function(){
		if(more.is(':hidden')){
			more.slideDown();
			control.text('Less Info');
		}else{
			more.slideUp();
			control.text('More Info');
		}
	});
});