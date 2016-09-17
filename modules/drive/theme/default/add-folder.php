<section class="panel">
  <header class="panel-heading">Create Folder</header>
  <div class="panel-body">
	<form id="drive_form" name="drive_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e(SITE_URL);?>drive/manager/do">
    <input type="hidden" name="action" id="action" value="create-folder" />      
      <div class="form">
          <div class="form-group">
             <label for="folder_name" class="control-label col-lg-4">Folder Name:</label>
             <div class="col-lg-8"><input type="text" name="folder_name" id="folder_name" class="form-control required" /></div>
          </div>
          <div class="form-group col-lg-offset-2 col-lg-10">
          	 <input class="btn update" type="submit" id="submit" value ="Submit" name="submit" />
          	 <input name="cancel" class="btn" type="button" id="cancel-button" value="Cancel" onClick="window.location='list'" />
          </div>
      </div>
    </form>
  </div>
</section>