<section class="content-header">
    <h1>
      <i class="fa fa-book"></i> Document manager
      <small>Manage document control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo URL::to('/'); ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
      <li><a href="<?php echo URL::to(strtolower("/$folder")); ?>"><?php echo $folder; ?></a></li>
      <li class="active"><?php echo $sub; ?></li>
    </ol>
  </section>