<?php if($message = Flash::read('danger')): ?>
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Error!</h4>
<?php foreach($message as $value) :?>
<div><?php echo $value; ?></div>
<?php endforeach; ?>
</div>
<?php endif; ?>


<?php if($message = Flash::read('success')): ?>
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> Success!</h4>
<?php foreach($message as $value) :?>
<div><?php echo $value; ?></div>
<?php endforeach; ?>
</div>
<?php endif; ?>