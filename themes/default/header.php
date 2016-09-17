<header class="header white-bg">
        <!--logo start-->
        <a href="<?php _e(SITE_URL);?>account/dashboard" class="logo">DEMO</a>
        <!--logo end-->
        <div class="horizontal-menu navbar-collapse collapse">
            <ul class="nav navbar-nav">
            	<li><a href="<?php _e(SITE_URL);?>account/dashboard"<?php if(strstr(_env('request_uri'), 'dashboard')) {?> class="active"<?php } ?>><i class="fa fa-desktop"></i> Dashboard</a></li>

                <?php if($account_obj->checkModule('career')) { ?>
                    <li class="dropdown<?php if(strstr(_env('request_uri'), 'career')) {?> active<?php } ?>">
                        <a href="<?php _e(SITE_URL);?>career/list" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle <?php if(strstr(_env('request_uri'), 'career')) {?> active<?php } ?>"><i class="fa fa-file-text-o"></i> Career</a>
                        <ul class="dropdown-menu">
                            <li<?php if(strstr(_env('request_uri'), 'career/list')) {?> class="active"<?php } ?>><a href="<?php _e(SITE_URL);?>career/list">Positions</a></li>
                            <li<?php if(strstr(_env('request_uri'), 'career/joinus?id=0')) {?> class="active"<?php } ?>><a href="<?php _e(SITE_URL);?>career/joinus?id=0">Uploaded Resumes</a></li>
                        </ul>
                    </li>
                <?php } ?>

                <?php if($account_obj->checkModule('page')) { ?>
                <li class="dropdown<?php if(strstr(_env('request_uri'), _b64('navigation')) || strstr(_env('request_uri'), 'page')) {?> active<?php } ?>"><a href="<?php _e(SITE_URL);?>page/list" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle <?php if(strstr(_env('request_uri'), 'page')) {?> active<?php } ?>"><i class="fa fa-file-text-o"></i> Pages</a>
                    <ul class="dropdown-menu">
                        <li<?php if(strstr(_env('request_uri'), '/list')) {?> class="active"<?php } ?>><a href="<?php _e(SITE_URL);?>page/list">All Pages</a></li>
                        <li<?php if(strstr(_env('request_uri'), 'contact-list')) {?> class="active"<?php } ?>><a href="<?php _e(SITE_URL);?>page/contact-list">Contacts Enquiries</a></li>
                    </ul>
                </li>
                <?php } ?>

                <?php if($account_obj->checkModule('access-user')) { ?>
                <li class="dropdown<?php if(strstr(_env('request_uri'), 'account/list') || strstr(_env('request_uri'), 'access-type')) {?> active<?php } ?>"><a href="<?php _e(SITE_URL);?>account/list" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle <?php if(strstr(_env('request_uri'), 'account/list') || strstr(_env('request_uri'), 'access-type')) {?> active<?php } ?>"><i class="fa fa-user"></i> Access Users</a>
                    <ul class="dropdown-menu">
                        <li<?php if(strstr(_env('request_uri'), 'account')) {?> class="active"<?php } ?>><a href="<?php _e(SITE_URL);?>account/list">Users List</a></li>
                        <li<?php if(strstr(_env('request_uri'), _b64('access-type'))) {?> class="active"<?php } ?>><a href="<?php _e(SITE_URL);?>master/list?t=<?php _e(_b64('access-type'));?>">Access Types</a></li>
                    </ul>
                </li>
                <?php } ?>

                <?php if($account_obj->checkModule('content')) { ?>
                <li class="dropdown<?php if(strstr(_env('request_uri'), 'content')) {?> active<?php } ?>"><a href="<?php _e(SITE_URL);?>content/list" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle<?php if(strstr(_env('request_uri'), 'content')) {?> active<?php } ?>"><i class="fa fa-user"></i>Manage Content</a>
                    <ul class="dropdown-menu">
                        <?php foreach($cont_obj::$_types as $code => $type) { ?>
                        <li<?php if(strstr(_env('request_uri'), 'content/list?t='.$code)) {?> class="active"<?php } ?>><a href="<?php _e(SITE_URL);?>content/list?t=<?php _e($code);?>"><?php _e($type);?></a></li>
                        <?php } ?>
                        <li<?php if(strstr(_env('request_uri'), 'feature')) {?> class="active"<?php } ?>><a href="<?php _e(SITE_URL);?>content/features"><strong>Studio Features</strong></a></li>
                        <li<?php if(strstr(_env('request_uri'), 'trending')) {?> class="active"<?php } ?>><a href="<?php _e(SITE_URL);?>content/trending"><strong>Studio Trending</strong></a></li>
                    </ul>
                </li>
                <?php } ?>

                <!--Master-->

                <!--<li class="dropdown <?php /*if(strstr(_env('request_uri'), _b64('category')) || strstr(_env('request_uri'), 'master')) {*/?>
                 active<?php /*} */?>">
                    <a href="<?php /*_e(SITE_URL);*/?>content/list" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle
                    <?php /*if(strstr(_env('request_uri'), 'master')) {*/?> active<?php /*} */?>">
                        <i class="fa fa-user"></i>Master</a>
                    <ul class="dropdown-menu">
                        <li<?php /*if(strstr(_env('request_uri'), 'master')) {*/?> class="active"<?php /*} */?>>
                            <a href="<?php /*_e(SITE_URL);*/?>master/list?t=<?php /*_e(_b64('category'));*/?>">Manage Content Type</a></li>
                    </ul>
                </li>-->

                <!-- Media -->
                <?php if($account_obj->checkModule('media')) { ?>
                    <li class="dropdown<?php if(strstr(_env('request_uri'), _b64('navigation')) || strstr(_env('request_uri'), 'media')) {?> active<?php } ?>">
                        <a href="<?php _e(SITE_URL);?>media/list" data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle
                        <?php if(strstr(_env('request_uri'),'media/list') || strstr(_env('request_uri'), 'access-type')) {?> active<?php } ?>"><i class="fa fa-user"></i> Media</a>
                        <ul class="dropdown-menu">
                            <li<?php if(strstr(_env('request_uri'), 'media')) {?> class="active"<?php } ?>><a href="<?php _e(SITE_URL);?>media/list">Photo Album</a></li>
                            <li<?php if(strstr(_env('request_uri'), 'media')) {?> class="active"<?php } ?>><a href="<?php _e(SITE_URL);?>media/videolist">Video Album</a></li>
                        </ul>
                    </li>
                <?php } ?>

            </ul>
            <div class="clear"></div>
        </div>
        <div class="nav notify-row" id="top_menu"><?php _e(_msg('ERR', 'error'));?></div>
        <div class="top-nav">
          <ul class="nav pull-right top-menu">
              <!-- user login dropdown start-->
              <li class="dropdown">
                 <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                      <?php _e($_SESSION[PF.'NAME']);?>
                      <b class="caret"></b>
                  </a>
                <ul class="dropdown-menu extended logout">
                      <div class="log-arrow-up"></div>
                      <?php ?><li><a href="<?php _e(SITE_URL);?>account/profile"><i class=" fa fa-suitcase"></i>Profile</a></li><?php ?>
                      <li><a onclick="location.href='javascript:void(0);'"><?php _e($_SESSION[PF.'NAME']);?></a></li>
                      <?php /*?><li><a href="<?php _e(SITE_URL);?>account/settings"><i class="fa fa-cog"></i> Settings</a></li><?php */?>
                      <li><a href="<?php _e(SITE_URL);?>account/logout/do"><i class="fa fa-key"></i> Log Out</a></li>
                  </ul>
              </li>
              <!-- user login dropdown end -->
          </ul>
      </div>
    </header>