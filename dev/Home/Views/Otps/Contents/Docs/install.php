<section style="padding-top: 50px; background: #6f5499">
    <div class="container">
    	<h2 style="color: #fff">Download list</h2>
		<ul class="list-group">
		<?php foreach ($files as $key => $value) { ?>
			<li class="list-group-item">
				<a href="" class="btn btn-success badge">Download</a>
				<i class="glyphicon glyphicon-pushpin"></i> [<a href="<?php echo URL::to('/docs/'.$value->name.'/index.html') ?>"><?php echo $value->name; ?></a>] <?php echo $value->title; ?>
			</li>
    	<?php } ?>
		</ul>
    </div>
</section>