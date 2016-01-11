<div class='oxy-appbar'>
    <ul class="oxy-appbar-links">
        <?php 
        $mod_name = 'Dashboard';
        if(isset($module_details['name'])):
          $mod_name = $module_details['name'];
        endif; 
        ///
        /// Dashboard view
        ///
        if ( empty($module_details['sections']) AND empty($module_details['sections'][$active_section]['shortcuts']) AND empty($module_details['shortcuts'])): 
             $sections_str = "<li class='active-item'>".$mod_name."</li>";
        else: 
            //
            // Sections
            //
            $sections_str = '';
            foreach ($module_details['sections'] as $name => $section): ?>
                <?php if(isset($section['name']) && isset($section['uri'])): ?>
                    <?php if ($name === $active_section): ?>
                      <?php $sections_str .= "<li class='active-item'>".anchor($section['uri'], (lang($section['name']) ? lang($section['name']) : $section['name']),'class=""' ).'</li>'; ?>
                    <?php else: ?>
                      <?php $sections_str .= "<li class='inactive-item'>".anchor($section['uri'], (lang($section['name']) ? lang($section['name']) : $section['name']),'class=""').'</li>'; ?>                  
                    <?php endif; 
                endif; 
            endforeach;                    
        endif; ?>
        <?php echo $sections_str;?>
        <li class="lang_select pull-right ">
              <form class='' action="<?php echo current_url(); ?>" id="change_language" method="get">
                <select class="form-control hidden-sm hidden-xs" name="lang" onchange="this.form.submit();">
                  <?php foreach(config_item('supported_languages') as $key => $lang): ?>
                    <option value="<?php echo $key; ?>" <?php echo CURRENT_LANGUAGE == $key ? ' selected="selected" ' : ''; ?>>
                       <?php echo $lang['name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </form>
        </li>
    </ul>
</div> 
<?php if ( ! empty($module_details['sections'][$active_section]['shortcuts'])): ?>
    <div class="row app-shortcuts-bar">
        <?php
        ///
        /// Display Shortcuts
        ///
        $str ='';
        foreach ($module_details['sections'][$active_section]['shortcuts'] as $shortcut):
            $additional_class = '';
            $name   = $shortcut['name'];$uri  = $shortcut['uri'];
            //check if its a modal
            if(isset($shortcut['modal']) && ($shortcut['modal']===true)) {
                $additional_class   = 'as_modal';
            }
            $str .= "<a class='li_shortcut btn-flat btn-sm btn btn-default ".$additional_class."' href='".site_url($uri)."'>".lang($name)."</a> "; 
        endforeach;
        echo $str; ?>
    </div>
<?php endif;  ?>