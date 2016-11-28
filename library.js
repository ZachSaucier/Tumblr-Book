var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
var date = new Date();
date = months[date.getMonth()]+' '+date.getDate()+', '+date.getFullYear();

if(myLibrary){
	var header = $('#header').text();
	if(header === ''){
		$('#open-edit').hide();
		$('#header').hide();
	}else{
		$('#edit-header').hide();
	}
	$('#open-edit').click(function(){
		$('#edit-header').show();
		$('#open-edit').hide();
		$('#header').hide();
	});
	$('#save').click(function(){
		$('#header').text($('#header-changes').val());
		if($('#header').text() !== ''){
			$('#edit-header').hide();
			$('#open-edit').show();
			$('#header').show();
		}
		$.ajax({
			type: 'POST',
			url: 'library-header.php',
			data: {header: $('#header').text()},
			success: function(resp){
				console.log('header update sent to the database');
				console.log(resp);
			},
			error: function(){
				console.log('error updating header in database');
			}
		});
	});
	$('#cancel').click(function(){
		$('#header-changes').val($('#header').text());
		if($('#header').text() !== ''){
			$('#edit-header').hide();
			$('#open-edit').show();
			$('#header').show();
		}
	});
}

$('.library-entry').each(function(){
	var entry = $(this);
	var blogname = entry.find('.blogname').text();
	var theme = entry.find('.theme').text();
	var more = entry.find('.more');
	var control = entry.find('.slide-control');
	var remove = entry.find('.library-remove');
	var add = entry.find('.library-add');
	
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
	if(add.text() === 'Add to Library'){		
		add.addClass('clickable-text');
		add.click(function(){
			add.text('In your Library');
			add.removeClass('clickable-text');
			add.off();
			$.ajax({
				type: 'POST',
				url: 'library-add.php',
				data: {blogname: blogname, theme: theme},
				success: function(resp){
					console.log('add request sent to the database');
					console.log(resp);
				},
				error: function(){
					console.log('error on database add query');
				}
			});
		});
	}
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