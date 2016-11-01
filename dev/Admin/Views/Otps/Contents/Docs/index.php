<?php echo $this->render('Elements\docs_navi', ['sub' => 'Index', 'folder' => 'Docs']); ?>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Document list</h3>
          <div class="pull-right"><a href="<?php echo URL::to('/docs/create') ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Create</a></div>
        </div>
        <div class="box-body">
          <table class="table">
            <tr>
              <th>Title</th>
              <th>Category</th>
              <th>Version</th>
              <th>Action</th>
            </tr>
            <?php foreach ($docs as $key => $value){ ?>
            <tr>
              <td><?php echo $value->title; ?></td>
              <td><?php echo $value->category; ?></td>
              <td><?php echo $value->version; ?></td>
              <td><a href="<?php echo URL::to('/docs/edit'); ?>">Edit</a></td>
            </tr>
            <?php } ?>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>