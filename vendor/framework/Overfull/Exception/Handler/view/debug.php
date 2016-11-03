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
	<?php if($isShowDetail === true && $listStack) {?>
	<div style="padding: 10px; border: 1px solid #ddd; margin-top: 10px">
	<?php foreach ($listStack as $key => $value) {?>	
	
		<div style="padding: 5px; border: 1px dashed #eee">
			<span style="display: inline-block; padding: 2px 5px; font-weight: bold; border: 1px solid #eee; background: #eee"><?php echo $key+1 ?></span>
			<span style="display: inline-block; padding: 2px 5px; font-weight: bold; border: 1px solid #eee"><?php echo $value['file'] ?></span>
			<span style="display: inline-block; padding: 2px 5px; font-weight: bold; border: 1px solid #eee"><?php echo $value['function'] ?></span>
			<span style="display: inline-block; padding: 2px 5px; font-weight: bold; border: 1px solid #eee"><?php echo $value['line'] ?></span>
			<div>
				<?php var_dump($value['args']); ?>				
			</div>
		</div>
	
	<?php } ?>
	</div>
	<?php } ?>
</body>
</html>