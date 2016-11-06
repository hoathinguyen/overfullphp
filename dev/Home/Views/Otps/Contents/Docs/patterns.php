<section style="padding-top: 50px; background: #c37f45">
    <div class="container">
    	<h2 style="color: #fff">Danh sách file</h2>
		<ul class="list-group">
		<?php if(empty($files)){ ?>
			<li class="list-group-item">Hiện tại chưa có pattern.</li>
		<?php } ?>
		<?php foreach ($files as $key => $value) { ?>
			<li class="list-group-item">
				<a href="<?php echo URL::to('/download/'.$value->id.'/pattern.html') ?>" class="btn btn-success badge" target="_blank">Download</a>
				<i class="glyphicon glyphicon-pushpin"></i> [<a href="<?php echo URL::to('/docs/'.$value->name.'/index.html') ?>"><?php echo $value->name; ?></a>] <?php echo $value->title; ?>
			</li>
    	<?php } ?>
		</ul>
    </div>
</section>