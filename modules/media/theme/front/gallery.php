<?php /**
 * Created by : Yogesh Rathod
 * Date       : 5-04-2016
 * Module     : Media
 */ ?>

<div class="banner innerBanner"><img src="<?php _e($theme_url); ?>images/inner-banner.jpg" alt=""/>
	<div class="bannerText">
		<h1>Gallery</h1>Feel free to browse our albums
	</div>
</div>
<div class="tabBar">
	<div class="wrapper cf">
		<ul class="nav nav-tabs tabNav">
			<li class="active"><a data-toggle="tab" href="#tab1">Photos</a></li>
			<li><a data-toggle="tab" href="#tab2">Videos</a></li>
		</ul>
	</div>
</div>

<div class="wrapper galleryBlog cf">
	<div class="row">
		<div class="tab-content">

			<div id="tab1" class="tab-pane fade in active">
				<div class="cf">
					<?php
					$array_search = array(':enmDeleted' => '0');
					$media_obj->setPrepare($array_search);
					$photo_album_count = $media_obj->getPhotoAlbumcount("enmDeleted = :enmDeleted");
					$qAdd = "mst_photo_albums.enmDeleted = '0' and rel_photos.enmDefaultImage = '1' order by mst_photo_albums.id ASC limit 9";

					if ($photo_album_count != 0) {
						$photos = $media_obj->getPhotoAlbum($qAdd);
						foreach ($photos as $photo) {
							$albumid = $photo['albumid'];
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
								   href="<?php _e($module_url);?>/album-gallery?albumid=<?php echo $photo['albumid'];?>" title="<?php _e($photo['strName']); ?>">
									<img src="<?php _e($imgurl); ?>"/>
									<h4><?php echo $photo['strName']; ?></h4>
								</a>
							<?php $array_search = array(':enmDeleted' => '0',':albumid' =>$albumid);
								  $media_obj->setPrepare($array_search);
								  $photo_count = $media_obj->getPhotocount("enmDeleted = :enmDeleted and idPhotoAlbum=:albumid");
							?>
								<div class="date">
									<i class="fa fa-book"></i><?php echo $photo_count; ?><span><?php echo date("d F Y", strtotime($photo['dtiCreated'])); ?></span>
								</div>
							</div>
						<?php } ?>

					<?php if($photo_album_count > 9){ ?>
							<div id="show-more<?php echo $photoid; ?>" class="morebox1">
							<a href="javascript:void(0)" id="<?php echo $photoid; ?>" class="show-more">Show More</a>
						</div>
					<?php }  } ?>
				</div>
			</div>

			<div id="tab2" class="tab-pane fade in">
				<div class="cf">
				<?php
				$array_search = array(':enmDeleted' => '0');
				$media_obj->setPrepare($array_search);
				$video_count = $media_obj->getVideoCount("enmDeleted = :enmDeleted");

				if ($video_count != 0) {

				$qAdd = "mst_video_albums.enmDeleted = '0' and enmType='Video' order by mst_video_albums.id ASC limit 9";
				$videos = $media_obj->getVideos($qAdd);
				foreach ($videos as $video) {

				$videoid = $video['id'];
				$fetch=explode("v=", $video['txtUrl']);
				$videoid=@$fetch['1'];

				?>
			<div class="col-lg-4 col-md-4">
				<a class="fancybox-video" data-type="iframe"
				   href="<?php echo convertYoutube($video['txtUrl']); ?>"
				   title="<?php echo $video['strName']; ?>">
				<?php echo "<img src='http://img.youtube.com/vi/".$videoid."/1.jpg' width='302' height='243' id='1' class='wsimg1' >"; ?>
				   <h4><?php echo $video['strName']?></h4>
				</a>
				<div class="date"><span><?php echo date("d F Y", strtotime($video['dtiCreated'])); ?></span></div>
			</div>
				<?php } ?>


				<?php if((int)$video_count > 9){ ?>
					<div id="show-more<?php echo $videoid; ?>" class="morebox2">
						<a href="javascript:void(0)" id="<?php echo $videoid; ?>" class="show-more">Show More</a>
					</div>
				<?php }  } ?>
			</div>
		</div>


	</div>
</div>


<link rel="stylesheet" type="text/css" href="<?php _e($theme_url); ?>css/jquery.fancybox.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url); ?>css/jquery.fancybox-thumbs.css"/>
<script type="text/javascript" src="<?php _e($theme_url); ?>js/jquery.fancybox.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>js/jquery.fancybox-thumbs.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>js/general.js"></script>
<script type="text/javascript">
	$(document).ready(function () {

		$('.fancybox-thumbs').fancybox({
			prevEffect: 'none',
			nextEffect: 'none',
			closeBtn: true,
			arrows: true,
			nextClick: true,
			helpers: {
				title: {
					type: 'inside'
				},
				thumbs: {
					type: 'inside',
					width: 80,
					height: 80
				}
			}
		});

		$('.fancybox-video').fancybox({
			prevEffect: 'none',
			nextEffect: 'none',
			type: 'iframe',
			closeBtn: true,
			arrows: false,
			nextClick: false,
			helpers: {
				title: {
					type: 'inside'
				}
			}
		});

		$('.show-more').on("click", function () {

			var ID = $(this).attr("id");
			if (ID) {
				$("#show-more" + ID).html('<img src="moreajax.gif" />');
				$.ajax({
					type: "POST",
					url: "<?php echo _e($module_url);?>/load/more-photo",
					data: "lastid=" + ID,
					cache: false,
					success: function (html) {
						$("#tab1").append(html);
						$("#show-more" + ID).remove(); // removing old more button
					}
				});
			}
			else {
				$(".morebox1").html('The End');// no results
			}
			return false;
		});
	});
</script>
<?php include_once($theme_path . 'footer.php'); ?>
