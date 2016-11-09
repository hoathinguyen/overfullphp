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
		<?php if($isShowDetail === true) {?>
		<br/><b>File:</b> <?php echo $file; ?>
		<br/><b>Line:</b> <?php echo $line; ?>
		<?php } ?>
	</div>
	<?php if($isShowDetail === true && $listStack) {?>
	<div style="padding: 10px; border: 1px solid #ddd; margin-top: 10px">
	<?php foreach ($listStack as $key => $value) {?>	
	
		<div style="padding: 5px; border: 1px dashed #eee">
			<span style="display: inline-block; padding: 2px 5px; font-weight: bold; border: 1px solid #eee; background: #eee"><?php echo $key+1 ?></span>
			<span style="display: inline-block; padding: 2px 5px; font-weight: bold; border: 1px solid #eee"><?php echo isset($value['file']) ? $value['file'] : null ?></span>
			<span style="display: inline-block; padding: 2px 5px; font-weight: bold; border: 1px solid #eee"><?php echo isset($value['function']) ? $value['function'] : null ?></span>
			<span style="display: inline-block; padding: 2px 5px; font-weight: bold; border: 1px solid #eee"><?php echo isset($value['line']) ? $value['line'] : null ?></span>
			<div>
				<?php var_dump($value['args']); ?>				
			</div>
		</div>
	
	<?php } ?>
	</div>
	<?php } ?>
</body>
</html>