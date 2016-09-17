<script type="text/javascript" src="<?php _e($theme_url);?>assets/thickbox/thickbox.js"></script>
<link type="text/css" href="<?php _e($theme_url);?>assets/thickbox/thickbox.css" rel="stylesheet" />
<script type="text/javascript" src="<?php _e($theme_url);?>assets/swfupload/lib/swfupload.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/swfupload/swfupload.queue.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/swfupload/fileprogress.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/swfupload/handlers.js"></script>
<script type="text/javascript">
var swfu;

window.onload = function() {
	
	var $folder = getHash('folder'); //alert($folder);
	
	var settings = {
		flash_url : "<?php _e($theme_url);?>assets/swfupload/lib/swfupload.swf",
		upload_url: "<?php _e($module_url);?>/upload/do",
		file_size_limit : "10 MB",
		post_params: {"f" : $folder},
		file_types : "*.jpg;*.png;*.gif;*.doc;*.xls;*.pdf;*.ppt;*.pptx;*.docx;*.xlsx;*.ods",
		file_types_description : "Document Files",
		file_upload_limit : 100,
		file_queue_limit : 0,
		custom_settings : {
			progressTarget : "queueBox",
			fileQueue : "fileQueue"
		},
		debug: false,
		
		// Button settings
		button_width: "103",
		button_height: "34",
		button_placeholder_id: "spanButtonPlaceholder",
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,
				
		// The event handler functions are defined in handlers.js
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : up_error,
		upload_success_handler : uploadSuccess,
		queue_complete_handler : queueComplete	// Queue plugin event
	};

	swfu = new SWFUpload(settings);
};
</script>
<style type="text/css">
#whole { text-align: left; font-size: 12px; }
/* -- Table Styles ------------------------------- */ td { font: 10pt Helvetica, Arial, sans-serif; vertical-align: top; }
.progressWrapper { overflow: hidden; }
.progressContainer { padding: 7px; border-bottom: solid 1px #999; overflow: hidden; }
/* Message */ .message { margin: 1em 0; padding: 10px 20px; border: solid 1px #FFDD99; overflow: hidden; }
/* Error */ .red { background: #B50000; }
/* Current */ .green { background: #DDF0DD; }
/* Complete */ .blue { background: #CEE2F2; }
.progressName { font-size: 8pt; color: #555; width: 300px; height: 14px; text-align: left; white-space: nowrap; overflow: hidden; float:left; }
.progressBarContainer { width: 140px; float: left; border: 1px solid #aaa; }
.progressBarInProgress, .progressBarComplete, .progressBarError { font-size: 0; width: 0%; height: 12px; background-color: #aaa; }
.progressBarComplete { width: 140px; background-color: #aaa; visibility: hidden; }
.progressBarError { width: 140px; background-color: red; visibility: hidden; }
.progressBarStatus { margin-top: 2px; width: 140px; font-size: 7pt; font-family: Arial; text-align: left; white-space: nowrap; float:left; display:none; }
a.progressCancel { display: block; float: right; font-size: 11px; }
a.progressCancel:hover { background-position: 0px 0px; }
/* -- SWFUpload Object Styles ------------------------------- */
.swfupload { vertical-align: top; position: absolute; z-index: 5; }
.upload-box { display: none; width: 500px; position: fixed; bottom: 0; background: #FFF; margin-bottom: 0px; right: 100px; border: 1px solid #999; border-bottom: 0; border-radius: 5px 5px 0 0; -moz-box-shadow: 0px 0px 10px 0px #ccc; -webkit-box-shadow: 0px 0px 10px 0px #ccc; box-shadow: 0px 0px 10px 0px #ccc; z-index: 10; height: 250px; overflow-y: auto; }
._uphead { background: #111; padding: 5px; color: #FFF; }
#divStatus { float: left; }
._close { color: #FFF; font-size: 16px; font-weight: bold; float: right; line-height: 16px; margin-right: 5px; }
a._close:hover { color: #DDD; }
._hide { display: none; }
</style>
<form id="upload_form" class="_form" method="post" enctype="multipart/form-data">
    <div class="upload-object">
      <div id="swfupload-control-pic">
      	<div id="queueBox" class="upload-box">
        	<div class="_uphead clearfix"><div id="divStatus">Uploading</div><a href="javascript:;" onclick="$('#queueBox').hide();" class="_close">&times;</a><a href="javascript:;" onclick="$('#queueBox').hide();" class="_close">_</a></div>
        	<ul id="fileQueue" class="_queue"></ul>
        </div>
        <a class="btn btn-primary thickbox" type="button" name="create-button" id="create-button" title="Create Folder" href="<?php _e($module_url);?>/add-folder?TB_iframe=true&amp;width=600&amp;height=230&modal=true"><i class="fa fa-plus"></i> Create</a>
        <span id="spanButtonPlaceholder"></span> 
        <a class="btn btn-primary" type="button" id="upload-button" name="upload-button" title="Upload Files"><i class="fa fa-upload"></i> Upload</a>
      </div>
    </div>
</form>
<script type="text/javascript">
$(document).ready(function() {
						   
	$('._searchForm').submit(function() {
		
		var qString = $(this).find('input').val();
		
		var current_url = window.location.href;
		var n = current_url.indexOf('#');
		
		if(n) {
			var parts = current_url.split('#');
			current_url = parts[0];
		}
		
		var $trigger = $('a#dataLoad');
		var $url = $trigger.attr('data-url');
		
		if(qString != '') {
			current_url += '#search/'+qString;
			$url += '&q='+qString;
		}
		
		window.location.href = current_url;
		
		$trigger.attr('data-url', $url);
		
		$trigger.trigger('click');
		return false;
	});
});
</script>