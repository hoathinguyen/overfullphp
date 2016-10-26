<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div style="padding: 10px; background: #ddd">
		<?php echo $title; ?>
	</div>
	<div style="padding: 10px; border: 1px solid #ddd">
		<b>Message:</b> <?php echo $message; ?>
		<br/><b>File:</b> <?php echo $file; ?>
		<br/><b>Line:</b> <?php echo $line; ?>
	</div>
	<?php if($isShowDetail === true && $lastErrors) {?>
	<div style="padding: 10px; border: 1px solid #ddd; margin-top: 10px">
	<?php foreach ($lastErrors as $key => $value) {?>	
	
		<div><?php echo $value; ?></div>
	
	<?php } ?>
	</div>
	<?php } ?>
</body>
</html>