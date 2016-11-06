<?php echo $this->render('Elements/docs_navi', ['sub' => 'Index', 'folder' => 'Files']); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
          <?php echo $this->render('Elements/flash_message'); ?>
        </div>
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Search document</h3>
                </div>
                <form role="form">
                    <div class="box-body">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Keyword:</label>
                          <input class="form-control" placeholder="Input your keyword" name="keyword" />
                        </div> 
                        <div class="col-md-3">
                          <label>Category:</label>
                          <select class="form-control" name="category">
                            <option value="0">All</option>
                            <option value="1">Framework</option>
                            <option value="2">Package</option>
                            <option value="3">Weight</option>
                          </select>
                        </div>
                        <div class="col-md-3">
                          <label>Version:</label>
                          <select class="form-control" name="version">
                            <option value="0">All</option>
                            <option value="1">1.x</option>
                          </select>
                        </div>
                        <!-- <div class="col-md-2">
                          <input class="form-control"/>
                        </div> -->
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
              <div class="pull-right"><a href="<?php echo URL::to('/files/create') ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Create</a></div>
            </div>
            <div class="box-body">
              <table class="table">
                <tr>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Version</th>
                  <th>Action</th>
                </tr>
                <?php foreach ($files as $key => $value){ ?>
                <tr>
                  <td><a href="<?php echo URL::to("/files/detail/$value->id"); ?>"><?php echo $value->title; ?></a></td>
                  <td><?php echo $value->category; ?></td>
                  <td><?php echo $value->version; ?></td>
                  <td>
                    <a href="<?php echo URL::to("/files/edit/$value->id"); ?>">Edit</a> | <a href="<?php echo URL::to("/files/delete/$value->id"); ?>">Delete</a>
                    </td>
                </tr>
                <?php } ?>
              </table>
            </div>
            </div>
        </div>
    </div>
</section>

@beginSection("js")
<script type="text/javascript">
    
</script>
@endSection