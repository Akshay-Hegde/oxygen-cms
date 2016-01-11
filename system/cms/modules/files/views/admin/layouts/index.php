<style>
div.img-div{
    /*height:100px;*/
    width:100px;
    overflow:hidden;
    /*border-radius:50%;*/
    border:#eee solid 5px;
}
.calm_color {
    color:#777;
}
a.download_file_link {
    color:#777;
}
a.download_file_link:hover {
    color:#66f;
}
/*
.img-div img{
    -webkit-transform:translate(-50%);
    margin-left:50px;
}*/
</style>
<script>
    var _token_name = "<?php echo $this->security->get_csrf_token_name();?>";
    var _token_value = "<?php echo $this->security->get_csrf_hash();?>";
</script>

<div class="row">
    <div class='col-xs-12'>
        <?php $this->load->helper('file'); ?>
        <?php $this->load->helper('text'); ?>
        <?php $this->load->view('admin/filter');?>
       <div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title">Files</h3>
                </div>  
                <div id="filter-stage">
                              
                </div>
            </div>
       </div>
    </div>
</div>