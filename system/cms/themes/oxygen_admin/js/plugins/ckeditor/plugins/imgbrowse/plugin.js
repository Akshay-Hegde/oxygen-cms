CKEDITOR.plugins.add('imgbrowse', {
	"init": function (editor) {
			editor.config.filebrowserImageBrowseUrl = SITE_URL + 'admin/files/browse/api/'; // editor.config.filebrowserImageBrowseUrl;
			editor.config.allowedContent = true;
			/*		
		if(editor.config.filebrowserImageBrowseUrl != false) {
			editor.config.filebrowserImageBrowseUrl = editor.config.filebrowserImageBrowseUrl;
			editor.config.allowedContent = true;
		} else {
			return;
		}*/
	}
});
