<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">
                	<?php if($is_admin_themes):?>
                		Admin Themes
                	<?php else:?>
                		<?php echo lang('addons:themes') ?>
                	<?php endif;?>	
                </h3>
            </div>
            <div class="box-body">

					<?php if ($themes): ?>
					
						<?php echo form_open('admin/addons/themes/set_default') ?>
						<?php echo form_hidden('method', $this->method) ?>

						<table id="standard_data_table" class="table table-bordered">
							<thead>
								<tr>
									<th width="50px" class="align-center"><?php echo lang('addons:themes:public_theme_label') ?></th>
									<th width="150px" class="align-center">Preview</th>
									<th width="15%"><?php echo lang('addons:themes:theme_label') ?></th>
									<th class=""><?php echo lang('global:description') ?></th>
									<th class="" width="15%"><?php echo lang('global:author') ?></th>
									<th width="50px" class="align-center"><?php echo lang('addons:themes:version_label') ?></th>
									<th width="250px"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($themes as $theme): ?>
								<tr>

									<td class="align-center"><input type="radio" name="theme" value="<?php echo $theme->slug ?>"
										<?php echo isset($theme->is_default) ? 'checked' : '' ?> />
									</td>
									<td>
										<img width="150px" src="<?php echo $theme->screenshot ?>" class="img-responsive thumbnail">
									</td>									
									<td>
										<?php if ( ! empty($theme->website)): ?>
											<?php echo anchor($theme->website, $theme->name, array('target'=>'_blank')) ?>
										<?php else: ?>
											<?php echo $theme->name ?>
										<?php endif ?>
									</td>
									<td class=""><?php echo $theme->description ?></td>
									<td class="">
										<?php if ($theme->author_website): ?>
											<?php echo anchor($theme->author_website, $theme->author, array('target'=>'_blank')) ?>
										<?php else: ?>
											<?php echo $theme->author ?>
										<?php endif ?>
									</td>
					
									<td class="align-center"><?php echo $theme->version ?></td>
									<td class="actions">
										<?php echo isset($theme->options) ? anchor('admin/addons/themes/options/'.$theme->slug, lang('addons:themes:options'), 'title="'.$theme->name.'" class="btn btn-flat bg-blue options"') : '' ?>
									</td>
								</tr>
								<?php endforeach ?>
							</tbody>
						</table>

						<?php $this->load->view('admin/partials/pagination') ?>
						
						<div>
							<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )) ?>
						</div>
						
						<?php echo form_close() ?>
					
					<?php else: ?>
						<div class="blank-slate">
							<p><?php echo lang('addons:themes:no_themes_installed') ?></p>
						</div>
					<?php endif ?>

               </div>
        </div>

    </div><!-- /.col -->

</div><!-- /.row -->