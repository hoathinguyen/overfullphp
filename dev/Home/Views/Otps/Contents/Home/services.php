<section class="bg-primary" style="padding: 50px; background: #009e81"></section>
<div class="container" style="margin-top: 50px">
	<div class="row">
	<?php foreach($services as $service): ?>
	 	<div class="col-sm-6 col-md-4">
	    	<div class="thumbnail" style="position: relative;">
	      		<img src="<?php echo $service->image ?>" alt="" style="background: #09c; height: 200px">
	      		<div class="caption">
	        		<a href="<?php echo $service->url ?>"><?php echo $service->title ?></a>
	        		<div style="font-size: 11px;">
	        			<?php echo $service->description ?>
	        		</div>
	      		</div>
	    	</div>
	  	</div>
	<?php endforeach; ?>
	</div>
</div>