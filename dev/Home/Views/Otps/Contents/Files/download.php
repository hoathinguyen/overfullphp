<section class="bg-primary" style="padding: 50px; background: #009e81"></section>
<section style="padding: 10px">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div style="height: 80px; border:1px solid #ddd" class="text-center">
                	<h3><a href="http://share.overfull.net">Tham gia kênh chia sẻ online</a></h3>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2">
            	<div style="border:1px solid #ddd; margin-top: 10px">
            		<h3 style="margin: 0; padding: 5px; border-bottom: 1px solid #ddd; background: #eee"><?php echo $file->title ?></h3>
            		<?php if(!empty($file->url)): ?>
            		<div style="padding: 5px; border-bottom: 1px dashed #ddd;" class="text-center">
            			<a href="<?php echo $file->url ?>" class="btn btn-success">Download</a>
            		</div>
            		<?php endif; ?>
            		<div style="padding: 5px;">
            			<?php echo $file->content; ?>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</section>