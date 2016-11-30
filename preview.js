var selected = $('#theme div.selected');
var input = $('[type="hidden"]');
$('#theme>div').click(function(){
	selected.removeClass('selected');
	selected = $(this);
	selected.addClass('selected');
	input.val(selected.find('div').text());
});