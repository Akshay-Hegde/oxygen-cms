<?php $icon = (isset($module_details['icon']))? $module_details['icon'] : 'fa fa-dashboard'; ?>
<?php $modname = (isset($module_details['name']))? $module_details['name'] : lang('global:dashboard'); ?>

<?php 
    /*
     * The following code builds the html for the left nav, html at end of doc.
     *
     */
    $str = '';

    foreach ($cms_menu_items as $menu_group => $data):

        $group_icon = (isset($data['icon']))?$data['icon']:'fa fa-edit';        
        $menu_items = isset($data['menu_items'])?$data['menu_items']:[];
        $menu_count = count($menu_items);
        $current_group = (isset($data['current_group']))?$data['current_group']:false;
        $current_colour = ($current_group)?' text-aqua':'';

        if($menu_count == 1):
            foreach ($menu_items as $key => $option)
            {
                $search_terms = lang_label($option['name']).' '.$option['name'];
                $str .= '<li class="nav_filter" search-terms="'.$search_terms.'"><a href="'.site_url($option['uri']).'"><i class="'.$option['icon'].$current_colour.'"></i> <span>'.lang_label($option['name']).'</span></a></li>';
            }
        endif;
        
        if ($menu_count > 1):
            $psearch_terms = lang_label($menu_group);
            $str .= ($current_group)?'<li search-terms="'.$psearch_terms.'" class=" treeview active">':'<li search-terms="'.$psearch_terms.'" class="treeview">';
            $str .= '<a href="#"><i class="'.$group_icon.$current_colour.'"></i> <span>'.lang_label($menu_group).'</span> <i class="fa fa-angle-left pull-right"></i></a>';
            $str .= ($current_group)? '<ul class="treeview-menu menu-open" style="display:block;">':'<ul class="treeview-menu">';

            foreach ($menu_items as $k => $option):

                $search_terms = $psearch_terms . ' '.lang_label($option['name']).' ';

                if( (isset($option['menu_items'])) AND (count($option['menu_items'])>1)):
        
                    $use_this_icon = (isset($option['icon']))?$option['icon']:$group_icon;

                    $submenu_items = $option['menu_items'];
                    $str .= '<li search-terms="'.$search_terms.'" class="treeview">';
                    $str .= '<a href="#"><i class="'.$use_this_icon.'"></i> <span>'.lang_label($option['name']).'</span> <i class="fa fa-angle-left pull-right"></i></a>';
                    $str .= '<ul class="treeview-menu">';
                    foreach ($submenu_items as $j => $suboption):
                        $str .= '<li search-terms="'.$search_terms.' '.lang_label($suboption['name']).'" class="nav_filter"><a href="'.site_url($suboption['uri']).'"><i class="'.$suboption['icon'].'"></i> '.lang_label($suboption['name']).'</a></li>';
                    endforeach;
                    $str .= '</ul>';

                else:
                    $str .= '<li search-terms="'.$search_terms.'" class="nav_filter"><a href="'.site_url($option['uri']).'"><i class="'.$option['icon'].$current_colour.'"></i> '.lang_label($option['name']).'</a></li>';
                endif;
                
            endforeach;
            //finish him off!
            $str .= '</ul>';
        endif;  
    endforeach;
?>

<aside class="main-sidebar" style=' height: auto;'>

    <section class="sidebar">

        <?php if(Settings::get('search_enabled')) : ?>

            <!-- Search Box -->
            <form id='sidebar-search-form' class="sidebar-form" action="admin/search" method="get">
                <div class="input-group">
                      <input id='q' name="q" class="form-control" type="text" placeholder="Search...">
                      <span class="input-group-btn">
                            <button id='sq_btn' name="search" class="btn btn-flat" id="search-btn" type="submit">
                                <i class="fa fa-times"></i>
                            </button>
                      </span>
                </div>
            </form>
        <?php endif;?>
        <!-- Sidebar Menu -->

        <ul id='sidebar-menu-result' class="sidebar-menu results-display-menu" style="display:none">
        </ul>

        <ul id='sidebar-menu' class="sidebar-menu control-panel-menu">
                
            <li class="nav_filter" search-terms="dashboard widget home">
                <a href="admin">
                    <i class="fa fa-dashboard"></i>
                    <span>
                        Dashboard
                    </span>
                </a>
            </li>

            <?php echo $str;?>
        </ul>

    </section>
</aside>

<?php unset($str);?>
<?php unset($icon);?>
<?php unset($modname);?>
