<?php echo $this->render('Elements\docs_navi', ['sub' => 'Detail', 'folder' => 'Docs']); ?>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $doc->title ?></h3>
                </div>
                <div class="box-body">
                  <?php echo $doc->content ?>
                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </div>
    </div>
</section>