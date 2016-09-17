<?php
if(!isset($_SESSION[PF.'USERID']) || empty($_SESSION[PF.'USERID'])){
	include_once(SITE_PATH.'errors/404.php');
	exit;
}

if(!class_exists('account')) _module('account');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php _e(SITE_TITLE);?> :: Invite your friends</title>
<link rel="stylesheet" type="text/css" href="<?php _e(SITE_URL);?>css/home/styles.css">
<script type="text/javascript" src="<?php _e(SITE_URL);?>js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php _e(SITE_URL);?>js/jquery.zclip.min.js"></script>
<script type="text/javascript" src="<?php _e(SITE_URL);?>js/jquery.validate.js"></script>
<script language="javascript">
function PopupCenter(pageURL, title,w,h) {  //alert(pageURL);return false;
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	var targetWin = window.open (pageURL,title,'width='+w+',height='+h+',top='+top+',left='+left);
}
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('a#copy-description').zclip({
        path:'<?php _e(SITE_URL);?>js/ZeroClipboard.swf',
        copy:$('p#description').text(),
		afterCopy:function(){
            $('a#copy-description').text('Copied').fadeOut('slow');
        }
    });
    $('a#copy-dynamic').zclip({
        path:'<?php _e(SITE_URL);?>js/ZeroClipboard.swf',
        copy:function(){return $('#dynamic').val();},
        beforeCopy:function(){
            $('#dynamic').css('background','white');
            $(this).css('color','orange');
        },
        afterCopy:function(){
            $('#dynamic').css('background','white');
            $(this).css('color','purple');
            $(this).next('.check').show();
        }		
    });
	
	$('#invitation_form').validate({
		errorElement: 'span',
		messages: {
			invitee_emails: 'Please enter atleat 1 email address'
		}
	});
});
</script>
<style type="text/css">
span.error { font-size: 11px; color:#F00; }
</style>
</head>
<body class="inviteFriends">
<div class="wrapper">
<!-- Start Header -->
<div id="header">
    <a href="#" id="logo<?php _e(ENV);?>"></a>
    <div class="hedTitle">Invite your friends</div>
</div>
<!-- Start Header -->


<div class="mailLink cf">
<?php echo _msg(PF.'MSG', 'message');?>
<h2>Invite your friends to join NaMoKEMP</h2>
<a onclick="location.href='javascript:void(0);'" onClick="PopupCenter('<?php _e(SITE_URL);?>account/yahoo-invitation','Yahoo Contact',600,500);" class="yIcon al"><img src="<?php _e(SITE_URL);?>images/yhaoo-icon.png" border="0">Invite your Yahoo! contacts</a>
<a onclick="location.href='javascript:void(0);'" onClick="PopupCenter('<?php _e(SITE_URL);?>account/gmail-invitation','Gmail Contact',600,500);" class="gIcon ar"><img src="<?php _e(SITE_URL);?>images/gmail-icon.png" border="0">Invite your Gmail contacts</a>
</div>

 <form id="invitation_form" name="invitation_form" method="post" class="invitForm cf" action="<?php _e(SITE_URL);?>account/send-invitation/do">
       <input type="hidden" name="action" id="action" value="invite-emails" />
       <fieldset>
           <label>Invite friends by Email (comma separated) <span for="invitee_emails" class="error ar" style="display:none;"></span></label>
           <textarea style="width:600px; margin-bottom:10px;" class="textarea required" name="invitee_emails" id="invitee_emails" /></textarea>
           <input name="" type="submit" value="Send" style="width:85px;" class="button ar">   
       </fieldset>               
  </form>
  <?php include("csv.php");?>  
  <div class="socialLink cf">
	<h2>More ways to invite your friends</h2>
    <?php 
		$url = '?r='._hash($volDetails['id']);
		$callfunction = google_shortenurl(SITE_URL.$url);
	?>
    <label class="copyLink"><a id="copy-dynamic">Copy link</a></label>   
    <input id="dynamic" name='dynamic' type="text" class="inputText copyLinkInput" value="<?php echo $callfunction;?>" />
    
    <a href="https://twitter.com/intent/tweet?source=webclient&text=Click here to Join NaMoKEMP <?php echo $callfunction;?>" class="tIcon ar" target="_blank"><img src="<?php _e(SITE_URL);?>images/t-icon.png" border="0">Tweet on Twitter</a>
    
    <a href="https://www.facebook.com/dialog/feed?app_id=173544649485889&link=<?php echo $callfunction;?>&picture=<?php _e(SITE_URL);?>images/namo-kemp.png&name=Click here to Join NaMoKEMP&redirect_uri=<?php _e(SITE_URL);?>account/invite" class="fIcon ar" target="_blank"><img src="<?php _e(SITE_URL);?>images/f-icon.png" border="0">Share on Facebook</a>
  </div>
  <div style="text-align:right;"><a href="<?php _e(SITE_URL);?>">Skip >></a></div>
</div>
<?php include_once(SITE_PATH.'footer.php');?>
</body>
</html>