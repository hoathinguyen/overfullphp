<?php echo $this->render('Elements\docs_navi', ['sub' => 'Index', 'folder' => 'Docs']); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Search document</h3>
                </div>
                <form role="form">
                    <div class="box-body">
                        <div class="input-group">
                        <input type="text" class="form-control" aria-label="Text input with segmented button dropdown">
                          <div class="input-group-btn">
                            <button type="button" class="btn btn-secondary">Action</button>
                            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="#">Action</a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else here</a>
                              <div role="separator" class="dropdown-divider"></div>
                              <a class="dropdown-item" href="#">Separated link</a>
                            </div>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
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