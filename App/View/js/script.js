var Flickr	= {
	'loadContent':	function(){
		$.ajax({
			url: "index.php?controller=list&action=ajax",
			type: "post",
			data: '' ,
			success: function (data) {
				$('.content').html(data);
			},
			error: function(data) {
				alert('Error');
			}
		});
	}
}