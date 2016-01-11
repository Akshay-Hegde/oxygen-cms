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


<div class="row">
    <div class='col-xs-12'>

       <div class="col-xs-12">
            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title">Files</h3>
                </div>  
                <div id="SelectorBody">

                <!-- Start-->
                <div class="box-body">

                    <div class="row" >
                        <div class="col-xs-12">
                        <?php foreach ($files as $key => $value):?>
                            <div class="col-lg-2 col-sm-3 col-xs-4 " style='margin:5px;overflow:hidden'>
                                    
                                    <?php if($value->type=='i'):?>
                                        <a class="ckhook" href="{{url:site}}files/large/<?php echo $value->filename;?>"> 
                                            <div class='img-div'>
                                            <img alt="Attachment" class='img-responsive' style='' src="{{url:site}}files/thumb/<?php echo $value->filename;?>/400">
                                            </div>
                                            <?php echo truncate_string($value->name,20);?>
                                        </a>
                                    <?php endif?>
                                        
                                    
                            </div>
                        <?php endforeach;?> 
                        </div>
                    </div>
                                                     
                    <div>
                      {{pagination:links}}</th>
                    </div>
                </div>
                <!-- End  /-->
        
                </div>
            </div>
       </div>
    </div>
</div>
<script>

            (function($) {
                $(function(){

                        $(document).on('click','a.ckhook',function(){

                            // To get value of imgroot and CKEditorFuncNum from URL
                            var url = location.href;    // current page address
                            var CKEditorFuncNum = url.match(/CKEditorFuncNum=([0-9]+)/) ? url.match(/CKEditorFuncNum=([0-9]+)/)[1] : null;

                            if(CKEditorFuncNum !== null) {

                                window.opener.CKEDITOR.tools.callFunction(CKEditorFuncNum, $(this).attr('href') );
                                window.close();
                            }  

                        });

                });
            })(jQuery);     


</script>