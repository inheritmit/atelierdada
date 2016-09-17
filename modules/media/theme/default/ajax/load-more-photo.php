<?php
/**
 * Developer: yogesh
 * Module   : Media
 * Date     : 7/4/16
 **/
?>
<?php
if (isSet($_POST['lastid']))
{
$lastid = trim($_POST['lastid']);
?>
<div id="tab1" class="tab-pane fade in active">
	<div class="cf">
		<?php
		$array_search = array(':enmDeleted' => '0');
		$media_obj->setPrepare($array_search);
		$photo_count = $media_obj->getMorePhotocount($lastid);

		if ((int)$photo_count > 0) {
			$qAdd = "enmDeleted = '0' and id>'$lastid' order by id desc limit 9";
			$photos = $media_obj->getPhotos($qAdd);
			foreach ($photos as $photo) {
				$imageuploaded_date=time();
				$imageuploaded_date=date("d F Y", strtotime($photo['dtiCreated']));
				$photoid = $photo['id'];
				if (isset($photo['strImageName']) && !empty($photo['strImageName'])) {
					if (file_exists(UPLOAD_PATH . 'media/' . $photo['strImageName'])) {
						$imgurl = SITE_URL . 'file-manager/media/' . $photo['strImageName'];
					} else {
						$imgurl = SITE_URL . 'themes/default/img/no-image.gif';
					}
				} else {
					$imgurl = SITE_URL . 'themes/default/img/no-image.gif';
				}
				?>
				<div class="col-lg-4 col-md-4">
					<a class="fancybox-thumbs" data-fancybox-group="thumb"
					   href="<?php _e($imgurl); ?>" title="<?php _e($photo['strDescription']); ?>">
						<img src="<?php _e($imgurl); ?>"/>
						<h4><?php echo $photo['strDescription']; ?></h4>
					</a>
					<div class="date"><span><?php echo $imageuploaded_date;?></span></div>
				</div>
			<?php } ?>

			<?php if ($photo_count > 9) { ?>
				<div id="show-more<?php echo $photoid; ?>" class="morebox1">
					<a href="javascript:void(0)" id="<?php echo $photoid; ?>" class="show-more">Show More</a>
				</div>
			<?php } else {
				echo '<div class="morebox1"><a href="javascript:void(0)"  class="show-more">No more data</a>
						</div>';

			}
		}
	}
?>
