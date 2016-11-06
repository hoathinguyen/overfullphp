<?php echo $this->render('Elements/docs_navi', ['sub' => 'Detail', 'folder' => 'Services']); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $service->title ?></h3>
                </div>
                <div class="box-body">
                  <?php echo $service->url ?>
                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </div>
    </div>
</section>