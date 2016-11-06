<section class="bg-primary" style="padding: 50px"></section>
<section class="bg-default" style="padding: 20px; background: #eee">
    <div class="container">
        <a href="<?php URL::to('/docs/1.x/index.html') ?>" class="btn btn-warning" style="padding-left: 30px;padding-right: 30px">1.x</a>
    </div>
</section>
<section style="padding: 10px">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <ul>
                <?php foreach ($menu as $key => $value) { ?>
                   <li> <i class="<?php echo $value->icon ?>"></i> <a href="<?php echo URL::to("/docs/{$version}.x/posts-".$value->id.".html") ?>"><?php echo $value->title ?></a></li>
                <?php } ?>
                </ul>
            </div>
            <div class="col-md-9" style="border-left: 1px solid #ddd">
            <?php if(!$doc){  ?>
                    Tài liệu không tồn tại.
            <?php } else {?>
                    <?php echo $doc->content; ?>
            <?php } ?>
            </div>
        </div>
    </div>
</section>