<?php echo $this->render('Elements\docs_navi', ['sub' => 'Create', 'folder' => 'Docs']); ?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Create new document</h3>
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <form method="post">
          <div class="box-body pad">
            <div class="form-group">
              <label for="formtitle">Title</label>
              <input class="form-control" name="title" id="formtitle" value="<?php echo !empty($model->title) ? $model->title : null ?>">
            </div>
            <div class="form-group">
              <label for="formcategory">Category</label>
              <select class="form-control" name="category_id" id="formcategory" value="<?php echo !empty($model->category_id) ? $model->category_id : null ?>">
                <option value="1">Framework</option>
                <option value="2">Package</option>
                <option value="3">Weight</option>
              </select>
            </div>
            <div class="form-group">
              <label for="formversion">Version</label>
              <select class="form-control" name="version_id" id="formversion" value="<?php echo !empty($model->version_id) ? $model->version_id : null ?>">
                <option value="1">1.x</option>
              </select>
            </div>
            <div class="form-group">
              <label for="formcontent">Content</label>
              <textarea id="formcontent" name="content" rows="10" cols="80"><?php echo !empty($model->content) ? $model->content : null ?></textarea>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

@beginSection("js")
<!-- CK Editor -->
<script src="<?php echo URL::to('/plugins/ckeditor/ckeditor.js')?>"></script>
<script>
  $(function () {
    CKEDITOR.replace('formcontent');
    $(".textarea").wysihtml5();
  });
</script>
@endSection