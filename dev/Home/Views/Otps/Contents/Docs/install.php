<section style="padding-top: 50px; background: #6f5499">
    <div class="container">
    	<h2 style="color: #fff">Danh sách file</h2>
		<ul class="list-group">
		<?php if(empty($files)){ ?>
			<li class="list-group-item">Hiện tại chưa có version framework.</li>
		<?php } ?>
		<?php foreach ($files as $key => $value) { ?>
			<li class="list-group-item">
				<a href="<?php echo URL::to('/download/'.$value->id.'/framework.html') ?>" class="btn btn-success badge" target="_blank">Download</a>
				<i class="glyphicon glyphicon-pushpin"></i> [<a href="<?php echo URL::to('/docs/'.$value->name.'/index.html') ?>"><?php echo $value->name; ?></a>] <?php echo $value->title; ?>
			</li>
    	<?php } ?>
		</ul>
    </div>
</section>