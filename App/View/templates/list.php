<?php
foreach($this->data as $item)
{
?>
<div class="flick_item">
	<div class="pic"><a href="<?php echo $item['href'] ?>"><img src="<?php echo $item['img'] ?>" width="200" height="240" alt="<?php echo $item['title'] ?>"/></a></div>
	<div class="icon">
		<i class="fa fa-rocket"></i>
	</div>
	<div class="info">
        	<div class="title"><?php echo $item['title'] ?> by <?php echo $item['author'] ?></div>
	</div>
</div>
<?php } ?>
<script>
	$( ".flick_item" ).mouseover(function(){
		$(this).children('.icon').show();
		console.log('here');
	});
	$( ".flick_item" ).mouseout(function(){
		$(this).children('.icon').hide();
	});
</script>