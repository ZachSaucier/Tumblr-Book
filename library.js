var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
var date = new Date();
date = months[date.getMonth()]+' '+date.getDate()+', '+date.getFullYear();

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
$('#post-comment').click(function(){
	var newComment = $('<div class="comment">');
	var content = $('#new-comment').val();
	newComment.html('<div><a href="library.php?user='+username+'">'+username+'</a> <span class="comment-date">'+date+'</span></div><div>'+content+'</div>');
	newComment.hide();
	$('#comments').append(newComment);
	newComment.slideDown();
	$('#new-comment').val('');
	$.ajax({
		type: 'POST',
		url: 'library-comment.php',
		data: {library: library, content: content},
		success: function(resp){
			console.log('comment sent to the database');
			console.log(resp);
		},
		error: function(){
			console.log('error saving comment to database');
		}
	});
});