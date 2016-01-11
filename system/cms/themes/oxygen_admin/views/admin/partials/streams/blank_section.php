
<div class="row">

    <div class="col-xs-12">

        <div class="box box-solid">

                <div class="box-header">
                  <h3 class="box-title"><?php if(isset($template['page_title'])) { echo lang_label($template['page_title']); } ?></h3>
                </div>
                <div class="box-body">
					<?php echo $content; ?>
                </div>

        </div>

    </div>

</div>