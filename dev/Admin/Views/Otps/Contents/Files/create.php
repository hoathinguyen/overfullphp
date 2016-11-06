<?php echo $this->render('Elements\docs_navi', ['sub' => 'Create', 'folder' => 'Files']); ?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title"><?php echo $type; ?> document</h3>
          <div class="pull-right box-tools">
            <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        
        <?php echo Form::open('file'); ?>
          <?php echo Form::hidden('id'); ?>
          <div class="box-body pad">
            <div class="form-group">
              <label for="formtitle">Title</label>
              <?php echo Form::input('title', ['class' => 'form-control']); ?>
              <span class="text-danger"><?php echo Form::message('title'); ?></span>
            </div>
            <div class="form-group">
              <label for="formtitle">Url</label>
              <?php echo Form::input('url', ['class' => 'form-control']); ?>
              <span class="text-danger"><?php echo Form::message('title'); ?></span>
            </div>
            <div class="form-group">
              <label for="formcategory">Category</label>
              <?php echo Form::select('category_id', ['1' => 'Framework', '2' => 'Package', '3' => 'Weight'],['class' => 'form-control', 'id' => "formcategory"]); ?>
              <span class="text-danger"><?php echo Form::message('category_id'); ?></span>
            </div>
            <div class="form-group">
              <label for="formversion">Version</label>
              <?php echo Form::select('version_id', ['1' => '1.x'], ['class' => 'form-control', 'id' => "formversion"]); ?>
              <span class="text-danger"><?php echo Form::message('version_id'); ?></span>
            </div>
            <div class="form-group">
              <label for="formcontent">Content</label>
              <?php echo Form::textarea('content', ['class' => 'form-control', 'id' => 'formcontent']); ?>
              <span class="text-danger"><?php echo Form::message('content'); ?></span>
            </div>
          </div>
          <div class="box-footer">
            <?php echo Form::submit('submit', ['class' => 'btn btn-primary', 'value' => $type]); ?>
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