<script src="<?php echo Asset::get_filepath_js('plugins/ckeditor/ckeditor.js') ?>"></script>
<script src="<?php echo Asset::get_filepath_js('plugins/ckeditor/adapters/jquery.js') ?>"></script>
<script type="text/javascript">

	var instance;
	var ck_theme_name;
	
	var _enterMode;
	var _shiftEnterMode;

	function update_instance()
	{
		instance = CKEDITOR.currentInstance;
	}

	 $(document).ready(function () {

			if (typeof(oxy) == 'undefined') {
				var oxy = {};
			}

			oxy.init_ckeditor = function(){

				//from settings
				//ck_theme_name = 'office2013';
				ck_theme_name = '<?php echo Settings::get("ckeditor_theme");?>';
				ck_ckeditor_behaviour = '<?php echo Settings::get("ckeditor_behaviour");?>';

 				var allowedTags ='abbr[title,id]; h1 h2 h3 p blockquote strong em;' +
							    'a[!href];' +
							    'img(left,right)[!src,alt,width,height];';

				if(ck_ckeditor_behaviour=='ENTER_P') {
					_enterMode=CKEDITOR.ENTER_BR;
					_shiftEnterMode=CKEDITOR.ENTER_P;
				}else {
					_enterMode=CKEDITOR.ENTER_P;
					_shiftEnterMode=CKEDITOR.ENTER_BR;
				}	

				$('textarea.wysiwyg-simple').ckeditor({
					toolbar: [

						['Maximize'],
						['Format', 'FontSize'],			
						['Bold', 'Italic', 'Underline','-','StrikeThrough'],	
						['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],									
						['NumberedList', 'BulletedList', '-', 'Link', 'Unlink'],
						['Abbr'],
						<?php if(Settings::get('ckeditor_adv_extrafeatures')):?>
							 ['Find'],
							 ['Source']
						<?php endif;?>							
					  ],
					width: '99%',
					height: 100,
					dialog_backgroundCoverColor: '#000',
					defaultLanguage: 'en',
					language: 'en',
					skin:ck_theme_name,
					enterMode:_enterMode,
					shiftEnterMode:_shiftEnterMode,		
					extraPlugins:'abbr,lineutils,widget,image,imgbrowse',
					allowedContent:allowedTags,					
				});

				$('textarea.wysiwyg-advanced').ckeditor({
					toolbar: [
						['Maximize'],
						['Image'],
						['Link','Unlink'],
						['Bold', 'Italic', 'Underline','-','StrikeThrough'],				
						['Cut','Copy','Paste','PasteFromWord'],
						['Undo','Redo'],
						['Table','HorizontalRule','SpecialChar'],
						['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl'],						
						['Format', 'FontSize',  'NumberedList','BulletedList','Outdent','Indent','Blockquote'],
						['CodeSnippet'],
						['Abbr'],
						<?php if(Settings::get('ckeditor_adv_extrafeatures')):?>
							 ['Subscript','Superscript'],
							 ['Find'],
							 ['ShowBlocks', 'RemoveFormat'],
						<?php endif;?>							
						['Source']
					],
					width: '99%',
					height: 400,
					dialog_backgroundCoverColor: '#000',
					removePlugins: 'elementspath',
					defaultLanguage: 'en',
					language: 'en',
					skin:ck_theme_name,
					enterMode:_enterMode,
					shiftEnterMode:_shiftEnterMode,	
					<?php if(Settings::get('ckeditor_adv_extrafeatures')):?>
						 //extraPlugins:'removeformat',
					<?php endif;?>
					extraPlugins:'abbr,lineutils,widget,codesnippet,image,imgbrowse',
					allowedContent:true,
				});

				$('textarea.wysiwyg-codedocs').ckeditor({
					toolbar: [
	
						['Maximize'],
						['Image'],
						['Link','Unlink'],
						['Bold', 'Italic', 'Underline','-','StrikeThrough'],				
						['Cut','Copy','Paste'],
						['Undo','Redo'],
						['Table','HorizontalRule'],
						<?php if(Settings::get('ckeditor_adv_extrafeatures')):?>
							['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-'],						
							['Format', 'FontSize',  'NumberedList','BulletedList','Outdent','Indent'],
						<?php endif;?>							
						['CodeSnippet'],
						['Abbr'],
						<?php if(Settings::get('ckeditor_adv_extrafeatures')):?>
							 ['Subscript','Superscript'],
							 ['Find'],
							 ['ShowBlocks', 'RemoveFormat'],
						<?php endif;?>							
						['Source']
					],
					width: '99%',
					height: 400,
					//dialog_backgroundCoverColor: '#000',
					skin:ck_theme_name,
					defaultLanguage: 'en',
					language: 'en',
					<?php if(Settings::get('ckeditor_adv_extrafeatures')):?>
						 //extraPlugins:'removeformat',
					<?php endif;?>
					extraPlugins:'abbr,lineutils,widget,codesnippet,image,imgbrowse',
					allowedContent: true,
					extraAllowedContent:'figure',
					disallowedContent :'script',
					filebrowserImageBrowseUrl: SITE_URL + 'admin/files/browse/api/',
				});
			};

			// call
			oxy.init_ckeditor();
			
	});


</script>