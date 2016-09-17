<?php
/**
 * Created by : Yogesh Rathod
 * Date       : 8-04-2016
 * Module     : Media
 */
?>
<div class="banner innerBanner"><img src="<?php _e($theme_url); ?>images/inner-banner.jpg" alt=""/>
	<div class="bannerText">
		<h1>Album Gallery</h1>Feel free to browse our albums
	</div>
</div>
<!--<div class="tabBar">
	<div class="wrapper cf">
		<ul class="nav nav-tabs tabNav">
			<li class="active"><a data-toggle="tab" href="#tab1">Photos</a></li>
			<li><a data-toggle="tab" href="#tab2">Videos</a></li>
		</ul>
	</div>
</div>-->

<div class="wrapper galleryBlog cf">
	<div class="row">
		<div class="tab-content">
			<div id="tab1" class="tab-pane fade in active">
				<div class="cf">
					<?php
					$array_search = array(':enmDeleted' => '0',
										  ':albumid' =>$_GET['albumid']);
					$media_obj->setPrepare($array_search);
					$photo_count = $media_obj->getPhotocount("enmDeleted = :enmDeleted and idPhotoAlbum=:albumid");
					//$photo_album_count = $media_obj->getPhotoAlbumcount("enmDeleted = :enmDeleted");
					$qAdd = "rel_photos.enmDeleted = '0' and rel_photos.idPhotoAlbum = ".$_GET['albumid']." order by rel_photos.id ASC limit 9";
					if ($photo_count != 0) {
						$photos = $media_obj->getPhotos($qAdd);
						//$photos = $media_obj->getPhotoAlbum($qAdd);
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
								   href="<?php _e($imgurl);?>" title="<?php _e($photo['strDescription']); ?>">
									<img src="<?php _e($imgurl); ?>"/>
									<h4><?php echo $photo['strDescription']; ?></h4>
								</a>
								<div class="date"><span><?php echo $imageuploaded_date; ?></span></div>
							</div>
						<?php } ?>
					<?php if($photo_count > 9){ ?>
						<div id="show-more<?php echo $photoid; ?>" class="morebox1">
							<a href="javascript:void(0)" id="<?php echo $photoid; ?>" class="show-more">Show More</a>
						</div>

					<?php }
					} ?>
				</div>
			</div>

			<div id="tab2" class="tab-pane fade in">
				<div class="cf">
					<div class="col-lg-4 col-md-4">
						<a class="fancybox-video"
						   data-type="iframe" href="https://www.youtube.com/embed/rOVC4NY8Q-A?rel=0&amp;showinfo=0"
						   title="Revamped Sardar Patel Stadium"><span></span><img src="images/gallery/photo1.jpg" alt=""/>
							<h4>Champions Premier League</h4>
						</a>
						<div class="date"><span>29 Feb.2016</span></div>
					</div>
					<div class="col-lg-4 col-md-4"><a class="fancybox-video" data-type="iframe" href="https://www.youtube.com/embed/rOVC4NY8Q-A?rel=0&amp;showinfo=0"
													  title="Lorem ipsum dolor sit amet, consectetur adipiscing elit"><span></span><img src="images/gallery/photo2.jpg" alt=""/>
							<h4>Revamped Sardar Patel stadium</h4>
						</a>

						<div class="date"><span>4 Feb.2016</span></div>
					</div>
					<div class="col-lg-4 col-md-4"><a class="fancybox-video" data-type="iframe" href="https://www.youtube.com/embed/rOVC4NY8Q-A?rel=0&amp;showinfo=0"
													  title="Revamped Sardar Patel Stadium"><span></span><img src="images/gallery/photo3.jpg" alt=""/>
							<h4>Narendra Modi felicitates Sachin</h4>
						</a>

						<div class="date"><span>29 Apr.2016</span></div>
					</div>
					<div class="col-lg-4 col-md-4"><a class="fancybox-video" data-type="iframe" href="https://www.youtube.com/embed/rOVC4NY8Q-A?rel=0&amp;showinfo=0"
													  title="Lorem ipsum dolor sit amet, consectetur adipiscing elit"><span></span><img src="images/gallery/photo4.jpg" alt=""/>
							<h4>GCA Club - Gymnasium</h4>
						</a>

						<div class="date"><span>29 Feb.2016</span></div>
					</div>
					<div class="col-lg-4 col-md-4"><a class="fancybox-video" data-type="iframe" href="https://www.youtube.com/embed/rOVC4NY8Q-A?rel=0&amp;showinfo=0"
													  title="Revamped Sardar Patel Stadium"><span></span><img src="images/gallery/photo5.jpg" alt=""/>
							<h4>World Cup 2011</h4>
						</a>

						<div class="date"><span>29 Feb.2016</span></div>
					</div>
					<div class="col-lg-4 col-md-4"><a class="fancybox-video" data-type="iframe" href="https://www.youtube.com/embed/rOVC4NY8Q-A?rel=0&amp;showinfo=0"
													  title="Lorem ipsum dolor sit amet, consectetur adipiscing elit"><span></span><img src="images/gallery/photo6.jpg" alt=""/>
							<h4>Scorer Seminar</h4>
						</a>

						<div class="date"><span>29 Feb.2016</span></div>
					</div>
					<div class="col-lg-4 col-md-4"><a class="fancybox-video" data-type="iframe" href="https://www.youtube.com/embed/rOVC4NY8Q-A?rel=0&amp;showinfo=0"
													  title="Revamped Sardar Patel Stadium"><span></span><img src="images/gallery/photo7.jpg" alt=""/>
							<h4>Seminar of Umpires</h4>
						</a>

						<div class="date"><span>29 Feb.2016</span></div>
					</div>
					<div class="col-lg-4 col-md-4"><a class="fancybox-video" data-type="iframe" href="https://www.youtube.com/embed/rOVC4NY8Q-A?rel=0&amp;showinfo=0"
													  title="Lorem ipsum dolor sit amet, consectetur adipiscing elit"><span></span><img src="images/gallery/photo8.jpg" alt=""/>
							<h4>Sports facilities at AUDA Eklavya</h4>
						</a>

						<div class="date"><span>29 Feb.2016</span></div>
					</div>
					<div class="col-lg-4 col-md-4"><a class="fancybox-video" data-type="iframe" href="https://www.youtube.com/embed/rOVC4NY8Q-A?rel=0&amp;showinfo=0"
													  title="Revamped Sardar Patel Stadium"><span></span><img src="images/gallery/photo9.jpg" alt=""/>
							<h4>Other Photos</h4>
						</a>

						<div class="date"><span>29 Feb.2016</span></div>
					</div>
				</div>
				<a href="#" class="show-more">Show More</a>
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

