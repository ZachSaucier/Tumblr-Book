$('.library-entry').each(function(){
	var entry = $(this);
	var blogname = entry.find('.blogname').text();
	var more = entry.find('.more');
	var control = entry.find('.slide-control');
	var remove = entry.find('.library-remove');
	
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
	remove.click(function(){
		if(confirm('Remove '+blogname+' from your library?')){
			entry.slideUp();
			$.ajax({
				type: 'POST',
				url: 'library-remove.php',
				data: {blogname: blogname},
				success: function(resp){
					console.log('remove request sent to the database');
					console.log(resp);
				},
				error: function(){
					console.log('error on database delete query');
				}
			});	
		}
	});
});