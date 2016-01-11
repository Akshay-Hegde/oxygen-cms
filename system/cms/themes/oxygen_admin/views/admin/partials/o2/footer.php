
      <!--
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          DEMO VERSION
        </div>
        <strong>Activate your product</strong>.
      </footer>
      -->

      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-md hidden-lg">
            <ul id="lang">
              <form action="<?php echo current_url(); ?>" id="change_language" method="get">
                <select class="chzn" name="lang" onchange="this.form.submit();">
                  <?php foreach(config_item('supported_languages') as $key => $lang): ?>
                    <option value="<?php echo $key; ?>" <?php echo CURRENT_LANGUAGE == $key ? ' selected="selected" ' : ''; ?>>
                       <?php echo $lang['name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </form>
            </ul>
        </div>

        <small>
            <!-- Default to the left -->
            <strong>
                Copyright &copy; <?php echo date('Y'); ?> 
                Oxygen<span style='color:#666'>CMS</span>
            </strong>
            Version <?php echo CMS_VERSION.'.<small>'.CMS_MIGRATION_VERSION.'</small>'; ?> &nbsp;&nbsp;<em><?php echo CMS_EDITION; ?></em> &nbsp; Rendered in {elapsed_time} sec. using {memory_usage}.
        </small>

    </footer>